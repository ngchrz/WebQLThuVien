<?php
$pageTitle = 'Sửa thông tin sách';

require_once __DIR__ . "/../header.php";
?>

<div class="mb-5">
    <a href="index.php?modun=Book" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách sách
    </a>
</div>

<?php if (empty($book)): ?>
    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
        <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center text-2xl mx-auto">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h2 class="font-extrabold text-gray-900 text-lg mt-4">Không tìm thấy sách</h2>
        <p class="text-sm text-gray-500 mt-1.5">Bản ghi có thể đã bị xóa hoặc đường dẫn không đúng.</p>
        <a href="index.php?modun=Book" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-white bg-indigo-600 px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Về danh sách
        </a>
    </div>
<?php else: ?>
<?php
    $cover = trim($book->cover_image ?? '');
    $coverUrl = $cover !== '' ? 'img/product/' . rawurlencode($cover) : '';
    $firstLetter = mb_substr($book->title ?? '?', 0, 1, 'UTF-8');
    $qty = (int)($book->quantity ?? 0);
    $avl = (int)($book->available ?? 0);
?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Form card -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-amber-50/80 to-transparent">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center text-lg shadow-lg shadow-amber-200 shrink-0">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            <div class="min-w-0">
                <h2 class="font-extrabold text-gray-900 text-lg leading-tight truncate">Sửa: <?= htmlspecialchars($book->title ?? '') ?></h2>
                <p class="text-[13px] text-gray-500 mt-0.5 flex items-center gap-2">
                    <span class="text-gray-400">ID #<?= htmlspecialchars($book->id ?? '') ?></span>
                    <span class="text-gray-300">•</span>
                    <span class="inline-flex items-center text-[11px] font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">
                        <?= htmlspecialchars($book->category ?? '—') ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Giữ nguyên method POST + tên field khớp cột bảng books để Controller xử lý -->
        <form action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            <!-- Tên sách -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tên sách <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-book text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="title" required value="<?= htmlspecialchars($book->title ?? '') ?>" placeholder="Tên sách"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Tác giả -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tác giả <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-pen-nib text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="author" required value="<?= htmlspecialchars($book->author ?? '') ?>" placeholder="Tác giả"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Thể loại -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Thể loại <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-tag text-gray-400 text-xs"></i>
                        </span>
                        <input type="text" name="category" required list="suggestCategory" value="<?= htmlspecialchars($book->category ?? '') ?>" placeholder="Thể loại"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                        <datalist id="suggestCategory">
                            <option value="Đồng thoại"></option>
                            <option value="Tiểu thuyết"></option>
                            <option value="Truyện dài"></option>
                            <option value="Fantasy"></option>
                            <option value="Kỹ năng sống"></option>
                        </datalist>
                    </div>
                </div>
                <!-- Năm xuất bản -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Năm xuất bản</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-regular fa-calendar text-gray-400 text-sm"></i>
                        </span>
                        <input type="number" name="publish_year" min="0" max="<?= date('Y') ?>" value="<?= htmlspecialchars($book->publish_year ?? '') ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Nhà xuất bản -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Nhà xuất bản</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-building-columns text-gray-400 text-xs"></i>
                    </span>
                    <input type="text" name="publisher" value="<?= htmlspecialchars($book->publisher ?? '') ?>" placeholder="Nhà xuất bản"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tổng số lượng -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tổng số bản <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-layer-group text-gray-400 text-xs"></i>
                        </span>
                        <input type="number" id="quantity" name="quantity" required min="0" value="<?= $qty ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
                <!-- Số bản còn lại -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Số bản còn lại</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-circle-check text-gray-400 text-xs"></i>
                        </span>
                        <input type="number" id="available" name="available" min="0" value="<?= $avl ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Phải từ 0 đến tổng số bản.</p>
                </div>
            </div>

            <!-- Mô tả -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mô tả</label>
                <div class="relative">
                    <span class="absolute top-3 left-0 flex items-start pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-align-left text-gray-400 text-sm"></i>
                    </span>
                    <textarea name="description" rows="3" placeholder="Tóm tắt nội dung sách..."
                              class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition resize-y"><?= htmlspecialchars($book->description ?? '') ?></textarea>
                </div>
            </div>

            <!-- Ảnh bìa -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Ảnh bìa</label>
                <div class="flex items-start gap-3">
                    <div class="w-20 h-28 rounded-xl bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-400 flex items-center justify-center text-2xl font-extrabold shrink-0 overflow-hidden relative">
                        <span><?= htmlspecialchars($firstLetter) ?></span>
                        <?php if ($coverUrl): ?>
                            <img id="currentCover" src="<?= htmlspecialchars($coverUrl) ?>" alt="Bìa hiện tại"
                                 class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="coverInput" name="cover_image" accept="image/*"
                               class="w-full text-sm text-gray-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:transition bg-gray-50 border border-gray-200 rounded-xl focus:outline-none transition">
                        <input type="hidden" name="current_cover" value="<?= htmlspecialchars($cover) ?>">
                        <p class="text-[11px] text-gray-400 mt-1">
                            Đang dùng: <span class="font-mono"><?= $cover !== '' ? htmlspecialchars($cover) : 'chưa có ảnh' ?></span>.
                            Chọn file mới để thay, bỏ trống để giữ nguyên.
                        </p>
                        <p id="newCoverName" class="hidden text-[11px] text-emerald-600 font-medium mt-1"></p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Lưu thay đổi
                </button>
                <a href="index.php?modun=Book" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Preview card -->
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <div class="w-full h-48 rounded-2xl bg-gradient-to-br from-indigo-100 via-indigo-50 to-violet-100 text-indigo-300 flex items-center justify-center text-5xl font-extrabold mx-auto shadow-sm overflow-hidden relative">
                <span><?= htmlspecialchars($firstLetter) ?></span>
                <?php if ($coverUrl): ?>
                    <img src="<?= htmlspecialchars($coverUrl) ?>" alt="<?= htmlspecialchars($book->title ?? 'Bìa sách') ?>"
                         class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                <?php endif; ?>
            </div>
            <h3 class="font-bold text-gray-900 mt-3 leading-tight"><?= htmlspecialchars($book->title ?? '') ?></h3>
            <p class="text-[13px] text-gray-500 mt-1"><?= htmlspecialchars($book->author ?? '') ?></p>
            <p class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 inline-block px-2.5 py-1 rounded-lg mt-2">
                <?= htmlspecialchars($book->category ?? '') ?>
            </p>
            <div class="text-left text-[13px] text-gray-600 mt-4 space-y-2.5 border-t border-gray-100 pt-4">
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-layer-group text-xs"></i></span> Tổng <?= $qty ?> bản • Còn <?= $avl ?> bản</p>
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-building-columns text-xs"></i></span> <?= htmlspecialchars(($book->publisher ?? '—') . (!empty($book->publish_year) ? ' • ' . $book->publish_year : '')) ?></p>
            </div>
        </div>
        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4 flex gap-3">
            <span class="w-9 h-9 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-circle-info"></i>
            </span>
            <p class="text-xs text-amber-800 leading-relaxed">Mọi thay đổi sẽ được áp dụng ngay sau khi nhấn <b>Lưu thay đổi</b>. Giảm tổng số bản thấp hơn số đang cho mượn có thể gây âm kho.</p>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Chặn còn lại vượt tổng số + hiện tên file bìa mới
    (function () {
        var qty = document.getElementById('quantity');
        var avl = document.getElementById('available');
        if (qty && avl && qty.closest('form')) {
            qty.closest('form').addEventListener('submit', function (e) {
                var q = parseInt(qty.value || '0', 10);
                var a = parseInt(avl.value || '0', 10);
                if (isNaN(q) || q < 0 || isNaN(a) || a < 0 || a > q) {
                    e.preventDefault();
                    alert('Số bản còn lại phải từ 0 đến tổng số bản.');
                    avl.focus();
                }
            });
        }
        var fileInput = document.getElementById('coverInput');
        var nameMsg = document.getElementById('newCoverName');
        if (fileInput && nameMsg) {
            fileInput.addEventListener('change', function () {
                var file = this.files && this.files[0];
                if (file) {
                    nameMsg.textContent = 'Ảnh mới: ' + file.name + ' (bìa cũ giữ lại đến khi lưu)';
                    nameMsg.classList.remove('hidden');
                } else {
                    nameMsg.classList.add('hidden');
                }
            });
        }
    })();
</script>

<?php require_once __DIR__ . "/../footer.php"; ?>
