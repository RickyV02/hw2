<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieLike extends Model
{
    protected $table = 'MOVIE_LIKES';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(Account::class, 'USERNAME', 'USERNAME');
    }
}