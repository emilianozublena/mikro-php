<?php include 'common/header.php' ?>
<div class="container">
    <header><h1>Mikro Php Books</h1></header>
    <nav>
        <a href="<?php echo $this->url('books/create') ?>">Go to Creation</a><br>
        <a href="<?php echo $this->url('books') ?>">Go to Books</a>
    </nav>
    <div class="row">
        <div class="col-md-4 book">
            <div class="card">
                <div class="card-header"><h3><?php echo $book->name ?></h3></div>
                <div class="card-body">
                    Book is in shelf: <?php echo $book->shelf->name ?>
                    Author: <?php echo $book->author ?>
                </div>
                    <a class="btn btn-primary" href="<?php echo $this->url('books/' . $book->id . '/updat') ?>">Update</a>
                    <button class="deleteBook btn btn-danger" data-book-id="<?php echo $book->id ?>">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'common/footer.php'; ?>