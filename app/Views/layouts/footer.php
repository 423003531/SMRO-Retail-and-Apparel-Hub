<style>
    /* ─────────────────────────────────────────
       THREAD Design System — Footer Component
       Consistent with login.php & register.php
    ───────────────────────────────────────── */
    .thread-footer {
        border-top: 1px solid #E4DDD6;
        background: #FFFFFF;
        padding: 14px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .thread-footer-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Left — brand + meta */
    .footer-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .footer-wordmark {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 300;
        font-size: 15px;
        color: #1A1210;
        letter-spacing: 0.04em;
        text-decoration: none;
        line-height: 1;
        white-space: nowrap;
    }
    .footer-wordmark span {
        font-weight: 400;
        color: #1A1210;
    }
    .footer-wordmark:hover { color: #C0490A; }
    .footer-wordmark:hover span { color: #C0490A; }

    .footer-sep {
        width: 1px;
        height: 14px;
        background: #D5CCC4;
        flex-shrink: 0;
    }

    .footer-meta {
        font-size: 11px;
        color: #A89890;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .footer-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .footer-meta-dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: #D5CCC4;
        flex-shrink: 0;
    }

    .footer-env-chip {
        display: inline-block;
        padding: 1px 7px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        background: #FBF3E0;
        color: #9A6B10;
        border: 1px solid rgba(154,107,16,.2);
        line-height: 1.6;
    }
    /* Switch chip colour in production */
    .footer-env-chip.env-production {
        background: #EDF5F0;
        color: #3A7D4E;
        border-color: rgba(58,125,78,.2);
    }

    /* Right — links */
    .footer-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer-link {
        font-size: 12px;
        font-weight: 500;
        color: #A89890;
        text-decoration: none;
        padding: 4px 10px;
        border-radius: 6px;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .footer-link:hover {
        color: #C0490A;
        background: #FAF0EA;
    }

    .footer-links-sep {
        width: 1px;
        height: 12px;
        background: #E4DDD6;
        flex-shrink: 0;
    }
</style>

<footer class="thread-footer">
    <div class="thread-footer-inner">

        <!-- Left: wordmark + render time + environment -->
        <div class="footer-left">

            <!-- Preserves original href="#" target="_blank" and CI4 variables -->
            <a class="footer-wordmark" href="#" target="_blank">
                Thr<span>ead</span>
            </a>

            <div class="footer-sep"></div>

            <div class="footer-meta">
                <div class="footer-meta-item">
                    <!-- Preserves original © date('Y') -->
                    &copy; <?= date('Y'); ?>
                </div>
                <div class="footer-meta-dot"></div>
                <div class="footer-meta-item">
                    <!-- Preserves original {elapsed_time} -->
                    Rendered in {elapsed_time}s
                </div>
                <div class="footer-meta-dot"></div>
                <div class="footer-meta-item">
                    <!-- Preserves original ucfirst(ENVIRONMENT) -->
                    <span class="footer-env-chip"><?= ucfirst(ENVIRONMENT) ?></span>
                </div>
            </div>
        </div>

        <!-- Right: support links — preserves original hrefs and target="_blank" -->
        <div class="footer-links">
            <a class="footer-link" href="https://github.com/gilangheavy/CI4-StarterPanel" target="_blank">Support</a>
            <div class="footer-links-sep"></div>
            <a class="footer-link" href="https://github.com/gilangheavy/CI4-StarterPanel/issues" target="_blank">Help Center</a>
        </div>

    </div>
</footer>