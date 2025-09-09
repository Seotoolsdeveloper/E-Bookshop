<?php
/** @var \CodeIgniter\Session\Session $session */
/** @var \CodeIgniter\Cart\Cart $cart */
?>

<div class="container mt-4">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="row">

        <!-- Shipping Details Form -->
        <div class="col-lg-6">
            <div class="card p-3 mb-3">
                <h5>Shipping Details</h5>

                <?= \Config\Services::validation()->listErrors() ?>

               <?= form_open(base_url(route_to('checkout.place_order')), ['id' => 'checkout-form']) ?>

                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <?= form_input([
                            'name' => 'name',
                            'value' => set_value('name'),
                            'placeholder' => 'Your Name...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= form_input([
                            'name' => 'email',
                            'value' => set_value('email'),
                            'placeholder' => 'Email...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= form_input([
                            'name' => 'contact',
                            'value' => set_value('contact'),
                            'placeholder' => 'Phone Number...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= form_textarea([
                            'name' => 'address',
                            'value' => set_value('address'),
                            'placeholder' => 'Shipping Address...',
                            'class' => 'form-control',
                            'rows' => 4
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= form_input([
                            'name' => 'zipcode',
                            'value' => set_value('zipcode'),
                            'placeholder' => 'Zip Code / Post Code...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= form_input([
                            'name' => 'city',
                            'value' => set_value('city'),
                            'placeholder' => 'City...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <h6>Payment Method</h6>
                        <div class="form-check">
                            <?= form_checkbox([
                                'name' => 'paymentcheck',
                                'value' => 0,
                                'checked' => set_checkbox('paymentcheck', TRUE),
                                'class' => 'form-check-input',
                                'id' => 'paymentcheck'
                            ]) ?>
                            <label for="paymentcheck" class="form-check-label">
                                Cash on Delivery
                            </label>
                        </div>
                    </div>

                    <p>We will contact you within 24 hours. Please read our <a href="<?= route_to('users.terms') ?>" target="_blank">shipping policy</a>. If you agree, place your order now.</p>

                    <div class="mb-3">
                        <?= form_submit('submit', 'Place Order', ['class' => 'btn btn-primary']) ?>
                        <?= form_reset('reset', 'Reset', ['class' => 'btn btn-secondary']) ?>
                    </div>

                <?= form_close() ?>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-6">
            <div class="card p-3 mb-3">
                <h5>Order Summary</h5>

                <table class="table table-bordered">
                    <tr>
                        <th>Total Book Price</th>
                        <td>Rs <?= esc($cart->total()) ?></td>
                    </tr>
                    <tr>
                        <th>Shipping Cost</th>
                        <?php $shipping = 40; ?>
                        <td>Rs <?= $shipping ?></td>
                    </tr>
                    <tr>
                        <th>Total Cost</th>
                        <td>Rs <?= $cart->total() + $shipping ?></td>
                    </tr>
                </table>

                <h6>Your Products</h6>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Book Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart->contents() as $item): ?>
                            <tr>
                                <td><img src="<?= esc($item['book_image']) ?>" alt="" width="50" height="80"></td>
                                <td><?= esc($item['name']) ?></td>
                                <td><?= esc($item['qty']) ?></td>
                                <td>Rs <?= esc($item['price']) ?></td>
                                <td>Rs <?= esc($item['subtotal']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
