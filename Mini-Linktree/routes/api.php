<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//login
Route::post('/login', 'App\Http\Controllers\LoginController@login');

//group API with auth sanctum middleware
Route::group(['middleware' => ['auth:sanctum']], function () {

    //LINK
    Route::get('/links', 'App\Http\Controllers\LinkController@index');
    Route::post('/links/store', 'App\Http\Controllers\LinkController@store');
    Route::post('/links/orderUpdate/{id}', 'App\Http\Controllers\LinkController@orderUpdate');
    // Route::post('/link/store', 'App\Http\Controllers\LinkController@store');
    Route::delete('/links/destroy/{id}', 'App\Http\Controllers\LinkController@destroy');

    //SOSIAl MEDIA
    Route::get('/sosialmedia', 'App\Http\Controllers\SosialMediaController@index');
    Route::post('/sosialmedia/store', 'App\Http\Controllers\SosialMediaController@store');
    Route::delete('/sosialmedia/destroy/{id}', 'App\Http\Controllers\SosialMediaController@destroy');

    //logout
    Route::post('/logout/{id}', 'App\Http\Controllers\LoginController@logout');
});
