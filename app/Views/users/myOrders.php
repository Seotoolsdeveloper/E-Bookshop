<?php $userModel = model('UserModel'); ?>

<?php if (!empty($orders)): ?>
    <div id="table-header">My Orders</div>
    <div class="table-responsive-sm table-responsive-md">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shipping Contact</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?= esc($order->orderId) ?></td>
                        <td><?= esc(substr(strip_tags($order->ship_name), 0, 100)) ?></td>
                        <td><?= esc($order->email) ?></td>
                        <td><?= esc($order->contact) ?></td>
                        <td>Rs <?= esc($order->total_price) ?></td>
                        <td><?= date('h:i a, d-M y', strtotime($order->dateTime)) ?></td>
                        <td>
                            <?= $order->status == 1 
                                ? '<span class="text-success">Accepted</span>' 
                                : '<span class="text-danger">Pending</span>' 
                            ?>
                        </td>
                        <td>
                            <a href="<?= base_url(route_to('user_home.order_view', $order->orderId)) ?>" 
                               title="View Details" class="btn btn-info btn-sm">
                               Details
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="error-msg">
        You did not order any book yet. You can order books from here: 
        <a href="<?= base_url(route_to('all_books'))?>" class="text-primary"><b>Order your books</b></a> now.
    </div>
<?php endif; ?>
