<!--=== Success msg ===-->
<?php if(session()->getFlashdata('success')): ?>
    <div class="success-msg"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<?php if(!empty($books)): ?>
<div class="container-fluid">
    <div id="table-header">My Books List</div>
    <table class="table table-bordered table-striped">
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
                <th>Book Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($books as $book): ?>
            <tr>
                <td><?= esc($book->id) ?></td>
                <td>
                    <a href="<?= base_url('users/book-view/'.$book->id) ?>" class="text-info" title="More Description">
                        <?= esc(ucwords($book->book_name)) ?>
                    </a>
                </td>
                <td><?= esc(substr(strip_tags($book->description), 0, 100)) ?>...</td>
                <td><?= esc($book->author) ?></td>
                <td><?= esc($book->publisher) ?></td>
                <td>Rs <?= esc($book->price) ?></td>
                <td><?= esc($book->quantity) ?></td>
                <td><?= esc(ucwords($book->category)) ?></td>
                <td>
                    <img src="<?= esc($book->book_image ?: base_url('tool/img/default-book.png')) ?>" 
                         alt="<?= esc($book->book_name) ?>" width="50" height="80">
                </td>
                <td>
                    <?= $book->status == 1 
                        ? '<span class="text-success">Published</span>' 
                        : '<span class="text-danger">Unpublished</span>' ?>
                </td>
                <td>
                    <div>
                        <a href="<?= base_url('users/book-view/'.$book->id) ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                    <br>
                    <div>
                        <a href="<?= base_url('user-home/myBooks-delete/'.$book->id) ?>" 
                           class="btn btn-danger btn-sm delete" 
                           data-confirm="Are you sure to delete this book?">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<div class="error-msg">
    You did not post any books for sale yet. You can <a href="<?= base_url('userhome/sellbooks') ?>" class="text-primary"><b>sell your books</b></a> now.
</div>
<?php endif; ?>
