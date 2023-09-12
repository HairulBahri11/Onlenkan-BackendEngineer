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
Route::post('/admin/store', 'App\Http\Controllers\Api\AdminController@store')->name('admin/store');
Route::post('/login', 'App\Http\Controllers\Api\LoginController@login')->name('login');
Route::middleware(['auth:sanctum'])->group(function () {
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
    Route::prefix('galeri')->group(function () {
        Route::get('/', 'App\Http\Controllers\Api\GaleriController@index')->name('galeri.index')->middleware('permission:lihat-galeri');
        Route::get('/{id}/show', 'App\Http\Controllers\Api\GaleriController@show')->name('galeri.show')->middleware('permission:lihat-galeri');
        Route::post('/store', 'App\Http\Controllers\Api\GaleriController@store')->name('galeri.store')->middleware('permission:tambah-galeri');
        Route::post('/{id}/update', 'App\Http\Controllers\Api\GaleriController@update')->name('galeri.update')->middleware('permission:edit-galeri');
        Route::delete('/{id}/destroy', 'App\Http\Controllers\Api\GaleriController@destroy')->name('galeri.destroy')->middleware('permission:hapus-galeri');
    });
    Route::prefix('admin')->group(function () {
        Route::post('/store', 'App\Http\Controllers\Api\AdminController@store')->name('admin/store')->middleware('permission:tambah-admin');
    });
});

Route::get('role', 'App\Http\Controllers\Api\RoleController@index');
Route::post('role/store', 'App\Http\Controllers\Api\RoleController@store');
Route::post('role/{id}/update', 'App\Http\Controllers\Api\RoleController@update');
Route::delete('role/{id}/destroy', 'App\Http\Controllers\Api\RoleController@destroy');

Route::get('permission', 'App\Http\Controllers\Api\RoleController@permission_index');
Route::post('permission/store', 'App\Http\Controllers\Api\RoleController@permission_store');
