<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
    <div class="success-msg">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="books-menu">
        <ul>
            <li><a href="<?= base_url('admin/books') ?>"><i class="fas fa-book"></i> All books</a></li>
            <li><a href="<?= base_url('admin/add_books') ?>"><i class="fas fa-plus-circle"></i> Add new book</a></li>

            <li class="pending-books">
                <a href="<?= base_url('admin/pending_books') ?>"><i class="fas fa-tools"></i> Pending books</a> 
                <div class="count-pending-books">
                    <?= isset($count_pending_books) ? $count_pending_books : 0 ?>
                </div>
            </li>
        </ul>
    </div>
</div>

<br>
<div class="container-fluid">
    <div id="table-header">Books list</div>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Book Name</th>
                <th>Description</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>User</th>
                <th>Book Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($books)): ?>
                <?php foreach($books as $book): ?>
                    <tr>
                        <td><?= esc($book->id) ?></td>
                        <td>
                            <a href="<?= base_url('admin/book_view/'.$book->id) ?>" title="More Description" class="text-info">
                                <?= esc(ucwords($book->book_name)) ?>
                            </a>
                        </td>
                        <td><span><?= esc(substr($book->description, 0, 100)) ?></span></td>
                        <td><b><?= esc($book->author) ?></b></td>
                        <td><?= esc($book->publisher) ?></td>
                        <td>Rs <?= esc($book->price) ?></td>
                        <td><?= esc($book->quantity) ?></td>
                        <td><?= esc(ucwords($book->category)) ?></td>
                        <td><?= esc(ucwords($book->name)) ?></td>
                        <td>
                            <img src="<?= esc($book->book_image) ?>" alt="" width="50" height="80">
                        </td>
                        <td>
                            <a href="<?= base_url('admin/book_view/'.$book->id) ?>" title="View More" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination section-padding">
        <?= $pager->links() ?>
    </div>
</div>
