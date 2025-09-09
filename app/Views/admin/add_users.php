<div class="container">
    <div class="my-form">
        <div id="form-header">Add New User</div>

        <?= form_open('admin/add_users') ?>

        <div class="form-group">
            <label>Name</label>
            <?= form_input([
                'name'=>'name', 
                'value'=>set_value('name'), 
                'placeholder'=>'Your name...', 
                'class'=>'form-control'
            ]) ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('name') : '' ?>
            </div>
        </div>

        <div class="form-group">
            <label>Contact</label>
            <?= form_input([
                'name'=>'contact', 
                'value'=>set_value('contact'), 
                'placeholder'=>'Phone number...', 
                'class'=>'form-control'
            ]) ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('contact') : '' ?>
            </div>
        </div>

        <div class="form-group">
            <label>E-mail</label>
            <?= form_input([
                'name'=>'email', 
                'value'=>set_value('email'), 
                'placeholder'=>'Your email...', 
                'class'=>'form-control'
            ]) ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('email') : '' ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Password</label>
                <?= form_password(['name'=>'password', 'placeholder'=>'Password...', 'class'=>'form-control']) ?>
                <div class="text-danger form-error">
                    <?= isset($validation) ? $validation->getError('password') : '' ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Confirm Password</label>
                <?= form_password(['name'=>'repassword', 'placeholder'=>'Re-type Password...', 'class'=>'form-control']) ?>
                <div class="text-danger form-error">
                    <?= isset($validation) ? $validation->getError('repassword') : '' ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Type</label>
            <?php 
            $options = [
                '' => 'Choose...',
                'U' => 'User',
                'A' => 'Admin'
            ]; 
            echo form_dropdown('type', $options, set_value('type', 'A'), ['class' => 'form-control']); 
            ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('type') : '' ?>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <?= form_input([
                'name'=>'address', 
                'value'=>set_value('address'), 
                'placeholder'=>'Your address...', 
                'class'=>'form-control'
            ]) ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('address') : '' ?>
            </div>
        </div>

        <div class="form-group">
            <label>City</label>
            <?= form_input([
                'name'=>'city', 
                'value'=>set_value('city'), 
                'placeholder'=>'Your city...', 
                'class'=>'form-control'
            ]) ?>
            <div class="text-danger form-error">
                <?= isset($validation) ? $validation->getError('city') : '' ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_submit('submit', 'Save', ['class'=>'btn btn-primary btn-sm my-btn']); ?>
            <?= form_reset('reset', 'Reset', ['class'=>'btn btn-danger btn-sm my-btn-res']); ?>
        </div>

        <?= form_close() ?>
    </div>
</div>
