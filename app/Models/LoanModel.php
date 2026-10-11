<?php
require_once __DIR__ . "/../../config/database.php";

class LoanModel
{
    // Thuộc tính tương ứng các cột trong bảng loans
    public int $user_id = 0;
    public int $book_id = 0;
    public string $borrow_date = '';
    public string $due_date = '';
    public string $status = 'borrowed';

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy toàn bộ phiếu mượn (kèm tên sách + tên độc giả)
    public function selectAll(): array
    {
        $sql = "SELECT l.*, b.title AS book_title, b.author AS book_author, b.cover_image,
                       d.ho_ten, d.ma_doc_gia, u.username
                FROM loans l
                JOIN books b ON b.id = l.book_id
                JOIN users u ON u.id = l.user_id
                LEFT JOIN doc_gia d ON d.id_doc_gia = u.id_doc_gia
                ORDER BY l.id DESC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy phiếu mượn của 1 tài khoản (dùng cho độc giả xem lịch sử của mình)
    public function getByUser(int $userId): array
    {
        $sql = "SELECT l.*, b.title AS book_title, b.author AS book_author, b.cover_image,
                       d.ho_ten, d.ma_doc_gia, u.username
                FROM loans l
                JOIN books b ON b.id = l.book_id
                JOIN users u ON u.id = l.user_id
                LEFT JOIN doc_gia d ON d.id_doc_gia = u.id_doc_gia
                WHERE l.user_id = :uid
                ORDER BY l.id DESC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['uid' => $userId]);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy 1 phiếu mượn theo ID
    public function getByID(int $id)
    {
        $sql = "SELECT * FROM loans WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Tạo phiếu mượn mới
    public function create(): bool
    {
        $sql = "INSERT INTO loans (user_id, book_id, borrow_date, due_date, status)
                VALUES (:user_id, :book_id, :borrow_date, :due_date, :status)";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute([
            'user_id'     => $this->user_id,
            'book_id'     => $this->book_id,
            'borrow_date' => $this->borrow_date,
            'due_date'    => $this->due_date,
            'status'      => $this->status,
        ]);
    }

    // Ghi nhận trả sách
    public function markReturned(int $id): bool
    {
        $sql = "UPDATE loans
                SET return_date = CURDATE(), status = 'returned'
                WHERE id = :id AND status = 'borrowed'";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute(['id' => $id]);
    }

    // Xóa phiếu mượn
    public function delete(int $id): bool
    {
        $stm = $this->db->pdo->prepare("DELETE FROM loans WHERE id = :id");
        return $stm->execute(['id' => $id]);
    }

    // Đếm số phiếu đang mượn
    public function countActive(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM loans WHERE status = 'borrowed'")->fetchColumn();
    }

    // Đếm số phiếu quá hạn (đang mượn & quá due_date)
    public function countOverdue(): int
    {
        return (int)$this->db->pdo->query(
            "SELECT COUNT(*) FROM loans WHERE status = 'borrowed' AND due_date < CURDATE()"
        )->fetchColumn();
    }

    // Đếm số phiếu đã trả
    public function countReturned(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM loans WHERE status = 'returned'")->fetchColumn();
    }

    // Độc giả đang có phiếu mượn CHƯA TRẢ cho 1 cuốn sách? (tránh mượn trùng)
    public function hasActiveLoan(int $userId, int $bookId): bool
    {
        $sql = "SELECT COUNT(*) FROM loans
                WHERE user_id = :uid AND book_id = :bid AND status = 'borrowed'";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['uid' => $userId, 'bid' => $bookId]);
        return (int)$stm->fetchColumn() > 0;
    }

    // Danh sách book_id mà độc giả đang mượn (chưa trả)
    public function activeBookIdsByUser(int $userId): array
    {
        $sql = "SELECT book_id FROM loans WHERE user_id = :uid AND status = 'borrowed'";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['uid' => $userId]);
        return $stm->fetchAll(PDO::FETCH_COLUMN);
    }
}
