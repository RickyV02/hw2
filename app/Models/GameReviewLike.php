<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameReviewLike extends Model
{   
    protected $table = 'GAMEREVIEW_LIKES';

    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function review()
    {      
        return $this->belongsTo("App\Models\Account","USERNAME");
    }
}