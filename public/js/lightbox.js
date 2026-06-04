// CSP-safe Lightbox (bez eval, bez inline, bez Alpine)
(function () {
    const overlay = document.getElementById('lb-overlay');
    if (!overlay) return;

    const img = document.getElementById('lb-img');
    const btnClose = document.getElementById('lb-close');

    function open(src) {
        if (!src) return;
        img.src = src;
        overlay.classList.remove('hidden');       // zobraz overlay
        document.documentElement.classList.add('overflow-y-hidden');
    }

    function close() {
        overlay.classList.add('hidden');          // skry overlay
        img.src = '';
        document.documentElement.classList.remove('overflow-y-hidden');
    }

    // delegácia klikov – chytí všetky elementy s data-lightbox-src
    document.addEventListener('click', function (e) {
        const t = e.target.closest('[data-lightbox-src]');
        if (t) {
            e.preventDefault();
            open(t.getAttribute('data-lightbox-src'));
            return;
        }
        if (e.target === overlay) close();
    });

    btnClose && btnClose.addEventListener('click', close);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });

    // test helper (do konzoly): window.lbOpen('https://placehold.co/1200x600')
    window.lbOpen = open;
})();
