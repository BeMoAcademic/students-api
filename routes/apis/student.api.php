<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum'], 'namespace' => 'Student'], function () {
    Route::get('/welcome', 'PageController@welcome');
    Route::get('/simulations', 'PageController@tests');
});
