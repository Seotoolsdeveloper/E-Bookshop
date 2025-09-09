<?= form_open("users/book_view/".$book_id) ?>
    <div class="form-group row">
        <div class="col-md-10 col-sm-10">
            <?= form_textarea([
                'name'=>'review', 
                'placeholder'=>'Give a review',  
                'value'=>set_value('review'), 
                'class'=>'form-control', 
                'rows'=>'3'
            ]) ?>
            <div class="text-danger form-error"><?= isset($validation) ? $validation->getError('review') : '' ?></div>
        </div>
        <div class="col-md-2 col-sm-2">
            <?= form_submit(['name'=>'submit', 'value'=>'Review', 'class'=>'btn btn-success']) ?>
        </div>
    </div>
<?= form_close() ?>