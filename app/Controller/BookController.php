<?php

require_once __DIR__ . "/../Models/BookModel.php";

class BookController
{
    private BookModel $book;

    public function __construct()
    {
        $this->book = new BookModel();
    }

    public function index()
    {
        $dsbook = $this->book->selectAll();                     // Lấy toàn bộ danh sách sách từ Database

        // Thống kê thật từ database (thay cho số liệu hard-code trước đây)
        $totalTitles = $this->book->countAllBook();             // Tổng số đầu sách
        $totalQty    = $this->book->countTotalQuantity();       // Tổng số bản
        $totalAvail  = $this->book->countAvailable();           // Số bản còn lại
        $outOfStock  = $this->book->countOutOfStock();          // Số đầu sách hết hàng
        $catList     = $this->book->getCategories();            // Danh sách thể loại cho bộ lọc

        // Vai trò + danh sách sách độc giả đang mượn (để hiển thị nút Mượn / Đang mượn)
        $isGuest = empty($_SESSION['user']);
        $isAdmin = (!$isGuest && ($_SESSION['user']['role'] ?? 'user') === 'admin');
        $myBorrowedBookIds = [];
        if (!$isGuest && !$isAdmin) {
            require_once __DIR__ . "/../Models/LoanModel.php";
            $loanModel = new LoanModel();
            $myBorrowedBookIds = array_map('intval', $loanModel->activeBookIdsByUser((int)$_SESSION['user']['id']));
        }

        require_once __DIR__ . "/../Views/book/bookview.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->book->title        = trim($_POST['title'] ?? '');
            $this->book->author       = trim($_POST['author'] ?? '');
            $this->book->category     = trim($_POST['category'] ?? '');
            $this->book->publisher    = trim($_POST['publisher'] ?? '');
            $this->book->publish_year = ($_POST['publish_year'] ?? '') !== '' ? (int)$_POST['publish_year'] : null;
            $this->book->quantity     = max(0, (int)($_POST['quantity'] ?? 0));

            $availableInput        = $_POST['available'] ?? '';
            $this->book->available = $availableInput !== '' ? (int)$availableInput : $this->book->quantity;

            // Ràng buộc: số bản còn lại không vượt quá tổng số bản
            if ($this->book->available > $this->book->quantity) {
                $this->book->available = $this->book->quantity;
            }
            if ($this->book->available < 0) {
                $this->book->available = 0;
            }

            $this->book->description = trim($_POST['description'] ?? '');
            $this->book->cover_image = $this->uploadCover();

            if ($this->book->add()) {
                header('Location: index.php?modun=Book');
                exit();
            } else {
                echo "Thêm sách không thành công";
            }
        }
        require_once __DIR__ . "/../Views/book/formthem.php";
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->book->title        = trim($_POST['title'] ?? '');
            $this->book->author       = trim($_POST['author'] ?? '');
            $this->book->category     = trim($_POST['category'] ?? '');
            $this->book->publisher    = trim($_POST['publisher'] ?? '');
            $this->book->publish_year = ($_POST['publish_year'] ?? '') !== '' ? (int)$_POST['publish_year'] : null;
            $this->book->quantity     = max(0, (int)($_POST['quantity'] ?? 0));
            $this->book->available    = max(0, (int)($_POST['available'] ?? 0));

            if ($this->book->available > $this->book->quantity) {
                $this->book->available = $this->book->quantity;
            }

            $this->book->description = trim($_POST['description'] ?? '');

            // Ảnh bìa: nếu chọn file mới thì thay, nếu không giữ ảnh cũ (current_cover)
            $newCover = $this->uploadCover();
            $this->book->cover_image = $newCover ?? ($_POST['current_cover'] ?? null);

            if ($this->book->update($id)) {
                header('Location: index.php?modun=Book');
                exit();
            } else {
                echo "Cập nhật sách không thành công";
            }
        }

        // GET: nạp dữ liệu để hiển thị form sửa
        $book = $this->book->getBookByID($id);
        require_once __DIR__ . "/../Views/book/formsua.php";
    }

    public function delete(int $id)
    {
        $this->book->delete($id);
        header('Location: index.php?modun=Book');
        exit();
    }

    // Xử lý upload ảnh bìa -> lưu vào img/product/, trả về tên file (hoặc null nếu không upload)
    private function uploadCover(): ?string
    {
        if (!isset($_FILES['cover_image']) || $_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $dir = __DIR__ . '/../../img/product/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $original = basename($_FILES['cover_image']['name']);
        $ext      = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $allowed, true)) {
            return null;
        }

        $base = pathinfo($original, PATHINFO_FILENAME);
        $base = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base);
        $filename = date('YmdHis') . '_' . $base . '.' . $ext;

        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $dir . $filename)) {
            return $filename;
        }
        return null;
    }
}
