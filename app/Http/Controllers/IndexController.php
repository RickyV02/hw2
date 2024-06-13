<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\Account;
use App\Models\UserToken;

class IndexController extends BaseController{

private function getToken(){

    $client_id_twitch = env('CLIENT_ID_TWITCH');
    $client_secret_twitch = env('CLIENT_SECRET_TWITCH');

    $url_token = "https://id.twitch.tv/oauth2/token";
    $data = array(
        'client_id' => $client_id_twitch,
        'client_secret' => $client_secret_twitch,
        'grant_type' => 'client_credentials'
    );
    
    $options_token = array(
        CURLOPT_URL => $url_token,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        )
    );
    
    $curl = curl_init();
    curl_setopt_array($curl, $options_token);
    $token=json_decode(curl_exec($curl), true);
    curl_close($curl);

    return $token;
}
    
public function getRandomSeries(){
        $apikey = env('API_KEY');
        
        $url = 'https://imdb-top-100-movies.p.rapidapi.com/series/';
        $headers = array(
            'x-rapidapi-key: ' . $apikey,
            'x-rapidapi-host: imdb-top-100-movies.p.rapidapi.com',
            'Content-Type: application/json'
            );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
}

public function getRandomMovies() {

    $apikey = env('API_KEY');
    
    $url = 'https://imdb-top-100-movies.p.rapidapi.com/';
    $headers = array(
    'x-rapidapi-key: ' . $apikey,
    'x-rapidapi-host: imdb-top-100-movies.p.rapidapi.com',
    'Content-Type: application/json'
    );
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

public function getRandomGames() {
    
    $client_id_twitch = env('CLIENT_ID_TWITCH');
    $token= $this->getToken();
    
    $url = "https://api.igdb.com/v4/games";
    $data = "fields name,cover.game,cover.image_id;limit 500;where (cover != null) & (release_dates.platform = (1,6));";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Client-ID: ' . $client_id_twitch,
    'Authorization: Bearer ' . $token['access_token']
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
    
}

public function getWeeklyTop10() {
    
    $apikey = env('API_KEY');

    $url = 'https://imdb188.p.rapidapi.com/api/v1/getWeekTop10';
    $headers = array(
        'x-rapidapi-key: ' . $apikey,
        'x-rapidapi-host: imdb188.p.rapidapi.com',
        'Content-Type: application/json'
    );
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

public function home()
{
    $series = json_decode($this->getRandomSeries());
    $games = json_decode($this->getRandomGames());
    $movies = json_decode($this->getRandomMovies());
    $weekly = json_decode($this->getWeeklyTop10());
    
    if ((!Session::has('username') && !Session::has('id')) && !Cookie::has('remember_me')) {
        return view('index')->with([
            'series' => $series,
            'games' => $games,
            'movies' => $movies,
            'weekly' => $weekly
        ]);
    } else {
        if(!Session::has('username') && !Session::has('id') && Cookie::has('remember_me')){
            
            $token = Cookie::get('remember_me');       
            $userToken = UserToken::where('TOKEN', $token)->where('EXPIRES_AT', '>', now())->first();
            if ($userToken) {       
                $userId = $userToken->USERID;
                $account = Account::find($userId);

             if ($account) {
                Session::put('id', $account->ID);
                Session::put('username', $account->USERNAME);
                } else return redirect('index')->withCookie(Cookie::forget('remember_me'));
            } else return redirect('index')->withCookie(Cookie::forget('remember_me'));
        }
        return view('home')->with([
            'series' => $series,
            'games' => $games,
            'movies' => $movies,
            'weekly' => $weekly
        ]);
    }
}

public function about(){
    return view("about");
}

public function terms(){
    return view("terms");
}

public function services(){
    return view("services");
}

}