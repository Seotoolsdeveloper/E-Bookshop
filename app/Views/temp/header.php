<div class="header-area">

    <!-- Top Bar -->
    <div class="hearder-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="welcome-tx">Welcome to Online Book Shop!</div>
                </div>
                <div class="col-md-6">
                    <div class="social-icon">
                        <span>Follow: </span>
                        <a href="https://www.facebook.com/jignesh.ameta.9/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://github.com/" target="_blank"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/jignesh-ameta-621772134/" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Header -->
    <div class="header-mid">
        <div class="container">
            <div class="row">

                <!-- Logo -->
                <div class="col-md-5">
                    <div class="logo">
                        <div class="lname">
                            <a href="<?= base_url(route_to('home')) ?>">
                                <span><img src="<?= base_url('tool/img/favicon.png') ?>" alt="Bookshop Logo"> Bookshop</span> & E-learning
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search & Cart -->
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-9 text-center">
                            <?php if (!session()->get('logged_in')): ?>
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
                            <div class="ic-cart">
                                <a href="<?= base_url('cart') ?>"><i class="fas fa-shopping-cart"></i> Cart</a>
                            </div>
                            <?php if (isset($cart) && $cart->total_items() > 0): ?>
                                <div class="cart-count">
                                    <div><?= $cart->total_items() ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Menu -->
    <div>
        <?= view('temp/menu') ?>
    </div>
</div>
