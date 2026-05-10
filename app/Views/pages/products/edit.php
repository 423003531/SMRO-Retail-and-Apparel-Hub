<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="page-header mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong><?= $title; ?></strong></h1>
    <p class="text-muted">Update product details below.</p>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>Please check your inputs:</strong>
        <ul class="mb-0 mt-1">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="<?= base_url('products/update/' . $product['id']) ?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name', esc($product['name'])) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Base SKU</label>
                    <input type="text" name="sku" class="form-control" value="<?= old('sku', esc($product['sku'])) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?= old('category', esc($product['category'])) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Default Selling Price</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" value="<?= old('selling_price', esc($product['selling_price'])) ?>">
                </div>
            </div>

            <div class="col-md-12 mb-3 mt-3">
                <div class="card border">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fs-6">Product Variants</h5>
                        <button type="button" class="btn btn-sm btn-primary" id="addVariantBtn">+ Add Variant</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped mb-0" id="variantsTable">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>Variant SKU</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Price (₱)</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($variants)): ?>
                                        <?php foreach ($variants as $index => $variant): ?>
                                            <tr>
                                                <td><input type="text" name="variants[<?= $index ?>][sku]" class="form-control form-control-sm" value="<?= esc($variant['sku']) ?>" required></td>
                                                <td><input type="text" name="variants[<?= $index ?>][size]" class="form-control form-control-sm" value="<?= esc($variant['size']) ?>"></td>
                                                <td><input type="text" name="variants[<?= $index ?>][color]" class="form-control form-control-sm" value="<?= esc($variant['color']) ?>"></td>
                                                <td><input type="number" step="0.01" name="variants[<?= $index ?>][price]" class="form-control form-control-sm" value="<?= esc($variant['price']) ?>"></td>
                                                <td><input type="number" name="variants[<?= $index ?>][stock_quantity]" class="form-control form-control-sm" value="<?= esc($variant['stock_quantity']) ?>" required></td>
                                                <td><button type="button" class="btn btn-outline-danger btn-sm remove-variant">X</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td><input type="text" name="variants[0][sku]" class="form-control form-control-sm" required></td>
                                            <td><input type="text" name="variants[0][size]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="variants[0][color]" class="form-control form-control-sm"></td>
                                            <td><input type="number" step="0.01" name="variants[0][price]" class="form-control form-control-sm" value="0.00"></td>
                                            <td><input type="number" name="variants[0][stock_quantity]" class="form-control form-control-sm" value="0" required></td>
                                            <td><button type="button" class="btn btn-outline-danger btn-sm remove-variant">X</button></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 p-3 bg-light border rounded">
                <label class="form-label d-block fw-bold">Product Image</label>
                <div class="mb-3">
                    <?php if (!empty($product['base_image'])): ?>
                        <p class="text-muted small mb-1">Current Image:</p>
                        <img src="<?= base_url('uploads/products/' . esc($product['base_image'])) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                    <?php else: ?>
                        <p class="text-muted small fst-italic">No image currently assigned to this product.</p>
                    <?php endif; ?>
                </div>
                <label class="form-label">Upload New Image</label>
                <input type="file" name="image" class="form-control bg-white" accept="image/png, image/jpeg, image/jpg, image/webp">
                <small class="text-muted">Leave blank if you want to keep the current image.</small>
            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php $statusValue = old('status', $product['status']); ?>
                    <option value="Active" <?= $statusValue === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= $statusValue === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="<?= base_url('products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
    // Set starting index based on existing rows
    let variantIndex = <?= !empty($variants) ? count($variants) : 1 ?>;
    
    document.getElementById('addVariantBtn').addEventListener('click', function() {
        const tableBody = document.querySelector('#variantsTable tbody');
        const newRow = `
            <tr>
                <td><input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" required></td>
                <td><input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm"></td>
                <td><input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm" value="0.00"></td>
                <td><input type="number" name="variants[${variantIndex}][stock_quantity]" class="form-control form-control-sm" value="0" required></td>
                <td><button type="button" class="btn btn-outline-danger btn-sm remove-variant">X</button></td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
        variantIndex++;
    });

    document.getElementById('variantsTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant')) {
            if (document.querySelectorAll('#variantsTable tbody tr').length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert("At least one variant is required.");
            }
        }
    });
</script>

<?= $this->endSection(); ?>