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
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: #a5b4fc; }
        .sidebar-link { transition: all .2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,.08); }
        .sidebar-link.active { background: #fff; color: #312e81 !important; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
        .sidebar-link.active i { color: #4f46e5; }
        .card-hover { transition: all .25s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -8px rgba(79,70,229,.18); }
        .btn-primary { transition: all .2s ease; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 16px -4px rgba(79,70,229,.4); }
        .table-row-hover { transition: background .15s ease; }
        input:focus, select:focus { box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
    </style>
</head>
<body class="bg-[#f1f5f9] text-gray-800 antialiased">

<?php
$__modun = $_GET['modun'] ?? '';
$__action = $_GET['action'] ?? '';
$__isDashboard = ($__modun === '');
$__isDocGia = ($__modun === 'Docgia');
$__isBooks = ($__modun === 'Book');
?>

<div class="flex min-h-screen overflow-hidden">

    <!-- Mobile overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside id="sidebar" class="fixed md:static z-40 inset-y-0 left-0 w-[260px] shrink-0 bg-gradient-to-b from-indigo-950 via-indigo-900 to-indigo-900 text-white flex flex-col justify-between shadow-2xl -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="px-5 pt-6">
            <!-- Brand -->
            <div class="flex items-center space-x-3 px-1 mb-8">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-950/50 shrink-0">
                    <i class="fa-solid fa-book-open-reader text-xl text-white"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-lg font-extrabold tracking-tight leading-none">LibManager</p>
                    <p class="text-[11px] uppercase tracking-widest text-indigo-300 mt-1.5 font-medium">Thư viện thông minh</p>
                </div>
            </div>

            <!-- Menu label -->
            <p class="text-[11px] font-semibold uppercase tracking-widest text-indigo-300/80 px-3 mb-2">Menu chính</p>

            <!-- Nav -->
            <nav class="space-y-1.5">
                <a href="index.php"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isDashboard ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isDashboard ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chart-pie text-[15px]"></i>
                    </span>
                    <span>Dashboard</span>
                    <?php if ($__isDashboard): ?>
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                    <?php endif; ?>
                </a>

                <a href="index.php?modun=Docgia"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isDocGia ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isDocGia ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-[15px]"></i>
                    </span>
                    <span>Quản lý độc giả</span>
                    <?php if ($__isDocGia): ?>
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                    <?php endif; ?>
                </a>

                <a href="index.php?modun=Book"
                   class="sidebar-link flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm font-medium <?= $__isBooks ? 'active' : 'text-indigo-100' ?>">
                    <span class="w-8 h-8 rounded-lg <?= $__isBooks ? 'bg-indigo-100 text-indigo-600' : 'bg-white/10 text-indigo-200' ?> flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book text-[15px]"></i>
                    </span>
                    <span>Quản lý Sách</span>
                    <?php if ($__isBooks): ?>
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                    <?php endif; ?>
                </a>
                <span class="flex items-center space-x-3 py-2.5 px-3.5 rounded-xl text-sm text-indigo-200 cursor-not-allowed" title="Sắp ra mắt">
                    <span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-arrow-right-arrow-left text-[15px]"></i>
                    </span>
                    <span>Mượn / Trả</span>
                    <span class="ml-auto text-[10px] bg-white/10 px-2 py-0.5 rounded-full">Soon</span>
                </span>
            </nav>
        </div>

        <!-- Admin box -->
        <div class="p-5">
            <div class="bg-white/10 backdrop-blur rounded-2xl p-3.5 border border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="relative shrink-0">
                        <img class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover" src="https://ui-avatars.com/api/?name=Thu+Thu&background=6366f1&color=fff&bold=true" alt="Admin">
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 border-2 border-indigo-900 rounded-full"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">Thủ Thư Admin</p>
                        <p class="text-xs text-indigo-300">Quản trị viên</p>
                    </div>
                </div>
            </div>
            <p class="text-center text-[11px] text-indigo-300/70 mt-3">LibManager v1.0 &copy; 2026</p>
        </div>
    </aside>

    <!-- ===== CONTENT WRAPPER ===== -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">

        <!-- ===== TOPBAR ===== -->
        <header class="bg-white/90 backdrop-blur border-b border-gray-100 sticky top-0 z-20">
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
                            <a href="index.php" class="hover:text-indigo-600">Trang chủ</a>
                            <i class="fa-solid fa-chevron-right text-[9px] text-gray-300"></i>
                            <span class="text-gray-700 font-medium"><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : ($__isDocGia ? 'Độc giả' : 'Dashboard') ?></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <div class="relative hidden lg:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                        </span>
                        <input type="text" placeholder="Tìm kiếm sách, độc giả..."
                               class="w-64 pl-10 pr-4 py-2.5 text-sm bg-gray-100/80 border border-transparent rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <button class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 hidden sm:flex items-center justify-center text-gray-500 relative">
                        <i class="fa-regular fa-bell"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full border border-white"></span>
                    </button>
                    <span class="hidden md:inline-flex items-center text-xs font-semibold bg-emerald-50 text-emerald-600 px-3 py-2 rounded-full border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Hệ thống ổn định
                    </span>
                </div>
            </div>
        </header>

        <!-- ===== MAIN (mở, đóng ở footer.php) ===== -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6">
