<?php
session_start();

require_once __DIR__ . "/app/Controller/DashboardController.php";
require_once __DIR__ . "/app/Controller/DocGiaController.php";
require_once __DIR__ . "/app/Controller/BookController.php";
require_once __DIR__ . "/app/Controller/LoanController.php";
require_once __DIR__ . "/app/Controller/AuthController.php";
require_once __DIR__ . "/app/Controller/UserController.php";
require_once __DIR__ . "/app/Controller/ProfileController.php";

$modun  = $_GET['modun'] ?? "";
$action = $_GET['action'] ?? "";

/* ------------------------------------------------------------
 *  KHU VỰC CÔNG KHAI: đăng nhập / đăng ký / đăng xuất
 *  (không yêu cầu đã đăng nhập)
 * ------------------------------------------------------------ */
if ($modun === "Auth") {
    $auth = new AuthController();
    if ($action === "register") {
        $auth->register();
    } elseif ($action === "logout") {
        $auth->logout();
    } else {
        $auth->login();
    }
    exit;
}

/* ------------------------------------------------------------
 *  KHÁCH (chưa đăng nhập)
 *  - Được xem danh mục sách (module Book, không action)
 *  - Mọi chỗ khác: yêu cầu đăng nhập, nhớ trang muốn tới để quay lại
 * ------------------------------------------------------------ */
$isLoggedIn = !empty($_SESSION['user']);

// Khách vào TRANG CHỦ (không có modun) -> đưa thẳng tới danh mục sách,
// thay vì bắt đăng nhập. Đăng nhập rồi thì trang chủ là Dashboard.
if (!$isLoggedIn && $modun === '') {
    $modun = 'Book';
}

$isPublicBook = ($modun === 'Book' && ($action === '' || $action === 'index'));

if (!$isLoggedIn && !$isPublicBook) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'index.php';

    if ($modun === 'Loan' && $action === 'borrow') {
        $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Vui lòng đăng nhập hoặc đăng ký để mượn sách.'];
    }

    header('Location: index.php?modun=Auth&action=login');
    exit;
}

$role = $_SESSION['user']['role'] ?? 'user';
$isAdmin = ($role === 'admin');

switch ($modun):

    case "Docgia":
        if (!$isAdmin) { header('Location: index.php'); exit; }     // chỉ quản trị được quản lý độc giả
        $controller = new DocGiaController();
        $id_docgia = $_GET['id_docgia'] ?? "";

        if ($action == "create")
            $controller->create();
        elseif ($action == "update")
            $controller->update((int)$id_docgia);
        elseif ($action == "delete")
            $controller->delete((int)$id_docgia);
        else
            $controller->index();
        break;

    case "Book":
        $controller = new BookController();
        $id_book = $_GET['id'] ?? "";

        if ($action == "create") {
            if (!$isAdmin) { header('Location: index.php?modun=Book'); exit; }
            $controller->create();
        } elseif ($action == "update") {
            if (!$isAdmin) { header('Location: index.php?modun=Book'); exit; }
            $controller->update((int)$id_book);
        } elseif ($action == "delete") {
            if (!$isAdmin) { header('Location: index.php?modun=Book'); exit; }
            $controller->delete((int)$id_book);
        } else {
            $controller->index();
        }
        break;

    case "Loan":
        $controller = new LoanController();
        $id_loan = $_GET['id'] ?? "";

        if ($action == "create") {
            if (!$isAdmin) { header('Location: index.php?modun=Loan'); exit; }
            $controller->create();
        } elseif ($action == "borrow") {
            $controller->borrow((int)$id_loan);       // độc giả tự mượn sách
        } elseif ($action == "return") {
            $controller->markReturned((int)$id_loan);
        } elseif ($action == "delete") {
            if (!$isAdmin) { header('Location: index.php?modun=Loan'); exit; }
            $controller->delete((int)$id_loan);
        } else {
            $controller->index();
        }
        break;

    case "Profile":
        $controller = new ProfileController();
        if ($action == "update")
            $controller->updateInfo();
        elseif ($action == "password")
            $controller->changePassword();
        else
            $controller->index();
        break;

    case "User":
        if (!$isAdmin) { header('Location: index.php'); exit; }     // chỉ quản trị được quản lý tài khoản
        $controller = new UserController();
        $id_user = $_GET['id'] ?? "";

        if ($action == "create")
            $controller->create();          // chỉ tạo tài khoản quản trị
        elseif ($action == "update")
            $controller->update((int)$id_user);
        elseif ($action == "resetpw")
            $controller->resetPassword((int)$id_user);
        elseif ($action == "lock")
            $controller->lock((int)$id_user);
        elseif ($action == "unlock")
            $controller->unlock((int)$id_user);
        else
            $controller->index();
        break;

    default:
        $controller = new DashboardController();
        $controller->index();
        break;
endswitch;
