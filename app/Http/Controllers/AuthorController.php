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
            $books = Book::where('author_id', $author->id)->get();
            $result[] = [
                'author'    => $author,
                'books'     => $books
            ];
        }
        return response()->json($result, 200);
    }
}
