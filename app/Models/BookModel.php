<?php
require_once __DIR__ . "/../../config/database.php";
class BookModel
{
    private Database $db;                                           // Khai báo thuộc tính $db có kiểu dữ liệu là Database
    public function __construct()                                   // Constructor: tự động chạy khi tạo đối tượng DocGiaModel
    {
        $this->db = new Database();                                 // Tạo một đối tượng Database và Sau đó lưu vào thuộc tính $db
    }

    public function countAllBook(){


        //sql
        //

        return 500;

    }



}
?>