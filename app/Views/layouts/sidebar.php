<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url(); ?> ">
            <span class="align-middle"><i>Thread</i></span>
        </a>
        <ul class="sidebar-nav">
            
            <li class="sidebar-header">
                Main
            </li>
            
            <li class="sidebar-item <?= url_is('dashboard*') || url_is('/') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('dashboard'); ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Catalog
            </li>
            <li class="sidebar-item <?= url_is('products*') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('products'); ?>">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Products</span>
                </a>
            </li>
            <li class="sidebar-item <?= url_is('inventory*') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('inventory'); ?>">
                    <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Stock Ledger</span>
                </a>
            </li>

            <li class="sidebar-header">
                Sales
            </li>
            <li class="sidebar-item <?= url_is('pos*') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('pos'); ?>">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Point of Sale</span>
                </a>
            </li>
            <li class="sidebar-item <?= url_is('sales*') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('sales'); ?>">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Sales History</span>
                </a>
            </li>

            <li class="sidebar-header">
                System
            </li>
            <li class="sidebar-item <?= url_is('users*') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="<?= base_url('users'); ?>">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</nav>