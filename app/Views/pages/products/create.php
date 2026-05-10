<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><strong><?= $title; ?></strong></h1>
        <p class="text-muted">Enter the details to add a new item to your inventory.</p>
    </div>
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
        <form action="<?= base_url('products/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required placeholder="e.g. Oversized Graphic Tee">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Base SKU (Stock Keeping Unit)</label>
                    <input type="text" name="sku" class="form-control" value="<?= old('sku') ?>" required placeholder="e.g. TEE-BLK">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?= old('category') ?>" required placeholder="e.g. Tops, Bottoms, Footwear">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Cost Price (₱)</label>
                    <input type="number" step="0.01" name="cost_price" class="form-control" value="<?= old('cost_price') ?>" required placeholder="0.00">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Default Selling Price (₱)</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" value="<?= old('selling_price') ?>" required placeholder="0.00">
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
                                        <tr>
                                            <td><input type="text" name="variants[0][sku]" class="form-control form-control-sm" placeholder="e.g. TEE-BLK-M" required></td>
                                            <td><input type="text" name="variants[0][size]" class="form-control form-control-sm" placeholder="e.g. M"></td>
                                            <td><input type="text" name="variants[0][color]" class="form-control form-control-sm" placeholder="e.g. Black"></td>
                                            <td><input type="number" step="0.01" name="variants[0][price]" class="form-control form-control-sm" value="0.00"></td>
                                            <td><input type="number" name="variants[0][stock_quantity]" class="form-control form-control-sm" value="0" required></td>
                                            <td><button type="button" class="btn btn-outline-danger btn-sm remove-variant">X</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <div class="mt-4 border-top pt-3">
                <button type="submit" class="btn btn-primary px-4">Save Product</button>
                <a href="<?= base_url('products') ?>" class="btn btn-light px-4 ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    let variantIndex = 1;
    
    // Add new row
    document.getElementById('addVariantBtn').addEventListener('click', function() {
        const tableBody = document.querySelector('#variantsTable tbody');
        const newRow = `
            <tr>
                <td><input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" required></td>
                <td><input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm" placeholder="e.g. L"></td>
                <td><input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="e.g. Red"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm" value="0.00"></td>
                <td><input type="number" name="variants[${variantIndex}][stock_quantity]" class="form-control form-control-sm" value="0" required></td>
                <td><button type="button" class="btn btn-outline-danger btn-sm remove-variant">X</button></td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
        variantIndex++;
    });

    // Remove row
    document.getElementById('variantsTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant')) {
            // Prevent removing the very last row if you want to enforce at least one variant
            if (document.querySelectorAll('#variantsTable tbody tr').length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert("You must have at least one variant.");
            }
        }
    });
</script>

<?= $this->endSection(); ?>