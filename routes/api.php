<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::prefix('version_1')->group(function () {
//     Route::resource('users', UserController::class);
//     Route::resource('conversations', ConversationController::class);
//     Route::resource('messages', MessageController::class);
// });


Route::get('/messages/{contact_id}/{userId}', [MessageController::class, 'getUserMessages']);
Route::post('/new_chat', [MessageController::class, 'store']);
Route::get('/chat/{contact_id}/{userId}',  [ConversationController::class, 'showChat']);
Route::get('/messages/{conversation_id}', [MessageController::class, 'getConversationMessages']);

Route::get('/contact_list/{userId}', [ConversationController::class, 'getUserContacts_by_id']);


/*Get conversation and chat list for sepfifc user */
Route::get('/chats/{userId}', [ConversationController::class, 'getUserContactsAndChatsList']);




Route::get('/user_chats/{contact_id}/{user_id}', [ConversationController::class, '']);


