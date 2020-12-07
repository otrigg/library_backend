<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Author;
use App\Models\Book;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class AuthorController extends Controller
{
    public function allAuthors()
    {
        $authors = Author::all();

        $fractal = new Manager();

        $resource = new Collection($authors, function(Author $author) {
            return [
                'id'            => (int) $author->id,
                'name'          => $author->name,
                'surname'       => $author->surname,
                'country'       => $author->country,
                'books'         => $author->books,
            ];
        });


        return response()->json($fractal->createData($resource)->toArray(), 200);

    }

    public function getAuthor($id)
    {
        $author = Author::find($id);
        if($author) {
            $fractal = new Manager();

            $resource = new Item($author, function(Author $author) {
                return [
                    'id'            => (int) $author->id,
                    'name'          => $author->name,
                    'surname'       => $author->surname,
                    'country'       => $author->country,
                    'books'         => $author->books,
                ];
            });
            return response()->json($fractal->createData($resource)->toArray(), 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function addAuthor(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'surname' => 'required|string',
                'country'   => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()], 400);
        }

        $author = author::create([
            'name'      => $request->name,
            'surname'   => $request->surname,
            'country'   => $request->country,
        ]);

        return response()->json($author, 201);
    }

    public function editAuthor(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'surname' => 'required|string',
                'country'   => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()], 400);
        }

        $author = Author::find($request->id);

        if ($author) {
            $author->update([
                'name'      => $request->name,
                'surname'   => $request->surname,
                'country'   => $request->country,
            ]);

            return response()->json($author, 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function deleteAuthor($id)
    {
        $author = Author::find($id);
        if ($author) {
            $author->delete();
            return response()->json(['message' => 'author deleted'], 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
