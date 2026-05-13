<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3"><strong>Order Detail</strong></h1>
        <div>
            <button onclick="window.print()" class="btn btn-success me-2">🖨 Print Receipt</button>
            <a href="<?= base_url('sales') ?>" class="btn btn-secondary">← Back to Sales</a>
        </div>
    </div>

    <!-- Order Summary Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Order Number</p>
                    <h5><?= esc($order['order_number']) ?></h5>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Date</p>
                    <h5><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></h5>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Total Amount</p>
                    <h5>₱<?= number_format($order['total_amount'], 2) ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Items Purchased</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $i => $item): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($item['product_name']) ?></td>
                                <td><?= esc($item['sku']) ?></td>
                                <td><?= esc($item['size']) ?></td>
                                <td><?= esc($item['color']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>₱<?= number_format($item['price'], 2) ?></td>
                                <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No items found for this order.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body * { visibility: hidden; }
        .container-fluid, .container-fluid * { visibility: visible; }
        .container-fluid { position: absolute; left: 0; top: 0; width: 100%; }
        .btn { display: none !important; }
    }
</style>

<?= $this->endSection(); ?>