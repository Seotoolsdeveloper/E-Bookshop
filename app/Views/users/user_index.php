<!--=== Success msg ===-->
<?php if(session()->getFlashdata('login_success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('login_success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>


<div class="admin-index section-padding">
    <div class="user-heading text-center">
        <h3>Welcome, <span class="text-info"><?= esc(session()->get('name')) ?></span></h3>
        <p>You can sell your book with a proper price. You can see your book information, track your orders, and edit your profile information like name, password, and other details.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="user-info">
            <div id="table-header">Profile details</div><br>
            <h4 class="text-info"><?= esc($user_details->name) ?></h4>
            <p><i class="fas fa-envelope"></i> <?= esc($user_details->email) ?></p>
            <p><i class="fas fa-mobile-alt"></i> <?= esc($user_details->contact) ?></p>
            <p><i class="fas fa-map-marker-alt"></i> <?= esc($user_details->address) ?> &nbsp;<i class="fas fa-city"></i> <?= esc($user_details->city) ?></p>
            <p><i class="fas fa-history"></i> Joined from: <?= esc(date('d-M, y', strtotime($user_details->createdate))) ?></p>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="user-activities">
            <div id="table-header">Your Activities</div><br>

            <?php 
                // Load UserModel
                $userModel = new \App\Models\UserModel();

                $totalBooks = count($userModel->myBooks(session()->get('id')));
                $publishedBooks = count($userModel->myPublishedBooks(session()->get('id')));
                $totalOrders = count($userModel->myOrders(session()->get('id')));
                $totalReviews = count($userModel->myReviews(session()->get('id')));
            ?>

            <div class="user-books">
                <b>Total Books:</b> You have uploaded <?= $totalBooks ?> books.
                <p class="text-success"><b>Published Books: <?= $publishedBooks ?></b></p>
            </div>

            <div class="user-orders">
                <b>Orders:</b> You have placed <?= $totalOrders ?> orders till now.
            </div>

            <div class="user-reviews">
                <b>Reviews:</b> You have written <?= $totalReviews ?> reviews of books.
            </div>

        </div>
    </div>
</div>
