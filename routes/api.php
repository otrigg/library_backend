<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('books', [BookController::class, 'allBooks']);
Route::get('book/{id}', [BookController::class, 'getBook']);

Route::get('authors', [AuthorController::class, 'allAuthors']);
Route::get('author/{id}', [AuthorController::class, 'getAuthor']);

Route::middleware(['auth:api', 'admin'])->group(function(){

    Route::post('book', [BookController::class, 'addBook']);
    Route::patch('book/{id}', [BookController::class, 'editBook']);
    Route::delete('book/{id}', [BookController::class, 'deleteBook']);

    Route::post('author', [AuthorController::class, 'addAuthor']);
    Route::patch('author/{id}', [AuthorController::class, 'editAuthor']);
    Route::delete('author/{id}', [AuthorController::class, 'deleteAuthor']);

});


Route::post('login', 'App\Http\Controllers\UserController@login');
Route::get('login', [ 'as' => 'login', 'uses' => 'App\Http\Controllers\UserController@doLogin']);
