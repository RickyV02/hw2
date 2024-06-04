<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'ACCOUNTS';

    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function token(){
        return $this->hasOne("App\Models\UserToken");
    }
    
    public function movieReviews()
    {   
        return $this->hasMany("App\Models\MovieReview");
    }

    public function gameReviews()
    {     
        return $this->hasMany("App\Models\GameReview");
    }

    public function gameLikes()
    {     
        return $this->hasMany("App\Models\GameLike");
    }

    public function movieLikes()
    {     
        return $this->hasMany("App\Models\MovieLike");
    }
}