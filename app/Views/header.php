<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - LibManager' : 'LibManager - Quản Lý Thư Viện' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: #a5b4fc; }

        /* Thanh menu bên trái */
        .sidebar-link { transition: background .2s ease, color .2s ease, transform .2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,.08); transform: translateX(2px); }
        .sidebar-link.active { background: #fff; color: #312e81 !important; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
        .sidebar-link.active i { color: #4f46e5; }

        /* Thẻ */
        .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -8px rgba(79,70,229,.18); }

        /* Nút */
        .btn-primary { transition: transform .18s ease, box-shadow .18s ease; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 16px -4px rgba(79,70,229,.4); }
        .btn-primary:active { transform: translateY(0) scale(.98); }

        /* Bảng + ô nhập liệu */
        .table-row-hover { transition: background .15s ease; }
        input, select, textarea { transition: box-shadow .2s ease, border-color .2s ease, background-color .2s ease; }
        input:focus, select:focus, textarea:focus { box-shadow: 0 0 0 3px rgba(99,102,241,.15); }

        /* ===== Hiệu ứng xuất hiện ===== */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
        @keyframes popIn  { from { opacity: 0; transform: translateY(-6px) scale(.98); } to { opacity: 1; transform: none; } }

        /* Các khối nội dung chính vào lần lượt */
        main > * { animation: fadeUp .38s cubic-bezier(.22,.61,.36,1) both; }
        main > *:nth-child(2) { animation-delay: .05s; }
        main > *:nth-child(3) { animation-delay: .10s; }
        main > *:nth-child(4) { animation-delay: .15s; }
        main > *:nth-child(n+5) { animation-delay: .20s; }

        /* Thẻ sách trong lưới vào lần lượt */
        .book-card { animation: fadeUp .38s cubic-bezier(.22,.61,.36,1) both; }
        .book-card:nth-child(2) { animation-delay: .05s; }
        .book-card:nth-child(3) { animation-delay: .10s; }
        .book-card:nth-child(4) { animation-delay: .15s; }
        .book-card:nth-child(5) { animation-delay: .20s; }
        .book-card:nth-child(6) { animation-delay: .25s; }

        /* Panel thông báo trượt xuống */
        #notifPanel:not(.hidden) { animation: popIn .18s ease-out; }

        /* ===== Modal xác nhận / thông báo ===== */
        #wbModal:not(.hidden) { display: flex; animation: wbFade .18s ease-out; }
        #wbModal:not(.hidden) #wbModalCard { animation: wbPop .24s cubic-bezier(.22,.61,.36,1); }
        @keyframes wbFade { from { opacity: 0; } to { opacity: 1; } }
        @keyframes wbPop  { from { opacity: 0; transform: translateY(10px) scale(.96); } to { opacity: 1; transform: none; } }

        /* Tôn trọng cài đặt giảm chuyển động của người dùng */
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            main > *, .book-card, #notifPanel:not(.hidden),
            #wbModal:not(.hidden), #wbModal:not(.hidden) #wbModalCard { animation: none !important; }
            .sidebar-link:hover, .card-hover:hover, .btn-primary:hover { transform: none; }
        }
    </style>
</head>
<body class="bg-[#f1f5f9] text-gray-800 antialiased">

<?php
$__modun = $_GET['modun'] ?? '';
$__action = $_GET['action'] ?? '';
$__isDashboard = ($__modun === '');
$__isDocGia = ($__modun === 'Docgia');
$__isBooks = ($__modun === 'Book');
$__isLoan = ($__modun === 'Loan');
$__isUser = ($__modun === 'User');
$__isProfile = ($__modun === 'Profile');

$__isGuest = empty($_SESSION['user']);
$__user = $_SESSION['user'] ?? ['ho_ten' => 'Khách', 'username' => 'guest', 'role' => 'user'];
$__isAdmin = (($__user['role'] ?? 'user') === 'admin');
$__displayName = $__user['ho_ten'] ?? $__user['username'] ?? 'Người dùng';
$__avatar = 'https://ui-avatars.com/api/?name=' . urlencode($__displayName) . '&background=6366f1&color=fff&bold=true';

// Trang chủ theo vai trò: khách chưa đăng nhập thì về danh mục sách
$__homeUrl = $__isGuest ? 'index.php?modun=Book' : 'index.php';

// Thông báo: chỉ hiển thị khi đã đăng nhập
$__overdue = [];
$__dueSoon = [];
$__notifCount = 0;
if (!$__isGuest) {
    require_once __DIR__ . "/../Models/NotificationModel.php";
    $__notif = new NotificationModel();
    $__uid = $__isAdmin ? null : (int)($__user['id'] ?? 0);
    $__overdue = $__notif->overdueLoans($__uid);
    $__dueSoon = $__notif->dueSoonLoans(3, $__uid);
    $__notifCount = count($__overdue) + count($__dueSoon);
}
?>

<div class="flex h-screen overflow-hidden">

    <!-- Mobile overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>

    <!-- ===== SIDEBAR (cố định) ===== -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-[260px] h-full shrink-0 bg-gradient-to-b from-indigo-950 via-indigo-900 to-indigo-900 text-white flex flex-col justify-between shadow-2xl -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="px-5 pt-6 overflow-y-auto">
            <!-- Brand (bấm vào để về trang chủ) -->
            <a href="<?= htmlspecialchars($__homeUrl) ?>" title="Về trang chủ"
               class="flex items-center space-x-3 px-1 mb-8 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-950/50 shrink-0 transition-transform duration-200 group-hover:scale-105">
                    <i class="fa-solid fa-book-open-reader text-xl text-white"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-lg font-extrabold tracking-tight leading-none transition-colors duration-200 group-hover:text-indigo-200">LibManager</p>
                    <p class="text-[11px] uppercase tracking-widest text-indigo-300 mt-1.5 font-medium">Thư viện thông minh</p>
                </div>
            </a>

            <!-- Menu label -->
            <p class="text-[11px] font-semibold uppercase tracking-widest text-indigo-300/80 px-3 mb-2">Menu chính</p>

            <!-- Nav -->
            <nav class="space-y-1.5">
                <?php if ($__isAdmin): ?>
                <a href="index.php"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isDashboard ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isDashboard ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chart-pie text-[15px]"></i>
                    </span>
                    <span>Dashboard</span>
                    <?php if ($__isDashboard): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>
                <?php endif; ?>

                <?php if ($__isAdmin): ?>
                <a href="index.php?modun=Docgia"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isDocGia ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isDocGia ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-[15px]"></i>
                    </span>
                    <span>Quản lý độc giả</span>
                    <?php if ($__isDocGia): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>
                <?php endif; ?>

                <a href="index.php?modun=Book"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isBooks ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isBooks ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book text-[15px]"></i>
                    </span>
                    <span><?= $__isAdmin ? 'Quản lý Sách' : 'Danh mục sách' ?></span>
                    <?php if ($__isBooks): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>

                <?php if (!$__isGuest): ?>
                <a href="index.php?modun=Loan"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isLoan ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isLoan ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-arrow-right-arrow-left text-[15px]"></i>
                    </span>
                    <span><?= $__isAdmin ? 'Mượn / Trả' : 'Phiếu của tôi' ?></span>
                    <?php if ($__isLoan): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>
                <?php endif; ?>

                <?php if ($__isAdmin): ?>
                <a href="index.php?modun=User"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isUser ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isUser ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-gear text-[15px]"></i>
                    </span>
                    <span>Tài khoản</span>
                    <?php if ($__isUser): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>
                <?php endif; ?>

                <?php if (!$__isGuest): ?>
                <a href="index.php?modun=Profile"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isProfile ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isProfile ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-id-badge text-[15px]"></i>
                    </span>
                    <span>Thông tin cá nhân</span>
                    <?php if ($__isProfile): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span><?php endif; ?>
                </a>
                <?php endif; ?>
            </nav>
        </div>

        <!-- User box -->
        <div class="p-5">
            <?php if ($__isGuest): ?>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-3.5 border border-white/10">
                    <div class="flex items-center space-x-3">
                        <div class="relative shrink-0">
                            <img class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover" src="<?= htmlspecialchars($__avatar) ?>" alt="Khách">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-white truncate">Khách</p>
                            <p class="text-xs text-indigo-300">Chưa đăng nhập</p>
                        </div>
                    </div>
                    <a href="index.php?modun=Auth&action=login"
                       class="mt-3 w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-indigo-900 bg-white hover:bg-indigo-50 px-3 py-2 rounded-xl transition">
                        <i class="fa-solid fa-right-to-bracket text-[11px]"></i> Đăng nhập
                    </a>
                </div>
            <?php else: ?>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-3.5 border border-white/10">
                    <div class="flex items-center space-x-3">
                        <a href="index.php?modun=Profile" class="flex items-center space-x-3 min-w-0 flex-1 group" title="Thông tin cá nhân">
                            <div class="relative shrink-0">
                                <img class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover" src="<?= htmlspecialchars($__avatar) ?>" alt="User">
                                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 border-2 border-indigo-900 rounded-full"></span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-white truncate group-hover:text-indigo-200 transition"><?= htmlspecialchars($__displayName) ?></p>
                                <p class="text-xs text-indigo-300"><?= $__isAdmin ? 'Quản trị viên' : 'Độc giả' ?></p>
                            </div>
                        </a>
                        <a href="index.php?modun=Auth&action=logout" title="Đăng xuất"
                           class="w-9 h-9 rounded-xl bg-white/10 hover:bg-rose-500 text-indigo-100 hover:text-white flex items-center justify-center transition shrink-0">
                            <i class="fa-solid fa-right-from-bracket text-sm"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <p class="text-center text-[11px] text-indigo-300/70 mt-3">LibManager v1.1 &copy; 2026</p>
        </div>
    </aside>

    <!-- ===== CONTENT WRAPPER ===== -->
    <div class="flex-1 flex flex-col h-screen min-w-0">

        <!-- ===== TOPBAR (cố định) ===== -->
        <header class="shrink-0 z-30 bg-white/90 backdrop-blur border-b border-gray-100">
            <div class="flex items-center justify-between gap-4 px-4 sm:px-6 py-3.5">
                <div class="flex items-center gap-3 min-w-0">
                    <button id="btnSidebar" class="md:hidden w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 shrink-0">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="min-w-0">
                        <h1 class="text-base sm:text-lg font-bold text-gray-900 truncate leading-tight">
                            <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : ($__isDocGia ? 'Quản lý độc giả' : 'Dashboard tổng quan') ?>
                        </h1>
                        <p class="text-xs text-gray-500 hidden sm:flex items-center gap-1.5 mt-0.5">
                            <a href="<?= htmlspecialchars($__homeUrl) ?>" class="hover:text-indigo-600">Trang chủ</a>
                            <i class="fa-solid fa-chevron-right text-[9px] text-gray-300"></i>
                            <span class="text-gray-700 font-medium"><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Dashboard' ?></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <!-- Thông báo -->
                    <?php if (!$__isGuest): ?>
                    <div class="relative" id="notifWrap">
                        <button id="btnNotif" type="button" title="Thông báo"
                                class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 relative">
                            <i class="fa-regular fa-bell"></i>
                            <?php if ($__notifCount > 0): ?>
                                <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">
                                    <?= $__notifCount > 9 ? '9+' : $__notifCount ?>
                                </span>
                            <?php endif; ?>
                        </button>

                        <div id="notifPanel"
                             class="hidden absolute right-0 mt-2 w-80 max-w-[90vw] bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <p class="font-bold text-sm text-gray-900">Thông báo</p>
                                <?php if ($__notifCount > 0): ?>
                                    <span class="text-[11px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full"><?= $__notifCount ?> mới</span>
                                <?php else: ?>
                                    <span class="text-[11px] font-semibold text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">Trống</span>
                                <?php endif; ?>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                <?php if ($__notifCount === 0): ?>
                                    <div class="px-4 py-10 text-center">
                                        <i class="fa-regular fa-bell-slash text-2xl text-gray-300"></i>
                                        <p class="text-sm text-gray-500 mt-2">Không có thông báo mới</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($__overdue as $n): ?>
                                        <a href="index.php?modun=Loan" class="flex gap-3 px-4 py-3 hover:bg-rose-50/60 border-b border-gray-50 transition">
                                            <span class="w-9 h-9 rounded-lg bg-rose-100 text-rose-500 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block text-[13px] font-semibold text-gray-800">Quá hạn trả sách</span>
                                                <span class="block text-xs text-gray-500 truncate"><?= htmlspecialchars($n->book_title) ?> — <?= htmlspecialchars($n->reader_name) ?></span>
                                                <span class="block text-[11px] text-rose-500 mt-0.5">Hạn trả: <?= date('d/m/Y', strtotime($n->due_date)) ?></span>
                                            </span>
                                        </a>
                                    <?php endforeach; ?>
                                    <?php foreach ($__dueSoon as $n): ?>
                                        <a href="index.php?modun=Loan" class="flex gap-3 px-4 py-3 hover:bg-amber-50/60 border-b border-gray-50 transition">
                                            <span class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-clock text-sm"></i>
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block text-[13px] font-semibold text-gray-800">Sắp đến hạn trả</span>
                                                <span class="block text-xs text-gray-500 truncate"><?= htmlspecialchars($n->book_title) ?> — <?= htmlspecialchars($n->reader_name) ?></span>
                                                <span class="block text-[11px] text-amber-600 mt-0.5">Hạn trả: <?= date('d/m/Y', strtotime($n->due_date)) ?></span>
                                            </span>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <a href="index.php?modun=Loan" class="block text-center text-[13px] font-semibold text-indigo-600 hover:bg-indigo-50 py-2.5 border-t border-gray-100 transition">
                                Xem tất cả phiếu mượn
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <span class="hidden md:inline-flex items-center text-xs font-semibold bg-emerald-50 text-emerald-600 px-3 py-2 rounded-full border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Hệ thống ổn định
                    </span>
                </div>
            </div>
        </header>

        <!-- ===== MAIN (vùng cuộn duy nhất, mở ở header - đóng ở footer.php) ===== -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6">

        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $__flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <?php $__ok = (($__flash['type'] ?? 'success') === 'success'); ?>
            <div class="mb-5 flex items-start gap-2.5 rounded-xl p-3.5 border <?= $__ok ? 'bg-emerald-50 border-emerald-100' : 'bg-rose-50 border-rose-100' ?>">
                <i class="fa-solid <?= $__ok ? 'fa-circle-check text-emerald-500' : 'fa-triangle-exclamation text-rose-500' ?> mt-0.5"></i>
                <p class="text-sm <?= $__ok ? 'text-emerald-700' : 'text-rose-700' ?>"><?= htmlspecialchars($__flash['msg'] ?? '') ?></p>
            </div>
        <?php endif; ?>
