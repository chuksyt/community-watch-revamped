(function () {
    // Inject styles
    var style = document.createElement('style');
    style.textContent =
        '#pg-loader{position:fixed;inset:0;background:#111;z-index:99999;pointer-events:none;transition:opacity 0.25s ease;}' +
        '#pg-bar{position:absolute;top:0;left:0;height:3px;width:0;background:#0d6efd;transition:width 0.5s ease;}';
    (document.head || document.documentElement).appendChild(style);

    // Inject overlay
    var loader = document.createElement('div');
    loader.id = 'pg-loader';
    loader.innerHTML = '<div id="pg-bar"></div>';
    document.documentElement.appendChild(loader);

    var bar = loader.querySelector('#pg-bar');

    // Kick fake progress forward immediately
    setTimeout(function () { bar.style.width = '65%'; }, 30);

    // Complete + fade out once DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        bar.style.transition = 'width 0.15s ease';
        bar.style.width = '100%';
        setTimeout(function () {
            loader.style.opacity = '0';
            setTimeout(function () { loader.style.display = 'none'; }, 250);
        }, 150);
    });

    function showLoader() {
        loader.style.display = '';
        loader.style.opacity = '1';
        bar.style.transition = 'none';
        bar.style.width = '0';
        setTimeout(function () {
            bar.style.transition = 'width 0.5s ease';
            bar.style.width = '60%';
        }, 30);
    }

    // Intercept all same-page navigations
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a || a.target === '_blank') return;
        var href = a.getAttribute('href') || '';
        if (!href || href[0] === '#' ||
            href.indexOf('mailto:') === 0 ||
            href.indexOf('tel:') === 0 ||
            href.indexOf('javascript:') === 0) return;
        showLoader();
    }, true);

    // Intercept form submissions
    document.addEventListener('submit', function () {
        showLoader();
    }, true);
})();
