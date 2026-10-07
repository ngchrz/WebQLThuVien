<?php require_once __DIR__."/../header.php"; ?>

            

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm z-10 flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-gray-800">Dashboard Quản Lý Thư Viện</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative hidden sm:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                        </span>
                        <input type="text" placeholder="Tìm kiếm hệ thống..." class="w-64 pl-10 pr-4 py-2 text-sm bg-gray-100 border border-transparent rounded-xl focus:bg-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <span class="text-xs font-semibold bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full border border-emerald-100">
                        <i class="fa-solid fa-circle text-[8px] mr-1"></i> Hệ thống ổn định
                    </span>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 space-y-6">
                
                <!-- Stats Cards Grid (4 Bảng CSDL) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1: Sách -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tổng Số Sách</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $tongSoSach; ?></h3>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mt-2">Kho sách vật lý & điện tử</span>
                        </div>
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                    <!-- Card 2: Độc giả -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tổng Độc Giả</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $tongSoDocGia; ?></h3>
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full inline-block mt-2">Thành viên đang hoạt động</span>
                        </div>
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <!-- Card 3: Mượn Trả -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lượt Đang Mượn</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">48</h3>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-block mt-2">Cần theo dõi hạn trả</span>
                        </div>
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>
                    <!-- Card 4: Người dùng (Hệ thống) -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Người Dùng Hệ Thống</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">6</h3>
                            <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full inline-block mt-2">Quản trị viên & thủ thư</span>
                        </div>
                        <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                    </div>
                </div>

               


            </main>
        </div>
   
<?php require_once __DIR__."/../footer.php"; ?>