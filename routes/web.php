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

// Route::get('/', function () {
//     return view('welcome');
// });




// Route::get('/chat', function () {
//     return view('chat');
// });
Route::view('/chat', 'chat');


use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;

//http://127.0.0.1:8000/messages/user/4
// Route::get('/messages/user/{userId}', [MessageController::class, 'getUserMessages']);

// Route::get('/chats', [ConversationController::class, 'index']);
//Route::get('/chats', 'ConversationController@chats']);

// calling function from controller
// Route::get('/chat_list/{userId}', [ConversationController::class, 'getChatList']);


// view 
Route::get('/chat_list/{userId}', [ConversationController::class, 'showChatList'])->name('chat_list');
Route::get('/chat/{conversation_id}', [MessageController::class, 'getConversationMessages']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
