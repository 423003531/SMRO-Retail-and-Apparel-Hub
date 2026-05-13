<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid mt-4">

    <!-- Date Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('sales') ?>" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?= esc($dateFrom) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?= esc($dateTo) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Search Order ID</label>
                    <input type="text" name="search" class="form-control" placeholder="Search order number..." value="<?= esc($search) ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="<?= base_url('sales/export') ?>?date_from=<?= esc($dateFrom) ?>&date_to=<?= esc($dateTo) ?>" class="btn btn-success w-100 mt-2">Export CSV</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                    <div class="h3 mb-0 fw-bold"><?= count($orders) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
                    <div class="h3 mb-0 fw-bold">₱<?= number_format($totalRevenue, 2) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Period</div>
                    <div class="h5 mb-0 fw-bold"><?= date('M d, Y', strtotime($dateFrom)) ?> — <?= date('M d, Y', strtotime($dateTo)) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Orders Table -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sales History</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Amount</th>
                                    <th>Date & Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong><?= esc($order['order_number']) ?></strong></td>
                                            <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                            <td><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= base_url('sales/' . $order['id']) ?>" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No sales found for this period.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                <?php if ($pager): ?>
                    <div class="card-footer bg-white">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Top Products</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topProducts)): ?>
                                <?php foreach ($topProducts as $product): ?>
                                    <tr>
                                        <td><?= esc($product['name']) ?></td>
                                        <td><?= esc($product['total_sold']) ?></td>
                                        <td>₱<?= number_format($product['revenue'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No data.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>