<?php

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

Route::get('/messages', function () {
    return view('messages');
});

Route::post('/send-message', function () {
    logger('sent!');
    broadcast(new \App\Events\MessageSent(request('message')))->toOthers();
    return response()->json(['status' => 'ok']);
});