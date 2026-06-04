import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// Lightbox – čistý JS, CSP-safe
(function () {
    const overlay = document.getElementById('lb-overlay');
    if (!overlay) return;
    const img = document.getElementById('lb-img');
    const btnClose = document.getElementById('lb-close');

    const open = (src) => {
        if (!src) return;
        img.src = src;
        overlay.classList.remove('hidden');             // <- namiesto overlay.hidden = false
        document.documentElement.classList.add('overflow-y-hidden');
    };

    const close = () => {
        overlay.classList.add('hidden');                // <- namiesto overlay.hidden = true
        img.src = '';
        document.documentElement.classList.remove('overflow-y-hidden');
    };

    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-lightbox-src]');
        if (trigger) {
            e.preventDefault();
            open(trigger.getAttribute('data-lightbox-src'));
            return;
        }
        if (e.target === overlay) close();
    });

    btnClose?.addEventListener('click', close);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
})();
