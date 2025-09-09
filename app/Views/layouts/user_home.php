<?= $this->extend('layouts/base_layout') ?>

<?= $this->section('content') ?>

<div class="user-menu-area">
    <div class="container">
        <div class="user-menu">
            <ul>
                <li><a href="<?= base_url('user-home/sellbooks') ?>">Sell Books</a></li>
                <li><a href="<?= base_url('user-home/myBooks') ?>">My books</a></li>
                <li><a href="<?= base_url('user-home/my-orders') ?>">My orders</a></li>
                <li><a href="<?= base_url(route_to('user.editprofile', session()->get('id'))) ?>"
                
                >Edit profile</a></li>
                <li><a href="<?= base_url('users/logout') ?>"><i class="fas fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <?= view($user_view) ?>   <!-- the dynamic inner page -->
</div>

<?= $this->endSection() ?>
