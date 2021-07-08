<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum'], 'namespace' => 'Student', 'prefix' => 'student'], function () {
    Route::get('/welcome', 'PageController@welcome');
    Route::get('/simulations', 'TestController@tests');
    Route::get('/programs', 'PageController@programs');
});
