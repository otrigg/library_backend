<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

use App\Models\Author;

class BookController extends Controller
{
    public function allBooks() {
        return Book::all();
    }

    public function getBook($id) {
        $book = Book::find($id);
        if($book) {
            return response()->json($book, 200);
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

        return response()->json($book, 200);
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
            return response()->json($book, 200);
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
