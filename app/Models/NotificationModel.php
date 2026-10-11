<?php
require_once __DIR__ . "/../../config/database.php";

class NotificationModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Phiếu quá hạn (đang mượn & quá due_date)
    // $userId = null: lấy tất cả (admin); có giá trị: chỉ của 1 tài khoản
    public function overdueLoans(?int $userId = null): array
    {
        $sql = "SELECT l.id, l.due_date, l.user_id,
                       b.title AS book_title,
                       COALESCE(d.ho_ten, u.username) AS reader_name
                FROM loans l
                JOIN books b ON b.id = l.book_id
                JOIN users u ON u.id = l.user_id
                LEFT JOIN doc_gia d ON d.id_doc_gia = u.id_doc_gia
                WHERE l.status = 'borrowed' AND l.due_date < CURDATE()";

        $params = [];
        if ($userId !== null) {
            $sql .= " AND l.user_id = :uid";
            $params['uid'] = $userId;
        }
        $sql .= " ORDER BY l.due_date ASC";

        $stm = $this->db->pdo->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Phiếu sắp đến hạn trong vòng $days ngày tới
    public function dueSoonLoans(int $days = 3, ?int $userId = null): array
    {
        $days = max(0, (int)$days);
        $sql = "SELECT l.id, l.due_date, l.user_id,
                       b.title AS book_title,
                       COALESCE(d.ho_ten, u.username) AS reader_name
                FROM loans l
                JOIN books b ON b.id = l.book_id
                JOIN users u ON u.id = l.user_id
                LEFT JOIN doc_gia d ON d.id_doc_gia = u.id_doc_gia
                WHERE l.status = 'borrowed'
                  AND l.due_date >= CURDATE()
                  AND l.due_date <= DATE_ADD(CURDATE(), INTERVAL $days DAY)";

        $params = [];
        if ($userId !== null) {
            $sql .= " AND l.user_id = :uid";
            $params['uid'] = $userId;
        }
        $sql .= " ORDER BY l.due_date ASC";

        $stm = $this->db->pdo->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }
}
