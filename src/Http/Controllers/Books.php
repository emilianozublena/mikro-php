<?php
/**
 * This controller represents the books resource/entity
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http\Controllers;

use Mikro\Models\Book;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Books extends Controller
{
    public function index()
    {
        return $this->view->file('books')->render([
            'books' => Book::all()
        ])->getResponse();
    }

    public function showBooksByShelf($id)
    {
        $books = new Book();
        return $this->view->file('books')->render([
            'books'   => $books->where('shelf_id', '=', $id)->get(),
            'shelfId' => $id
        ])->getResponse();
    }

    public function show($id)
    {
        $book = new Book();
        return $this->view->file('book')->render([
            'book' => $book->where('id', '=', $id)->first()
        ])->getResponse();
    }

    public function search($id = '')
    {
        $books = new Book();
        $term = urldecode($this->request->get('term'));
        if (is_numeric($id)) {
            $renderData = [
                'books'   => $books->where('shelf_id', '=', $id)->where(function ($query) use ($term) {
                    $query->orWhere('name', 'LIKE', '%' . $term . '%');
                    $query->orWhere('author', 'LIKE', '%' . $term . '%');
                })->get(),
                'shelfId' => $id,
                'term'    => $term
            ];
        } else {
            $renderData = [
                'books' => $books->where(function ($query) use ($term) {
                    $query->orWhere('name', 'LIKE', '%' . $term . '%');
                    $query->orWhere('author', 'LIKE', '%' . $term . '%');
                })->get(),
                'term'  => $term
            ];
        }
        return $this->view->file('books')->render($renderData)->getResponse();
    }

    public function create()
    {
        return $this->view->file('create-book')->render()->getResponse();
    }

    public function store()
    {
        $book = new Book([
            'name'     => $this->request->get('name'),
            'author'   => $this->request->get('author'),
            'shelf_id' => $this->request->get('shelf_id')
        ]);
        $book->save();
        return $this->books();
    }

    public function delete($id)
    {
        $book = new Book();
        $book->where('id', '=', $id);
        $response = $this->container->get('response');
        if ($book instanceof Book && Book::destroy($id)) {
            $returnResponse = $response->create(
                JsonResponse::class,
                [],
                Response::HTTP_NO_CONTENT
            );
        } else {
            $returnResponse = $response->create(
                JsonResponse::class,
                [
                    'message' => [
                        'class' => 'alert-danger',
                        'text'  => 'There\'s been an error deleting the book with id ' . $id
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $returnResponse;
    }

    public function update($id)
    {
        $book = new Book();
        return $this->view->file('update-book')->render([
            'book' => $book->where('id', '=', $id)->first()
        ])->getResponse();
    }

    public function put($id)
    {
        $book = (new Book())->where('id', '=', $id)->first();
        $response = $this->container->get('response');
        if(!isset($book->name)) {
            $returnResponse = $response->create(
                JsonResponse::class,
                [
                    'message' => 'No book with id ' . $id
                ],
                Response::HTTP_NO_CONTENT
            );
        }else {
            $body = json_decode($this->request->getContent());
            $book->fill((array)$body);
            $book->save();
            if ($book->save()) {
                $returnResponse = $response->create(
                    JsonResponse::class,
                    [
                        'message' => 'You\'ve updated successfully this book with id ' . $id
                    ],
                    Response::HTTP_OK
                );
            } else {
                $returnResponse = $response->create(
                    JsonResponse::class,
                    [
                        'message' => 'There\'s been an error updating the book with id ' . $id
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $returnResponse;
    }

    public function patch($id)
    {
        $book = (new Book())->where('id', '=', $id)->first();
        $response = $this->container->get('response');
        if(!isset($book->name)) {
            $returnResponse = $response->create(
                JsonResponse::class,
                [
                    'message' => 'No book with id ' . $id
                ],
                Response::HTTP_NO_CONTENT
            );
        }else {
            $body = json_decode($this->request->getContent());
            foreach ($body as $attribute => $value) {
                $book->{$attribute} = $value;
            }
            $book->save();
            if ($book->save()) {
                $returnResponse = $response->create(
                    JsonResponse::class,
                    [
                        'message' => 'You\'ve updated successfully this book with id ' . $id
                    ],
                    Response::HTTP_OK
                );
            } else {
                $returnResponse = $response->create(
                    JsonResponse::class,
                    [
                        'message' => 'There\'s been an error updating the book with id ' . $id
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $returnResponse;
    }
}