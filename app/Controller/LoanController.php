<?php

require_once __DIR__ . "/../Models/LoanModel.php";
require_once __DIR__ . "/../Models/BookModel.php";
require_once __DIR__ . "/../Models/UserModel.php";

class LoanController
{
    private LoanModel $loan;
    private BookModel $book;
    private UserModel $user;

    public function __construct()
    {
        $this->loan = new LoanModel();
        $this->book = new BookModel();
        $this->user = new UserModel();
    }

    // Ghi thông báo tạm (flash)
    private function flash(string $type, string $msg): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    }

    // ĐỘC GIẢ tự mượn sách từ trang Quản lý sách (tự trừ tồn kho)
    public function borrow(int $bookId)
    {
        $role   = $_SESSION['user']['role'] ?? 'user';
        $userId = (int)($_SESSION['user']['id'] ?? 0);

        // Quản trị không mượn qua đây (ghi nhận ở chức năng Mượn/Trả)
        if ($role === 'admin') {
            $this->flash('error', 'Quản trị viên vui lòng ghi nhận mượn ở mục Mượn / Trả.');
            header('Location: index.php?modun=Book');
            exit();
        }

        $book = $this->book->getBookByID($bookId);

        if (!$book) {
            $this->flash('error', 'Không tìm thấy sách.');
        } elseif ((int)$book->available <= 0) {
            $this->flash('error', 'Sách "' . $book->title . '" đã hết bản trong kho.');
        } elseif ($this->loan->hasActiveLoan($userId, $bookId)) {
            $this->flash('error', 'Bạn đang mượn cuốn sách này rồi.');
        } else {
            $this->loan->user_id     = $userId;
            $this->loan->book_id     = $bookId;
            $this->loan->borrow_date = date('Y-m-d');
            $this->loan->due_date    = date('Y-m-d', strtotime('+14 days'));
            $this->loan->status      = 'borrowed';

            if ($this->loan->create()) {
                $this->book->adjustAvailable($bookId, -1); // trừ 1 bản còn lại
                $this->flash('success', 'Mượn thành công "' . $book->title . '". Hạn trả: ' . date('d/m/Y', strtotime($this->loan->due_date)) . '.');
            } else {
                $this->flash('error', 'Mượn sách thất bại, vui lòng thử lại.');
            }
        }

        header('Location: index.php?modun=Book');
        exit();
    }

    public function index()
    {
        $role = $_SESSION['user']['role'] ?? 'user';

        if ($role === 'admin') {
            $dsLoan = $this->loan->selectAll();                 // Thủ thư xem tất cả phiếu
        } else {
            $dsLoan = $this->loan->getByUser((int)$_SESSION['user']['id']); // Độc giả xem phiếu của mình
        }

        // Thống kê theo ĐÚNG phạm vi hiển thị:
        //  - admin: toàn hệ thống
        //  - độc giả: chỉ tính trên các phiếu của chính người dùng đó
        $today = date('Y-m-d');
        $dangMuon = 0;
        $quaHan   = 0;
        $daTra    = 0;
        foreach ($dsLoan as $l) {
            if ($l->status === 'returned') {
                $daTra++;
            } elseif ($l->status === 'borrowed') {
                $dangMuon++;
                if ($l->due_date < $today) {
                    $quaHan++;
                }
            }
        }

        // Thông tin độc giả (hiển thị ở đầu trang cho độc giả)
        $docGiaCode = '';
        if ($role !== 'admin' && !empty($_SESSION['user']['id_doc_gia'])) {
            require_once __DIR__ . "/../Models/DocGiaModel.php";
            $dgModel = new DocGiaModel();
            $dg = $dgModel->getDocGiaByID((int)$_SESSION['user']['id_doc_gia']);
            if ($dg) {
                $docGiaCode = $dg->ma_doc_gia;
            }
        }

        require_once __DIR__ . "/../Views/loan/loanview.php";
    }

    public function create()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $user_id     = (int)($_POST['user_id'] ?? 0);
            $book_id     = (int)($_POST['book_id'] ?? 0);
            $borrow_date = $_POST['borrow_date'] ?? date('Y-m-d');
            $due_date    = $_POST['due_date'] ?? date('Y-m-d', strtotime('+14 days'));

            $book = $this->book->getBookByID($book_id);

            if ($user_id <= 0 || $book_id <= 0) {
                $error = 'Vui lòng chọn độc giả và sách.';
            } elseif (!$book) {
                $error = 'Sách không tồn tại.';
            } elseif ((int)$book->available <= 0) {
                $error = 'Sách này đã hết bản trong kho, không thể cho mượn.';
            } elseif ($due_date < $borrow_date) {
                $error = 'Hạn trả phải sau hoặc bằng ngày mượn.';
            } else {
                $this->loan->user_id     = $user_id;
                $this->loan->book_id     = $book_id;
                $this->loan->borrow_date = $borrow_date;
                $this->loan->due_date    = $due_date;
                $this->loan->status      = 'borrowed';

                if ($this->loan->create()) {
                    $this->book->adjustAvailable($book_id, -1); // giảm 1 bản còn lại
                    header('Location: index.php?modun=Loan');
                    exit();
                }
                $error = 'Ghi nhận mượn thất bại, vui lòng thử lại.';
            }
        }

        $dsUser = $this->user->selectAll();
        $dsBook = $this->book->selectAll();
        require_once __DIR__ . "/../Views/loan/formthem.php";
    }

    public function markReturned(int $id)
    {
        $role = $_SESSION['user']['role'] ?? 'user';
        $loan = $this->loan->getByID($id);

        // Chỉ xử lý khi phiếu đang mượn; và chỉ admin hoặc chính chủ phiếu mới được trả
        if ($loan && $loan->status === 'borrowed') {
            $isOwner = ($role !== 'admin' && (int)$loan->user_id === (int)($_SESSION['user']['id'] ?? 0));
            if ($role === 'admin' || $isOwner) {
                if ($this->loan->markReturned($id)) {
                    $this->book->adjustAvailable((int)$loan->book_id, +1); // trả lại 1 bản
                }
            }
        }

        header('Location: index.php?modun=Loan');
        exit();
    }

    public function delete(int $id)
    {
        $loan = $this->loan->getByID($id);
        if ($loan) {
            // Nếu phiếu đang mượn thì trả lại kho trước khi xóa
            if ($loan->status === 'borrowed') {
                $this->book->adjustAvailable((int)$loan->book_id, +1);
            }
            $this->loan->delete($id);
        }
        header('Location: index.php?modun=Loan');
        exit();
    }
}
