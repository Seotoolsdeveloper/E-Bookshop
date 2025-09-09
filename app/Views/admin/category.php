<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
    <div class="success-msg">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<div class="view-btn">
    <a href="<?= base_url('admin/add_category') ?>">Add new Category <i class="fas fa-plus-circle"></i></a>
</div>
<br>

<div class="container">
    <div id="table-header">Category list</div>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($category)): ?>
                <?php foreach($category as $ctg): ?>
                    <tr>
                        <td><?= esc($ctg->id) ?></td>
                        <td>
                            <a href="<?= base_url('admin/ctg_view/'.$ctg->id) ?>" title="More Description" class="text-info">
                                <?= esc(ucwords($ctg->category)) ?>
                            </a>
                        </td>
                        <td>
                            <p><?= esc(substr($ctg->description, 0, 90)) ?></p>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/ctg_view/'.$ctg->id) ?>" title="View More" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No categories found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
