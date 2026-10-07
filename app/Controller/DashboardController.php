<?php

require_once __DIR__ . "/../Models/DocGiaModel.php";
require_once __DIR__ . "/../Models/BookModel.php";

class DashboardController
{

    private BookModel $book;
    private DocGiaModel $docgia;

    public function __construct(){
        $this->book = new BookModel();
        $this->docgia = new DocGiaModel();
    }
   
    public function index()
    {
        
        $tongSoSach = $this->book->countAllBook();

        $tongSoDocGia = 98;

        require_once __DIR__ . "/../Views/dashboard/dashboardview.php";
    }
}   

?>