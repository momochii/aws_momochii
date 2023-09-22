<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/***** board *****/
Route::get('/board', [App\Http\Controllers\boardController::class, 'index'])->name('board');
Route::get('/board/write/{id?}', [App\Http\Controllers\boardController::class, 'write'])->where('id','[0-9]+')->name('board.write');
Route::post('/board/proc/', [App\Http\Controllers\boardController::class, 'proc'])->name('board.proc');
Route::get('/board/view/{id}', [App\Http\Controllers\boardController::class, 'view'])->where('id','[0-9]+')->name('board.view');
