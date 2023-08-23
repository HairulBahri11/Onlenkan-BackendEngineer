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

#Kategori
Route::prefix('kategori')->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\KategoriController@index')->name('kategori.index');
    Route::get('/{id}/show', 'App\Http\Controllers\Api\KategoriController@show')->name('kategori.show');
    Route::post('/store', 'App\Http\Controllers\Api\KategoriController@store')->name('kategori.store');
    Route::patch('/{id}/update', 'App\Http\Controllers\Api\KategoriController@update')->name('kategori.update');
    Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\KategoriController@destroy')->name('kategori.destroy');
});

#Produk
Route::prefix('produk')->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\ProdukController@index')->name('produk.index');
    Route::get('/{id}/show', 'App\Http\Controllers\Api\ProdukController@show')->name('produk.show');
    Route::post('/store', 'App\Http\Controllers\Api\ProdukController@store')->name('produk.store');
    Route::patch('/{id}/update', 'App\Http\Controllers\Api\ProdukController@update')->name('produk.update');
    Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\ProdukController@destroy')->name('produk.destroy');
});
