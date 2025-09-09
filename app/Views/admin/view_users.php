<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
    <div class="success-msg">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<div class="view-btn">
    <a href="<?= base_url('admin/add_users') ?>">Add new user <i class="fas fa-plus-circle"></i></a>
</div>
<br>

<div class="container">
    <div id="table-header">All Users List</div>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Type</th>
                <th>Address</th>
                <th>City</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users_data)): ?>
                <?php foreach($users_data as $udata): ?>
                    <tr>
                        <td><?= esc($udata->id) ?></td>
                        <td class="text-info"><?= esc($udata->name) ?></td>
                        <td><?= esc($udata->contact) ?></td>
                        <td><?= esc($udata->email) ?></td>
                        <td><?= esc($udata->type) ?></td>
                        <td><?= esc(substr($udata->address, 0, 80)) ?></td>
                        <td><?= esc($udata->city) ?></td>
                        <td>
                            <a href="<?= base_url('admin/user_delete/'.$udata->id) ?>" 
                               class="btn btn-outline-danger btn-sm delete" 
                               data-confirm="Are you sure to delete this User?">
                               <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
