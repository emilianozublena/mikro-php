<?php include 'common/header.php' ?>
<div class="container">
    <header><h1>Mikro Php Books</h1></header>
    <nav>
        <a href="<?php echo $this->url('books/create') ?>">Go to Creation</a><br>
        <a href="<?php echo $this->url('shelves') ?>">Go to Shelves</a>
    </nav>
    <div class="row">
        <div class="col-md-6">
            <?php
                if(isset($shelfId)) {
                    $action = $this->url('shelves/' . $shelfId . '/books/search');
                }else {
                    $action = $this->url('books/search');
                }
            ?>
            <form name="form" method="GET" action="<?php echo $action ?>">
                <input type="text" name="term" placeholder="Type in your search" value="<?php echo isset($term) ? $term : '' ?>">
                <button type="submit" class="btn btn-primary">Search!</button>
            </form>
        </div>
    </div>
    <div class="row">
        <?php if(count($books) == 0): ?>
            <div class="col-md-12">
                <h3>No books found <?php echo isset($term) ? 'for search term: "'.$term.'"' : '' ?></h3>
            </div>
        <?php else: ?>
            <?php if(isset($term)): ?>
                <div class="col-md-12">
                    <h3>Books found for search term: "<?php echo $term ?>" (<?php echo count($books); ?>)</h3>
                </div>
            <?php endif; ?>
            <?php foreach($books as $key => $book):
                if(($key+1)%4==0) {
                    ?></div><div class="row"><?php
                }
                ?>
                <div class="col-md-4 book">
                    <div class="card">
                        <div class="card-header"><h3><?php echo $book->name ?></h3></div>
                        <div class="card-body">
                            Book is in shelf: <?php echo $book->shelf->name ?>
                            Author: <?php echo $book->author ?>
                        </div>
                        <div class="card-footer">
                            <a class="view btn btn-primary" href="<?php echo $this->url('books/' . $book->id) ?>">Go to Book</a>
                            <button class="bookDelete btn btn-danger" data-book-id="<?php echo $book->id ?>">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include 'common/footer.php'; ?>
