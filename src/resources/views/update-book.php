<?php include 'common/header.php' ?>
<div class="container">
    <header><h1>Mikro Php Books</h1></header>
    <nav>
        <a href="<?php echo $this->url('books') ?>">Go to Books</a><br>
        <a href="<?php echo $this->url('shelves') ?>">Go to Shelves</a>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <form name="form" id="updateBookForm" action="<?php echo $this->url('books/' . $book->id) ?>" method="POST" enctype="application/x-www-form-urlencoded">
                <input name="name" type="text" placeholder="Insert book name" value="<?php echo $book->name ?>">
                <input name="author" type="text" placeholder="Insert author's book name" value="<?php echo $book->author ?>">
                <input name="shelf_id" type="text" placeholder="Insert shelves id" value="<?php echo $book->shelf->id ?>">
                <input type="hidden" name="orig_name" value="<?php echo $book->name ?>">
                <input type="hidden" name="orig_author" value="<?php echo $book->author ?>">
                <input type="hidden" name="orig_shelf_id" value="<?php echo $book->shelf->id ?>">
                <button class="create" type="submit">Update Book</button>
            </form>
        </div>
    </div>
</div>
<?php include 'common/footer.php'; ?>