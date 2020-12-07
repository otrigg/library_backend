<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function allBooks() {
        return Book::all();
    }

    public function getBook($id) {
        $book = Book::find($id);

        return response()->json($book, 200);
    }

    public function addBook(Request $request) {
        $book = Book::create([
            'title'     => $request->title,
            'isbn'      => $request->isbn,
            'year'      => $request->year,
            'author_id' => $request->author_id
        ]);

        return response()->json($book, 200);
    }

    public function editBook(Request $request) {
        $book = Book::find($request->id);
        $book->update([
            'title'     => $request->title,
            'year'      => $request->year,
            'isbn'      => $request->isbn,
            'author_id' => $request->author_id
        ]);

        return response()->json($book, 200);
    }

    public function deleteBook($id) {
        $book = Book::find($id);
        $book->delete();

        return response()->json(['message' => 'book deleted'], 200);
    }
}
