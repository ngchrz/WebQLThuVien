<?php
$pageTitle = 'Thêm quản trị viên';
require_once __DIR__ . "/../header.php";
?>

<!-- Breadcrumb back -->
<div class="mb-5">
    <a href="index.php?modun=User" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách tài khoản
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Form card -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-violet-50/60 to-transparent">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 text-white flex items-center justify-center text-lg shadow-lg shadow-violet-200 shrink-0">
                <i class="fa-solid fa-user-shield"></i>
            </span>
            <div>
                <h2 class="font-extrabold text-gray-900 text-lg leading-tight">Thêm quản trị viên</h2>
                <p class="text-[13px] text-gray-500 mt-0.5">Tạo tài khoản thủ thư / quản trị nội bộ</p>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mx-6 mt-5 flex items-start gap-2.5 rounded-xl bg-rose-50 border border-rose-100 p-3.5">
                <i class="fa-solid fa-triangle-exclamation text-rose-500 mt-0.5"></i>
                <p class="text-sm text-rose-700"><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="p-6 space-y-5">
            <!-- Tên đăng nhập -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tên đăng nhập <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-at text-gray-400 text-sm"></i></span>
                    <input type="text" name="username" required placeholder="VD: thuthu01"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Mật khẩu -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mật khẩu <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                    <input type="password" name="password" required minlength="6" placeholder="Ít nhất 6 ký tự"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Vai trò (cố định) -->
            <div>
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Vai trò</label>
                <div class="flex items-center gap-2.5 px-4 py-2.5 text-sm bg-gray-100 border border-gray-200 rounded-xl text-gray-600">
                    <i class="fa-solid fa-user-shield text-violet-500"></i>
                    Quản trị viên (admin) — cố định
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Tài khoản độc giả không tạo ở đây; độc giả tự đăng ký ở trang Đăng ký.</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-check text-xs"></i> Thêm quản trị viên
                </button>
                <a href="index.php?modun=User" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
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
            <h3 class="font-bold text-[15px]">Về tài khoản</h3>
            <ul class="text-[13px] text-indigo-100 mt-2.5 space-y-2 leading-relaxed">
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> <b>Độc giả</b>: tự đăng ký, gắn hồ sơ độc giả.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> <b>Quản trị viên</b>: tạo tại đây, có toàn quyền.</li>
                <li class="flex gap-2"><i class="fa-solid fa-check text-[11px] mt-1 text-emerald-300"></i> Mật khẩu được mã hóa an toàn.</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
