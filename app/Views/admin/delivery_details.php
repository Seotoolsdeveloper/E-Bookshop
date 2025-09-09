<!--=== Success msg ===-->
<?php if(session()->getFlashdata('success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<!--=== JS code for print ===-->
<script>
function printDiv(eleId){
    var PW = window.open('', '_blank', 'Print content');
    PW.document.write(document.getElementById(eleId).innerHTML);
    PW.document.close();
    PW.focus();
    PW.print();
    PW.close();
}
</script>

<br>
<div class="container" id="print-delivery-details">
    <!--=== CSS links for printing ===-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/style.css'); ?>">

    <div class="row">
        <div class="col-lg-8">
            <div id="table-header">Delivery Details</div><br>
            <h5 class="text-info">Details of Order #<?= esc($order_detail->orderId) ?></h5>
            <table class="table borderless">
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
                    <td><?= $order_detail->paymentcheck == 1 ? 'Cash on delivery' : 'Bank payment' ?></td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?= date('h:i a, d-M y', strtotime($order_detail->dateTime)) ?></td>
                </tr>
                <tr>
                    <th>Order Book IDs</th>
                    <td><?= esc($order_detail->bookId) ?></td>
                </tr>
                <tr>
                    <th>Book Quantity</th>
                    <td><?= esc($order_detail->quantity) ?></td>
                </tr>
                <tr>
                    <th>Delivery Status</th>
                    <td>
                        <?= $order_detail->del_status == 1 
                            ? '<span class="text-success">Delivered</span>' 
                            : '<span class="text-danger">Set to deliver</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th>Order Placed By</th>
                    <td><b><?= esc($order_detail->name) ?></b></td>
                </tr>
            </table>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <div>
        <h5>* Customer has to pay total <span class="text-info">Rs <?= esc($order_detail->total_price) ?></span> including shipping.</h5>
    </div>
</div>

<br>
<div class="container">
    <button onclick="printDiv('print-delivery-details');" class="btn btn-primary btn-sm">
        <i class="fas fa-print"></i> Print
    </button>
    &nbsp;

    <!-- POST form for cancel delivery -->
    <form method="post" action="<?= base_url("admin/cancle_delivery/{$order_detail->orderId}") ?>" style="display:inline;" onsubmit="return confirm('Are you sure to cancel this order delivery?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger btn-sm">Cancel Delivery</button>
    </form>
</div>
