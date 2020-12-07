<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{
    public function allAuthors()
    {
        $authors = Author::all();
        $result = array();
        foreach ($authors as $author) {
            $result[] = $this->authorWithBooks($author->id);
        }
        return response()->json($result, 200);
    }

    public function getAuthor($id)
    {
        $author = Author::find($id);
        if($author) {
            return response()->json($this->authorWithBooks($id), 200);
        } else {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function authorWithBooks($id)
    {
        $author = Author::find($id);
        $books = Book::where('author_id', $author->id)
            ->get(['id', 'title', 'year', 'isbn']);

        $authorWithBooks = [
            'author'    => $author,
            'books'     => $books
        ];

        return $authorWithBooks;
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
