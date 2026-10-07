<?php
$pageTitle = 'Quản lý sách';
require_once __DIR__ . "/../header.php";
?>

<!-- Page heading + actions -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-base shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-book"></i>
            </span>
            Quản lý sách
        </h2>
        <!-- <p class="text-[13px] text-gray-500 mt-1.5 ml-[50px]">
            Tổng cộng <span class="font-bold text-gray-800"><?= $totalTitles ?></span> đầu sách
            (<span class="font-bold text-gray-800"><?= $totalQty ?></span> bản, còn
            <span class="font-bold text-gray-800"><?= $totalAvail ?></span> bản) trong kho
        </p> -->
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="index.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
        <a href="index.php?modun=Book&action=create" class="btn-primary inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-plus text-xs"></i> Thêm sách
        </a>
    </div>
</div>

<!-- Stats cards -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-5">
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-book"></i>
        </span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $totalTitles ?></span>
            <span class="block text-xs text-gray-500 mt-1">Đầu sách</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-layer-group"></i>
        </span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $totalQty ?></span>
            <span class="block text-xs text-gray-500 mt-1">Tổng số bản</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $totalAvail ?></span>
            <span class="block text-xs text-gray-500 mt-1">Bản còn lại</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $outOfStock ?></span>
            <span class="block text-xs text-gray-500 mt-1">Đầu sách hết hàng</span>
        </span>
    </div>
</div>

<!-- List card -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-solid fa-search text-gray-400 text-sm"></i>
            </span>
            <input id="searchBook" type="text" placeholder="Tìm theo tên sách, tác giả, NXB..."
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
        </div>
        <div class="flex items-center gap-2 text-xs">
            <select id="filterCategory" class="bg-gray-50 border border-gray-200 text-gray-600 font-medium text-xs px-3 py-2 rounded-full focus:outline-none focus:border-indigo-500">
                <option value="">Tất cả thể loại</option>
                <?php foreach ($catList as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="inline-flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 font-semibold px-3 py-2 rounded-full">
                <i class="fa-solid fa-book text-[11px]"></i> <?= $totalTitles ?> đầu sách
            </span>
        </div>
    </div>

    <!-- Book grid -->
    <div class="p-5">
        <?php if (!empty($dsbook)): ?>
            <div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                <?php foreach ($dsbook as $book): ?>
                    <?php
                        $qty = (int)($book->quantity ?? 0);
                        $avl = (int)($book->available ?? 0);
                        $cover = trim($book->cover_image ?? '');
                        $coverUrl = $cover !== '' ? 'img/product/' . rawurlencode($cover) : '';
                        $firstLetter = mb_substr($book->title ?? '?', 0, 1, 'UTF-8');
                        $isOut = $avl <= 0;
                    ?>
                    <div class="book-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col"
                         data-category="<?= htmlspecialchars($book->category ?? '') ?>">
                        <!-- Cover -->
                        <div class="relative w-full h-44 bg-gradient-to-br from-indigo-100 via-indigo-50 to-violet-100 flex items-center justify-center overflow-hidden">
                            <span class="text-5xl font-extrabold text-indigo-300 select-none"><?= htmlspecialchars($firstLetter) ?></span>
                            <?php if ($coverUrl): ?>
                                <img src="<?= htmlspecialchars($coverUrl) ?>" alt="<?= htmlspecialchars($book->title ?? 'Bìa sách') ?>"
                                     class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                            <?php endif; ?>
                            <span class="absolute top-2.5 left-2.5 inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-700 bg-white/90 backdrop-blur border border-indigo-100 px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-tag text-[10px]"></i> <?= htmlspecialchars($book->category ?? '—') ?>
                            </span>
                            <?php if ($isOut): ?>
                                <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-white bg-rose-500 px-2.5 py-1 rounded-full shadow">Hết hàng</span>
                            <?php else: ?>
                                <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-emerald-700 bg-emerald-100/95 border border-emerald-200 px-2.5 py-1 rounded-full">Còn <?= $avl ?>/<?= $qty ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Body -->
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-gray-900 leading-snug line-clamp-2"><?= htmlspecialchars($book->title ?? '') ?></h3>
                            <p class="text-[13px] text-gray-500 mt-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-nib text-[11px] text-gray-300"></i>
                                <?= htmlspecialchars($book->author ?? '—') ?>
                            </p>
                            <p class="text-[12px] text-gray-400 mt-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-building-columns text-[11px] text-gray-300"></i>
                                <?= htmlspecialchars($book->publisher ?? '—') ?>
                                <?php if (!empty($book->publish_year)): ?>
                                    <span class="text-gray-300">•</span> <?= htmlspecialchars($book->publish_year) ?>
                                <?php endif; ?>
                                <span class="text-gray-300">•</span> ID #<?= htmlspecialchars($book->id ?? '') ?>
                            </p>
                            <?php if (!empty($book->description)): ?>
                                <p class="text-[13px] text-gray-600 mt-2.5 leading-relaxed line-clamp-2"><?= htmlspecialchars($book->description) ?></p>
                            <?php endif; ?>
                            <!-- Stock bar -->
                            <div class="mt-3">
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full <?= $isOut ? 'bg-rose-400' : 'bg-gradient-to-r from-indigo-500 to-violet-500' ?>"
                                         style="width: <?= $qty > 0 ? round($avl / $qty * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                                <a href="index.php?modun=Book&action=update&id=<?= htmlspecialchars($book->id ?? '') ?>"
                                   title="Sửa"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-[13px] font-semibold text-amber-600 bg-amber-50 border border-amber-100 hover:bg-amber-500 hover:text-white hover:border-amber-500 px-3 py-2 rounded-xl transition">
                                    <i class="fa-solid fa-pen text-[11px]"></i> Sửa
                                </a>
                                <a href="index.php?modun=Book&action=delete&id=<?= htmlspecialchars($book->id ?? '') ?>"
                                   onclick="return confirm('Bạn có chắc muốn xóa sách này?');"
                                   title="Xóa"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-[13px] font-semibold text-rose-500 bg-rose-50 border border-rose-100 hover:bg-rose-500 hover:text-white hover:border-rose-500 px-3 py-2 rounded-xl transition">
                                    <i class="fa-solid fa-trash text-[11px]"></i> Xóa
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="px-5 py-14 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-300 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <p class="font-semibold text-gray-700 mt-4">Chưa có sách nào</p>
                <p class="text-sm text-gray-400 mt-1">Hãy nhập đầu sách đầu tiên vào kho.</p>
                <a href="index.php?modun=Book&action=create" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-white bg-indigo-600 px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus text-xs"></i> Thêm ngay
                </a>
            </div>
        <?php endif; ?>
        <p id="bookEmptySearch" class="hidden px-5 py-10 text-center text-sm text-gray-400">Không tìm thấy sách phù hợp từ khóa.</p>
    </div>
</div>

<script>
    // Lọc nhanh phía client theo từ khóa + thể loại (không ảnh hưởng logic PHP)
    (function () {
        var input = document.getElementById('searchBook');
        var select = document.getElementById('filterCategory');
        var grid = document.getElementById('bookGrid');
        var emptyMsg = document.getElementById('bookEmptySearch');
        if (!grid) return;
        function applyFilter() {
            var kw = input ? input.value.toLowerCase().trim() : '';
            var cat = select ? select.value : '';
            var visible = 0;
            grid.querySelectorAll('.book-card').forEach(function (card) {
                var byKw = !kw || card.innerText.toLowerCase().includes(kw);
                var byCat = !cat || (card.getAttribute('data-category') === cat);
                var show = byKw && byCat;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (emptyMsg) emptyMsg.classList.toggle('hidden', visible !== 0);
        }
        if (input) input.addEventListener('input', applyFilter);
        if (select) select.addEventListener('change', applyFilter);
    })();
</script>

<?php require_once __DIR__ . "/../footer.php"; ?>
