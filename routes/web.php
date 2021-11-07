<?php

use App\Http\Controllers\MessageController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('usermessage/{id}', [MessageController::class, 'user_message'])->name('user.message');
Route::post('sendmessage', [MessageController::class, 'send_message'])->name('user.message.send');
Route::get('deletesinglemessage/{id}', [MessageController::class, 'delete_single_message'])->name('single.message.delete');

Route::get('deleteallmessage/{id}', [MessageController::class, 'delete_all_message'])->name('all.message.delete');


// Route::get('/shbfvdgbdhs', [MessageController::class, 'user_list']);
