<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;

class MessageController extends Controller
{
  
    public function getConversationMessages($conversation_id)
    {
        try {
            $messages = Message::where('conversation_id', $conversation_id)->get();
            return response()->json($messages);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve messages.'], 500);
        }
    }

    public function index($conversation_id)
    {     
        $messageModel = new Message();
        $messages = $messageModel->getMessagesbyConversationID($conversation_id);

        return $messages;
    }
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255'
        ]);

        $message = new Message();
        $message->content = $request->content;
        $message->sender_id = 1;
        $message->receiver_id = 2;
        $message->conversation_id = $request->conversation_id;

        $message->save();
    
        return response()->json($message, 201);
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
