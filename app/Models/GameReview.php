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
        return $this->belongsTo("App\Models\Account","USERNAME");
    }

    public function like(){
        return $this->hasMany("App\Models\GameReviewLike");
    }
}