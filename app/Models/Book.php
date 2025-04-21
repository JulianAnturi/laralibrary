<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['name', 'lended', 'isbn', 'url', 'state', 'quantity', 'price', 'sypnosis'];
}
