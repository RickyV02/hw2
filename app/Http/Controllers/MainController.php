<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Models\MovieReview;
use App\Models\GameReview;
use App\Models\GameLike;
use App\Models\MovieLike;
use App\Models\GameReviewLike;
use App\Models\MovieReviewLike;
use App\Models\Account;

class MainController extends BaseController{
    public function show(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $apikey = env('API_KEY');

        $url = "https://imdb8.p.rapidapi.com/auto-complete?q=" . urlencode(Request::post('search'));
        $headers = [
            'x-rapidapi-key: ' . $apikey,
            'x-rapidapi-host: imdb8.p.rapidapi.com',
            'Content-Type: application/json',
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        curl_close($curl);

        return view("search")->with([
            'name' => Request::post("search"),
            'json' => json_decode($response),
        ]);
    }

    public function search(){
        
        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $apikey = env('API_KEY');

        $url = "https://imdb8.p.rapidapi.com/auto-complete?q=" . urlencode(Request::get('name'));
        $headers = [
            'x-rapidapi-key: ' . $apikey,
            'x-rapidapi-host: imdb8.p.rapidapi.com',
            'Content-Type: application/json',
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public function getToken(){

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

    public function result() {

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $qid = Request::get('qid');
        $search = '';
    
        if ($qid === "videoGame") {
            $client_id = env('CLIENT_ID_TWITCH');
    
            $url = "https://api.igdb.com/v4/games";
            $name = Request::get('name');
            $data = 'search "'. $name .'";' .
                'fields id,name,alternative_names.name,genres.name,release_dates.*,cover.image_id,genres.*,summary,storyline,rating,platforms.name,themes.name,rating,collection.*,dlcs.name,expansions.name,franchise.name,involved_companies.company.name;';
    
            $headers = [
                'Accept: application/json',
                'Client-ID: ' . $client_id,
                'Authorization: Bearer ' . $this->getToken()['access_token']
            ];
    
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]);
    
            $response = curl_exec($curl);
            curl_close($curl);
    
            return view('result')->with([
                'json' => json_decode($response),
                'type' => 'videoGame',
            ]);
            
        } elseif (Request::has('id')) {
            $search = Request::get('id');
            $type="";
            if (Str::startsWith($search, 'tt')) {
                $url = "https://imdb146.p.rapidapi.com/v1/title/?id=" . urlencode($search);
                $type="tt";
            } elseif (Str::startsWith($search, 'nm')) {
                $url = "https://imdb146.p.rapidapi.com/v1/name/?id=" . urlencode($search);
                $type="nm";
            }
    
            $headers = [
                'x-rapidapi-key: ' . env('API_KEY'),
                'x-rapidapi-host: imdb146.p.rapidapi.com',
                'Content-Type: application/json',
            ];
    
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]);
    
            $response = curl_exec($curl);
            curl_close($curl);
    
            return view('result')->with([
                'json' => json_decode($response),
                'type' => $type,
            ]);
        }
    }

    public function review(){
        
        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }

        $id = Request::post('id');
        $name = Request::post('name');
        $image = Request::post('image');
        $userid=Session::get("username");
        
        return view('review', compact('id', 'name', 'image','userid'));
    }

    public function saveReview() {

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }

        $username = Session::get('username');
        $id = Request::post('id');
        $name = Request::post('name');
        $cover = Request::post('cover');
        $rating = Request::post('rating');
        $review = Request::post('review');

        if(is_numeric($id)) {
            $reviewModel = new GameReview();
            $reviewModel->GAME_ID = $id;
            $reviewModel->GAME_NAME = $name;
        } else {
            $reviewModel = new MovieReview();
            $reviewModel->FILM_ID = $id;
            $reviewModel->FILM_NAME = $name;
        }
    
        $reviewModel->USERNAME = $username;
        $reviewModel->RECENSIONE = $review;
        $reviewModel->VOTO = $rating;
        $reviewModel->COVER = $cover;
    
        if ($reviewModel->save()) {
            return response()->json(['ok' => true]);
        } else {
            return response()->json(['ok' => false]);
        }
    }
    
    public function getLike(){
        
        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
    
        if(is_numeric($id)){
            $like = GameLike::where('USERNAME', $username)->where('GAME_ID', $id)->first();
        } else {
            $like = MovieLike::where('USERNAME', $username)->where('FILM_ID', $id)->first();
        }
    
        if($like) {
            return response()->json(['ok' => true]);
        } else {
            return response()->json(['ok' => false]);
        }
    }

    public function getReview(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
    
        if(is_numeric($id)){
            $review = GameReview::where('USERNAME', $username)->where('GAME_ID', $id)->first();
        } else {
            $review = MovieReview::where('USERNAME', $username)->where('FILM_ID', $id)->first();
        }
    
        if($review) {
            return response()->json(['ok' => true, 'content' => $review]);
        } else {
            return response()->json(['ok' => false]);
        }
    }

    public function getReviewLikes(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
    
        if(is_numeric($id)){
            $row = GameReview::where('USERNAME', $username)->where('GAME_ID', $id)->first();
        } else {
            $row = MovieReview::where('USERNAME', $username)->where('FILM_ID', $id)->first();
        }
    
        return response()->json($row);
    }

    public function getRandomReviews()
    {

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $id = Request::get('q');
    
        if (is_numeric($id)) {
            $reviews = GameReview::with('user')
                ->where('GAME_ID', $id)
                ->inRandomOrder()
                ->get();
        } else {
            $reviews = MovieReview::with('user')
                ->where('FILM_ID', $id)
                ->inRandomOrder()
                ->get();
        }
    
        if ($reviews->isEmpty()) {
            return response()->json(['norev' => true]);
        }
    
        return response()->json($reviews);
    }
    
    public function getNumReviews(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $id = Request::post('id');

        if (is_numeric($id)) {
            $count = GameReview::where('GAME_ID', $id)->count();
        } else {
            $count = MovieReview::where('FILM_ID', $id)->count();
        }
    
        return response()->json(['info' => $count]);
    }

    public function getNumLikes(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $id = Request::post('id');

        if (is_numeric($id)) {
            $count = GameLike::where('GAME_ID', $id)->count();
        } else {
            $count = MovieLike::where('FILM_ID', $id)->count();
        }
    
        return response()->json(['info' => $count]);
    }

    public function saveLikes(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
        $name = Request::post('name');
        $cover = Request::post('cover');
    
        if (is_numeric($id)) {
            $like = new GameLike();
            $like->USERNAME = $username;
            $like->GAME_ID = $id;
            $like->GAME_NAME = $name;
            $like->COVER = $cover;
        } else {
            $like = new MovieLike();
            $like->USERNAME = $username;
            $like->FILM_ID = $id;
            $like->FILM_NAME = $name;
            $like->COVER = $cover;
        }
    
        if ($like->save()) {
            return response()->json(['ok' => true]);
        } else {
            return response()->json(['ok' => false]);
        }
    }

    public function deleteLikes(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
    
        if (is_numeric($id)) {
            $deleted = GameLike::where('USERNAME', $username)
                ->where('GAME_ID', $id)
                ->delete();
        } else {
            $deleted = MovieLike::where('USERNAME', $username)
                ->where('FILM_ID', $id)
                ->delete();
        }
    
        if ($deleted) {
            return response()->json(['ok' => false]);
        } else {
            return response()->json(['ok' => true]);
        }
    }

    public function getMyReviewLikes(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
    
        if (is_numeric($id)) {
            $likes = GameReviewLike::where('USERNAME', $username)
                ->get();
        } else {
            $likes = MovieReviewLike::where('USERNAME', $username)
                ->get();
        }
    
        if ($likes->isEmpty()) {
            return response()->json(['nolike' => true]);
        } else {
            return response()->json($likes);
        }
    }

    public function addReviewLike(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
        $referenceid = Request::post('reference_id');
    
        if (is_numeric($referenceid)) {
            $like = new GameReviewLike();
            $like->REVIEW_ID = $id;
            $like->USERNAME = $username;
            if ($like->save()) {
                $review = GameReview::where('ID', $id)->first();
                $review->NUMLIKE += 1;
                $review->save();
                return response()->json(['ok' => 'insert', 'id' => $id]);
            }
        } else {
            $like = new MovieReviewLike();
            $like->REVIEW_ID = $id;
            $like->USERNAME = $username;
            if ($like->save()) {
                $review = MovieReview::where('ID', $id)->first();
                $review->NUMLIKE += 1;
                $review->save();
                return response()->json(['ok' => 'insert', 'id' => $id]);
            }
        }
    
        return response()->json(['ok' => false]);
    }

    public function deleteReviewLike(){

        if ((!Session::has('username') && !Session::has('id'))) {
            return redirect('index');
        }
        
        $username = Session::get('username');
        $id = Request::post('id');
        $referenceid = Request::post('reference_id');
    
        if (is_numeric($referenceid)) {
            $like = GameReviewLike::where('REVIEW_ID', $id)
                ->where('USERNAME', $username)
                ->delete();
            if ($like) {
                $review = GameReview::where('ID', $id)->first();
                $review->NUMLIKE -= 1;
                $review->save();
                return response()->json(['ok' => 'delete', 'id' => $id, 'referenceid' => $referenceid]);
            }
        } else {
            $like = MovieReviewLike::where('REVIEW_ID', $id)
                ->where('USERNAME', $username)
                ->delete();
            if ($like) {
                $review = MovieReview::where('ID', $id)->first();
                $review->NUMLIKE -= 1;
                $review->save();
                return response()->json(['ok' => 'delete', 'id' => $id, 'referenceid' => $referenceid]);
            }
        }
    
        return response()->json(['ok' => false]);
    }

    public function profile() {
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }
    
        $q = Request::get('q');
        $user = Session::get('username');

        $movieLikes = MovieLike::where('USERNAME', $q)->get();
        $gameLikes = GameLike::where('USERNAME', $q)->get();
    
        return view('profile', ['q' => $q, 
        'user' => $user, 
        'movieLikes' => $movieLikes, 
        'gameLikes' => $gameLikes]
        );
    }

    public function getMyReviews(){
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }

        $q = Request::get('q');
        $movieReviews = MovieReview::with("user")->where('USERNAME', $q)->get();
        $gameReviews = GameReview::with("user")->where('USERNAME', $q)->get();
        $reviews = $movieReviews->merge($gameReviews);
   
        if ($reviews->isEmpty()) {
        return response()->json(['norev' => true]);
        }

        return response()->json($reviews);
    }

    public function getMyLikedReviews(){
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }
 
        $q = Request::get('q');
        $movieReviews = MovieReviewLike::with("review")
            ->with("account")
            ->where('USERNAME', $q)
            ->get();
        $gameReviews = GameReviewLike::with("review")
        ->with("account")
            ->where('USERNAME', $q)
            ->get();
    
        $likedReviews = $movieReviews->merge($gameReviews);
        if ($likedReviews->isEmpty()) {
            return response()->json(['norev' => true]);
        }
    
        return response()->json($likedReviews);
    }
    public function getUserAvatar(){
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }

        $q = Request::get('q');
        $user = Account::where('USERNAME', $q)->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['nouser' => true]);
        }
    }

    public function deleteReview(){
        
    if (!Session::has('username') && !Session::has('id')) {
        return redirect('login');
    }

    $userid = Session::get('username');
    $id = Request::get('id');
    $referenceid = Request::get('reference_id');

    if (is_numeric($referenceid)) {
        $gameReview = GameReview::where('ID', $id)->where('USERNAME', $userid)->first();
        if ($gameReview) {
            GameReviewLike::where('REVIEW_ID', $id)->delete();
            $gameReview->delete();
            return response()->json(['ok' => 'delete', 'id' => $id, 'referenceid' => $referenceid]);
        }
    } else {
        $movieReview = MovieReview::where('ID', $id)->where('USERNAME', $userid)->first();
        if ($movieReview) {
            MovieReviewLike::where('REVIEW_ID', $id)->delete();
            $movieReview->delete();
            return response()->json(['ok' => 'delete', 'id' => $id, 'referenceid' => $referenceid]);
        }
    }

    return response()->json(['ok' => false]);
    }

    public function changeSettings(){

        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }
        
        $errors = [];
        $updates = [];

        $user = Account::find(Session::get("id"));

        if (Request::has('email')) {
            $email = Request::post('email');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email format not valid!";
            } else {
                $existingEmail = Account::where('EMAIL', $email)->first();
                if ($existingEmail) {
                    $errors[] = "Email already taken!";
                } else {
                    $user->EMAIL = $email;
                    if ($user->save()) {
                        $updates["email"] = "Email changed successfully!";
                    } else {
                        $errors[] = "Error connecting to the Database";
                    }
                }
            }
        }

        if (Request::has('password')) {
            $password = Request::post('password');
            if (strlen($password) < 8) {
                $errors[] = "Enter a password with at least 8 characters!";
            } else if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password) && !preg_match('/[A-Z]/', $password)) {
                $errors[] = "Password must contain at least one Upper Case letter and a special character!";
            } else {
                $user->PWD = bcrypt($password);
                if ($user->save()) {
                    $updates["password"] = "Password changed successfully!";
                } else {
                    $errors[] = "Error connecting to the Database";
                }
            }
        }

        if (Request::hasFile('file')) {
            $file = Request::file('file');
            if ($file->isValid()) {
                $allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
                $fileExtension = strtolower($file->getClientOriginalExtension());
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors[] = "Allowed formats are .png, .jpeg, .jpg, and .gif!";
                } else {
                    if ($file->getSize() <= 5 * 1024 * 1024) {
                        $newName = uniqid('', true) . "." . $fileExtension;
                        $file->move(public_path() . "/assets", $newName);
                        $user->AVATAR = 'assets/' . $newName;
                        if (!$user->save()) {
                            $errors[] = "Error connecting to the Database";
                        } else {
                            $updates["avatar"] = "Avatar changed successfully!";
                        }
                    } else {
                        $errors[] = "The image must not exceed 5MB!";
                    }
                }
            } else {
                $errors[] = "Error loading the file!";
            }
        }

        if (empty($errors)) {
            echo json_encode(["UpdateLog" => $updates, "UpdateError" => $errors]);
        } else {
            echo json_encode(["UpdateLog" => $updates, "UpdateError" => $errors]);
        }
            
    }

    public function countUserLikes() {
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }
    
        $userId = Session::get('username');
    
        $movieLikesCount = MovieLike::where('USERNAME', $userId)->count();
        $gameLikesCount = GameLike::where('USERNAME', $userId)->count();
    
        $totalLikes = $movieLikesCount + $gameLikesCount;
    
        return response()->json(['likes' => $totalLikes]);
    }

    public function countUserReviews() {
        if (!Session::has('username') && !Session::has('id')) {
            return redirect('login');
        }
    
        $userId = Session::get('username');
    
        $movieReviewsCount = MovieReview::where('USERNAME', $userId)->count();
        $gameReviewsCount = GameReview::where('USERNAME', $userId)->count();
    
        $totalReviews = $movieReviewsCount + $gameReviewsCount;
    
        return response()->json(['rev' => $totalReviews]);
    }

}