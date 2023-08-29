<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Contracts\Role;
// use Spatie\Permission\Models\Permission;

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

#login
Route::post('/login', 'App\Http\Controllers\Api\LoginController@login')->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('kategori')->group(function () {
        Route::get('/', 'App\Http\Controllers\Api\KategoriController@index')->name('kategori.index')->middleware('permission:lihat-kategori');
        Route::get('/{id}/show', 'App\Http\Controllers\Api\KategoriController@show')->name('kategori.show')->middleware('permission:lihat-kategori');
        Route::post('/store', 'App\Http\Controllers\Api\KategoriController@store')->name('kategori.store')->middleware('permission:tambah-kategori');
        Route::post('/{id}/update', 'App\Http\Controllers\Api\KategoriController@update')->name('kategori.update')->middleware('permission:edit-kategori');
        Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\KategoriController@destroy')->name('kategori.destroy')->middleware('permission:hapus-kategori');
    });

    Route::prefix('produk')->group(function () {
        Route::get('/', 'App\Http\Controllers\Api\ProdukController@index')->name('produk.index')->middleware('permission:lihat-produk');
        Route::get('/{id}/show', 'App\Http\Controllers\Api\ProdukController@show')->name('produk.show')->middleware('permission:lihat-produk');
        Route::post('/store', 'App\Http\Controllers\Api\ProdukController@store')->name('produk.store')->middleware('permission:tambah-produk');
        Route::post('/{id}/update', 'App\Http\Controllers\Api\ProdukController@update')->name('produk.update')->middleware('permission:edit-produk');
        Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\ProdukController@destroy')->name('produk.destroy')->middleware('permission:hapus-produk');
    });
});
// #Kategori
// Route::prefix('kategori')->group(function () {
//     Route::get('/', 'App\Http\Controllers\Api\KategoriController@index')->name('kategori.index');
//     Route::get('/{id}/show', 'App\Http\Controllers\Api\KategoriController@show')->name('kategori.show');
//     Route::post('/store', 'App\Http\Controllers\Api\KategoriController@store')->name('kategori.store');
//     Route::patch('/{id}/update', 'App\Http\Controllers\Api\KategoriController@update')->name('kategori.update');
//     Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\KategoriController@destroy')->name('kategori.destroy');
// });

// #Produk
// Route::prefix('produk')->group(function () {
//     Route::get('/', 'App\Http\Controllers\Api\ProdukController@index')->name('produk.index');
//     Route::get('/{id}/show', 'App\Http\Controllers\Api\ProdukController@show')->name('produk.show');
//     Route::post('/store', 'App\Http\Controllers\Api\ProdukController@store')->name('produk.store');
//     Route::post('/{id}/update', 'App\Http\Controllers\Api\ProdukController@update')->name('produk.update');
//     Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\ProdukController@destroy')->name('produk.destroy');
// });



// Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
//     Route::prefix('kategori')->group(function () {
//         Route::get('/', 'App\Http\Controllers\Api\KategoriController@index')->name('kategori.index')->middleware('permission:lihat-kategori');
//         Route::get('/{id}/show', 'App\Http\Controllers\Api\KategoriController@show')->name('kategori.show')->middleware('permission:lihat-kategori');
//         Route::post('/store', 'App\Http\Controllers\Api\KategoriController@store')->name('kategori.store')->middleware('permission:tambah-kategori');
//         Route::patch('/{id}/update', 'App\Http\Controllers\Api\KategoriController@update')->name('kategori.update')->middleware('permission:edit-kategori');
//         Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\KategoriController@destroy')->name('kategori.destroy')->middleware('permission:hapus-kategori');
//     });
//     Route::prefix('produk')->group(function () {
//         Route::get('/', 'App\Http\Controllers\Api\ProdukController@index')->name('produk.index')->middleware('permission:lihat-produk');
//     });
// });



//middleware untuk role penjual
// Route::group(['middleware' => ['auth:sanctum', 'role:penjual']], function () {
//     Route::prefix('kategori')->group(function () {
//         Route::get('/', 'App\Http\Controllers\Api\KategoriController@index')->name('kategori.index');
//     });
//     Route::prefix('produk')->group(function () {
//         Route::get('/', 'App\Http\Controllers\Api\ProdukController@index')->name('produk.index');
//         Route::get('/{id}/show', 'App\Http\Controllers\Api\ProdukController@show')->name('produk.show');
//         Route::post('/store', 'App\Http\Controllers\Api\ProdukController@store')->name('produk.store');
//         Route::post('/{id}/update', 'App\Http\Controllers\Api\ProdukController@update')->name('produk.update');
//         Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\ProdukController@destroy')->name('produk.destroy');
//     });
// });
