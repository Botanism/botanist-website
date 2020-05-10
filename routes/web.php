<?php

use Illuminate\Support\Facades\Auth;
use \App\Http\Middleware\ServerProperty;
use \App\Http\Middleware\CheckToken;

View::composer('*', function ($view) {
    $view->with('Lang', new \App\Http\Controllers\LangController());
    $view->with('currRoute', Route::currentRouteName());
});

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/doc/{mainDir?}/{subDir?}/{subSubDir?}', 'DocController@main')->name('doc');

Route::post('/accept_cookies', 'UserController@acceptCookies')->name('accept_cookies');

Route::get('/discord_login', 'DiscordController@discordLogin')->name('discord_login');
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@signIn')->name('send_login');

Route::get('/check_2fa', 'UserController@check2FA')->name('check_2fa');
Route::post('/check_2fa_token', 'UserController@check2FAToken')->name('check_2fa_token');
Route::get('/reset2fa', 'UserController@reset2FA')->name('reset_2fa');
Route::post('/overstep2fa', 'UserController@overstep2FA')->name('overstep_2fa');

Route::get('/register', 'UserController@register')->name('register');
Route::post('/register', 'UserController@signUp')->name('send_register');
Route::get('/lost-password', 'UserController@lastPassword')->name('lost_password');

Route::get('/logout', 'UserController@logout')->name('logout');

Route::group(['prefix' => '/dashboard', 'middleware' => ['auth', 'check_token']], function () {
    View::composer('*', function ($view) {
        $view->with('discordUser', (new \App\Http\Controllers\DiscordController)->getDiscordInfos());
    });

    Route::get('/discord_link', 'DiscordController@discordLink')->name('discord_link');

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::post('/', 'UserController@updateProfile')->name('update_profile');
    Route::post('/updatepass', 'UserController@updatePassword')->name('update_password');


    Route::get('/servers', 'UserController@servers')->name('servers');
    Route::post('/servers', 'UserController@addServer')->name('add_server');
    Route::get('/added_server', 'UserController@addedServer')->name('added_server');

    Route::group(['prefix' => '/servers/{id}', 'middleware' => [ServerProperty::class]], function () {
        Route::get('/', 'UserController@editServer')->name('edit_server');
        Route::get('/general', 'UserController@editServerGeneral')->name('server_conf_general');
        Route::get('/moderation', 'UserController@editServerModeration')->name('server_conf_moderation');

        Route::post('/update_conf', 'UserController@updateConfiguration');
    });


    Route::post('/get2fa', 'UserController@get2FACode')->name('get_2fa_code');
    Route::post('/enable2fa', 'UserController@enable2FACode')->name('enable_2fa_code');
    Route::get('/disable2fa', 'UserController@disable2FA')->name('disable_2fa');
    Route::post('/remove2fa', 'UserController@remove2FA')->name('remove_2fa');

    Route::post('/delete_account', 'UserController@deleteAccount');
});


Route::post('/lang/{lang}', 'LangController@changeLang')->name('change_lang')->where('lang', '[a-z]{2}');
