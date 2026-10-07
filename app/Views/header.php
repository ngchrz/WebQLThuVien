<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tổng Quan Thư Viện</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar thu gọn chỉ chứa logo và thương hiệu -->
        <aside class="bg-indigo-900 text-white w-64 space-y-6 py-6 px-4 hidden md:flex flex-col justify-between shadow-xl">
            <div>
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3 px-2 mb-8">
                    <div class="bg-indigo-600 p-2.5 rounded-xl shadow-lg">
                        <i class="fa-solid fa-book-open-reader text-xl text-white"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold tracking-wide">LibManager</span>
                        <p class="text-xs text-indigo-300">Tổng Quan Thư Viện</p>
                    </div>
                </div>

                <!-- Navigation Status Menu (Chỉ hiển thị Dashboard active) -->
                <nav class="space-y-1">
                    <a href="index.php" class="flex items-center space-x-3 py-3 px-4 rounded-xl text-sm font-medium bg-indigo-800 text-white shadow-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Dashboard View</span>
                    </a>
                </nav>

                 <nav class="space-y-1">
                    <a href="index.php?modun=Docgia" class="flex items-center space-x-3 py-3 px-4 rounded-xl text-sm font-medium bg-indigo-800 text-white shadow-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Quản lý độc giả</span>
                    </a>
                </nav>
            </div>

            <!-- Admin profile snippet -->
            <div class="pt-4 border-t border-indigo-800 flex items-center justify-between px-2">
                <div class="flex items-center space-x-3">
                    <img class="w-9 h-9 rounded-full border-2 border-indigo-400" src="https://placehold.co/100x100/4f46e5/ffffff?text=AD" alt="Admin">
                    <div>
                        <p class="text-sm font-semibold text-white">Thủ Thư Admin</p>
                        <p class="text-xs text-indigo-300">Quản trị viên</p>
                    </div>
                </div>
            </div>
        </aside>