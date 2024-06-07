<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameReview extends Model
{
    protected $table = 'GAME_REVIEWS';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Account::class, 'USERNAME', 'USERNAME');
    }

    public function likes()
    {
        return $this->hasMany(GameReviewLike::class, 'REVIEW_ID', 'ID');
    }
}