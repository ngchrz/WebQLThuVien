<?php
$pageTitle = 'Sửa thông tin độc giả';

require_once __DIR__ . "/../../Models/DocGiaModel.php";
require_once __DIR__ . "/../header.php";
?>

<div class="mb-5">
    <a href="index.php?modun=Docgia" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách
    </a>
</div>

<?php if (empty($docgia)): ?>
    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
        <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center text-2xl mx-auto">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h2 class="font-extrabold text-gray-900 text-lg mt-4">Không tìm thấy độc giả</h2>
        <p class="text-sm text-gray-500 mt-1.5">Bản ghi có thể đã bị xóa hoặc đường dẫn không đúng.</p>
        <a href="index.php?modun=Docgia" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-white bg-indigo-600 px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Về danh sách
        </a>
    </div>
<?php else: ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Form card -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-amber-50/80 to-transparent">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center text-lg shadow-lg shadow-amber-200 shrink-0">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            <div class="min-w-0">
                <h2 class="font-extrabold text-gray-900 text-lg leading-tight truncate">Sửa: <?= htmlspecialchars($docgia->ho_ten ?? '') ?></h2>
                <p class="text-[13px] text-gray-500 mt-0.5 flex items-center gap-2">
                    <span class="inline-flex items-center font-mono text-[11px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">
                        <?= htmlspecialchars($docgia->ma_doc_gia ?? '—') ?>
                    </span>
                    <span class="text-gray-300">•</span> ID #<?= htmlspecialchars($docgia->id_doc_gia ?? '') ?>
                </p>
            </div>
        </div>

        <!-- Giữ nguyên method POST + tên field để Controller xử lý, chỉ làm đẹp giao diện -->
        <form action="" method="POST" class="p-6 space-y-5">
            <!-- Mã độc giả (hiển thị, không sửa) -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mã độc giả</label>
                <input type="text" value="<?= htmlspecialchars($docgia->ma_doc_gia ?? '') ?>" disabled
                       class="w-full px-4 py-2.5 text-sm font-mono font-bold bg-gray-50 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed">
                <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1"><i class="fa-solid fa-lock text-[10px]"></i> Mã do hệ thống tự sinh, không thể chỉnh sửa.</p>
            </div>

            <!-- Họ tên -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Họ tên <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="hoten" required value="<?= htmlspecialchars($docgia->ho_ten ?? '') ?>" placeholder="Họ tên độc giả"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Ngày sinh -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Ngày sinh</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-regular fa-calendar text-gray-400 text-sm"></i>
                        </span>
                        <input type="date" name="ngaysinh" value="<?= htmlspecialchars($docgia->ngay_sinh ?? '') ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition text-gray-700">
                    </div>
                </div>
                <!-- Giới tính -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Giới tính</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="gioitinh" value="Nam" class="peer hidden" <?= (($docgia->gioi_tinh ?? 'Nam') === 'Nam') ? 'checked' : '' ?>>
                            <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:border-sky-500 peer-checked:shadow-lg peer-checked:shadow-sky-200 transition">
                                <i class="fa-solid fa-mars text-xs"></i> Nam
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gioitinh" value="Nữ" class="peer hidden" <?= (($docgia->gioi_tinh ?? '') === 'Nữ') ? 'checked' : '' ?>>
                            <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 peer-checked:shadow-lg peer-checked:shadow-pink-200 transition">
                                <i class="fa-solid fa-venus text-xs"></i> Nữ
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- SĐT -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Số điện thoại</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                    </span>
                    <input type="text" name="sdt" value="<?= htmlspecialchars($docgia->so_dien_thoai ?? '') ?>" placeholder="Số điện thoại"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Địa chỉ -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Địa chỉ</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-location-dot text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="diachi" value="<?= htmlspecialchars($docgia->dia_chi ?? '') ?>" placeholder="Địa chỉ"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Lưu thay đổi
                </button>
                <a href="index.php?modun=Docgia" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Preview card -->
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-3xl font-extrabold mx-auto shadow-lg shadow-indigo-200">
                <?= htmlspecialchars(mb_substr($docgia->ho_ten ?? '?', 0, 1, 'UTF-8')) ?>
            </div>
            <h3 class="font-bold text-gray-900 mt-3 leading-tight"><?= htmlspecialchars($docgia->ho_ten ?? '') ?></h3>
            <p class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 inline-block px-2.5 py-1 rounded-lg mt-2">
                <?= htmlspecialchars($docgia->ma_doc_gia ?? '') ?>
            </p>
            <div class="text-left text-[13px] text-gray-600 mt-4 space-y-2.5 border-t border-gray-100 pt-4">
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-regular fa-calendar text-xs"></i></span> <?= !empty($docgia->ngay_sinh) ? htmlspecialchars(date('d/m/Y', strtotime($docgia->ngay_sinh))) : '—' ?></p>
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-phone text-xs"></i></span> <?= htmlspecialchars($docgia->so_dien_thoai ?? '—') ?></p>
                <p class="flex items-start gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-location-dot text-xs"></i></span> <span class="leading-relaxed"><?= htmlspecialchars($docgia->dia_chi ?? '—') ?></span></p>
            </div>
        </div>
        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4 flex gap-3">
            <span class="w-9 h-9 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-circle-info"></i>
            </span>
            <p class="text-xs text-amber-800 leading-relaxed">Mọi thay đổi sẽ được áp dụng ngay sau khi nhấn <b>Lưu thay đổi</b>. Hãy kiểm tra kỹ trước khi xác nhận.</p>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . "/../footer.php"; ?>
