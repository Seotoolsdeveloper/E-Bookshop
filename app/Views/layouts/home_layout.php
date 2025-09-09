<?= $this->extend('layouts/base_layout') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Sell your books easily on Bookshop. Upload details, images, and reach buyers.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>




<?php
if(isset($user_view)){
?>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 500px">
            <?= view($user_view); ?>
            
        </div>
    </div>
</div>

<?php
}else{
    ?>
<!-- Slider Area -->
<div>
    <?= view('temp/slider') ?>
</div>

<!-- Recent Books Section -->
<div class="section-padding after-slider">
    <div class="container">
        <div class="section-title"><a href="<?= base_url('users/all_books') ?>">Recent Books</a></div>
        <div><?= view('temp/recent_books') ?></div>
    </div>
</div>

<?php }?>
<?= $this->endSection() ?>



