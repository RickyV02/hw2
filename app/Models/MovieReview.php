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
        return $this->belongsTo(Account::class, 'USERNAME', 'USERNAME');
    }

    public function likes()
    {
        return $this->hasMany(MovieReviewLike::class, 'REVIEW_ID', 'ID');
    }
}