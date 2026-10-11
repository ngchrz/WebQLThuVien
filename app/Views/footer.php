            <p class="text-center text-xs text-gray-400 mt-8 pb-2">
                LibManager — Hệ thống quản lý thư viện &copy; 2026. Giao diện Tailwind CSS.
            </p>
        </main>
    </div><!-- /content wrapper -->
</div><!-- /flex -->

<!-- ===== Modal xác nhận / thông báo (thay cho confirm/alert mặc định) ===== -->
<div id="wbModal" class="hidden fixed inset-0 z-[100] items-center justify-center p-4">
    <div id="wbModalOverlay" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
    <div id="wbModalCard" role="dialog" aria-modal="true" aria-labelledby="wbModalTitle"
         class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 text-center">
        <div id="wbModalIcon" class="w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-4"></div>
        <h3 id="wbModalTitle" class="text-lg font-extrabold text-gray-900"></h3>
        <p id="wbModalMsg" class="text-sm text-gray-500 mt-2 leading-relaxed"></p>
        <div class="flex gap-2.5 mt-6">
            <button id="wbModalCancel" type="button"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition"></button>
            <button id="wbModalOk" type="button"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition"></button>
        </div>
    </div>
</div>

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

    // Bật/tắt panel thông báo
    (function () {
        var btnNotif = document.getElementById('btnNotif');
        var panel = document.getElementById('notifPanel');
        var wrap = document.getElementById('notifWrap');
        if (!btnNotif || !panel) return;

        btnNotif.addEventListener('click', function (e) {
            e.stopPropagation();
            panel.classList.toggle('hidden');
        });
        // Bấm ra ngoài thì đóng
        document.addEventListener('click', function (e) {
            if (wrap && !wrap.contains(e.target)) {
                panel.classList.add('hidden');
            }
        });
        // Nhấn Esc để đóng
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') panel.classList.add('hidden');
        });
    })();

    // ===== Modal xác nhận / thông báo (thay confirm/alert mặc định) =====
    (function () {
        var modal = document.getElementById('wbModal');
        if (!modal) return;

        var overlay   = document.getElementById('wbModalOverlay');
        var iconBox   = document.getElementById('wbModalIcon');
        var titleEl   = document.getElementById('wbModalTitle');
        var msgEl     = document.getElementById('wbModalMsg');
        var okBtn     = document.getElementById('wbModalOk');
        var cancelBtn = document.getElementById('wbModalCancel');
        var resolver  = null;

        var ICONS = {
            danger:  { box: 'bg-rose-100 text-rose-500',       icon: 'fa-solid fa-triangle-exclamation', btn: 'bg-rose-600 hover:bg-rose-700' },
            error:   { box: 'bg-rose-100 text-rose-500',       icon: 'fa-solid fa-circle-exclamation',   btn: 'bg-rose-600 hover:bg-rose-700' },
            warning: { box: 'bg-amber-100 text-amber-600',     icon: 'fa-solid fa-circle-question',      btn: 'bg-indigo-600 hover:bg-indigo-700' },
            info:    { box: 'bg-indigo-100 text-indigo-600',   icon: 'fa-solid fa-circle-info',          btn: 'bg-indigo-600 hover:bg-indigo-700' },
            success: { box: 'bg-emerald-100 text-emerald-600', icon: 'fa-solid fa-circle-check',         btn: 'bg-emerald-600 hover:bg-emerald-700' }
        };

        function close(result) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            var done = resolver;
            resolver = null;
            if (done) done(result);
        }

        function open(opts) {
            opts = opts || {};
            var conf = ICONS[opts.type] || ICONS.warning;

            iconBox.className = 'w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-4 ' + conf.box;
            iconBox.innerHTML = '<i class="' + conf.icon + '"></i>';
            titleEl.textContent = opts.title || 'Xác nhận';
            msgEl.textContent = opts.message || '';
            okBtn.textContent = opts.okText || 'Đồng ý';
            okBtn.className = 'flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition ' + conf.btn;
            cancelBtn.textContent = opts.cancelText || 'Huỷ';
            cancelBtn.classList.toggle('hidden', opts.alert === true);

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(function () { okBtn.focus(); }, 40);

            return new Promise(function (resolve) { resolver = resolve; });
        }

        window.wbConfirm = function (message, opts) {
            opts = opts || {};
            opts.message = message;
            return open(opts);
        };

        window.wbAlert = function (message, opts) {
            opts = opts || {};
            opts.message = message;
            opts.alert = true;
            if (!opts.type) opts.type = 'info';
            if (!opts.title) opts.title = 'Thông báo';
            if (!opts.okText) opts.okText = 'Đã hiểu';
            return open(opts);
        };

        okBtn.addEventListener('click', function () { close(true); });
        cancelBtn.addEventListener('click', function () { close(false); });
        if (overlay) overlay.addEventListener('click', function () { close(false); });
        document.addEventListener('keydown', function (e) {
            if (modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') { e.preventDefault(); close(false); }
            else if (e.key === 'Enter') { e.preventDefault(); close(true); }
        });

        // Tự động gắn cho mọi phần tử có thuộc tính data-confirm
        document.addEventListener('click', function (e) {
            var el = (e.target && e.target.closest) ? e.target.closest('[data-confirm]') : null;
            if (!el) return;
            e.preventDefault();

            wbConfirm(el.getAttribute('data-confirm'), {
                title:      el.getAttribute('data-confirm-title') || 'Xác nhận',
                okText:     el.getAttribute('data-confirm-ok') || 'Đồng ý',
                cancelText: el.getAttribute('data-confirm-cancel') || 'Huỷ',
                type:       el.getAttribute('data-confirm-type') || 'warning'
            }).then(function (ok) {
                if (!ok) return;
                var href = el.getAttribute('href');
                if (el.tagName === 'A' && href && href !== '#') {
                    window.location.href = href;
                } else if (el.form) {
                    el.form.submit();
                }
            });
        });
    })();
</script>

</body>
</html>
