<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><strong><?= $title; ?></strong></h1>
        <p class="text-muted">Track the history of stock movements (In / Out).</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#adjustStockModal">
        + Adjust Stock
    </button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<!-- Search Bar -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body py-2">
        <form method="GET" action="<?= base_url('inventory') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search by product name, SKU, or remarks..." value="<?= esc($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
                <a href="<?= base_url('inventory/export') ?>?search=<?= esc($search) ?>" class="btn btn-success w-100 mt-2">Export CSV</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Product</th>
                        <th>Variant (Size/Color)</th>
                        <th>Movement</th>
                        <th>Qty</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= date('M d, Y h:i A', strtotime($log['created_at'])) ?></td>
                                <td class="fw-bold"><?= esc($log['product_name']) ?></td>
                                <td>
                                    <?php if ($log['variant_sku']): ?>
                                        <span class="badge bg-secondary"><?= esc($log['variant_sku']) ?></span>
                                        <?= esc($log['size']) ?> / <?= esc($log['color']) ?>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($log['movement_type'] === 'in'): ?>
                                        <span class="badge bg-success">STOCK IN</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">STOCK OUT</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold fs-5 <?= $log['movement_type'] === 'in' ? 'text-success' : 'text-danger' ?>">
                                    <?= $log['movement_type'] === 'in' ? '+' : '-' ?><?= esc($log['quantity']) ?>
                                </td>
                                <td><?= esc($log['remarks'] ?: 'No remarks') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <?php if ($search): ?>
                                    <h5>No results found for "<?= esc($search) ?>".</h5>
                                    <a href="<?= base_url('inventory') ?>">Clear search</a>
                                <?php else: ?>
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    <em>No stock movements recorded yet.</em>
                                <?php endif; ?>
                            </td>
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

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1" aria-labelledby="adjustStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('inventory/adjust') ?>" method="POST">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="adjustStockModalLabel">Adjust Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Select Product & Variant</label>
                        <select name="variant_id" class="form-select" required>
                            <option value="" disabled selected>Choose a specific item...</option>
                            <?php if(!empty($variants)): ?>
                                <?php foreach($variants as $variant): ?>
                                    <option value="<?= $variant['id'] ?>">
                                        <?= esc($variant['product_name']) ?> —
                                        <?= esc($variant['size']) ?> / <?= esc($variant['color']) ?>
                                        (Current Stock: <?= $variant['stock_quantity'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Movement Type</label>
                            <select name="movement_type" class="form-select" required>
                                <option value="in">STOCK IN (+)</option>
                                <option value="out">STOCK OUT (-)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Quantity</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-muted small fw-bold text-uppercase">Remarks / Reason</label>
                        <input type="text" name="remarks" class="form-control" placeholder="e.g., Restock shipment, Damaged item..." required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Adjustment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>