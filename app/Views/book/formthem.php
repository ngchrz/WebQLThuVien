<?php
$pageTitle = 'Thêm sách mới';
require_once __DIR__ . "/../header.php";
?>

<!-- Breadcrumb back -->
<div class="mb-5">
    <a href="index.php?modun=Book" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách sách
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Form card -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-indigo-50/60 to-transparent">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-200 shrink-0">
                <i class="fa-solid fa-book-medical"></i>
            </span>
            <div>
                <h2 class="font-extrabold text-gray-900 text-lg leading-tight">Thêm sách mới</h2>
                <p class="text-[13px] text-gray-500 mt-0.5">Điền đầy đủ thông tin để nhập sách vào kho</p>
            </div>
        </div>

        <!-- Tên field khớp cột bảng books để Controller xử lý -->
        <form action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            <!-- Tên sách -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                    Tên sách <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-book text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="title" required placeholder="VD: Harry Potter và hòn đá phù thủy"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <!-- Tác giả -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                    Tác giả <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-solid fa-pen-nib text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" name="author" required placeholder="VD: Nguyễn Nhật Ánh"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Thể loại -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                        Thể loại <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-tag text-gray-400 text-xs"></i>
                        </span>
                        <input type="text" name="category" required list="suggestCategory" placeholder="VD: Tiểu thuyết"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
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
                        <input type="number" name="publish_year" min="0" max="<?= date('Y') ?>" placeholder="VD: 2020"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
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
                    <input type="text" name="publisher" placeholder="VD: NXB Trẻ"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tổng số lượng -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                        Tổng số bản <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-layer-group text-gray-400 text-xs"></i>
                        </span>
                        <input type="number" id="quantity" name="quantity" required min="0" value="1"
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
                        <input type="number" id="available" name="available" min="0" placeholder="Để trống = bằng tổng số"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Bỏ trống thì mặc định còn lại = tổng số bản.</p>
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
                              class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition placeholder:text-gray-400 resize-y"></textarea>
                </div>
            </div>

            <!-- Ảnh bìa -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Ảnh bìa</label>
                <div class="flex items-start gap-3">
                    <div id="coverPreview" class="w-20 h-28 rounded-xl bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-300 hidden items-center justify-center text-2xl font-extrabold shrink-0 overflow-hidden">
                        <img id="coverPreviewImg" src="#" alt="Xem trước bìa" class="w-full h-full object-cover hidden">
                        <span id="coverPreviewLetter">?</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="cover_image" accept="image/*"
                               class="w-full text-sm text-gray-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:transition bg-gray-50 border border-gray-200 rounded-xl focus:outline-none transition">
                        <p class="text-[11px] text-gray-400 mt-1">File ảnh lưu vào <span class="font-mono">uploads/covers/</span>, tên file ghi vào cột <span class="font-mono">cover_image</span>.</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-check text-xs"></i> Thêm sách
                </button>
                <a href="index.php?modun=Book" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
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
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Tên sách, tác giả, thể loại và tổng số bản là bắt buộc.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Số bản còn lại không được vượt quá tổng số bản.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Thể loại gõ mới sẽ tự tạo nhóm lọc ngoài danh sách.</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-indigo-500"></i> Các bước tiếp theo
            </h3>
            <ol class="mt-3 space-y-2.5 text-[13px] text-gray-600">
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">1</span> Nhập thông tin & nhấn lưu</li>
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">2</span> Sách xuất hiện trong kho ngay</li>
                <li class="flex items-center gap-2.5"><span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0">3</span> Độc giả có thể mượn ngay</li>
            </ol>
        </div>
    </div>
</div>

<script>
    // Tự điền số bản còn lại = tổng số khi chưa nhập, xem trước ảnh bìa
    (function () {
        var qty = document.getElementById('quantity');
        var avl = document.getElementById('available');
        if (qty && avl) {
            qty.addEventListener('input', function () {
                if (avl.value === '' || parseInt(avl.value, 10) > parseInt(qty.value || '0', 10)) {
                    avl.placeholder = 'Để trống = ' + (qty.value || '0');
                }
            });
            var form = qty.closest('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    var q = parseInt(qty.value || '0', 10);
                    var a = avl.value === '' ? q : parseInt(avl.value, 10);
                    if (isNaN(q) || q < 0 || isNaN(a) || a < 0 || a > q) {
                        e.preventDefault();
                        alert('Số bản còn lại phải từ 0 đến tổng số bản.');
                        avl.focus();
                    }
                });
            }
        }
        var fileInput = document.querySelector('input[name="cover_image"]');
        var preview = document.getElementById('coverPreview');
        var previewImg = document.getElementById('coverPreviewImg');
        var previewLetter = document.getElementById('coverPreviewLetter');
        var titleInput = document.querySelector('input[name="title"]');
        if (titleInput && previewLetter) {
            titleInput.addEventListener('input', function () {
                previewLetter.textContent = (this.value.trim().charAt(0) || '?').toUpperCase();
            });
        }
        if (fileInput && preview) {
            fileInput.addEventListener('change', function () {
                var file = this.files && this.files[0];
                if (!file) return;
                var url = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                preview.classList.add('flex');
                previewImg.src = url;
                previewImg.classList.remove('hidden');
                if (previewLetter) previewLetter.classList.add('hidden');
            });
        }
    })();
</script>

<?php require_once __DIR__ . "/../footer.php"; ?>
