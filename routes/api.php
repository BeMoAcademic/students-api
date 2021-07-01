<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api->version('v1', function ($api) {
    $api->post('/auth/register', [AuthController::class, 'register']);
    $api->post('/auth/login', [AuthController::class, 'login']);

    $api->group(['middleware' => ['auth:sanctum']], function ($api) {
        $api->get('/me', function(Request $request) {
            return auth()->user();
        });

        $api->post('/auth/logout', [AuthController::class, 'logout']);

        $api->group(['prefix' => 'student'], function ($api) {
            $api->get('/welcome', [\App\Http\Controllers\Student\PageController::class, 'welcome']);
        });
    });
});
