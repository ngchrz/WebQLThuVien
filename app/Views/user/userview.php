<?php
$pageTitle = 'Quản lý tài khoản';
require_once __DIR__ . "/../header.php";

$currentId = (int)($_SESSION['user']['id'] ?? 0);
?>

<!-- Page heading + actions -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-base shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-user-gear"></i>
            </span>
            Quản lý tài khoản
        </h2>
        <p class="text-[13px] text-gray-500 mt-1.5 ml-[50px]">
            Tổng cộng <span class="font-bold text-gray-800"><?= count($dsUser ?? []) ?></span> tài khoản trong hệ thống
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="index.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
        <a href="index.php?modun=User&action=create" class="btn-primary inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-user-shield text-xs"></i> Thêm quản trị viên
        </a>
    </div>
</div>

<!-- Info banner: độc giả tự đăng ký -->
<div class="mb-5 flex items-start gap-3 rounded-2xl bg-indigo-50 border border-indigo-100 p-4">
    <span class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 text-sm">
        <i class="fa-solid fa-circle-info"></i>
    </span>
    <p class="text-[13px] text-indigo-800 leading-relaxed">
        Tài khoản <b>độc giả</b> do người dùng <b>tự đăng ký</b> (gắn với hồ sơ độc giả). Quản trị viên chỉ <b>sửa thông tin</b>,
        <b>đặt lại mật khẩu</b> khi quên, <b>khóa</b> khi vi phạm và <b>khôi phục</b> lại tài khoản.
    </p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-5">
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-users"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= count($dsUser ?? []) ?></span>
            <span class="block text-xs text-gray-500 mt-1">Tổng tài khoản</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-user-shield"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $tongAdmin ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Quản trị viên</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-user"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $tongUser ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Độc giả</span>
        </span>
    </div>
    <div class="card-hover bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
        <span class="w-11 h-11 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-lock"></i></span>
        <span>
            <span class="block text-xl font-extrabold text-gray-900 leading-none"><?= $tongKhoa ?? 0 ?></span>
            <span class="block text-xs text-gray-500 mt-1">Đang bị khóa</span>
        </span>
    </div>
</div>

<!-- Table card -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[900px]">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 text-[11px] uppercase tracking-wider">
                    <th class="text-left font-semibold px-5 py-3.5">ID</th>
                    <th class="text-left font-semibold px-4 py-3.5">Tên đăng nhập</th>
                    <th class="text-left font-semibold px-4 py-3.5">Độc giả liên kết</th>
                    <th class="text-center font-semibold px-4 py-3.5">Vai trò</th>
                    <th class="text-center font-semibold px-4 py-3.5">Trạng thái</th>
                    <th class="text-center font-semibold px-5 py-3.5 w-[170px]">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($dsUser)): ?>
                    <?php foreach ($dsUser as $u): ?>
                        <?php
                            $isSelf = ((int)$u->id === $currentId);
                            $isLocked = ((int)$u->status === 0);
                        ?>
                        <tr class="table-row-hover hover:bg-indigo-50/40">
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center font-mono text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-lg">
                                    #<?= (int)$u->id ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                        <?= htmlspecialchars(mb_strtoupper(mb_substr($u->username ?? '?', 0, 1, 'UTF-8'))) ?>
                                    </span>
                                    <span class="font-semibold text-gray-900 <?= $isLocked ? 'text-gray-400 line-through' : '' ?>"><?= htmlspecialchars($u->username ?? '') ?></span>
                                    <?php if ($isSelf): ?>
                                        <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">Bạn</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <?php if (!empty($u->ho_ten)): ?>
                                    <div class="text-gray-800 font-medium"><?= htmlspecialchars($u->ho_ten) ?></div>
                                    <div class="font-mono text-[11px] text-gray-400"><?= htmlspecialchars($u->ma_doc_gia ?? '') ?></div>
                                <?php else: ?>
                                    <span class="text-gray-300">— Không liên kết —</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <?php if ($u->role === 'admin'): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-violet-600 bg-violet-50 border border-violet-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-user-shield text-[10px]"></i> Quản trị
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-600 bg-sky-50 border border-sky-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-user text-[10px]"></i> Độc giả
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <?php if (!$isLocked): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Hoạt động
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-600 bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-lock text-[10px]"></i> Bị khóa
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="index.php?modun=User&action=update&id=<?= (int)$u->id ?>"
                                       title="Sửa / Đặt lại mật khẩu"
                                       class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 border border-amber-100 hover:bg-amber-500 hover:text-white hover:border-amber-500 flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <?php if ($isLocked): ?>
                                        <a href="index.php?modun=User&action=unlock&id=<?= (int)$u->id ?>"
                                           data-confirm="Khôi phục (mở khóa) tài khoản này?" data-confirm-type="success" data-confirm-ok="Khôi phục"
                                           title="Khôi phục tài khoản"
                                           class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 flex items-center justify-center transition">
                                            <i class="fa-solid fa-lock-open text-xs"></i>
                                        </a>
                                    <?php elseif ($isSelf): ?>
                                        <span class="w-8 h-8 rounded-lg bg-gray-50 text-gray-300 border border-gray-100 flex items-center justify-center cursor-not-allowed" title="Không thể tự khóa chính mình">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </span>
                                    <?php else: ?>
                                        <a href="index.php?modun=User&action=lock&id=<?= (int)$u->id ?>"
                                           data-confirm="Khóa tài khoản này? Người dùng sẽ không thể đăng nhập." data-confirm-type="danger" data-confirm-ok="Khóa"
                                           title="Khóa tài khoản"
                                           class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 border border-rose-100 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-300 flex items-center justify-center text-2xl mx-auto">
                                <i class="fa-solid fa-user-slash"></i>
                            </div>
                            <p class="font-semibold text-gray-700 mt-4">Chưa có tài khoản nào</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>
