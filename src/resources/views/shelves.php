<?php include 'common/header.php' ?>
<div class="container">
    <header><h1>Mikro Php Shelves</h1></header>
    <nav>
        <a href="<?php echo $this->url('books/create') ?>">Go to Creation</a>
    </nav>
    <div class="row">
        <?php if(count($shelves) == 0): ?>
            <div class="col-md-12">
                <h3>No books found</h3>
            </div>
        <?php else: ?>
            <?php foreach($shelves as $key => $shelf):
                if(($key+1)%4==0) {
                    ?></div><div class="row"><?php
                }
                ?>
                <div class="col-md-4 shelf">
                    <div class="card">
                        <div class="card-header"><h3><?php echo $shelf->name ?></h3></div>
                        <div class="card-footer">
                            <a class="view btn btn-primary" href="<?php echo $this->url('shelves/' . $shelf->id) ?>">Go to Shelf</a>
                            <button class="shelfDelete btn btn-danger" data-shelf-id="<?php echo $shelf->id ?>">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include 'common/footer.php'; ?>