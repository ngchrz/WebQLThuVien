<?php
$pageTitle = 'Thông tin cá nhân';
require_once __DIR__ . "/../header.php";

$isAdmin = (($_SESSION['user']['role'] ?? 'user') === 'admin');
$hasDocGia = !empty($docgia);
?>

<!-- Heading -->
<div class="mb-5">
    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-base shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-id-badge"></i>
        </span>
        Thông tin cá nhân
    </h2>
    <p class="text-[13px] text-gray-500 mt-1.5 ml-[50px]">Xem và cập nhật tài khoản của bạn</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- Cột trái -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Cập nhật thông tin -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-indigo-50/60 to-transparent">
                <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-lg shadow-lg shadow-indigo-200 shrink-0">
                    <i class="fa-solid fa-user-pen"></i>
                </span>
                <div>
                    <h2 class="font-extrabold text-gray-900 text-lg leading-tight">Cập nhật thông tin</h2>
                    <p class="text-[13px] text-gray-500 mt-0.5">Chỉnh sửa tài khoản và hồ sơ độc giả của bạn</p>
                </div>
            </div>

            <form action="index.php?modun=Profile&action=update" method="POST" class="p-6 space-y-5">
                <!-- Tên đăng nhập -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tên đăng nhập <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-at text-gray-400 text-sm"></i></span>
                        <input type="text" name="username" required value="<?= htmlspecialchars($user->username ?? '') ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>

                <?php if ($hasDocGia): ?>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Họ tên <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-user text-gray-400 text-sm"></i></span>
                            <input type="text" name="ho_ten" required value="<?= htmlspecialchars($docgia->ho_ten ?? '') ?>"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Ngày sinh</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-calendar text-gray-400 text-sm"></i></span>
                                <input type="date" name="ngay_sinh" value="<?= htmlspecialchars($docgia->ngay_sinh ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition text-gray-700">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Giới tính</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-venus-mars text-gray-400 text-sm"></i></span>
                                <select name="gioi_tinh" class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition appearance-none">
                                    <option value="Nam" <?= (($docgia->gioi_tinh ?? '') === 'Nam') ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= (($docgia->gioi_tinh ?? '') === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Số điện thoại</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-phone text-gray-400 text-xs"></i></span>
                                <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($docgia->so_dien_thoai ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-envelope text-gray-400 text-sm"></i></span>
                                <input type="email" name="email" value="<?= htmlspecialchars($docgia->email ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Địa chỉ</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-location-dot text-gray-400 text-sm"></i></span>
                            <input type="text" name="dia_chi" value="<?= htmlspecialchars($docgia->dia_chi ?? '') ?>"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-3.5 flex gap-3">
                        <i class="fa-solid fa-circle-info text-gray-400 mt-0.5"></i>
                        <p class="text-xs text-gray-500 leading-relaxed">Tài khoản của bạn chưa liên kết hồ sơ độc giả nên chỉ có thể đổi tên đăng nhập.</p>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                    <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-floppy-disk text-xs"></i> Lưu thay đổi
                    </button>
                    <a href="index.php" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
                        Hủy bỏ
                    </a>
                </div>
            </form>
        </div>

        <!-- Đổi mật khẩu -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-sky-50/60 to-transparent">
                <span class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-key"></i>
                </span>
                <div>
                    <h3 class="font-bold text-gray-900 text-[15px] leading-tight">Đổi mật khẩu</h3>
                    <p class="text-[12px] text-gray-500">Cần nhập đúng mật khẩu hiện tại</p>
                </div>
            </div>
            <form action="index.php?modun=Profile&action=password" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mật khẩu hiện tại</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                        <input type="password" name="current_password" required
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mật khẩu mới</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                            <input type="password" name="new_password" required minlength="6" placeholder="Ít nhất 6 ký tự"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Xác nhận mật khẩu mới</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                            <input type="password" name="confirm_password" required minlength="6" placeholder="Nhập lại mật khẩu mới"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                        </div>
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-rotate text-xs"></i> Đổi mật khẩu
                </button>
            </form>
        </div>
    </div>

    <!-- Cột phải: thẻ hồ sơ -->
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-3xl font-extrabold mx-auto shadow-lg shadow-indigo-200">
                <?= htmlspecialchars(mb_strtoupper(mb_substr($user->username ?? '?', 0, 1, 'UTF-8'))) ?>
            </div>
            <h3 class="font-bold text-gray-900 mt-3 leading-tight"><?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? $user->username ?? '') ?></h3>
            <p class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 inline-block px-2.5 py-1 rounded-lg mt-2">
                <?= $isAdmin ? 'Quản trị viên' : 'Độc giả' ?>
            </p>
            <div class="text-left text-[13px] text-gray-600 mt-4 space-y-2.5 border-t border-gray-100 pt-4">
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-at text-xs"></i></span> <?= htmlspecialchars($user->username ?? '') ?></p>
                <?php if ($hasDocGia): ?>
                    <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-id-card text-xs"></i></span> <?= htmlspecialchars($docgia->ma_doc_gia ?? '') ?></p>
                    <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-phone text-xs"></i></span> <?= htmlspecialchars($docgia->so_dien_thoai ?? '—') ?></p>
                <?php endif; ?>
            </div>
            <a href="index.php?modun=Loan" class="mt-4 inline-flex w-full items-center justify-center gap-2 text-sm font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 px-4 py-2.5 rounded-xl transition">
                <i class="fa-solid fa-arrow-right-arrow-left text-xs"></i> <?= $isAdmin ? 'Xem phiếu mượn' : 'Phiếu mượn của tôi' ?>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
