<?php
$pageTitle = 'Thêm độc giả mới';
require_once __DIR__ . "/../header.php";
?>

<!-- Breadcrumb back -->
<div class="mb-5">
    <a href="index.php?modun=Docgia" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Form card -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-indigo-50/60 to-transparent">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-200 shrink-0">
                <i class="fa-solid fa-user-plus"></i>
            </span>
            <div>
                <h2 class="font-extrabold text-gray-900 text-lg leading-tight">Thêm độc giả mới</h2>
                <p class="text-[13px] text-gray-500 mt-0.5">Điền đầy đủ thông tin để tạo thẻ thành viên</p>
            </div>
        </div>

        <form action="" method="POST" class="p-6 space-y-5">
            <!-- Họ tên -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                    Họ tên <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="hoten" required placeholder="VD: Nguyễn Văn An"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Ngày sinh -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                        Ngày sinh <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-regular fa-calendar text-gray-400 text-sm"></i>
                        </span>
                        <input type="date" name="ngaysinh" required
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition text-gray-700">
                    </div>
                </div>
                <!-- Giới tính -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Giới tính</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="gioitinh" value="Nam" class="peer hidden" checked>
                            <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:border-sky-500 peer-checked:shadow-lg peer-checked:shadow-sky-200 transition">
                                <i class="fa-solid fa-mars text-xs"></i> Nam
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gioitinh" value="Nữ" class="peer hidden">
                            <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 peer-checked:shadow-lg peer-checked:shadow-pink-200 transition">
                                <i class="fa-solid fa-venus text-xs"></i> Nữ
                            </span>
                        </label>
                    </div>
                    <!-- fallback select ẩn cho tương thích: vẫn giữ name gioitinh qua radio ở trên -->
                </div>
            </div>

            <!-- SĐT -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                    Số điện thoại <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                    </span>
                    <input type="text" name="sdt" required placeholder="VD: 0912345678"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <!-- Địa chỉ -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Địa chỉ</label>
                <div class="relative">
                    <span class="absolute top-3 left-0 flex items-start pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-location-dot text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="diachi" placeholder="VD: 123 Nguyễn Huệ, Q.1, TP.HCM"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-check text-xs"></i> Thêm độc giả
                </button>
                <a href="index.php?modun=Docgia" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Side hint -->
    <div class="space-y-4">
        <div class="bg-gradient-to-br from-indigo-600 to-violet-600 text-white rounded-2xl p-5 shadow-lg shadow-indigo-200">
            <span class="w-10 h-10 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center mb-3">
                <i class="fa-solid fa-lightbulb"></i>
            </span>
            <h3 class="font-bold text-[15px]">Lưu ý khi nhập liệu</h3>
            <ul class="text-[13px] text-indigo-100 mt-2.5 space-y-2 leading-relaxed">
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Mã độc giả (VD: DG001) được hệ thống tự sinh sau khi lưu.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Kiểm tra kỹ số điện thoại để liên lạc khi đến hạn trả.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Ngày sinh dùng để thống kê độ tuổi bạn đọc.</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-indigo-500"></i> Các bước tiếp theo
            </h3>
            <ol class="mt-3 space-y-2.5 text-[13px] text-gray-600">
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">1</span> Nhập thông tin & nhấn lưu</li>
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">2</span> Hệ thống tự tạo mã DGxxx</li>
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">3</span> Độc giả có thể mượn sách ngay</li>
            </ol>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
