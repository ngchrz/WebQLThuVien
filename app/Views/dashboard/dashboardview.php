<?php
$pageTitle = 'Dashboard tổng quan';

require_once __DIR__ . "/../header.php";

?>

<!-- Greeting banner -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 text-white p-6 sm:p-8 mb-6 shadow-lg shadow-indigo-200">
    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full"></div>
    <div class="absolute right-20 -bottom-16 w-40 h-40 bg-white/10 rounded-full"></div>
    <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden md:flex w-20 h-20 bg-white/15 rounded-2xl items-center justify-center text-4xl backdrop-blur">
        <i class="fa-solid fa-book-open-reader"></i>
    </div>
    <div class="relative">
        <p class="text-indigo-200 text-sm font-medium flex items-center gap-2">
            <i class="fa-regular fa-calendar"></i> <?= date('d/m/Y') ?> — Chào mừng trở lại
        </p>
        <h2 class="text-xl sm:text-2xl font-extrabold mt-1.5 tracking-tight">Thư viện đang hoạt động tốt hôm nay</h2>
        <p class="text-indigo-100/90 text-sm mt-1.5 max-w-xl">Theo dõi tổng số sách, độc giả và lượt mượn trả ngay tại một nơi tập trung, trực quan.</p>
        <div class="flex flex-wrap gap-2.5 mt-4">
            <a href="index.php?modun=Docgia" class="btn-primary inline-flex items-center gap-2 bg-white text-indigo-700 text-sm font-semibold px-4 py-2.5 rounded-xl">
                <i class="fa-solid fa-users text-xs"></i> Quản lý độc giả
            </a>
            <a href="index.php?modun=Docgia&action=create" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-sm font-semibold px-4 py-2.5 rounded-xl border border-white/20 transition">
                <i class="fa-solid fa-plus text-xs"></i> Thêm độc giả mới
            </a>
        </div>
    </div>
</div>

<!-- Stats cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

    <!-- Card sách -->
    <div class="card-hover bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[13px] font-medium text-gray-500 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 inline-block"></span> Tổng số sách
            </p>
            <h3 class="text-[28px] leading-8 font-extrabold text-gray-900 mt-2"><?= $tongSoSach ?? 0; ?></h3>
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full inline-flex items-center gap-1 mt-2.5 border border-emerald-100">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> Kho sách vật lý & điện tử
            </span>
        </div>
        <div class="shrink-0 w-[52px] h-[52px] bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-book"></i>
        </div>
    </div>

    <!-- Card độc giả -->
    <div class="card-hover bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[13px] font-medium text-gray-500 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> Tổng độc giả
            </p>
            <h3 class="text-[28px] leading-8 font-extrabold text-gray-900 mt-2"><?= $tongSoDocGia ?? 0; ?></h3>
            <span class="text-[11px] font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full inline-flex items-center gap-1 mt-2.5 border border-amber-100">
                <i class="fa-solid fa-circle-check text-[10px]"></i> Thành viên đang hoạt động
            </span>
        </div>
        <div class="shrink-0 w-[52px] h-[52px] bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-amber-200">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Card đang mượn -->
    <div class="card-hover bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[13px] font-medium text-gray-500 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-500 inline-block"></span> Lượt đang mượn
            </p>
            <h3 class="text-[28px] leading-8 font-extrabold text-gray-900 mt-2">48</h3>
            <span class="text-[11px] font-semibold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full inline-flex items-center gap-1 mt-2.5 border border-sky-100">
                <i class="fa-solid fa-clock text-[10px]"></i> Cần theo dõi hạn trả
            </span>
        </div>
        <div class="shrink-0 w-[52px] h-[52px] bg-gradient-to-br from-sky-400 to-blue-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-sky-200">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
    </div>

    <!-- Card hệ thống -->
    <div class="card-hover bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[13px] font-medium text-gray-500 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-500 inline-block"></span> Người dùng hệ thống
            </p>
            <h3 class="text-[28px] leading-8 font-extrabold text-gray-900 mt-2">6</h3>
            <span class="text-[11px] font-semibold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-full inline-flex items-center gap-1 mt-2.5 border border-violet-100">
                <i class="fa-solid fa-user-shield text-[10px]"></i> Quản trị & thủ thư
            </span>
        </div>
        <div class="shrink-0 w-[52px] h-[52px] bg-gradient-to-br from-violet-500 to-purple-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-violet-200">
            <i class="fa-solid fa-user-shield"></i>
        </div>
    </div>
</div>

<!-- Lower section: quick actions + info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 mt-5">

    <!-- Quick actions -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-900">Thao tác nhanh</h3>
                <p class="text-xs text-gray-500 mt-0.5">Các chức năng thường dùng trong ngày</p>
            </div>
            <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-bolt"></i>
            </span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="index.php?modun=Docgia&action=create" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                <span class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <i class="fa-solid fa-user-plus"></i>
                </span>
                <span>
                    <span class="block text-sm font-semibold text-gray-800">Thêm độc giả</span>
                    <span class="block text-xs text-gray-500 mt-0.5">Tạo thẻ thành viên mới</span>
                </span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-300 ml-auto group-hover:text-indigo-500 group-hover:translate-x-0.5 transition"></i>
            </a>
            <a href="index.php?modun=Docgia" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                <span class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <i class="fa-solid fa-list-ul"></i>
                </span>
                <span>
                    <span class="block text-sm font-semibold text-gray-800">Danh sách độc giả</span>
                    <span class="block text-xs text-gray-500 mt-0.5">Tra cứu & chỉnh sửa</span>
                </span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-300 ml-auto group-hover:text-indigo-500 group-hover:translate-x-0.5 transition"></i>
            </a>
            <span class="flex items-center gap-3 p-4 rounded-xl border border-dashed border-gray-200 bg-gray-50/60 opacity-70">
                <span class="w-11 h-11 rounded-xl bg-gray-200 text-gray-500 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-book-medical"></i>
                </span>
                <span>
                    <span class="block text-sm font-semibold text-gray-600">Nhập sách mới</span>
                    <span class="block text-xs text-gray-400 mt-0.5">Sắp ra mắt</span>
                </span>
            </span>
            <span class="flex items-center gap-3 p-4 rounded-xl border border-dashed border-gray-200 bg-gray-50/60 opacity-70">
                <span class="w-11 h-11 rounded-xl bg-gray-200 text-gray-500 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                </span>
                <span>
                    <span class="block text-sm font-semibold text-gray-600">Ghi nhận mượn / trả</span>
                    <span class="block text-xs text-gray-400 mt-0.5">Sắp ra mắt</span>
                </span>
            </span>
        </div>
    </div>

    <!-- System status -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-900">Trạng thái</h3>
                <p class="text-xs text-gray-500 mt-0.5">Tổng quan hoạt động</p>
            </div>
            <span class="inline-flex items-center text-[11px] font-semibold bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full border border-emerald-100">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Ổn định
            </span>
        </div>
        <div class="space-y-3.5 text-sm">
            <div>
                <div class="flex justify-between text-xs font-medium mb-1.5">
                    <span class="text-gray-600">Tỉ lệ sách đang được mượn</span>
                    <span class="text-gray-900 font-bold">32%</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-[32%] bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-xs font-medium mb-1.5">
                    <span class="text-gray-600">Độc giả hoạt động</span>
                    <span class="text-gray-900 font-bold">86%</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-[86%] bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-xs font-medium mb-1.5">
                    <span class="text-gray-600">Đúng hạn trả sách</span>
                    <span class="text-gray-900 font-bold">94%</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-[94%] bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full"></div>
                </div>
            </div>
        </div>
        <div class="mt-auto pt-5">
            <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-3.5 flex gap-3">
                <span class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 text-sm">
                    <i class="fa-solid fa-circle-info"></i>
                </span>
                <p class="text-xs text-indigo-700 leading-relaxed">Số liệu tổng hợp theo thời gian thực từ kho sách và danh sách độc giả. Chi tiết xem ở từng module quản lý.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
