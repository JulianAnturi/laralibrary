<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Lend extends Model
{
    protected $table = 'lends';
    protected $fillable = ['date_lend', 'date_deliver', 'user_id', 'book_id'];


    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
