<?php
require_once __DIR__ . "/app/Controller/DashboardController.php";
require_once __DIR__ . "/app/Controller/DocGiaController.php";
require_once __DIR__ . "/app/Controller/BookController.php";

$modun = $_GET['modun'] ?? "";
$action = $_GET['action'] ?? "";



switch($modun):
    case "Docgia":
        $controller = new DocGiaController();
        $id_docgia = $_GET['id_docgia'] ?? "";

        if($action == "create")        
            $controller->create();
        elseif($action == "update")
            $controller->update($id_docgia);
        else
            $controller->index();
        break;
    case "Book":
        $controller = new BookController();
        $controller->index();
        break;
    
    default:
        $controller = new DashboardController();
        $controller->index();
        break;
endswitch;


?>
