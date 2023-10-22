<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [UserController::class, 'authenticate']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    // Route::get('/riwayat-absen', [UserController::class, 'riwayatAbsen']);
    Route::get('/absen-masuk', [UserController::class, 'absenMasukView']);
    Route::post('/absen-masuk', [UserController::class, 'absenMasuk']);
    Route::get('/countdown', [UserController::class, 'countdown']);
    Route::post('/absen-pulang', [UserController::class, 'absenPulang']);
    Route::get('/izin', [UserController::class, 'izinView']);
    Route::post('/izin', [UserController::class, 'izin']);
    Route::get('peta-lokasi/{id}', [UserController::class, 'tampilPeta']);
    Route::get('/end', [UserController::class, 'end']);
});
