<br>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-9 col-sm-12" id="book-detail">
			<div id="table-header">Book Detail</div><br>
			<div><h5>Details of <span class="text-info"><?= strip_tags($book_detail->book_name)?></span></h5></div>
			<div class="row">
			<div class="col-lg-4 col-md-5 col-sm-6" id="book-img"><?php print '<img src = "'.strip_tags($book_detail->book_image).'" alt = "">';?></div>
			<div class="col-lg-8 col-md-7 col-sm-6">
				<div class="book-info">
					<div>Book Name: <?= strip_tags($book_detail->book_name)?></div>
					<div>Author: <i><?= strip_tags($book_detail->author)?></i></div>
					<div>Publisher: <?= strip_tags($book_detail->publisher)?></div>
					<div>Category: <?= strip_tags($book_detail->category)?></div>
					<div class="text-success"><i class="fas fa-check-circle"></i> Stock: Available</div>
					<div>Price: Rs <?= strip_tags($book_detail->price)?></div>
				</div>
			<!--=== Restricted user to buy their own book ===-->
			<?php if(session()->get('id') != $book_detail->userId): ?>

				<div id="addtocart"> <button class="add-to-cart-btn btn btn-outline-success btn-sm" 
                        data-id="<?= $book_detail->id ?>" 
                        data-name="<?= htmlspecialchars($book_detail->book_name) ?>" 
                        data-price="<?= $book_detail->price ?>">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button></div>

				
			<?php else: ?>
				<div><p class="text-danger">You can't buy your books. This book is upload by you.</p></div>
			<?php endif; ?>

			</div>
			</div>

			<br><div class="book-description"><h5>Book description</h5><hr><p><?= nl2br(htmlentities($book_detail->description)) ?></p></div>
			<hr>

		  <?php if(session()->get('logged_in'))
		  {
			view("users/review");
		  }
		  else
		  {
		  	print '<div><p>Please log in to write a review. <a href="'.base_url('users/login').'" class = "btn-login">Login</a></p></div>';
		  }
		  ?>

		</div>
		<div class="col-lg-4 col-md-3">
			
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<?= view("users/review_display"); ?>
		</div>
	</div>
</div>
