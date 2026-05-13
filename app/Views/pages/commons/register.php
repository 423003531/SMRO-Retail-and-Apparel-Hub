<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Gilang Heavy">
    <meta name="keywords" content="Gilang Heavy, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Create Account — THREAD Retail Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <style>
        /* ─────────────────────────────────────────
           THREAD Design System — Register Page
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

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 36px;
        }
        /* Wordmark — no box, pure typography */
        .brand-wordmark {
            display: flex;
            align-items: baseline;
            gap: 0;
            position: relative;
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
        /* Thin accent rule beneath */
        .brand-rule {
            display: block;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
            margin-top: 3px;
        }
        .brand-wrap {
            display: flex;
            flex-direction: column;
        }

        /* Heading */
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
            margin-bottom: 26px;
        }

        /* ── CI4 Alerts slot ── */
        .alert-slot { margin-bottom: 16px; }

        /* Override any Bootstrap alert colours to match THREAD palette */
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

        /* ── Form elements ── */
        .field-group {
            margin-bottom: 16px;
        }
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

        /* Password show/hide wrapper */
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

        /* Strength meter */
        .strength-wrap    { margin-top: 7px; }
        .strength-track   { height: 3px; background: var(--border); border-radius: 2px; overflow: hidden; margin-bottom: 4px; }
        .strength-fill    { height: 100%; border-radius: 2px; width: 0; transition: width .3s ease, background .3s ease; }
        .strength-hint    { font-size: 11px; color: var(--text-3); }

        /* Submit button */
        .btn-register {
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
            margin-top: 4px;
        }
        .btn-register:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 14px rgba(192,73,10,.22);
        }
        .btn-register:active { transform: translateY(1px); }

        /* Login link */
        .login-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-2);
            margin-top: 20px;
        }
        .login-link a {
            color: var(--accent);
            font-weight: 700;
            text-decoration: none;
        }
        .login-link a:hover { text-decoration: underline; }

        /* ─────────────────────────────
           RIGHT — BRAND PANEL
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
        /* Crosshatch texture — identical to mockup */
        .bp-pattern {
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient( 45deg, rgba(255,255,255,.018) 0px, rgba(255,255,255,.018) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(-45deg, rgba(255,255,255,.018) 0px, rgba(255,255,255,.018) 1px, transparent 1px, transparent 40px);
        }
        /* Warm ambient glow */
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

        /* Brand mark inside dark panel */
        .bp-brand {
            display: flex;
            flex-direction: column;
            margin-bottom: 48px;
        }
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

        /* Editorial numbered feature list */
        .bp-features {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .bp-feature {
            display: grid;
            grid-template-columns: 36px 1fr;
            gap: 16px;
            align-items: start;
            padding: 18px 0;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .bp-feature:last-child {
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .bp-feature-num {
            font-family: var(--font-cg);
            font-style: italic;
            font-size: 22px;
            font-weight: 300;
            color: rgba(232,144,106,.35);
            line-height: 1.1;
            padding-top: 1px;
        }
        .bp-feature-body {}
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
         LEFT — REGISTRATION FORM
    ════════════════════════════════ -->
    <div class="form-panel">

        <!-- Brand wordmark -->
        <div class="brand">
            <div class="brand-wrap">
                <div class="brand-wordmark">
                    <span class="wm-the">Thr</span><span class="wm-read">ead</span>
                </div>
                <span class="brand-rule"></span>
            </div>
        </div>

        <div class="form-heading">Create your account</div>
        <div class="form-sub">Join the THREAD Retail &amp; Apparel Hub</div>

        <!-- ── CI4 alerts component — completely untouched ── -->
        <div class="alert-slot">
            <?= $this->include('components/alerts'); ?>
        </div>

        <!-- ── FORM — action, method, and ALL name/required attributes preserved exactly ── -->
        <form action="<?= base_url('register'); ?>" method="POST">

            <!-- Full Name -->
            <div class="field-group">
                <label class="field-label" for="inputFullname">Full Name</label>
                <input
                    class="field-input"
                    id="inputFullname"
                    type="text"
                    name="inputFullname"
                    placeholder="Enter your full name"
                    required />
            </div>

            <!-- Email -->
            <div class="field-group">
                <label class="field-label" for="inputEmail">Email Address</label>
                <input
                    class="field-input"
                    id="inputEmail"
                    type="email"
                    name="inputEmail"
                    placeholder="you@store.ph"
                    required />
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
                        placeholder="Create a password"
                        required
                        oninput="checkStrength(this.value)" />
                    <button type="button" class="pw-toggle" onclick="togglePw('inputPassword', this)" aria-label="Show password">👁</button>
                </div>
                <!-- Strength meter — cosmetic only, no effect on form logic -->
                <div class="strength-wrap">
                    <div class="strength-track">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div class="strength-hint" id="strength-hint">Use 8+ characters with letters, numbers &amp; symbols</div>
                </div>
            </div>

            <!-- Repeat Password -->
            <div class="field-group">
                <label class="field-label" for="inputPassword2">Confirm Password</label>
                <div class="input-wrap">
                    <input
                        class="field-input"
                        id="inputPassword2"
                        type="password"
                        name="inputPassword2"
                        placeholder="Repeat your password"
                        required />
                    <button type="button" class="pw-toggle" onclick="togglePw('inputPassword2', this)" aria-label="Show password">👁</button>
                </div>
            </div>

            <!-- Submit — preserves original register action -->
            <button type="submit" class="btn-register">Create Account</button>

        </form>

        <!-- Login link — preserves original base_url() -->
        <div class="login-link">
            Already have an account?&nbsp;
            <a href="<?= base_url() ?>">Sign in</a>
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

            <!-- Headline -->
            <div class="bp-title">
                Your store,<br>fully in<br><em>control.</em>
            </div>

            <div class="bp-sub">
                Everything you need to run a modern retail operation — inventory, POS, customers, and analytics — all in one place.
            </div>

            <!-- Editorial numbered feature list -->
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
        input.type   = isHidden ? 'text' : 'password';
        btn.textContent = isHidden ? '🙈' : '👁';
    }

    /* ── Password strength meter (cosmetic only) ── */
    function checkStrength(val) {
        const fill = document.getElementById('strength-fill');
        const hint = document.getElementById('strength-hint');
        if (!fill || !hint) return;

        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { pct: '0%',   color: '',          label: 'Use 8+ characters with letters, numbers & symbols' },
            { pct: '25%',  color: '#B03030',   label: 'Weak — add uppercase letters or numbers' },
            { pct: '50%',  color: '#9A6B10',   label: 'Fair — try adding a symbol' },
            { pct: '75%',  color: '#5C7A3E',   label: 'Good — almost there!' },
            { pct: '100%', color: '#3A7D4E',   label: 'Strong password ✓' },
        ];

        const lvl = val.length === 0 ? levels[0] : levels[score];
        fill.style.width      = lvl.pct;
        fill.style.background = lvl.color;
        hint.textContent      = lvl.label;
        hint.style.color      = lvl.color || 'var(--text-3)';
    }
</script>

</body>
</html>