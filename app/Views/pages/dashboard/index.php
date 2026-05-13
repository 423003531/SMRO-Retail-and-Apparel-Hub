<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="page-header mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong><?= esc($title); ?></strong></h1>
    <p class="text-muted">Welcome to your inventory control center.</p>
</div>

<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= esc($totalProducts) ?></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Items in Stock</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= esc($totalStock) ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="m-0 font-weight-bold text-primary">Daily Sales Revenue (Last 7 Days)</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
            </div>
            <div class="card-body">
                <canvas id="topProductsChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="m-0 font-weight-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Low Stock Alerts</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($lowStockItems)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Variant</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStockItems as $item): ?>
                                    <tr>
                                        <td class="fw-bold"><?= esc($item['product_name']) ?></td>
                                        <td><?= esc($item['size']) ?> / <?= esc($item['color']) ?></td>
                                        <td><span class="badge bg-danger"><?= esc($item['stock_quantity']) ?> Left</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
                        <em>All inventory levels look healthy!</em>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-clock-history me-2"></i> Recent Activity</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recentActivity)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recentActivity as $log): ?>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold"><?= esc($log['product_name']) ?> <span class="text-muted small">(<?= esc($log['size']) ?>/<?= esc($log['color']) ?>)</span></div>
                                    <div class="small text-muted"><?= date('M d, Y h:i A', strtotime($log['created_at'])) ?></div>
                                </div>
                                <div>
                                    <?php if ($log['movement_type'] === 'in'): ?>
                                        <span class="badge bg-success">+<?= esc($log['quantity']) ?> (IN)</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">-<?= esc($log['quantity']) ?> (OUT)</span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <em>No recent activity found.</em>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: <?= $salesLabels ?>,
            datasets: [{
                label: 'Revenue (₱)',
                data: <?= $salesData ?>,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Top Products Chart
    const topCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: <?= $topProductLabels ?>,
            datasets: [{
                label: 'Units Sold',
                data: <?= $topProductData ?>,
                backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<?= $this->endSection(); ?>