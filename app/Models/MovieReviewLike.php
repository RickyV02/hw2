<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieReviewLike extends Model
{
    protected $table = 'MOVIEREVIEW_LIKES';

    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function review()
    {      
        return $this->belongsTo("App\Models\MovieReview");
    }
}