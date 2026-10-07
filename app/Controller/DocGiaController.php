<?php

require_once __DIR__ . "/../Models/DocGiaModel.php";

class DocGiaController
{
    
    private DocGiaModel $doc_gia;   
    public function __construct()
    {
        $this->doc_gia = new DocGiaModel();                       
    }
    public function index()
    {
        $dsDocGia = $this->doc_gia->selectAll();                     // Lấy toàn bộ danh sách độc giả từ Database
        require_once __DIR__ . "/../Views/List.php";
    }

    public function create()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->doc_gia->ho_ten = $_POST['hoten'] ?? "";
            $this->doc_gia->ngay_sinh = $_POST['ngaysinh'] ?? "";
            $this->doc_gia->gioi_tinh = $_POST['gioitinh'] ?? "";
            $this->doc_gia->so_dien_thoai = $_POST['sdt'] ?? "";
            $this->doc_gia->dia_chi = $_POST['diachi'] ?? "";
            if($this->doc_gia->add()){
                header('Location: index.php'); exit();

            }else{
                echo "thêm mới không thành công";
            }
            
        }
        require_once __DIR__ . "/../Views/formthem.php";
    }
}
?>