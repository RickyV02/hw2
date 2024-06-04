<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\Account;

class LoginController extends BaseController{
    public function check_login()
    {
        if((Session::has('username') && Session::has('id'))||Cookie::has('remember_me')){
            return redirect('home');
        }else return view('login');
    }

    public function do_login(){
        $error = array();
        if(!empty(Request::post('username')) && !empty(Request::post('password'))){
            $user = Account::where('username', Request::post('username'))->first();
            if(!$user){
                $error[] = "Wrong username";
            } else {
                if(!password_verify(Request::post('password'), $user->PWD)){
                    $error[] = "Wrong password";
                }
            }
        } else {
            $error[] = "Insert username and password";
        }
        if(count($error) == 0){
            Session::put('id', $user->ID);
            Session::put('username', $user->USERNAME);
            if(!empty(Request::post('rememberme'))){
                return redirect('setcookie');
            }else return redirect('home');
        } else {
            return redirect('login')->withInput()->withErrors($error);
        }
    }

    public function signup()
    {
        if((Session::has('username') && Session::has('id'))||Cookie::has('remember_me'))
            return redirect('home');
        else return view('signup');
    }

    public function checkCredentials($type){
        if(empty(Request::get('q'))) {
            return ['exists' => false];
        }
        if(!in_array($type, ['username', 'email'])) {
            return ['exists' => false];
        }
        $user = Account::where($type, Request::get('q'))->first();
        return ['exists' => $user ? true : false];
    }   

    public function do_signup()
    {
        if((Session::has('username') && Session::has('id')) || Cookie::has('remember_me')) {
            return redirect('home');
        }   
        

        if (!empty(Request::post('email')) && !empty(Request::post('username')) && !empty(Request::post('password')) && !empty(Request::post('rpassword')) && !empty(Request::post('terms'))) {
        $errors = [];
        $email = Request::post('email');
        $password = Request::post('password');

        if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', Request::post('username'))) {
            $errors[] = "Username format not valid!";
        } elseif (strlen(Request::post('username')) < 4 || strlen(Request::post('username')) > 16) {
            $errors[] = "Enter username between 4 and 16 characters!";
        } else {
            $username = Request::post('username');
            $existingUsername = Account::where('USERNAME', $username)->exists();
            if ($existingUsername) {
                $errors[] = "Username already taken!";
            }
        }

        if (strlen($password) < 8) {
            $errors[] = "Enter a password with at least 8 characters!";
        }

        if ($password !== Request::post("rpassword")) {
            $errors[] = "Passwords doesn't match!";
        }

        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password) && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one Upper Case letter and a special character!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email format not valid!";
        } else {
            $email = strtolower($email);
            $existingEmail = Account::where('EMAIL', $email)->exists();
            if ($existingEmail) {
                $errors[] = "Email already taken!";
            }
        }

        if (empty($errors)) {
            if (Request::hasFile('avatar')) {
                $avatar = Request::file('avatar');

                $allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
                $fileExtension = strtolower($avatar->getClientOriginalExtension());

                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors[] = "Allowed formats are .png, .jpeg, .jpg, and .gif!";
                } else {
                    if ($avatar->isValid()) {
                        if ($avatar->getSize() <= 5*1024*1024) {
                            $newName = uniqid('', true) . "." . $fileExtension;
                            $avatar->move(public_path() . "/assets", $newName);
                            $avatar = 'assets/' . $newName;
                        } else {
                            $errors[] = "The image must not exceed 5MB!";
                        }
                    } else {
                        $errors[] = "Error loading the file!";
                    }
                }
            } else {
                $errors[] = "No image loaded!";
            }
        }

        if (empty($errors)) {
            $password = bcrypt($password);

            $user = new Account;
            $user->USERNAME = Request::post('username');
            $user->PWD = $password;
            $user->EMAIL = Request::post('email');
            $user->AVATAR=$avatar;
            $user->save();
            
            Session::put('id', $user->ID);
            Session::put('username', $user->USERNAME);
            return redirect('home');
        }
        } elseif (Request::post("username")) {
        $errors[] = "Fill all the fields!";
        }
        return redirect('signup')->withInput()->withErrors($errors);
    }
}