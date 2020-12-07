<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{
    public function allAuthors() {
        $authors = Author::all();
        $result = array();
        foreach ($authors as $author) {
            $result[] = $this->authorWithBooks($author->id);
        }
        return response()->json($result, 200);
    }

    public function getAuthor($id) {

        return response()->json($this->authorWithBooks($id), 200);

    }

    public function authorWithBooks($id) {
        $author = Author::find($id);
        $books = Book::where('author_id', $author->id)
            ->get(['id', 'title', 'year', 'isbn']);

        $authorWithBooks = [
            'author'    => $author,
            'books'     => $books
        ];

        return $authorWithBooks;
    }

    public function addAuthor(Request $request) {
        $author = author::create([
            'name'      => $request->name,
            'surname'   => $request->surname,
            'country'   => $request->country,
        ]);

        return response()->json($author, 200);
    }

    public function editAuthor(Request $request) {
        $author = Author::find($request->id);
        $author->update([
            'name'      => $request->name,
            'surname'   => $request->surname,
            'country'   => $request->country,
        ]);

        return response()->json($author, 200);
    }

    public function deleteAuthor($id) {
        $author = Author::find($id);
        $author->delete();

        return response()->json(['message' => 'author deleted'], 200);
    }
}
