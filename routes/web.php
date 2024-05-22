<?php

use Illuminate\Support\Facades\Route;
use Atomjoy\Socialites\Http\Controllers\OauthLogin;

Route::group(['middleware' => ['web']], function () {
	Route::get('/oauth/logout', [OauthLogin::class, 'logout']);
	Route::get('/oauth/google/oauth', [OauthLogin::class, 'oauth']);
	Route::get('/oauth/{driver}/redirect', [OauthLogin::class, 'redirect']);
	Route::get('/oauth/{driver}/callback', [OauthLogin::class, 'callback']);
});
