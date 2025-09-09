<!--=== Success msg ===-->
<?php if(session()->getFlashdata('success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<br>

<div class="container-fluid" style="min-height: 500px">
    <div id="table-header">Orders Ready to Deliver</div>
    <div class="table-responsive-sm">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shipping Contact</th>
                    <th>Shipping City</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Delivery Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= esc($order->orderId) ?></td>
                    <td><?= esc(substr($order->ship_name, 0, 100)) ?></td>
                    <td><?= esc($order->email) ?></td>
                    <td><?= esc($order->contact) ?></td>
                    <td><?= esc($order->city) ?></td>
                    <td>Rs <?= esc($order->total_price) ?></td>
                    <td><?= date('h:i a, d-M y', strtotime($order->dateTime)) ?></td>
                    <td>
                        <?= $order->del_status == 1 
                            ? '<span class="text-success">Delivered</span>' 
                            : '<span class="text-danger">Set to deliver</span>' ?>
                    </td>
                    <td>
                        <form method="post" action="<?= base_url("admin/confirm_delivery/{$order->orderId}") ?>" style="display:inline;" onsubmit="return confirm('Are you sure to confirm this order delivery?');">
                          <?= csrf_field() ?> <!-- CI4 CSRF token -->
                          <button type="submit" class="btn btn-success btn-sm">Delivered</button>
                      </form>
                        &nbsp;
                        <a href="<?= base_url("admin/delivery_details/{$order->orderId}") ?>" 
                           class="btn btn-primary btn-sm">Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
