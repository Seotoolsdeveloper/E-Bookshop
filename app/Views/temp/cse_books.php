<div class="row con-flex">
        <?php foreach($cse_books as $book):?>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div id="single-book">
                <div id="book-image">
                    <?php print '<img src = "'.strip_tags($book->book_image).'" alt = "">';?>
                 <!--=== Restricted user to buy their own book ===-->
                 <?php if(session()->get('id') != $book->userId): ?>   

                   <div id="addto-cart"> <button class="add-to-cart-btn" 
                        data-id="<?= $book->id ?>" 
                        data-name="<?= htmlspecialchars($book->book_name) ?>" 
                        data-price="<?= $book->price ?>">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button></div>
                    
                 <?php endif; ?>
                </div>
                <div class="book-text">
                    <div id="book-name"><?= substr(htmlentities($book->book_name),0,20) ?></div>
                    <div id="author">By <i><?= $book->author ?></i></div>
                    <div id="price">Rs <?= $book->price ?></div>
                    <div id="book-details">
                        <?php print '<a href = "'.base_url().'users/book-view/'.$book->id.'">View details</a>'; ?>
                    </div>
                </div>
            </div>  
        </div>
    <?php endforeach;?>
</div>