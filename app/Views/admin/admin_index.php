<div class="text-success">
<?php 
if (session()->getFlashdata('login_success')) {
    echo '<div class="success-msg">' . session()->getFlashdata('login_success') . '</div>';
}
?>
</div>

<div class="admin-index section-padding" style="min-height: 500px">
    <div class="text-center">
        <h3>Admin Dashboard</h3>
        <p>Welcome, <a href="#" class="text-primary"><?= session()->get('name') ?></a>. You have logged in as an admin. Now you can monitor the full application</p>
    </div>

    <div class="admin-content section-padding">
        <div class="container">
            <div class="row con-flex">

                <?php 
                $adminModel = model('App\Models\AdminModel');

                $stats = [
                    ['bg' => 'primary', 'icon' => 'fas fa-list',       'label' => 'Total Category',   'count' => count($adminModel->getCategory()), 'link' => base_url('admin/category')],
                    ['bg' => 'success', 'icon' => 'fas fa-book',      'label' => 'Total Books',     'count' => count($adminModel->countTotalBooks()), 'link' => base_url('admin/books')],
                    ['bg' => 'secondary', 'icon' => 'fas fa-users',   'label' => 'Total Users',     'count' => count($adminModel->getUsers()), 'link' => base_url('admin/allusers')],
                    ['bg' => 'info', 'icon' => 'fas fa-desktop',      'label' => 'Total e-books',   'count' => count($adminModel->getEbooks()), 'link' => base_url('admin/ebooks')],
                    ['bg' => 'danger', 'icon' => 'fas fa-shopping-cart', 'label' => 'Total Orders', 'count' => count($adminModel->getOrders()), 'link' => base_url('admin/orders')],
                    ['bg' => 'warning', 'icon' => 'fas fa-book-dead','label' => 'Pending Books',  'count' => count($adminModel->pendingBooks()), 'link' => base_url('admin/pending_books')],
                ];

                foreach ($stats as $stat): ?>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="col-admin bg-<?= $stat['bg'] ?> clickable-div" data-href="<?= $stat['link'] ?>">
                            <div>
                                <i class="<?= $stat['icon'] ?>"></i>
                                <h6><?= $stat['label'] ?></h6>
                            </div>
                            <?= $stat['count'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
