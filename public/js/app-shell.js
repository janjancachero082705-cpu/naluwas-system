/* ==========================================================================
   APP SHELL
   Used by: resources/views/layouts/app.blade.php

   CONTENTS
     1. Theme toggle (light / dark)
     2. Popups (user menu, notifications)
     3. Mobile sidebar drawer
   ========================================================================== */
(function () {
    'use strict';

    var $ = function (id) { return document.getElementById(id); };
    var root = document.documentElement;


    /* ======================================================================
       1. THEME TOGGLE
       (the saved theme is applied earlier, inline in <head>, to avoid a flash)
    ====================================================================== */
    var isThemeToggling = false;

    function paintThemeIcon() {
        var isDark = root.getAttribute('data-theme') === 'dark';
        var cls = isDark ? 'fas fa-sun theme-ico' : 'fas fa-moon theme-ico';
        document.querySelectorAll('.theme-ico').forEach(function (el) { el.className = cls; });
    }

    function saveTheme(value) {
        try { localStorage.setItem('theme', value); } catch (err) {}
    }

    function toggleTheme(e) {
        if (e) e.preventDefault();
        if (isThemeToggling) return;               // ignore double-fires
        isThemeToggling = true;
        setTimeout(function () { isThemeToggling = false; }, 300);

        if (root.getAttribute('data-theme') === 'dark') {
            root.removeAttribute('data-theme');
            saveTheme('light');
        } else {
            root.setAttribute('data-theme', 'dark');
            saveTheme('dark');
        }

        paintThemeIcon();
        window.dispatchEvent(new Event('themechanged'));   // charts etc. can listen
    }

    paintThemeIcon();
    document.addEventListener('click', function (e) {
        if (e.target.closest('#themeToggleBtn') || e.target.closest('[data-theme-toggle]')) {
            toggleTheme(e);
        }
    }, true);


    /* ======================================================================
       2. POPUPS
    ====================================================================== */
    var userCard   = $('userCard');
    var userPanel  = $('userPanel');
    var notifBell  = $('notificationBell');
    var notifPanel = $('notificationDropdown');

    function closePopups() {
        if (userPanel)  userPanel.classList.remove('show');
        if (userCard)   userCard.classList.remove('active');
        if (notifPanel) notifPanel.classList.remove('show');
    }

    function togglePopup(panel) {
        if (!panel) return;
        var wasOpen = panel.classList.contains('show');
        closePopups();
        if (!wasOpen) {
            panel.classList.add('show');
            if (panel === userPanel && userCard) userCard.classList.add('active');
        }
    }

    function bindToggle(trigger, panel) {
        if (!trigger || !panel) return;
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            togglePopup(panel);
        });
    }

    bindToggle(userCard, userPanel);
    bindToggle(notifBell, notifPanel);

    // clicking the header avatar opens the sidebar user menu
    var headerUser = $('headerUser');
    if (headerUser && userCard) {
        headerUser.addEventListener('click', function () { userCard.click(); });
    }

    // click outside closes popups
    document.addEventListener('click', function (e) {
        var inside = e.target.closest('#userPanel, #userCard, #notificationDropdown, #notificationBell');
        if (!inside) closePopups();
    });


    /* ======================================================================
       3. MOBILE SIDEBAR DRAWER
    ====================================================================== */
    var mobileQuery = window.matchMedia('(max-width: 1023px)');
    var sidebar = $('sidebar');
    var scrim = $('scrim');
    var menuToggle = $('menuToggle');
    var drawerOpen = false;

    function setSidebar(open) {
        drawerOpen = !!open && mobileQuery.matches;
        if (sidebar) sidebar.classList.toggle('mobile-open', drawerOpen);
        if (scrim)   scrim.classList.toggle('show', drawerOpen);
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            closePopups();
            setSidebar(!drawerOpen);
        });
    }

    if (scrim) {
        scrim.addEventListener('click', function () {
            closePopups();
            setSidebar(false);
        });
    }

    // clicks inside the sidebar shouldn't reach the "click outside" handler
    if (sidebar) {
        sidebar.addEventListener('click', function (e) {
            if (e.target.closest('#userPanel, #userCard')) return;
            e.stopPropagation();
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 1023) setSidebar(false);
    });
})();