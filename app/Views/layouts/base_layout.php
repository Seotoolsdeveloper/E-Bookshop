<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title ?? 'Bookshop | E-learning' ?></title>
    <link rel="shortcut icon" href="<?= base_url('tool/img/favicon.png'); ?>" type="image/png">

    <!-- Page-specific meta -->
    <?= $this->renderSection('meta') ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('tool/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/all.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tool/css/style.css'); ?>">

    <!-- JS -->
    <script src="<?= base_url('tool/js/jquery-3.2.1.slim.min.js'); ?>"></script>

    <?= $this->renderSection('head-scripts') ?>
</head>
<body>

<!-- Header -->
<?= $this->include('temp/header') ?>

<!-- Flash Messages -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="success-msg">
        <div class="container"><?= esc(session()->getFlashdata('success')) ?></div>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="error-msg">
        <div class="container"><?= esc(session()->getFlashdata('error')) ?></div>
    </div>
<?php endif; ?>


    <?= $this->renderSection('content') ?>


<!-- Footer -->
<?= $this->include('temp/footer') ?>

<!-- JS -->
<script src="<?= base_url('tool/js/popper-1.12.9.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/all.js'); ?>"></script>
<script src="<?= base_url('tool/js/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('tool/js/main.js'); ?>"></script>

<?= $this->renderSection('scripts') ?>

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
                // Optionally update cart counter in header
                const cartCounter = document.querySelector('.cart-count div');
                if(cartCounter) cartCounter.textContent = data.total_items;
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
    });
});
</script>
</body>
</html>