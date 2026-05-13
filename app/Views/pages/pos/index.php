<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="page-header mb-4">
    <h1 class="h3 mb-0 text-gray-800"><strong><?= esc($title); ?></strong></h1>
    <p class="text-muted">Tap an item to add it to the cart.</p>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="m-0 font-weight-bold text-primary">Available Items</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if(!empty($availableItems)): ?>
                        <?php foreach($availableItems as $item): ?>
                            <div class="col-md-6 col-xl-4 mb-3">
                                <div class="card h-100 border-1 shadow-sm" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'"
                                     onclick="addToCart(<?= $item['id'] ?>, '<?= esc($item['product_name']) ?>', '<?= esc($item['size']) ?>/<?= esc($item['color']) ?>', <?= esc($item['selling_price']) ?>)">
                                    <div class="card-body text-center p-3">
                                        <h6 class="font-weight-bold text-dark mb-1"><?= esc($item['product_name']) ?></h6>
                                        <p class="text-muted small mb-2"><?= esc($item['size']) ?> / <?= esc($item['color']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="text-primary fw-bold">₱<?= number_format($item['selling_price'], 2) ?></span>
                                            <span class="badge bg-success"><?= esc($item['stock_quantity']) ?> in stock</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            No items available in stock. Time to restock!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
            <div class="card-header bg-white pt-4 pb-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-cart3 me-2"></i> Current Order</h6>
                <button class="btn btn-sm btn-outline-danger" onclick="clearCart()">Clear</button>
            </div>
            
            <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="cart-items">
                    <li class="list-group-item text-center text-muted py-4" id="empty-cart-msg">Cart is empty</li>
                </ul>
            </div>
            
            <div class="card-footer bg-light border-top-0 pt-3 pb-4">
                <div class="d-flex justify-content-between font-weight-bold h5 mb-3 text-dark">
                    <span>Total:</span>
                    <span>₱<span id="cart-total">0.00</span></span>
                </div>
                
                <form action="<?= base_url('pos/checkout') ?>" method="POST" id="checkout-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="cart_data" id="cart-data-input">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm" id="checkout-btn" disabled>
                        Complete Sale
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = {};

    function addToCart(variantId, name, variantName, price) {
        price = parseFloat(price);
        
        if (cart[variantId]) {
            cart[variantId].quantity++;
        } else {
            cart[variantId] = {
                id: variantId,
                name: name,
                variant: variantName,
                price: price,
                quantity: 1
            };
        }
        renderCart();
    }

    function removeFromCart(variantId) {
        delete cart[variantId];
        renderCart();
    }

    function clearCart() {
        cart = {};
        renderCart();
    }

    function renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const checkoutBtn = document.getElementById('checkout-btn');
        const cartDataInput = document.getElementById('cart-data-input');
        const totalDisplay = document.getElementById('cart-total');

        cartItemsContainer.innerHTML = '';
        let total = 0;
        let itemCount = 0;

        for (const id in cart) {
            const item = cart[id];
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemCount++;

            cartItemsContainer.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h6 class="my-0 text-dark fw-bold">${item.name}</h6>
                        <small class="text-muted">${item.variant} &nbsp;&bull;&nbsp; x${item.quantity}</small>
                    </div>
                    <div class="text-end">
                        <span class="text-dark d-block fw-bold">₱${itemTotal.toFixed(2)}</span>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" onclick="removeFromCart(${id})"><small>Remove</small></button>
                    </div>
                </li>
            `;
        }

        if (itemCount === 0) {
            cartItemsContainer.innerHTML = '<li class="list-group-item text-center text-muted py-4">Cart is empty</li>';
            checkoutBtn.disabled = true;
        } else {
            checkoutBtn.disabled = false;
        }

        totalDisplay.innerText = total.toFixed(2);
        cartDataInput.value = JSON.stringify(cart);
    }
</script>

<?= $this->endSection(); ?>