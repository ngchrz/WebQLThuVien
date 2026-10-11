<?php
$pageTitle = 'Sửa tài khoản';
require_once __DIR__ . "/../header.php";

$currentId = (int)($_SESSION['user']['id'] ?? 0);
$isSelf = (!empty($user) && (int)$user->id === $currentId);
?>

<div class="mb-5">
    <a href="index.php?modun=User" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
        <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
        </span>
        Quay lại danh sách tài khoản
    </a>
</div>

<?php if (empty($user)): ?>
    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
        <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center text-2xl mx-auto">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h2 class="font-extrabold text-gray-900 text-lg mt-4">Không tìm thấy tài khoản</h2>
        <p class="text-sm text-gray-500 mt-1.5">Tài khoản có thể đã bị xóa hoặc đường dẫn không đúng.</p>
        <a href="index.php?modun=User" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-white bg-indigo-600 px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Về danh sách
        </a>
    </div>
<?php else: ?>
<?php $isLocked = ((int)$user->status === 0); ?>
<?php
// Tên độc giả liên kết: đối chiếu id_doc_gia với danh sách $dsDocGia
// để thẻ xem trước luôn khớp với ô select (tránh lệch dữ liệu).
$linkedDocGia = null;
foreach ($dsDocGia as $dg) {
    if ((int)$dg->id_doc_gia === (int)($user->id_doc_gia ?? 0)) {
        $linkedDocGia = $dg;
        break;
    }
}
?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">

    <!-- ===== Cột trái: form sửa thông tin + đặt lại mật khẩu ===== -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Sửa thông tin -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3.5 bg-gradient-to-r from-amber-50/80 to-transparent">
                <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center text-lg shadow-lg shadow-amber-200 shrink-0">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <div class="min-w-0">
                    <h2 class="font-extrabold text-gray-900 text-lg leading-tight truncate">Sửa: <?= htmlspecialchars($user->username ?? '') ?></h2>
                    <p class="text-[13px] text-gray-500 mt-0.5 flex items-center gap-2">
                        <span class="text-gray-400">ID #<?= (int)$user->id ?></span>
                        <?php if ($isSelf): ?>
                            <span class="text-gray-300">•</span>
                            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">Tài khoản của bạn</span>
                        <?php endif; ?>
                    </p>
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
                        <input type="text" name="username" required value="<?= htmlspecialchars($user->username ?? '') ?>"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>

                <!-- Vai trò -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Vai trò</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-user-shield text-gray-400 text-sm"></i></span>
                        <select name="role" class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition appearance-none">
                            <option value="user" <?= ($user->role === 'user') ? 'selected' : '' ?>>Độc giả (user)</option>
                            <option value="admin" <?= ($user->role === 'admin') ? 'selected' : '' ?>>Quản trị (admin)</option>
                        </select>
                    </div>
                    <?php if ($isSelf): ?>
                        <p class="text-[11px] text-amber-600 mt-1">Bạn không thể tự hạ quyền quản trị của chính mình.</p>
                    <?php endif; ?>
                </div>

                <!-- Liên kết độc giả -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Liên kết hồ sơ độc giả</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-id-card text-gray-400 text-sm"></i></span>
                        <select name="id_doc_gia" class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition appearance-none">
                            <option value="">— Không liên kết —</option>
                            <?php foreach ($dsDocGia as $dg): ?>
                                <option value="<?= (int)$dg->id_doc_gia ?>" <?= ((int)($user->id_doc_gia ?? 0) === (int)$dg->id_doc_gia) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dg->ma_doc_gia) ?> — <?= htmlspecialchars($dg->ho_ten) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                    <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-amber-200">
                        <i class="fa-solid fa-floppy-disk text-xs"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?modun=User" class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-3 rounded-xl transition">
                        Hủy bỏ
                    </a>
                </div>
            </form>
        </div>

        <!-- Đặt lại mật khẩu -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-sky-50/60 to-transparent">
                <span class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-key"></i>
                </span>
                <div>
                    <h3 class="font-bold text-gray-900 text-[15px] leading-tight">Đặt lại mật khẩu</h3>
                    <p class="text-[12px] text-gray-500">Dùng khi độc giả quên mật khẩu đăng nhập</p>
                </div>
            </div>
            <form action="index.php?modun=User&action=resetpw&id=<?= (int)$user->id ?>" method="POST" class="p-6 flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="flex-1">
                    <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mật khẩu mới</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                        <input type="password" name="new_password" required minlength="6" placeholder="Ít nhất 6 ký tự"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shrink-0">
                    <i class="fa-solid fa-rotate text-xs"></i> Đặt lại
                </button>
            </form>
        </div>
    </div>

    <!-- ===== Cột phải: trạng thái + xem trước ===== -->
    <div class="space-y-4">

        <!-- Trạng thái / Khóa-Khôi phục -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-indigo-500"></i> Trạng thái tài khoản
            </h3>
            <div class="mt-3 flex items-center gap-2.5">
                <?php if ($isLocked): ?>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-100 px-3 py-1.5 rounded-full">
                        <i class="fa-solid fa-lock text-[11px]"></i> Đang bị khóa
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-full">
                        <i class="fa-solid fa-circle-check text-[11px]"></i> Đang hoạt động
                    </span>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <?php if ($isLocked): ?>
                    <a href="index.php?modun=User&action=unlock&id=<?= (int)$user->id ?>"
                       data-confirm="Khôi phục (mở khóa) tài khoản này?" data-confirm-type="success" data-confirm-ok="Khôi phục"
                       class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-lock-open text-xs"></i> Khôi phục tài khoản
                    </a>
                <?php elseif ($isSelf): ?>
                    <span class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-400 text-sm font-semibold px-4 py-2.5 rounded-xl cursor-not-allowed">
                        <i class="fa-solid fa-lock text-xs"></i> Không thể tự khóa
                    </span>
                <?php else: ?>
                    <a href="index.php?modun=User&action=lock&id=<?= (int)$user->id ?>"
                       data-confirm="Khóa tài khoản này? Người dùng sẽ không thể đăng nhập." data-confirm-type="danger" data-confirm-ok="Khóa"
                       class="w-full inline-flex items-center justify-center gap-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-lock text-xs"></i> Khóa tài khoản
                    </a>
                <?php endif; ?>
            </div>
            <p class="text-[11px] text-gray-400 mt-2.5 leading-relaxed">Tài khoản bị khóa sẽ không thể đăng nhập cho đến khi được khôi phục.</p>
        </div>

        <!-- Xem trước -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-3xl font-extrabold mx-auto shadow-lg shadow-indigo-200">
                <?= htmlspecialchars(mb_strtoupper(mb_substr($user->username ?? '?', 0, 1, 'UTF-8'))) ?>
            </div>
            <h3 class="font-bold text-gray-900 mt-3 leading-tight"><?= htmlspecialchars($user->username ?? '') ?></h3>
            <p class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 inline-block px-2.5 py-1 rounded-lg mt-2">
                <?= ($user->role === 'admin') ? 'Quản trị viên' : 'Độc giả' ?>
            </p>
            <div class="text-left text-[13px] text-gray-600 mt-4 space-y-2.5 border-t border-gray-100 pt-4">
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-hashtag text-xs"></i></span> ID #<?= (int)$user->id ?></p>
                <p class="flex items-center gap-2.5"><span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0"><i class="fa-solid fa-id-card text-xs"></i></span> <?= $linkedDocGia ? htmlspecialchars($linkedDocGia->ma_doc_gia . ' — ' . $linkedDocGia->ho_ten) : 'Không liên kết độc giả' ?></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . "/../footer.php"; ?>
