(function () {
    var busy = false;
    function fit() {
        if (busy || !window.Chart || !Chart.instances) return;
        busy = true;
        requestAnimationFrame(function () {
            Object.keys(Chart.instances).forEach(function (k) {
                try { Chart.instances[k].resize(); } catch (e) {}
            });
            busy = false;
        });
    }
    window.addEventListener('load', function () {
        [50, 300, 800, 1500].forEach(function (t) { setTimeout(fit, t); });
        if ('ResizeObserver' in window) {
            document.querySelectorAll('.income-chart, .donut-wrap').forEach(function (el) {
                new ResizeObserver(fit).observe(el);
            });
        }
    });
    window.addEventListener('resize', fit);
    window.addEventListener('orientationchange', function () { setTimeout(fit, 250); });
})();