<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'year',
        'isbn'
    ];

    protected $appends = ['author'];

    public function author()
    {
         return $this->belongsTo('App\Models\Author');
    }

    public function getAuthorAttribute()
    {
        $author = Author::find($this->author_id);
        return $author;
    }
}
