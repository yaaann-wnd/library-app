<?php

use App\Http\Controllers\berandaController;
use App\Http\Controllers\bukuController;
use App\Http\Controllers\kategoriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('buku', bukuController::class);    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('kategori', kategoriController::class);    
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [berandaController::class, 'index'])->name('beranda.index');
Route::get('/{id}', [berandaController::class, 'show'])->name('beranda.show');
