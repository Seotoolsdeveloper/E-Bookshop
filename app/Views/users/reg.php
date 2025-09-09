<!--=== Success msg ===-->
<?php if (session()->getFlashdata('reg_success')): ?>
    <div class="success-msg"><?= session()->getFlashdata('reg_success'); ?></div>
<?php endif; ?>

<div class="login-form-area">
    <div class="container">
        <div class="reg-form">
            <div class="form-header">Registration Form</div>

            <?= form_open('users/registration') ?>

                <div class="form-group">
                    <label for="name">Name</label>
                    <?= form_input(['name'=>'name', 'placeholder'=>'Your name...', 'value'=>set_value('name'), 'class'=>'form-control']) ?>
                    <?php if (isset($validation) && $validation->getError('name')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="contact">Contact</label>
                    <?= form_input(['name'=>'contact', 'placeholder'=>'Phone number...', 'value'=>set_value('contact'), 'class'=>'form-control']) ?>
                    <?php if (isset($validation) && $validation->getError('contact')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('contact') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <?= form_input(['name'=>'email', 'placeholder'=>'Your email...', 'value'=>set_value('email'), 'class'=>'form-control']) ?>
                    <?php if (isset($validation) && $validation->getError('email')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('email') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <?= form_password(['name'=>'password', 'placeholder'=>'Password...','class'=>'form-control']) ?>
                        <?php if (isset($validation) && $validation->getError('password')): ?>
                            <div class="text-danger form-error"><?= $validation->getError('password') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="repassword">Confirm Password</label>
                        <?= form_password(['name'=>'repassword', 'placeholder'=>'Re-type Password...','class'=>'form-control']) ?>
                        <?php if (isset($validation) && $validation->getError('repassword')): ?>
                            <div class="text-danger form-error"><?= $validation->getError('repassword') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <?= form_input(['name'=>'address', 'placeholder'=>'Your address...', 'value'=>set_value('address'), 'class'=>'form-control']) ?>
                    <?php if (isset($validation) && $validation->getError('address')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('address') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <?= form_input(['name'=>'city', 'placeholder'=>'Your city...', 'value'=>set_value('city'), 'class'=>'form-control']) ?>
                    <?php if (isset($validation) && $validation->getError('city')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('city') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <?= form_checkbox('conditionBox', '1', set_checkbox('conditionBox'), ['class'=>'form-check-input']); ?>
                        <label class="form-check-label" for="term">
                            I declare that all the information given above is true and valid. 
                            By clicking sign up, you agree to our 
                            <a href="<?= base_url('users/terms') ?>" target="_blank" class="text-primary">terms and conditions</a>.
                        </label>
                    </div>
                    <?php if (isset($validation) && $validation->getError('conditionBox')): ?>
                        <div class="text-danger form-error"><?= $validation->getError('conditionBox') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <?= form_submit(['name'=>'submit','value'=>'Sign Up', 'class'=>'btn btn-primary my-btn']); ?>
                </div>

                <div class="form-group" id="acc">
                    <span>Already have an account?</span>
                    <a href="<?= base_url('users/login') ?>">Login now</a>
                </div>

            <?= form_close() ?>

            <!--=== Social login ===-->
            <div class="col-lg-12 text-center">
                <span><a href="#" class="btn btn-primary fb"><i class="fab fa-facebook-f"></i> Login with Facebook</a></span>&nbsp;
                <span><a href="#" class="btn btn-outline-danger"><i class="fab fa-google"></i> Login with Google</a></span>
            </div>
        </div>
    </div>
</div>
