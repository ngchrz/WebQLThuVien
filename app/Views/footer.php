            <p class="text-center text-xs text-gray-400 mt-8 pb-2">
                LibManager — Hệ thống quản lý thư viện &copy; 2026. Giao diện Tailwind CSS.
            </p>
        </main>
    </div><!-- /content wrapper -->
</div><!-- /flex -->

<script>
    (function () {
        var btn = document.getElementById('btnSidebar');
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        if (!btn || !sidebar) return;
        function open() {
            sidebar.classList.remove('-translate-x-full');
            if (overlay) overlay.classList.remove('hidden');
        }
        function close() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }
        }
        btn.addEventListener('click', function () {
            if (sidebar.classList.contains('-translate-x-full')) open();
            else close();
        });
        if (overlay) overlay.addEventListener('click', close);
    })();
</script>

</body>
</html>
