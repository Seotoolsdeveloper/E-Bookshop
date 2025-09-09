<div class="container">
    <div class="my-form">
        <div id="form-header">Update book info</div>
        <?= form_open_multipart("admin/book_edit/{$book_detail->id}") ?>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Book Name</label>
            <div class="col-sm-6">
                <?= form_input([
                    'name'=>'book_name', 
                    'placeholder'=> 'Book Name', 
                    'value'=> set_value('book_name', $book_detail->book_name), 
                    'class'=>'form-control'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('book_name') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-6">
                <?= form_textarea([
                    'name'=>'description', 
                    'placeholder'=>'Book Description',  
                    'value'=> set_value('description', $book_detail->description), 
                    'class'=>'form-control', 
                    'rows'=>'5'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('description') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Author</label>
            <div class="col-sm-6">
                <?= form_input([
                    'name'=>'author', 
                    'placeholder'=> 'Author Name', 
                    'value'=> set_value('author', $book_detail->author), 
                    'class'=>'form-control'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('author') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Publisher</label>
            <div class="col-sm-6">
                <?= form_input([
                    'name'=>'publisher', 
                    'placeholder'=> 'Publisher Name', 
                    'value'=> set_value('publisher', $book_detail->publisher), 
                    'class'=>'form-control'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('publisher') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-6">
                <?= form_input([
                    'name'=>'price', 
                    'placeholder'=> 'Book Price', 
                    'value'=> set_value('price', $book_detail->price), 
                    'class'=>'form-control'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('price') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Quantity</label>
            <div class="col-sm-6">
                <?= form_input([
                    'name'=>'quantity', 
                    'placeholder'=> 'How many books you have?', 
                    'value'=> set_value('quantity', $book_detail->quantity), 
                    'class'=>'form-control'
                ]) ?>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('quantity') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Book Image</label>
            <div class="col-sm-6">
                <?= form_upload(['name'=>'userfile', 'class'=>'form-control']) ?>
                <small class="text-secondary">* Upload PNG, JPG format. Image should not be more than 400KB</small>
            </div>
            <div class="col-sm-4 text-danger"></div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-6">
                <select name="categoryId" class="form-control">
                    <option value="">Choose...</option>
                    <?php foreach($category as $ctg): ?>
                        <option value="<?= esc($ctg->id) ?>" <?= set_select('categoryId', $ctg->id, ($book_detail->categoryId == $ctg->id)) ?>>
                            <?= esc($ctg->category) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-4 text-danger">
                <?= isset($validation) ? $validation->getError('categoryId') : '' ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-6">
                <select name="status" class="form-control">
                    <option value="1" <?= set_select('status', '1', ($book_detail->status == 1)) ?>>Published</option>
                    <option value="0" <?= set_select('status', '0', ($book_detail->status == 0)) ?>>Unpublished</option>
                </select>
            </div>
            <div class="col-sm-4 text-danger"></div>
        </div>

        <div class="sub">
            <?= form_submit('submit', 'Update', ['class'=>'btn btn-primary btn-sm my-btn']) ?>
            <?= form_reset('reset', 'Reset', ['class'=>'btn btn-danger btn-sm my-btn-res']) ?>
        </div>

        <?= form_close() ?>
    </div>
</div>
