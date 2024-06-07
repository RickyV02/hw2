<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'ACCOUNTS';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function token()
    {
        return $this->hasOne(UserToken::class, 'USERID', 'ID');
    }

    public function movieReviews()
    {
        return $this->hasMany(MovieReview::class, 'USERNAME', 'USERNAME');
    }

    public function gameReviews()
    {
        return $this->hasMany(GameReview::class, 'USERNAME', 'USERNAME');
    }

    public function gameLikes()
    {
        return $this->hasMany(GameLike::class, 'USERNAME', 'USERNAME');
    }

    public function movieLikes()
    {
        return $this->hasMany(MovieLike::class, 'USERNAME', 'USERNAME');
    }
}