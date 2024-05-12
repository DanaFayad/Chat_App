<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getConversationMessages($conversation_id)
    {
        //     $loggedInUserId = auth()->user()->id;
        $messageModel = new Message();
        $messages = $messageModel->getMessagesbyConversationID($conversation_id);

        return response()->json($messages);
    }



    public function getUserMessages($userId)
    {

        $messageModel = new Message();
        $messages = $messageModel->getMessagesbyUserID($userId);

        return response()->json($messages);
    }


    public function getConversations($userId)
    {

        $conversations = Message::with(['sender', 'receiver'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->groupBy('conversation_id')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($conversations);
    }
}
