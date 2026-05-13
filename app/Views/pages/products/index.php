<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><strong><?= $title; ?></strong></h1>
        <p class="text-muted">Manage your retail inventory, pricing, and stock.</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('products/create') ?>" class="btn btn-primary">+ Add Product</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Search Bar -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body py-2">
        <form method="GET" action="<?= base_url('products') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search by name, SKU, or category..." value="<?= esc($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>SKU</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Sizes</th>
                        <th>Colors</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products) && is_array($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="text-muted"><small><?= esc($product['sku']); ?></small></td>
                                <td>
                                    <?php if (!empty($product['base_image'])): ?>
                                        <img src="<?= base_url('uploads/products/' . esc($product['base_image'])) ?>" alt="<?= esc($product['name']) ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light text-muted border rounded d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 0.7rem;">
                                            No Img
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= esc($product['name']); ?></strong></td>
                                <td><?= esc($product['category']); ?></td>
                                <td>
                                    <?php
                                        $sizes = explode(',', $product['sizes']);
                                        foreach ($sizes as $size) {
                                            if (trim($size) !== '') {
                                                echo '<span class="badge bg-secondary me-1">' . esc(trim($size)) . '</span>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td><?= esc($product['colors']); ?></td>
                                <td class="text-success">₱<?= number_format($product['selling_price'], 2); ?></td>
                                <td>
                                    <?php if ($product['total_stock'] <= 5): ?>
                                        <span class="badge bg-danger"><?= esc($product['total_stock']); ?> Left</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= esc($product['total_stock']); ?> In Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($product['status'] === 'Active'): ?>
                                        <span class="badge bg-primary">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><?= esc($product['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('products/edit/' . $product['id']); ?>" class="btn btn-sm btn-info text-white">Edit</a>
                                    <a href="<?= base_url('products/delete/' . $product['id']); ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this product?');">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <?php if ($search): ?>
                                    <h5>No products found for "<?= esc($search) ?>".</h5>
                                    <a href="<?= base_url('products') ?>">Clear search</a>
                                <?php else: ?>
                                    <h5>No products found.</h5>
                                    <p>Click "+ Add Product" to start building your inventory.</p>
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

<?= $this->endSection(); ?>