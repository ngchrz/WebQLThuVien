<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - LibManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        .auth-brand { animation: fadeUp .45s cubic-bezier(.22,.61,.36,1) both; }
        .auth-card  { animation: fadeUp .45s .08s cubic-bezier(.22,.61,.36,1) both; }
        input { transition: box-shadow .2s ease, border-color .2s ease, background-color .2s ease; }
        button { transition: transform .18s ease, box-shadow .18s ease; }
        button:active { transform: scale(.99); }
        @media (prefers-reduced-motion: reduce) { .auth-brand, .auth-card { animation: none !important; } }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-950 via-indigo-900 to-violet-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <!-- Brand (bấm vào để về trang chủ) -->
        <a href="index.php?modun=Book" title="Về trang chủ" class="auth-brand flex items-center justify-center gap-3 mb-6 group">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg transition-transform duration-200 group-hover:scale-105">
                <i class="fa-solid fa-book-open-reader text-xl text-white"></i>
            </div>
            <div>
                <p class="text-xl font-extrabold text-white leading-none transition-colors duration-200 group-hover:text-indigo-200">LibManager</p>
                <p class="text-[11px] uppercase tracking-widest text-indigo-300 mt-1">Thư viện thông minh</p>
            </div>
        </a>

        <div class="auth-card bg-white rounded-3xl shadow-2xl p-7 sm:p-8">
            <h1 class="text-xl font-extrabold text-gray-900">Đăng ký thẻ độc giả</h1>
            <p class="text-sm text-gray-500 mt-1">Thông tin bên dưới sẽ tạo hồ sơ độc giả và tài khoản đăng nhập liên kết.</p>

            <?php if (!empty($flash)): ?>
                <?php $__ok = (($flash['type'] ?? 'success') === 'success'); ?>
                <div class="mt-5 flex items-start gap-2.5 rounded-xl p-3.5 border <?= $__ok ? 'bg-emerald-50 border-emerald-100' : 'bg-rose-50 border-rose-100' ?>">
                    <i class="fa-solid <?= $__ok ? 'fa-circle-check text-emerald-500' : 'fa-triangle-exclamation text-rose-500' ?> mt-0.5"></i>
                    <p class="text-sm <?= $__ok ? 'text-emerald-700' : 'text-rose-700' ?>"><?= htmlspecialchars($flash['msg'] ?? '') ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="mt-5 flex items-start gap-2.5 rounded-xl bg-rose-50 border border-rose-100 p-3.5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 mt-0.5"></i>
                    <p class="text-sm text-rose-700"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="mt-6 space-y-5">
                <!-- Thông tin độc giả -->
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-indigo-500 mb-3">Thông tin độc giả</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Họ tên <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-user text-gray-400 text-sm"></i></span>
                                <input type="text" name="hoten" required placeholder="VD: Nguyễn Văn An"
                                       value="<?= htmlspecialchars($_POST['hoten'] ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Ngày sinh</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-calendar text-gray-400 text-sm"></i></span>
                                    <input type="date" name="ngaysinh" value="<?= htmlspecialchars($_POST['ngaysinh'] ?? '') ?>"
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition text-gray-700">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Giới tính</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="gioitinh" value="Nam" class="peer hidden" checked>
                                        <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:border-sky-500 transition">
                                            <i class="fa-solid fa-mars text-xs"></i> Nam
                                        </span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="gioitinh" value="Nữ" class="peer hidden">
                                        <span class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-600 peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 transition">
                                            <i class="fa-solid fa-venus text-xs"></i> Nữ
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Số điện thoại</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-phone text-gray-400 text-xs"></i></span>
                                    <input type="text" name="sdt" placeholder="VD: 0912345678" value="<?= htmlspecialchars($_POST['sdt'] ?? '') ?>"
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-regular fa-envelope text-gray-400 text-sm"></i></span>
                                    <input type="email" name="email" placeholder="VD: an@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Địa chỉ</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-location-dot text-gray-400 text-sm"></i></span>
                                <input type="text" name="diachi" placeholder="VD: 123 Nguyễn Huệ, Q.1, TP.HCM" value="<?= htmlspecialchars($_POST['diachi'] ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin tài khoản -->
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-indigo-500 mb-3">Thông tin đăng nhập</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Tên đăng nhập <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-at text-gray-400 text-sm"></i></span>
                                <input type="text" name="username" required placeholder="VD: annguyen"
                                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Mật khẩu <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                                    <input type="password" name="password" required minlength="6" placeholder="Ít nhất 6 ký tự"
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Xác nhận mật khẩu <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"><i class="fa-solid fa-lock text-gray-400 text-sm"></i></span>
                                    <input type="password" name="confirm" required minlength="6" placeholder="Nhập lại mật khẩu"
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:-translate-y-0.5 transition">
                    <i class="fa-solid fa-user-plus text-xs"></i> Tạo tài khoản
                </button>
            </form>

            <p class="text-sm text-gray-500 text-center mt-6">
                Đã có tài khoản?
                <a href="index.php?modun=Auth&action=login" class="font-semibold text-indigo-600 hover:text-indigo-700">Đăng nhập</a>
            </p>
        </div>
    </div>

</body>
</html>
