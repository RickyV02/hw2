<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLike extends Model
{
    protected $table = 'GAME_LIKES';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(Account::class, 'USERNAME', 'USERNAME');
    }
}