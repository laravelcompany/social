<?php

use Cornatul\Social\Http\DevToController;
use Cornatul\Social\Http\GithubController;
use Cornatul\Social\Http\GoogleController;
use Cornatul\Social\Http\LinkedInController;
use Cornatul\Social\Http\MediumController;
use Cornatul\Social\Http\SocialController;
use Cornatul\Social\Http\SocialCredentialsController;
use Cornatul\Social\Http\SocialLoginController;
use Cornatul\Social\Http\TumblrController;
use Cornatul\Social\Http\TwitterController;

Route::group(['middleware' => ['web','auth'],'prefix' => 'social', 'as' => 'social.'], static function () {
    //generate the index page
    Route::get('/', [SocialController::class, 'index'])->name('index');
    Route::get('/view/{id}', [SocialController::class, 'view'])->name('view');
    Route::get('/edit/{id}', [SocialController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [SocialController::class, 'update'])->name('update');
    Route::get('/create', [SocialController::class, 'create'])->name('create');
    Route::post('/save', [SocialController::class, 'save'])->name('save');
    Route::get('/destroy/{id}', [SocialController::class, 'destroy'])->name('destroy');

    //custom login
    Route::get('/login/{account}/{provider}', [SocialLoginController::class, 'login'])->name('login');
    Route::get('/login/callback', [SocialLoginController::class, 'callback'])->name('callback');

    //credentials
    Route::get('/credentials/create/{account}', [SocialCredentialsController::class, 'create'])->name('credentials.create');
    Route::get('/credentials/edit/{configurationID}', [SocialCredentialsController::class, 'edit'])->name('credentials.edit');
    Route::post('/credentials/update', [SocialCredentialsController::class, 'update'])->name('credentials.update');
    Route::post('/credentials/create/', [SocialCredentialsController::class, 'save'])->name('credentials.save');


    //Share
    Route::get('/share/{account}', [\Cornatul\Social\Http\ShareController::class, 'share'])->name('share.create');
    Route::post('/share/', [\Cornatul\Social\Http\ShareController::class, 'send'])->name('share.send');
});
