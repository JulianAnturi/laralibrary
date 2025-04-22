<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{
    protected $table = 'lends';
    protected $fillable = ['date_lend', 'date_deliver', 'user_id', 'book_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

