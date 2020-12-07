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
Route::get('authors', [AuthorController::class, 'allAuthors']);

Route::middleware(['auth:api', 'admin'])->group(function(){

    Route::post('book', [BookController::class, 'addBook']);
    Route::patch('book/{id}', [BookController::class, 'editBook']);
    Route::delete('book/{id}', [BookController::class, 'deleteBook']);
});


Route::post('login', 'App\Http\Controllers\UserController@login');
Route::get('login', [ 'as' => 'login', 'uses' => 'App\Http\Controllers\UserController@doLogin']);
