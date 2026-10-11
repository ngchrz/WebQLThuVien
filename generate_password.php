<?php
// ============================================================
//  TIEN ICH: Tao hash mat khau de dan vao bang `users`
//  Truy cap: http://localhost/thuvien/generate_password.php
//  (duoc database.sql tham chieu)
// ============================================================
$plain = $_GET['p'] ?? '';
$hash  = $plain !== '' ? password_hash($plain, PASSWORD_DEFAULT) : '';
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Password - LibManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f1f5f9] text-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h1 class="text-lg font-extrabold text-gray-900">Tạo hash mật khẩu</h1>
        <p class="text-sm text-gray-500 mt-1">Nhập mật khẩu cần mã hóa, sau đó copy chuỗi hash để dán vào cột <span class="font-mono">password</span> của bảng <span class="font-mono">users</span>.</p>

        <form method="GET" class="mt-5 flex gap-2">
            <input type="text" name="p" value="<?= htmlspecialchars($plain) ?>" placeholder="VD: admin123"
                   class="flex-1 px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                Tạo hash
            </button>
        </form>

        <?php if ($hash !== ''): ?>
            <div class="mt-5">
                <label class="block text-[13px] font-semibold text-gray-700 mb-1.5">Hash (PASSWORD_DEFAULT)</label>
                <textarea readonly rows="3"
                          class="w-full px-4 py-2.5 text-sm font-mono bg-gray-50 border border-gray-200 rounded-xl focus:outline-none"><?= htmlspecialchars($hash) ?></textarea>
                <p class="text-[11px] text-gray-400 mt-1">Mật khẩu gốc: <b><?= htmlspecialchars($plain) ?></b></p>
            </div>
        <?php endif; ?>

        <a href="index.php" class="inline-flex items-center gap-2 mt-5 text-sm font-medium text-gray-500 hover:text-indigo-600">
            &larr; Về trang quản lý
        </a>
    </div>
</body>
</html>
