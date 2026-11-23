/* app-motion.js - i-load pagkahuman sa app-shell.js */
(function () {
    'use strict';
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var root = document.documentElement;

    /* 1. Page-load entrance */
    var main = document.getElementById('mainContent');
    if (main && !reduce) {
        Array.prototype.forEach.call(main.children, function (el, i) {
            el.style.setProperty('--i', Math.min(i, 8));
        });
        main.classList.add('is-entering');
    }

    /* 2. Theme toggle */
    function onThemeClick() {
        root.classList.add('theme-fading');
        document.querySelectorAll('.theme-ico').forEach(function (i) {
            i.classList.add('spin');
            setTimeout(function () { i.classList.remove('spin'); }, 500);
        });
        setTimeout(function () { root.classList.remove('theme-fading'); }, 400);
    }
    document.querySelectorAll('#themeToggleBtn, [data-theme-toggle], #hmTheme')
        .forEach(function (b) { b.addEventListener('click', onThemeClick); });

    /* 3. Scroll reveal (opt-in: data-reveal) */
    var revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length) {
        if (reduce || !('IntersectionObserver' in window)) {
            revealEls.forEach(function (el) { el.classList.add('in'); });
        } else {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
                });
            }, { threshold: 0.12 });
            revealEls.forEach(function (el, i) {
                el.style.transitionDelay = (i % 4) * 60 + 'ms';
                io.observe(el);
            });
        }
    }

    /* 4. Count-up (opt-in: data-count="1250") */
    function countUp(el) {
        var target = parseFloat(el.getAttribute('data-count'));
        if (isNaN(target)) return;
        var decimals = (el.getAttribute('data-count').split('.')[1] || '').length;
        var prefix = el.getAttribute('data-prefix') || '';
        var dur = 1100, start = null;
        function fmt(n) { return prefix + n.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals }); }
        if (reduce) { el.textContent = fmt(target); return; }
        function step(t) {
            if (!start) start = t;
            var p = Math.min((t - start) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 4);
            el.textContent = fmt(target * eased);
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }
    var counters = document.querySelectorAll('[data-count]');
    if (counters.length && 'IntersectionObserver' in window) {
        var co = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { countUp(e.target); co.unobserve(e.target); }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { co.observe(el); });
    } else {
        counters.forEach(countUp);
    }

    /* 5. Scroll progress bar */
    if (!reduce) {
        var bar = document.createElement('div');
        bar.className = 'mo-progress';
        document.body.appendChild(bar);
        var ticking = false;
        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function () {
                var h = root.scrollHeight - window.innerHeight;
                bar.style.transform = 'scaleX(' + (h > 0 ? window.scrollY / h : 0) + ')';
                ticking = false;
            });
        }, { passive: true });
    }

    /* 6. Loading state sa submit buttons */
    document.addEventListener('submit', function (e) {
        var btn = e.target.querySelector('button[type="submit"]:not([data-no-loading])');
        if (btn && !btn.classList.contains('hm-item')) {
            setTimeout(function () { btn.classList.add('is-loading'); }, 0);
        }
    });
    window.addEventListener('pageshow', function () {
        document.querySelectorAll('.btn.is-loading').forEach(function (b) { b.classList.remove('is-loading'); });
    });
})();