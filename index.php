<?php
require_once __DIR__ . "/app/Controller/DocGiaController.php";

$action = $_GET['action'] ?? "";
$controller = new DocGiaController();

switch($action):
    case "create":
        $controller->create();
        break;
    
    default:
        $controller->index();
        break;
endswitch;


?>
