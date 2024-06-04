<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieReview extends Model
{
    protected $table = 'MOVIE_REVIEWS';

    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function user()
    {      
        return $this->belongsTo("App\Models\Account","USERNAME");
    }

    public function like(){
        return $this->hasMany("App\Models\MovieReviewLike");
    }
}