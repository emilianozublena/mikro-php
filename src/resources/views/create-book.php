<?php include 'common/header.php' ?>
<div class="container">
    <header><h1>Mikro Php Books</h1></header>
    <nav>
        <a href="<?php echo $this->url('books') ?>">Go to Books</a><br>
        <a href="<?php echo $this->url('shelves') ?>">Go to Shelves</a>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <form name="form" action="<?php echo $this->url('books') ?>" method="POST" enctype="application/x-www-form-urlencoded">
                <input name="name" type="text" placeholder="Insert book name">
                <input name="author" type="text" placeholder="Insert author's book name">
                <input name="shelf_id" type="text" placeholder="Insert shelves id">
                <button class="create" type="submit">Create new Book</button>
            </form>
        </div>
    </div>
</div>
<?php include 'common/footer.php'; ?>