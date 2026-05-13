<style>
    /* ─────────────────────────────────────────
       THREAD — Header
       Self-contained: no Bootstrap layout deps
    ───────────────────────────────────────── */

    .th-header {
        position: sticky;
        top: 0;
        z-index: 1030;                  /* matches Bootstrap navbar — below modals (1050) */
        width: 100%;
        height: 58px;
        background: #fff;
        border-bottom: 1px solid #E4DDD6;
        box-sizing: border-box;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0 20px 0 16px;
        /* NO overflow:hidden — dropdowns must escape the header */

        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
    }

    /* ── Sidebar toggle ── */
    /* keeps .js-sidebar-toggle for Bootstrap's sidebar JS */
    .th-toggle {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4.5px;
        border-radius: 8px;
        border: 1.5px solid #E4DDD6;
        background: transparent;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s;
    }
    .th-toggle:hover {
        background: #FAF0EA;
        border-color: rgba(192,73,10,.28);
    }
    .th-toggle:hover .th-bar { background: #C0490A; }

    /* keeps .hamburger + .align-self-center classes on the inner <i> */
    .th-toggle .hamburger.align-self-center {
        display: contents; /* let the bars flow directly into the flex column */
    }
    .th-bar {
        display: block;
        width: 15px;
        height: 1.5px;
        border-radius: 2px;
        background: #6B5C54;
        transition: background 0.15s;
        pointer-events: none;
    }

    /* ── Right cluster ── */
    .th-right {
        display: flex;
        align-items: center;
        gap: 6px;
        height: 100%;           /* fill header height */
        flex-shrink: 0;
    }

    /* ── Generic icon button ── */
    .th-icon-btn {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1.5px solid #E4DDD6;
        background: transparent;
        color: #6B5C54;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
        position: relative;
    }
    .th-icon-btn:hover {
        background: #FAF0EA;
        border-color: rgba(192,73,10,.28);
        color: #C0490A;
    }
    .th-icon-btn svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: block;
    }

    /* ── Separator ── */
    .th-sep {
        width: 1px;
        height: 20px;
        background: #E4DDD6;
        flex-shrink: 0;
        margin: 0 2px;
    }

    /* ── User button ── */
    .th-user-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* ── Notif wrap ── */
    .th-notif-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .th-user-btn {
        display: flex;
        align-items: center;
        gap: 9px;
        height: 40px;
        padding: 0 10px 0 5px;
        border-radius: 8px;
        border: 1.5px solid transparent;
        background: transparent;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s;
        white-space: nowrap;
    }
    .th-user-btn:hover {
        background: #FAF8F5;
        border-color: #E4DDD6;
    }

    .th-avatar {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid #E4DDD6;
        display: block;
    }

    .th-user-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        overflow: hidden;
    }
    .th-user-name {
        font-size: 13px;
        font-weight: 600;
        color: #1A1210;
        line-height: 1.2;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .th-user-role {
        font-size: 10px;
        font-weight: 600;
        color: #A89890;
        text-transform: uppercase;
        letter-spacing: 0.55px;
        line-height: 1.2;
    }

    .th-chevron {
        flex-shrink: 0;
        color: #C8BEB8;
        display: flex;
        align-items: center;
        margin-left: 2px;
    }
    .th-chevron svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.2;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: block;
    }

    /* ── Dropdown panel ── */
    .th-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 210px;
        background: #fff;
        border: 1.5px solid #E4DDD6;
        border-radius: 10px;
        box-shadow: 0 12px 40px rgba(26,18,16,.14);
        overflow: hidden;
        z-index: 1035;                  /* above header (1030), below modal backdrop (1040) & modal (1050) */
        animation: thDrop .14s ease;
    }
    @keyframes thDrop {
        from { opacity: 0; transform: translateY(-5px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .th-dropdown.open { display: block; }

    .th-drop-header {
        padding: 10px 16px;
        border-bottom: 1px solid #F0EBE6;
        font-size: 10px;
        font-weight: 700;
        color: #C8BEB8;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .th-drop-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #1A1210;
        text-decoration: none;
        border-bottom: 1px solid #F7F4F1;
        transition: background .12s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        white-space: nowrap;
    }
    .th-drop-item:last-child { border-bottom: none; }
    .th-drop-item:hover { background: #FAF8F5; }
    .th-drop-item svg {
        width: 14px;
        height: 14px;
        stroke: #C8BEB8;
        stroke-width: 1.8;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex-shrink: 0;
    }

    /* Logout — danger tone */
    .th-drop-item.th-logout { color: #B03030; }
    .th-drop-item.th-logout svg { stroke: #E0A0A0; }
    .th-drop-item.th-logout:hover { background: #FAF0F0; }

    /* Notification empty state */
    .th-notif-empty {
        padding: 20px 16px;
        text-align: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .th-notif-empty-icon { font-size: 22px; opacity: .3; margin-bottom: 6px; }
    .th-notif-empty-text { font-size: 12px; color: #A89890; }

    .th-drop-footer {
        padding: 10px 16px;
        border-top: 1px solid #F0EBE6;
        text-align: center;
    }
    .th-drop-footer a {
        font-size: 12px;
        font-weight: 600;
        color: #C0490A;
        text-decoration: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .th-drop-footer a:hover { text-decoration: underline; }

    /* ── Responsive: hide user text on very small screens ── */
    @media (max-width: 480px) {
        .th-user-text,
        .th-chevron { display: none; }
        .th-user-btn { padding: 0 6px; gap: 0; }
    }
</style>

<!-- ════════════════════════════════════════
     THREAD Header
     Original Bootstrap classes kept on <nav>
     so existing sidebar/layout JS still works
════════════════════════════════════════ -->
<nav class="th-header navbar navbar-expand navbar-light navbar-bg">

    <!-- ── Sidebar toggle ──
         .js-sidebar-toggle kept for CI4/Bootstrap sidebar JS
         .hamburger + .align-self-center kept as original        -->
    <a class="th-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center">
            <span class="th-bar"></span>
            <span class="th-bar"></span>
            <span class="th-bar"></span>
        </i>
    </a>

    <!-- ── Right cluster ── -->
    <div class="th-right">

        <!-- Bell / Notifications
             #alertsDropdown + data-bs-toggle kept from original -->
        <div class="th-notif-wrap">
            <a class="th-icon-btn nav-icon dropdown-toggle"
               href="#"
               id="alertsDropdown"
               data-bs-toggle="dropdown"
               onclick="thToggleDrop('th-notif', event)">
                <svg viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </a>

            <div class="th-dropdown dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                 id="th-notif"
                 aria-labelledby="alertsDropdown">
                <!-- Preserves original "0 New Notifications" text -->
                <div class="th-drop-header">0 New Notifications</div>
                <div class="th-notif-empty">
                    <div class="th-notif-empty-icon">🔔</div>
                    <div class="th-notif-empty-text">You're all caught up</div>
                </div>
                <div class="th-drop-footer dropdown-menu-footer">
                    <!-- Preserves original "Show all notifications" link -->
                    <a href="#" class="text-muted">Show all notifications</a>
                </div>
            </div>
        </div>

        <div class="th-sep"></div>

        <!-- User pill
             base_url, $user['fullname'], data-bs-toggle, d-none/d-sm classes — all preserved -->
        <div class="th-user-wrap">

            <!-- Desktop user pill -->
            <a class="th-user-btn nav-link dropdown-toggle d-none d-sm-inline-flex"
               href="#"
               data-bs-toggle="dropdown"
               onclick="thToggleDrop('th-user', event)">

                <!-- Preserves original src + alt -->
                <img
                    class="th-avatar avatar img-fluid rounded me-1"
                    src="<?= base_url('assets/images/avatar.png') ?>"
                    alt="<?= $user['fullname']; ?>" />

                <div class="th-user-text">
                    <!-- Preserves original $user['fullname'] -->
                    <span class="th-user-name text-dark"><?= $user['fullname']; ?></span>
                    <span class="th-user-role">Staff</span>
                </div>

                <span class="th-chevron">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </a>

            <!-- Mobile icon fallback — preserves original d-inline-block d-sm-none -->
            <a class="th-icon-btn nav-icon dropdown-toggle d-inline-flex d-sm-none"
               href="#"
               data-bs-toggle="dropdown"
               onclick="thToggleDrop('th-user', event)">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </a>

            <!-- User dropdown -->
            <div class="th-dropdown dropdown-menu dropdown-menu-end" id="th-user">
                <div class="th-drop-header">My Account</div>

                <a class="th-drop-item" href="#">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Profile
                </a>

                <a class="th-drop-item" href="#">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Settings
                </a>

                <!-- Preserves original base_url('logout') href exactly, including trailing space -->
                <a class="th-drop-item th-logout dropdown-item" href="<?= base_url('logout'); ?> ">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Log out
                </a>
            </div>

        </div><!-- /th-user-wrap -->

    </div><!-- /th-right -->

</nav>

<script>
    /* ── Dropdown toggle — UI only, no CI4 logic affected ── */
    function thToggleDrop(id, e) {
        e.preventDefault();
        e.stopPropagation();
        const target = document.getElementById(id);
        document.querySelectorAll('.th-dropdown').forEach(function(d) {
            if (d.id !== id) d.classList.remove('open');
        });
        target.classList.toggle('open');
    }

    document.addEventListener('click', function() {
        document.querySelectorAll('.th-dropdown').forEach(function(d) {
            d.classList.remove('open');
        });
    });
</script>