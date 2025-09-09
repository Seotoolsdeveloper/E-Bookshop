<div class="my-form">
    <div id="form-header">Update Category</div>
    
    <?= form_open("admin/ctg_edit/{$ctg_detail->id}") ?>
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Category Name</label>
        <div class="col-sm-6">
            <?= form_input([
                'name'=>'category', 
                'value'=>set_value('category', $ctg_detail->category), 
                'placeholder'=> 'Category name...', 
                'class'=>'form-control'
            ]) ?>
        </div>
        <div class="col-sm-4 text-danger">
            <?= isset($validation) ? $validation->getError('category') : '' ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-6">
            <?= form_textarea([
                'name'=>'description', 
                'value'=>set_value('description', $ctg_detail->description), 
                'placeholder'=>'Category description...',
                'class'=>'form-control',
                'rows'=>'5'
            ]) ?>
        </div>
        <div class="col-sm-4 text-danger">
            <?= isset($validation) ? $validation->getError('description') : '' ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tag</label>
        <div class="col-sm-6">
            <?= form_input([
                'name'=>'tag', 
                'value'=>set_value('tag', $ctg_detail->tag), 
                'placeholder'=> 'Category tag...', 
                'class'=>'form-control'
            ]) ?>
        </div>
        <div class="col-sm-4 text-danger">
            <?= isset($validation) ? $validation->getError('tag') : '' ?>
        </div>
    </div>

    <div class="sub">
        <?= form_submit('submit', 'Update', ['class'=>'btn btn-primary btn-sm my-btn']) ?>
        <?= form_reset('reset', 'Reset', ['class'=>'btn btn-danger btn-sm my-btn-res']) ?>
    </div>

    <?= form_close() ?>
</div>
