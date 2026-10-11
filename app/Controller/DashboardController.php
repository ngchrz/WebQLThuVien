<?php

require_once __DIR__ . "/../Models/DocGiaModel.php";
require_once __DIR__ . "/../Models/BookModel.php";
require_once __DIR__ . "/../Models/LoanModel.php";
require_once __DIR__ . "/../Models/UserModel.php";

class DashboardController
{

    private BookModel $book;
    private DocGiaModel $docgia;
    private LoanModel $loan;
    private UserModel $user;

    public function __construct(){
        $this->book = new BookModel();
        $this->docgia = new DocGiaModel();
        $this->loan = new LoanModel();
        $this->user = new UserModel();
    }

    public function index()
    {
        // Số liệu lấy trực tiếp từ database
        $tongSoSach   = $this->book->countAllBook();     // Tổng số đầu sách
        $tongSoDocGia = $this->docgia->countAll();       // Tổng số độc giả
        $tongSoBan    = $this->book->countTotalQuantity(); // Tổng số bản
        $conLai       = $this->book->countAvailable();   // Số bản còn lại

        $dangMuon     = $this->loan->countActive();      // Phiếu đang mượn
        $quaHan       = $this->loan->countOverdue();     // Phiếu quá hạn
        $daTra        = $this->loan->countReturned();    // Phiếu đã trả
        $nguoiDung    = $this->user->countAll();         // Tổng tài khoản

        // Tỉ lệ sách đang được mượn = (tổng bản - còn lại) / tổng bản
        $tiLeDangMuon = $tongSoBan > 0 ? (int)round(($tongSoBan - $conLai) / $tongSoBan * 100) : 0;

        require_once __DIR__ . "/../Views/dashboard/dashboardview.php";
    }
}
