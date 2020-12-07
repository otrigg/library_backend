<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

use App\Models\Author;

class BookController extends Controller
{
    public function allBooks() {
        $fractal = new Manager();

        $books = Book::all();

        $resource = new Collection($books, function(Book $book) {
            return [
                'id'        => (int) $book->id,
                'title'     => $book->title,
                'isbn'      => (int) $book->isbn,
                'year'      => (int) $book->year,
                'author_id' => (int) $book->author_id,
            ];
        });


        return response()->json($fractal->createData($resource)->toArray(), 200);
    }

    public function getBook($id) {
        $fractal = new Manager();

        $book = Book::find($id);
        if($book) {
            $fractal = new Manager();

            $resource = new Item($book, function(Book $book) {
                return [
                    'id'        => (int) $book->id,
                    'title'     => $book->title,
                    'isbn'      => (int) $book->isbn,
                    'year'      => (int) $book->year,
                    'author'    => $book->author,
                ];
            });

            return response()->json($fractal->createData($resource)->toArray(), 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function addBook(Request $request) {

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'isbn' => 'required|string',
                'year'   => 'required|string',
                'author_id' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()], 400);
        }

        $book = Book::create([
            'title'     => $request->title,
            'isbn'      => $request->isbn,
            'year'      => $request->year,
            'author_id' => $request->author_id
        ]);

        $fractal = new Manager();

        $resource = new Item($book, function(Book $book) {
            return [
                'id'        => (int) $book->id,
                'title'     => $book->title,
                'isbn'      => (int) $book->isbn,
                'year'      => (int) $book->year,
                'author'    => $book->author,
            ];
        });

        return response()->json($fractal->createData($resource)->toArray(), 201);
    }

    public function editBook(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'isbn' => 'required|string',
                'year'   => 'required|string',
                'author_id' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()], 400);
        }

        $book = Book::find($request->id);

        if($book) {
            $book->update([
                'title'     => $request->title,
                'year'      => $request->year,
                'isbn'      => $request->isbn,
                'author_id' => $request->author_id
            ]);

            $fractal = new Manager();

            $resource = new Item($book, function(Book $book) {
                return [
                    'id'        => (int) $book->id,
                    'title'     => $book->title,
                    'isbn'      => (int) $book->isbn,
                    'year'      => (int) $book->year,
                    'author'    => $book->author,
                ];
            });

            return response()->json($fractal->createData($resource)->toArray(), 200);

        } else {
            return response()->json(['message' => 'not found'], 404);
        }

    }

    public function deleteBook($id) {
        $book = Book::find($id);

        if($book) {
            $book->delete();
            return response()->json(['message' => 'book deleted'], 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
