@php
    $langs = ['en', 'tl', 'ceb'];
    $allTranslations = [];
    foreach ($langs as $lang) {
        $path = base_path("lang/{$lang}.json");
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
            $allTranslations[$lang] = json_decode($content, true) ?: [];
        } else {
            $allTranslations[$lang] = [];
        }
    }
@endphp
<script>
window.__translations = {!! json_encode($allTranslations, JSON_UNESCAPED_UNICODE) !!};
window.__currentLocale = '{{ app()->getLocale() }}';

window.__t = function(key, fallback) {
    var lang = window.__translations[window.__currentLocale] || {};
    return lang[key] || fallback || key;
};

window.applyTranslations = function() {
    document.querySelectorAll('[data-i18n]').forEach(function(el) {
        var key = el.getAttribute('data-i18n');
        var translated = window.__t(key);
        if (translated && translated !== key) {
            var hasIcon = el.querySelector('i');
            if (hasIcon) {
                for (var i = 0; i < el.childNodes.length; i++) {
                    var node = el.childNodes[i];
                    if (node.nodeType === 3 && node.textContent.trim()) {
                        node.textContent = ' ' + translated;
                        break;
                    }
                }
            } else {
                el.textContent = translated;
            }
        }
    });

    document.querySelectorAll('[data-i18n-placeholder]').forEach(function(el) {
        var key = el.getAttribute('data-i18n-placeholder');
        var translated = window.__t(key);
        if (translated) el.placeholder = translated;
    });
};

window.setLocale = function(locale) {
    window.__currentLocale = locale;
    document.documentElement.setAttribute('lang', locale);
    window.applyTranslations();
    window.dispatchEvent(new CustomEvent('localeChanged', { detail: { locale: locale } }));
    console.log('[i18n] Locale changed to:', locale);
};

document.addEventListener('DOMContentLoaded', function() {
    window.applyTranslations();
});

console.log('[i18n] Translations loaded:', Object.keys(window.__translations));
</script>