<?php
/**
 * This controller represents the shelves resource/entity
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http\Controllers;

use Mikro\Models\Book;
use Mikro\Models\Shelf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Shelves extends Controller
{
    public function index()
    {
        return $this->view->file('shelves')->render([
            'shelves' => Shelf::all()
        ])->getResponse();
    }

    public function delete($id)
    {
        $shelf = new Shelf();
        $shelf->where('id', '=', $id);
        $response = $this->container->get('response');
        if($shelf instanceof Shelf && Shelf::destroy($id)) {
            $returnResponse = $response->create(
                JsonResponse::class,
                [],
                Response::HTTP_NO_CONTENT
            );
        }else {
            $returnResponse = $response->create(
                JsonResponse::class,
                [
                    'message' => [
                        'text'  => 'There\'s been an error deleting the shelf with id ' . $id
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $returnResponse;
    }
}