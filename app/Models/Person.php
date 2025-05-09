<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;
    protected $table = 'people';
    protected $fillable = ['name', 'lended', 'email', 'address', 'identification', 'phone'];

    public function lends()
    {
        return $this->hasMany(Lend::class, 'user_id');
    }
}
