<?php helper('url'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--==== CSS =====-->
    <link rel="stylesheet" href="<?= base_url('tool/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/all.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/style.css'); ?>">
    
    <!-- jQuery -->
    <script src="<?= base_url('tool/js/jquery-3.2.1.slim.min.js'); ?>"></script>

    <title>Bookshop | User pages</title>
    <link rel="shortcut icon" href="<?= base_url('tool/img/favicon.png'); ?>" type="image/png">
</head>

<body>
<!--=========== Header area =============-->
<div class="header-area">
    <div class="hearder-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="welcome-tx">Welcome to Online Book Shop!</div>
                </div>
                <div class="col-md-6">
                    <div class="social-icon">
                        <span>Follow : </span>
                        <a href="https://www.facebook.com/jignesh.ameta.9/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://github.com/" target="_blank" title="Github"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/jignesh-ameta-621772134/" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-mid">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="logo">
                        <div class="lname">
                            <a href="<?= base_url(route_to('home')) ?>"><span><img src="<?= base_url('tool/img/favicon.png') ?>"> Bookshop</span> & E-learning</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-9 text-center">
                        <?php if (! session()->get('logged_in')): ?>
                            <a href="<?= base_url('users/login') ?>" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a href="<?= base_url('users/registration') ?>" class="btn-login"><i class="fas fa-user-cog"></i> Register</a>
                        <?php else: ?>
                            <div class="admin-search">
                                <?= form_open(base_url(route_to('users.search')), ['id' => 'user-search', 'method' => 'get']) ?>
                                    <input type="text" name="keywords" class="form-control" placeholder="Search any book" value="<?= esc($_GET['keywords'] ?? '') ?>">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                <?= form_close() ?>
                            </div>
                        <?php endif; ?>
                        </div>

                        <div class="col-md-3">
                            <div class="ic-cart"><a href="<?= base_url('cart') ?>"><i class="fas fa-shopping-cart"></i> Cart</a></div>
                            <?php if (! empty($cart) && $cart->total_items() > 0): ?>
                                <div class="cart-count"><div><?= $cart->total_items() ?></div></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Menu -->
    <div><?= view('temp/menu') ?></div>
</div>

<!-- Single header -->
<div class="single-header-u">
    <div class="container">
        <span><a href="<?= base_url(route_to('home')) ?>"><i class="fas fa-home"></i> Home</a></span>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 500px">
            <?= view($user_view); ?>
        </div>
    </div>
</div>

<!-- Footer -->
<div><?= view('temp/footer') ?></div>

<!-- Cart add via AJAX -->
<script>
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = this.dataset.price;

        fetch('<?= base_url('cart/add') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `id=${encodeURIComponent(id)}&name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&qty=1`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert(`Added! Total Items: ${data.total_items}`);
                const cartCounter = document.querySelector('.cart-count div');
                if(cartCounter) cartCounter.textContent = data.total_items;
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
    });
});


document.querySelectorAll('.delete-cart-item').forEach(btn => {
    btn.addEventListener('click', function() {
        const rowid = this.dataset.rowid;

        if (!confirm('Are you sure you want to remove this item from cart?')) return;

        fetch('<?= base_url('cart/remove') ?>/' + rowid, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                // Optionally remove the row from table
                this.closest('tr').remove();

                // Update cart total and counter
                const cartTotalEl = document.querySelector('.cart-total');
                const cartCounter = document.querySelector('.cart-count div');

                if(cartTotalEl) cartTotalEl.textContent = `Rs ${data.cart_total}`;
                if(cartCounter) cartCounter.textContent = data.total_items;

                // If no items left, show empty message
                if(data.total_items === 0){
                    document.querySelector('form').innerHTML = '<h5>Your cart is empty, or you have not added any products to cart.</h5>';
                }
            } else {
                alert(data.message || 'Failed to remove item.');
            }
        })
        .catch(err => console.error(err));
    });
});
</script>

<script src="<?= base_url('tool/js/popper-1.12.9.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/all.js'); ?>"></script>
<script src="<?= base_url('tool/js/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/main.js'); ?>"></script>

</body>
</html>
