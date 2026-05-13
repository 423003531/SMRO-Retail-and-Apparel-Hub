<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Gilang Heavy">
    <meta name="keywords" content="Gilang Heavy, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Sign In — THREAD Retail Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <style>
        /* ─────────────────────────────────────────
           THREAD Design System — Login Page
           Consistent with register.php
        ───────────────────────────────────────── */
        :root {
            --bg:            #FAF8F5;
            --bg-2:          #F3F0EB;
            --border:        #E4DDD6;
            --border-2:      #D5CCC4;
            --accent:        #C0490A;
            --accent-light:  #FAF0EA;
            --accent-hover:  #A83D08;
            --text-1:        #1A1210;
            --text-2:        #6B5C54;
            --text-3:        #A89890;
            --sidebar-bg:    #141210;
            --success:       #3A7D4E;
            --success-bg:    #EDF5F0;
            --danger:        #B03030;
            --danger-bg:     #FAF0F0;
            --warning:       #9A6B10;
            --warning-bg:    #FBF3E0;
            --radius:        8px;
            --radius-full:   999px;
            --transition:    0.15s ease;
            --font-d:        'DM Serif Display', serif;
            --font-b:        'Plus Jakarta Sans', sans-serif;
            --font-cg:       'Cormorant Garamond', serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: var(--font-b);
            background: var(--bg);
            color: var(--text-1);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── PAGE SHELL ── */
        .page-wrap {
            display: flex;
            min-height: 100vh;
        }

        /* ─────────────────────────────
           LEFT — FORM PANEL
        ───────────────────────────── */
        .form-panel {
            width: 480px;
            min-width: 480px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            border-right: 1px solid var(--border);
            overflow-y: auto;
        }

        /* ── Brand wordmark — identical to register.php ── */
        .brand {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 40px;
        }
        .brand-wrap {
            display: flex;
            flex-direction: column;
        }
        .brand-wordmark {
            display: flex;
            align-items: baseline;
            gap: 0;
        }
        .brand-wordmark .wm-the {
            font-family: var(--font-cg);
            font-weight: 300;
            font-style: italic;
            font-size: 26px;
            color: var(--text-2);
            letter-spacing: 0.04em;
            line-height: 1;
        }
        .brand-wordmark .wm-read {
            font-family: var(--font-cg);
            font-weight: 400;
            font-style: italic;
            font-size: 26px;
            color: var(--text-1);
            letter-spacing: 0.04em;
            line-height: 1;
        }
        .brand-rule {
            display: block;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
            margin-top: 3px;
        }

        /* ── Heading ── */
        .form-heading {
            font-family: var(--font-d);
            font-size: 26px;
            color: var(--text-1);
            line-height: 1.2;
            margin-bottom: 5px;
        }
        .form-sub {
            font-size: 13px;
            color: var(--text-2);
            margin-bottom: 28px;
        }

        /* ── CI4 Alerts slot ── */
        .alert-slot { margin-bottom: 18px; }

        .alert-slot .alert {
            padding: 10px 14px;
            border-radius: var(--radius);
            font-size: 13px;
            font-family: var(--font-b);
            border: 1.5px solid transparent;
            margin-bottom: 0;
        }
        .alert-slot .alert-danger  { background: var(--danger-bg);  border-color: rgba(176,48,48,.2);  color: var(--danger);  }
        .alert-slot .alert-success { background: var(--success-bg); border-color: rgba(58,125,78,.2);  color: var(--success); }
        .alert-slot .alert-warning { background: var(--warning-bg); border-color: rgba(154,107,16,.2); color: var(--warning); }

        /* ── Form elements — identical tokens to register.php ── */
        .field-group { margin-bottom: 18px; }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-2);
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .field-input {
            width: 100%;
            padding: 10px 14px;
            background: #fff;
            border: 1.5px solid var(--border-2);
            border-radius: var(--radius);
            color: var(--text-1);
            font-size: 14px;
            font-family: var(--font-b);
            outline: none;
            transition: border var(--transition), box-shadow var(--transition);
            -webkit-appearance: none;
            appearance: none;
        }
        .field-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(192,73,10,.08);
        }
        .field-input::placeholder { color: var(--text-3); }

        /* Password show/hide */
        .input-wrap { position: relative; }
        .input-wrap .field-input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-3);
            font-size: 15px;
            padding: 0;
            line-height: 1;
            transition: color var(--transition);
        }
        .pw-toggle:hover { color: var(--text-1); }

        /* ── Row: remember me + forgot link ── */
        .form-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -6px;
            margin-bottom: 22px;
        }
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .remember-wrap input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        .remember-wrap label {
            font-size: 12px;
            color: var(--text-2);
            cursor: pointer;
            user-select: none;
        }
        .forgot-link {
            font-size: 12px;
            color: var(--text-3);
            text-decoration: none;
            transition: color var(--transition);
        }
        .forgot-link:hover { color: var(--accent); }

        /* ── Submit button ── */
        .btn-signin {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 700;
            font-family: var(--font-b);
            cursor: pointer;
            transition: background var(--transition), box-shadow var(--transition);
        }
        .btn-signin:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 14px rgba(192,73,10,.22);
        }
        .btn-signin:active { transform: translateY(1px); }

        /* ── Register link ── */
        .register-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-2);
            margin-top: 20px;
        }
        .register-link a {
            color: var(--accent);
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover { text-decoration: underline; }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: var(--text-3);
            font-size: 11px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Role pills (visual only — shows available roles) ── */
        .role-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .role-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-2);
            flex: 1;
            min-width: 100px;
            transition: all var(--transition);
        }
        .role-pill:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }
        .role-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .dot-owner   { background: #C0490A; }
        .dot-manager { background: #2A5EA8; }
        .dot-cashier { background: #5C7A3E; }

        /* ─────────────────────────────
           RIGHT — BRAND PANEL
           Identical structure to register.php
        ───────────────────────────── */
        .brand-panel {
            flex: 1;
            background: var(--sidebar-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .bp-pattern {
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient( 45deg, rgba(255,255,255,.018) 0px, rgba(255,255,255,.018) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(-45deg, rgba(255,255,255,.018) 0px, rgba(255,255,255,.018) 1px, transparent 1px, transparent 40px);
        }
        .bp-glow {
            position: absolute;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(192,73,10,.11) 0%, transparent 68%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .bp-content {
            position: relative;
            text-align: left;
            padding: 56px 52px;
            max-width: 420px;
            width: 100%;
        }

        /* Panel wordmark */
        .bp-brand { display: flex; flex-direction: column; margin-bottom: 48px; }
        .bp-wordmark {
            font-family: var(--font-cg);
            font-style: italic;
            font-weight: 300;
            font-size: 32px;
            color: #EDE5DC;
            letter-spacing: 0.06em;
            line-height: 1;
        }
        .bp-wordmark span { color: #E8906A; font-weight: 400; }
        .bp-rule {
            display: block;
            width: 40px;
            height: 1px;
            background: var(--accent);
            margin-top: 8px;
        }

        /* Headline */
        .bp-title {
            font-family: var(--font-d);
            font-size: 36px;
            color: #F0EAE2;
            line-height: 1.18;
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }
        .bp-title em { color: #E8906A; font-style: italic; }

        .bp-sub {
            font-size: 13px;
            color: #55463E;
            line-height: 1.75;
            margin-bottom: 44px;
            font-weight: 300;
        }

        /* Editorial numbered feature list — identical to register.php */
        .bp-features { display: flex; flex-direction: column; gap: 0; }
        .bp-feature {
            display: grid;
            grid-template-columns: 36px 1fr;
            gap: 16px;
            align-items: start;
            padding: 18px 0;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .bp-feature:last-child { border-bottom: 1px solid rgba(255,255,255,.06); }

        .bp-feature-num {
            font-family: var(--font-cg);
            font-style: italic;
            font-size: 22px;
            font-weight: 300;
            color: rgba(232,144,106,.35);
            line-height: 1.1;
            padding-top: 1px;
        }
        .bp-feature-title {
            font-size: 13px;
            font-weight: 600;
            color: #C8BEB8;
            margin-bottom: 3px;
            letter-spacing: 0.1px;
        }
        .bp-feature-desc {
            font-size: 12px;
            color: #4A3E39;
            line-height: 1.55;
            font-weight: 300;
        }

        /* ── Responsive ── */
        @media (max-width: 860px) {
            .brand-panel { display: none; }
            .form-panel  { width: 100%; min-width: unset; border-right: none; padding: 36px 28px; }
        }
        @media (max-width: 480px) {
            .form-panel { padding: 28px 20px; }
        }
    </style>
</head>

<body>
<div class="page-wrap">

    <!-- ════════════════════════════════
         LEFT — LOGIN FORM
    ════════════════════════════════ -->
    <div class="form-panel">

        <!-- Brand wordmark — identical markup to register.php -->
        <div class="brand">
            <div class="brand-wrap">
                <div class="brand-wordmark">
                    <span class="wm-the">Thr</span><span class="wm-read">ead</span>
                </div>
                <span class="brand-rule"></span>
            </div>
        </div>

        <div class="form-heading">Welcome back</div>
        <div class="form-sub">Sign in to your account to continue</div>

        <!-- ── CI4 alerts component — completely untouched ── -->
        <div class="alert-slot">
            <?= $this->include('components/alerts'); ?>
        </div>

        <!-- ── FORM — action, method, and ALL name attrs preserved exactly ── -->
        <form action="<?= base_url('login'); ?>" method="POST">

            <!-- Email -->
            <div class="field-group">
                <label class="field-label" for="inputEmail">Email Address</label>
                <input
                    class="field-input"
                    id="inputEmail"
                    type="email"
                    name="inputEmail"
                    placeholder="you@store.ph" />
            </div>

            <!-- Password -->
            <div class="field-group">
                <label class="field-label" for="inputPassword">Password</label>
                <div class="input-wrap">
                    <input
                        class="field-input"
                        id="inputPassword"
                        type="password"
                        name="inputPassword"
                        placeholder="Enter your password" />
                    <button type="button" class="pw-toggle" onclick="togglePw('inputPassword', this)" aria-label="Show password">👁</button>
                </div>
            </div>

            <!-- Remember me + Forgot password row (UI only) -->
            <div class="form-footer-row">
                <div class="remember-wrap">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">Keep me signed in</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <!-- Submit — preserves original login action -->
            <button type="submit" class="btn-signin">Sign In</button>

        </form>

        <!-- Divider + role pills (visual context, no logic) -->
        <div class="divider">Sign in as</div>
        <div class="role-pills">
            <div class="role-pill">
                <div class="role-pill-dot dot-owner"></div>
                Owner
            </div>
            <div class="role-pill">
                <div class="role-pill-dot dot-manager"></div>
                Manager
            </div>
            <div class="role-pill">
                <div class="role-pill-dot dot-cashier"></div>
                Cashier
            </div>
        </div>

        <!-- Register link — preserves original base_url('register') -->
        <div class="register-link">
            Don't have an account?&nbsp;
            <a href="<?= base_url('register') ?>">Register</a>
        </div>

    </div><!-- /form-panel -->


    <!-- ════════════════════════════════
         RIGHT — BRAND PANEL
    ════════════════════════════════ -->
    <div class="brand-panel">
        <div class="bp-pattern"></div>
        <div class="bp-glow"></div>

        <div class="bp-content">

            <!-- Panel wordmark -->
            <div class="bp-brand">
                <div class="bp-wordmark">Thr<span>ead</span></div>
                <span class="bp-rule"></span>
            </div>

            <!-- Headline — different copy from register, same structure -->
            <div class="bp-title">
                Run your<br>store with<br><em>clarity.</em>
            </div>

            <div class="bp-sub">
                End-to-end inventory, POS, customer management, and analytics — purpose-built for apparel retail.
            </div>

            <!-- Editorial numbered feature list — identical structure to register.php -->
            <div class="bp-features">

                <div class="bp-feature">
                    <div class="bp-feature-num">01</div>
                    <div class="bp-feature-body">
                        <div class="bp-feature-title">Smart Inventory</div>
                        <div class="bp-feature-desc">Track stock by size, color &amp; branch in real time</div>
                    </div>
                </div>

                <div class="bp-feature">
                    <div class="bp-feature-num">02</div>
                    <div class="bp-feature-body">
                        <div class="bp-feature-title">Integrated POS</div>
                        <div class="bp-feature-desc">Fast walk-in sales with Cash, GCash &amp; Card support</div>
                    </div>
                </div>

                <div class="bp-feature">
                    <div class="bp-feature-num">03</div>
                    <div class="bp-feature-body">
                        <div class="bp-feature-title">Customer Loyalty</div>
                        <div class="bp-feature-desc">Built-in loyalty points and tiered customer profiles</div>
                    </div>
                </div>

                <div class="bp-feature">
                    <div class="bp-feature-num">04</div>
                    <div class="bp-feature-body">
                        <div class="bp-feature-title">Live Analytics</div>
                        <div class="bp-feature-desc">Revenue, top sellers &amp; branch performance at a glance</div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- /brand-panel -->

</div><!-- /page-wrap -->


<script>
    /* ── Password show/hide (UI only — no effect on form values or submission) ── */
    function togglePw(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const isHidden = input.type === 'password';
        input.type      = isHidden ? 'text' : 'password';
        btn.textContent = isHidden ? '🙈' : '👁';
    }
</script>

</body>
</html>