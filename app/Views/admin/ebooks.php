<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
    <div class="success-msg">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="books-menu">
        <ul>
            <li><a href="<?= base_url('admin/ebooks') ?>"><i class="fas fa-chalkboard-teacher"></i> All E-Books</a></li>
            <li><a href="<?= base_url('admin/add_ebooks') ?>"><i class="fas fa-plus-circle"></i> Add New E-Book</a></li>
        </ul>
    </div>
</div>

<br>

<div class="container-fluid">
    <div id="table-header">E-Books List</div>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Book Name</th>
                <th>Description</th>
                <th>Author</th>
                <th>Category</th>
                <th>Book File</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ebooks)): ?>
                <?php foreach($ebooks as $ebook): ?>
                    <tr>
                        <td><?= esc($ebook->id) ?></td>
                        <td>
                            <a href="<?= base_url('admin/ebook_view/'.$ebook->id) ?>" 
                               title="More Description" class="text-info">
                               <?= esc(ucwords($ebook->ebook_name)) ?>
                            </a>
                        </td>
                        <td><?= esc(substr($ebook->description, 0, 100)) ?></td>
                        <td><?= esc($ebook->author) ?></td>
                        <td><?= esc(ucwords($ebook->category)) ?></td>
                        <td>
                            View and Download:<br>
                            <p>
                                <a href="<?= esc($ebook->book_file) ?>" target="_blank" class="text-info">
                                    <?= esc(ucwords($ebook->ebook_name)) ?>
                                </a>
                            </p>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/ebook_view/'.$ebook->id) ?>" 
                               title="View details" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No e-books found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
