<!--=== Success msg ===-->
<?php if (session()->getFlashdata('success')): ?>
    <div class="success-msg"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<br>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div id="table-header">Order Detail</div><br>
            <h5>Details of Order number <?= esc($order_detail->orderId) ?></h5>

            <table class="table">
                <tr>
                    <th>Ship Name</th>
                    <td><?= esc($order_detail->ship_name) ?></td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td><?= esc($order_detail->contact) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= esc($order_detail->email) ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?= esc($order_detail->address) ?></td>
                </tr>
                <tr>
                    <th>Shipping City</th>
                    <td><?= esc($order_detail->city) ?></td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>Rs <?= esc($order_detail->total_price) ?></td>
                </tr>
                <tr>
                    <th>Payment Type</th>
                    <td>
                        <?= $order_detail->paymentcheck == 1 ? 'Cash on delivery' : 'Bank payment' ?>
                    </td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?= date('h:i a, d-M y', strtotime($order_detail->dateTime)) ?></td>
                </tr>
                <tr>
                    <th>Ordered Books</th>
                    <td><?= esc($order_detail->bookId) ?></td>
                </tr>
                <tr>
                    <th>Book Quantity</th>
                    <td><?= esc($order_detail->quantity) ?></td>
                </tr>
                <tr>
                    <th>Order Status</th>
                    <td>
                        <?= $order_detail->status == 1 
                            ? '<span class="text-success">Accepted</span>' 
                            : '<span class="text-danger">Pending</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th>Order placed by</th>
                    <td><b><?= esc($order_detail->name) ?></b></td>
                </tr>
            </table>

            <div><h5>Action</h5></div>
           

			<form action="<?= base_url('admin/acceptorder/' . $order_detail->orderId) ?>" method="post" style="display:inline;">
				<?= csrf_field() ?>
				<button type="submit" class="btn btn-success btn-sm accept" 
						onclick="return confirm('Are you sure to Acept this order?');">
					<i class="fas fa-check"></i> Accept Order
				</button>
			</form>

            <a href="<?= base_url('admin/delete_order/' . $order_detail->orderId) ?>" 
               class="btn btn-danger btn-sm delete" 
               data-confirm="Are you sure to cancel this order?">
               <i class="fas fa-trash"></i> Cancel Order
            </a>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
