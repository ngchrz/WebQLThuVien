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
        require_once __DIR__ . "/../Views/docgia/docgiaview.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->doc_gia->ho_ten        = trim($_POST['hoten'] ?? "");
            $this->doc_gia->ngay_sinh     = $_POST['ngaysinh'] ?? "";
            $this->doc_gia->gioi_tinh     = $_POST['gioitinh'] ?? "";
            $this->doc_gia->so_dien_thoai = trim($_POST['sdt'] ?? "");
            $this->doc_gia->dia_chi       = trim($_POST['diachi'] ?? "");
            $this->doc_gia->email         = trim($_POST['email'] ?? "");

            if ($this->doc_gia->add()) {
                header('Location: index.php?modun=Docgia');
                exit();
            } else {
                echo "Thêm mới không thành công";
            }
        }
        require_once __DIR__ . "/../Views/docgia/formthem.php";
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->doc_gia->ho_ten        = trim($_POST['hoten'] ?? "");
            $this->doc_gia->ngay_sinh     = $_POST['ngaysinh'] ?? "";
            $this->doc_gia->gioi_tinh     = $_POST['gioitinh'] ?? "";
            $this->doc_gia->so_dien_thoai = trim($_POST['sdt'] ?? "");
            $this->doc_gia->dia_chi       = trim($_POST['diachi'] ?? "");
            $this->doc_gia->email         = trim($_POST['email'] ?? "");

            if ($this->doc_gia->update($id)) {
                header('Location: index.php?modun=Docgia');
                exit();
            } else {
                echo "Cập nhật không thành công";
            }
        }

        // GET: nạp dữ liệu để hiển thị form sửa
        $docgia = $this->doc_gia->getDocGiaByID($id);
        require_once __DIR__ . "/../Views/docgia/formsua.php";
    }

    public function delete(int $id)
    {
        $this->doc_gia->delete($id);
        header('Location: index.php?modun=Docgia');
        exit();
    }
}
