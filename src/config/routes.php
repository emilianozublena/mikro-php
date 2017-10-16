<?php
/**
 * This file defines all available routes through Kernel
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

//roots for shelves
$kernel->get('', [
    '\Mikro\Http\Controllers\Shelves',
    'index'
]);
$kernel->get('shelves', [
    '\Mikro\Http\Controllers\Shelves',
    'index'
]);
$kernel->get('shelves/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'showBooksByShelf'
]);
$kernel->delete('shelves/{id:\d+}', [
    '\Mikro\Http\Controllers\Shelves',
    'delete'
]);
$kernel->get('shelves/{id:\d+}/books/search', [
    '\Mikro\Http\Controllers\Books',
    'search'
]);

//routes for books
$kernel->get('books', [
    '\Mikro\Http\Controllers\Books',
    'index'
]);
$kernel->get('books/search', [
    '\Mikro\Http\Controllers\Books',
    'search'
]);
$kernel->get('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'show'
]);
$kernel->delete('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'delete'
]);
$kernel->get('books/create', [
    '\Mikro\Http\Controllers\Books',
    'create'
]);
$kernel->post('books', [
    '\Mikro\Http\Controllers\Books',
    'store'
]);
$kernel->get('books/{id:\d+}/update', [
    '\Mikro\Http\Controllers\Books',
    'update'
]);
$kernel->put('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'put'
]);
$kernel->patch('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'patch'
]);