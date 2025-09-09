<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
  
    <div class="success-msg"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<br>
<div class="container-fluid">
    <div id="table-header">All Orders</div>
    <div class="table-responsive-sm">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Shipping Contact</th>
                    <th scope="col">Shipping City</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Orders Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order->orderId) ?></td>
                        <td><?= esc(substr(strip_tags($order->ship_name), 0, 100)) ?></td>
                        <td><?= esc($order->email) ?></td>
                        <td><?= esc($order->contact) ?></td>
                        <td><?= esc($order->city) ?></td>
                        <td>Rs <?= esc($order->total_price) ?></td>
                        <td><?= date('h:i a, d-M y', strtotime($order->dateTime)) ?></td>
                        <td>
                            <?php if ($order->status == 1): ?>
                                <span class="text-success">Accepted</span>
                            <?php else: ?>
                                <span class="text-danger">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/order_view/' . $order->orderId) ?>" 
                               title="View Details" class="btn btn-primary btn-sm">
                               Details
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="section-padding">
            <h6>
                <a href="<?= base_url('admin/ready_to_deliver') ?>" class="text-primary">
                    <i class="fas fa-truck"></i> Orders ready to deliver
                </a>
            </h6>
        </div>
    </div>
</div>
