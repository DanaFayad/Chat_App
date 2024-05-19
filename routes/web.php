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
use App\Http\Controllers\Auth\LoginController;

//http://127.0.0.1:8000/messages/user/4
 Route::get('/chat/{contact_id}/{userId}', [ConversationController::class, 'showChat']);

// Route::get('/chats', [ConversationController::class, 'index']);
//Route::get('/chats', 'ConversationController@chats']);

// calling function from controller
// Route::get('/chat_list/{userId}', [ConversationController::class, 'getChatList']);


// view 
Route::get('/chat_list/{userId}', [ConversationController::class, 'showChatList'])->name('chat_list');


// Route::get('/messages/{conversation_id}', [MessageController::class, 'index']);
Route::post('/new_chat', [MessageController::class, 'store']);
// Route::get('/chat/{conversation_id}',  [ConversationController::class, 'showChat']);
Route::get('/messages/{conversation_id}', [MessageController::class, 'getConversationMessages']);
Route::get('/messages/{contact_id}/{userId}', [MessageController::class, 'getUserMessages']);



/*Login */
Route::get('login', [LoginController::class, 'loginView'])->name('login');
Route::get('/', [LoginController::class, 'loginView'])->name('login');

Route::post('sign_in', [LoginController::class, 'sign_in'])->name('sign_in');
/*END Login */


Route::get('/contact_list', [ConversationController::class, 'getUserContacts']);
/*get contacts for user id  */
Route::get('/contact_list/{userId}', [ConversationController::class, 'getUserContacts_by_id']);


