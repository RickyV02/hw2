<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'USER_TOKENS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    public function user(){   
        return $this->belongsTo("App\Models\Account");
    }
}