<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\UserToken;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{

    public function setCookie() {
        $token = bin2hex(random_bytes(32));
        $expires_at = now()->addDays(30)->format('Y-m-d H:i:s');
        $id = session()->get('id');
        
        $userToken = new UserToken;
        $userToken->USERID = $id;
        $userToken->TOKEN = $token; 
        $userToken->EXPIRES_AT = $expires_at;
        $userToken->save();
        
        $cookie = Cookie::make('remember_me', $token, 30 * 24 * 60);
    
        return redirect('home')->withCookie($cookie);
    }
    

    public function getCookie(){
        return Cookie::get('remember_me');
    }
    
    public function deleteCookie(){
        if (Cookie::has('remember_me')) {
            $token = Cookie::get('remember_me');
            $userToken = UserToken::where('TOKEN', $token)->first();
            
            if ($userToken) {
                $userToken->delete();
            }
        }
        Session::flush();   
        return redirect('index');
    }
}