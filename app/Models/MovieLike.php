<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieLike extends Model
{
    protected $table = 'MOVIE_LIKES';

    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function user()
    {   
        return $this->belongsTo("App\Models\Account");
    }
}