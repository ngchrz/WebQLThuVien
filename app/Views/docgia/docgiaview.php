<?php
$pageTitle = 'Danh sách độc giả';
require_once __DIR__ . "/../header.php";
?>

<!-- Page heading + actions -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-base shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-users"></i>
            </span>
            Danh sách độc giả
        </h2>
        <p class="text-[13px] text-gray-500 mt-1.5 ml-[50px]">
            Tổng cộng <span class="font-bold text-gray-800"><?= count($dsDocGia ?? []) ?></span> độc giả trong hệ thống
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="index.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
        <a href="index.php?modun=Docgia&action=create" class="btn-primary inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-plus text-xs"></i> Thêm độc giả
        </a>
    </div>
</div>

<!-- Table card -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-solid fa-search text-gray-400 text-sm"></i>
            </span>
            <input id="searchDocGia" type="text" placeholder="Tìm theo tên, mã, SĐT..."
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-200 text-gray-600 font-medium px-3 py-2 rounded-full">
                <i class="fa-solid fa-filter text-gray-400"></i> Tất cả
            </span>
            <span class="inline-flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 font-semibold px-3 py-2 rounded-full">
                <i class="fa-solid fa-users text-[11px]"></i> <?= count($dsDocGia ?? []) ?> records
            </span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[820px]">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 text-[11px] uppercase tracking-wider">
                    <th class="text-left font-semibold px-5 py-3.5">Mã độc giả</th>
                    <th class="text-left font-semibold px-4 py-3.5">Họ tên</th>
                    <th class="text-left font-semibold px-4 py-3.5">Ngày sinh</th>
                    <th class="text-left font-semibold px-4 py-3.5">Giới tính</th>
                    <th class="text-left font-semibold px-4 py-3.5">SĐT</th>
                    <th class="text-left font-semibold px-4 py-3.5">Địa chỉ</th>
                    <th class="text-center font-semibold px-5 py-3.5 w-[140px]">Hành động</th>
                </tr>
            </thead>
            <tbody id="docGiaBody" class="divide-y divide-gray-100">
                <?php if (!empty($dsDocGia)): ?>
                    <?php foreach ($dsDocGia as $doc_gia): ?>
                        <tr class="table-row-hover hover:bg-indigo-50/40">
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center font-mono text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-lg">
                                    <?= htmlspecialchars($doc_gia->ma_doc_gia ?? '—'); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <span class="font-semibold text-gray-900"><?= htmlspecialchars($doc_gia->ho_ten ?? ''); ?></span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 whitespace-nowrap">
                                <?= !empty($doc_gia->ngay_sinh) ? htmlspecialchars(date('d/m/Y', strtotime($doc_gia->ngay_sinh))) : '<span class="text-gray-300">—</span>'; ?>
                            </td>
                            <td class="px-4 py-3.5">
                                <?php if (($doc_gia->gioi_tinh ?? '') === 'Nữ'): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-pink-600 bg-pink-50 border border-pink-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-venus text-[10px]"></i> Nữ
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-600 bg-sky-50 border border-sky-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-mars text-[10px]"></i> Nam
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 font-medium whitespace-nowrap">
                                <i class="fa-solid fa-phone text-[11px] text-gray-300 mr-1.5"></i><?= htmlspecialchars($doc_gia->so_dien_thoai ?? '—'); ?>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 max-w-[220px] truncate" title="<?= htmlspecialchars($doc_gia->dia_chi ?? ''); ?>">
                                <?= htmlspecialchars($doc_gia->dia_chi ?? '—'); ?>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="index.php?modun=Docgia&action=update&id_docgia=<?= htmlspecialchars($doc_gia->id_doc_gia); ?>"
                                       title="Sửa"
                                       class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 border border-amber-100 hover:bg-amber-500 hover:text-white hover:border-amber-500 flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('Bạn có chắc muốn xóa độc giả này?');"
                                       title="Xóa"
                                       class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 border border-rose-100 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-300 flex items-center justify-center text-2xl mx-auto">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <p class="font-semibold text-gray-700 mt-4">Chưa có độc giả nào</p>
                            <p class="text-sm text-gray-400 mt-1">Hãy thêm độc giả đầu tiên vào hệ thống.</p>
                            <a href="index.php?modun=Docgia&action=create" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-white bg-indigo-600 px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                                <i class="fa-solid fa-plus text-xs"></i> Thêm ngay
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Lọc nhanh phía client (không ảnh hưởng logic PHP)
    (function () {
        var input = document.getElementById('searchDocGia');
        var body = document.getElementById('docGiaBody');
        if (!input || !body) return;
        input.addEventListener('input', function () {
            var kw = this.value.toLowerCase().trim();
            body.querySelectorAll('tr').forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(kw) ? '' : 'none';
            });
        });
    })();
</script>

<?php require_once __DIR__ . "/../footer.php"; ?>
