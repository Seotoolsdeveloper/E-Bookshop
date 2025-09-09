
<div class="row">
    <div class="col-lg-8">

        <form action="<?= base_url(route_to('user.editprofile', $user_details->id)) ?>" method="post">
            <?= csrf_field() ?>
            <div id="form-header">Edit Your Info and Password</div><br>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your name..." value="<?= set_value('name', $user_details->name) ?>">
                <?php if(isset($validation) && $validation->hasError('name')): ?>
                    <div class="text-danger form-error"><?= $validation->getError('name') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" class="form-control" placeholder="Phone number..." value="<?= set_value('contact', $user_details->contact) ?>">
                <?php if(isset($validation) && $validation->hasError('contact')): ?>
                    <div class="text-danger form-error"><?= $validation->getError('contact') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password...">
                    <?php if(isset($validation) && $validation->hasError('password')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('password') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="repassword">Confirm Password</label>
                    <input type="password" name="repassword" class="form-control" placeholder="Re-type Password...">
                    <?php if(isset($validation) && $validation->hasError('repassword')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('repassword') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Your address..." value="<?= set_value('address', $user_details->address) ?>">
                <?php if(isset($validation) && $validation->hasError('address')): ?>
                    <div class="text-danger form-error"><?= $validation->getError('address') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" placeholder="Your city..." value="<?= set_value('city', $user_details->city) ?>">
                <?php if(isset($validation) && $validation->hasError('city')): ?>
                    <div class="text-danger form-error"><?= $validation->getError('city') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm my-btn">Update</button>
                <button type="reset" class="btn btn-danger btn-sm my-btn-res">Reset</button>
            </div>
        </form>

    </div>
</div>