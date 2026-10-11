<?php
$pageTitle = 'Quản lý mượn / trả';
require_once __DIR__ . "/../header.php";

$role    = $_SESSION['user']['role'] ?? 'user';
$isAdmin = ($role === 'admin');
$today   = date('Y-m-d');
?>

<!-- Page heading + actions -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-base shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
            </span>
            <?= $isAdmin ? 'Quản lý mượn / trả' : 'Phiếu mượn của tôi' ?>
        </h2>
        <p class="text-[13px] text-gray-500 mt-1.5 ml-[50px]">
            <?php if ($isAdmin): ?>
                Tổng cộng <span class="font-bold text-gray-800"><?= count($dsLoan ?? []) ?></span> phiếu trong hệ thống
            <?php else: ?>
                <span class="font-semibold text-gray-700"><?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? $_SESSION['user']['username'] ?? '') ?></span>
                <?php if (!empty($docGiaCode)): ?>
                    <span class="font-mono text-[11px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md ml-1"><?= htmlspecialchars($docGiaCode) ?></span>
                <?php endif; ?>
                <span class="text-gray-300 mx-1">•</span> Bạn có <span class="font-bold text-gray-800"><?= count($dsLoan ?? []) ?></span> phiếu
            <?php endif; ?>
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="index.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
        <?php if ($isAdmin): ?>
        <a href="index.php?modun=Loan&action=create" class="btn-primary inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-plus text-xs"></i> Ghi nhận mượn
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 mb-5">
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-clock-rotate-left"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $dangMuon ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Đang mượn</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-triangle-exclamation"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $quaHan ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Quá hạn</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-circle-check"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $daTra ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Đã trả</span>
        </span>
    </div>
</div>

<!-- Table card -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[900px]">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 text-[11px] uppercase tracking-wider">
                    <th class="text-left font-semibold px-5 py-3.5">Phiếu</th>
                    <th class="text-left font-semibold px-4 py-3.5">Độc giả</th>
                    <th class="text-left font-semibold px-4 py-3.5">Sách</th>
                    <th class="text-left font-semibold px-4 py-3.5">Ngày mượn</th>
                    <th class="text-left font-semibold px-4 py-3.5">Hạn trả</th>
                    <th class="text-left font-semibold px-4 py-3.5">Ngày trả</th>
                    <th class="text-center font-semibold px-4 py-3.5">Trạng thái</th>
                    <th class="text-center font-semibold px-5 py-3.5 w-[160px]">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($dsLoan)): ?>
                    <?php foreach ($dsLoan as $l): ?>
                        <?php
                            $isReturned = ($l->status === 'returned');
                            $isOverdue  = (!$isReturned && $l->status === 'borrowed' && $l->due_date < $today);
                        ?>
                        <tr class="table-row-hover hover:bg-indigo-50/40">
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center font-mono text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-lg">
                                    #<?= str_pad((string)$l->id, 4, '0', STR_PAD_LEFT) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-gray-900"><?= htmlspecialchars($l->ho_ten ?? $l->username ?? '—') ?></div>
                                <?php if (!empty($l->ma_doc_gia)): ?>
                                    <div class="font-mono text-[11px] text-gray-400"><?= htmlspecialchars($l->ma_doc_gia) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-medium text-gray-800 max-w-[220px] truncate" title="<?= htmlspecialchars($l->book_title ?? '') ?>">
                                    <?= htmlspecialchars($l->book_title ?? '—') ?>
                                </div>
                                <div class="text-[12px] text-gray-400 truncate max-w-[220px]"><?= htmlspecialchars($l->book_author ?? '') ?></div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 whitespace-nowrap"><?= !empty($l->borrow_date) ? htmlspecialchars(date('d/m/Y', strtotime($l->borrow_date))) : '—' ?></td>
                            <td class="px-4 py-3.5 whitespace-nowrap <?= $isOverdue ? 'text-rose-600 font-semibold' : 'text-gray-600' ?>">
                                <?= !empty($l->due_date) ? htmlspecialchars(date('d/m/Y', strtotime($l->due_date))) : '—' ?>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 whitespace-nowrap">
                                <?= !empty($l->return_date) ? htmlspecialchars(date('d/m/Y', strtotime($l->return_date))) : '<span class="text-gray-300">—</span>' ?>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <?php if ($isReturned): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Đã trả
                                    </span>
                                <?php elseif ($isOverdue): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-600 bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Quá hạn
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-600 bg-sky-50 border border-sky-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-clock text-[10px]"></i> Đang mượn
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <?php if (!$isReturned): ?>
                                        <a href="index.php?modun=Loan&action=return&id=<?= htmlspecialchars($l->id) ?>"
                                           data-confirm="Xác nhận đã nhận lại sách này?" data-confirm-type="success" data-confirm-ok="Đã nhận"
                                           title="Trả sách"
                                           class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 px-3 py-1.5 rounded-lg transition">
                                            <i class="fa-solid fa-rotate-left text-[11px]"></i> Trả
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($isAdmin): ?>
                                        <a href="index.php?modun=Loan&action=delete&id=<?= htmlspecialchars($l->id) ?>"
                                           data-confirm="Xóa phiếu mượn này?" data-confirm-type="danger" data-confirm-ok="Xoá"
                                           title="Xóa"
                                           class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 border border-rose-100 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-5 py-14 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-300 flex items-center justify-center text-2xl mx-auto">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                            </div>
                            <p class="font-semibold text-gray-700 mt-4">Chưa có phiếu mượn nào</p>
                            <p class="text-sm text-gray-400 mt-1">
                                <?= $isAdmin ? 'Hãy ghi nhận phiếu mượn đầu tiên.' : 'Bạn chưa mượn cuốn sách nào.' ?>
                            </p>
                            <?php if ($isAdmin): ?>
                                <a href="index.php?modun=Loan&action=create" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-white bg-indigo-600 px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                                    <i class="fa-solid fa-plus text-xs"></i> Ghi nhận mượn
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
