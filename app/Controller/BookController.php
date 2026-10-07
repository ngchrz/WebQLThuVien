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
        $totalTitles = 120;
        $totalQty = 32;
        $totalAvail = 21;
        $outOfStock = 53;
        $dsbook = $this->book->selectAll();                     // Lấy toàn bộ danh sách độc giả từ Database
        require_once __DIR__ . "/../Views/book/bookview.php";
    }
}