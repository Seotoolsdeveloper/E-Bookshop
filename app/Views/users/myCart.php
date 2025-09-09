<div id="table-header"><i class="fas fa-shopping-cart"></i> Shopping Cart</div>

<?php if(session()->getFlashdata('cart_error')): ?>
    <div class="error-msg"><?= session()->getFlashdata('cart_error') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('cart_success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('cart_success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('remove_cart')): ?>
    <div class="error-msg"><?= session()->getFlashdata('remove_cart') ?></div>
<?php endif; ?>

<?php if($cart && $cart->contents()): ?>
    <form action="<?= base_url('cart/update') ?>" method="post">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Image</th>
                    <th>Book Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach($cart->contents() as $books): ?>
                    <tr>
                        <td style="display:none;">
                            <input type="hidden" name="<?= $i ?>[rowid]" value="<?= $books['rowid'] ?>">
                        </td>
                        <td>
                            <?php if (!empty($books['book_image'])): ?>
                                <img src="<?= esc($books['book_image']) ?>" alt="<?= esc($books['name']) ?>" width="50" height="80">
                            <?php else: ?>
                                <img src="<?= base_url('tool/img/default-book.png') ?>" alt="No image" width="50" height="80">
                            <?php endif; ?>
                        </td>
                        <td><?= $books['name'] ?></td>
                        <td>
                            <input type="number" name="<?= $i ?>[qty]" value="<?= $books['qty'] ?>" class="form-control qty">
                        </td>
                        <td>Rs <?= $books['price'] ?></td>
                        <td>Rs <?= $books['subtotal'] ?></td>
                        <td>
                           
                            <button type="button" class="btn btn-outline-danger btn-sm delete-cart-item" data-rowid="<?= $books['rowid'] ?>" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3"></td>
                    <td><b>Shipping Fee</b></td>
                    <td>Rs <?= $cart->total_items() ? 40 : 0 ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td>
                        <a href="<?= base_url('users/all-books') ?>" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </td>
                    <td colspan="1"></td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Update cart</button>
                    </td>
                    <td><b>Total</b></td>
                    <td>Rs <?= $cart->total_items() ? $cart->total() + 40 : 0 ?></td>
                    <td>
                        <?php if($cart->total_items()): ?>
                            <?php if(session()->get('logged_in')): ?>
                                <a href="<?= base_url('checkout') ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-check"></i> Checkout
                                </a>
                            <?php else: ?>
                                <div class="text-danger">
                                    *Please log in to checkout <a href="<?= base_url('users/login') ?>" class="btn-login">Login</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
<?php else: ?>
    <div><h5>Your cart is empty, or you have not added any products to cart.</h5></div>
    <div>
        <a href="<?= base_url('users/all_books') ?>" class="btn btn-outline-success btn-sm">
            <i class="fas fa-shopping-bag"></i> Continue Shopping
        </a>
    </div>
<?php endif; ?>
