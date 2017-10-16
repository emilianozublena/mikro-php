<?php
/**
 * This is just a simple migration for setting up our database tables.
 * This migration only works with Eloquent ORM, if you choose to use a different ORM(or a plain custom PDO implementation),
 * you can create your own migrations file ;)
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint;

//first we load the container
$container = (require '../config/services.php');
$orm = $container->get('database');
//and init it
$orm->init();

//after that, we drop every table, because for this simple migration we want the whole DB to be migrated and seeded
$pdoQuery = $orm->getCapsuleObject()->schema()->getConnection()->getPdo();
$tables = $pdoQuery->query("SHOW FULL TABLES")->fetchAll();
$dbConfig = $orm->getConfigForActiveDriver();
if (count($tables) > 0) {
    $dropListing = [];
    foreach ($tables as $table) {
        $dropListing[] = $table['Tables_in_' . $dbConfig['database']];
    }
    foreach ($dropListing as $dropTable) {
        $pdoQuery->query('DROP TABLE ' . $dropTable);
    }
}

//now we create the tables
Capsule::schema()->create('books', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('shelf_id', false, true)->index();
    $table->string('name');
    $table->string('author');
    $table->timestamps();
});

Capsule::schema()->create('shelves', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->timestamps();
});

//and then we populate it
$shelf = new \Mikro\Models\Shelf([
    'name' => 'My First Shelf'
]);
$shelf->save();
$shelf2 = new \Mikro\Models\Shelf([
    'name' => 'My Second Shelf'
]);
$shelf2->save();
$book = new \Mikro\Models\Book([
    'name'     => 'Don Quixote',
    'author'   => 'Miguel de Cervantes',
    'shelf_id' => $shelf->id
]);
$book->save();
$book1 = new \Mikro\Models\Book([
    'name'     => 'In Search of Lost Time',
    'author'   => 'Marcel Proust',
    'shelf_id' => $shelf->id
]);
$book1->save();
$book2 = new \Mikro\Models\Book([
    'name'     => 'The Odyssey',
    'author'   => 'Homer',
    'shelf_id' => $shelf->id
]);
$book2->save();
$book3 = new \Mikro\Models\Book([
    'name'     => 'Ulysses',
    'author'   => 'James Joyce',
    'shelf_id' => $shelf2->id
]);
$book3->save();
$book4 = new \Mikro\Models\Book([
    'name'     => 'War and Peace',
    'author'   => 'Leo Tolstoy',
    'shelf_id' => $shelf2->id
]);
$book4->save();


