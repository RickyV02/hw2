<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\IndexController@home');
Route::get('home', 'App\Http\Controllers\IndexController@home');
Route::get('index', 'App\Http\Controllers\IndexController@home');
Route::get('setcookie', 'App\Http\Controllers\CookieController@setCookie');
Route::get('login', 'App\Http\Controllers\LoginController@check_login');
Route::post('login', 'App\Http\Controllers\LoginController@do_login');
Route::get('signup', 'App\Http\Controllers\LoginController@signup');
Route::post('signup', 'App\Http\Controllers\LoginController@do_signup');
Route::get('signup/check/{type}', 'App\Http\Controllers\LoginController@checkCredentials');
Route::get('logout', 'App\Http\Controllers\CookieController@deleteCookie');