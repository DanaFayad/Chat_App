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


        $userId = $request->user_id;
        $contact_id = $request->contact_id;

        $message = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
            ->where(function ($query)  use ($contact_id) {
                $query->where('sender_id', $contact_id)
                    ->orWhere('receiver_id', $contact_id);
            })
            ->first();


        if ($message) {
            $conversation_id =   $message->conversation_id;
        } else {
            $conversation_id =     DB::table('conversations')->insertGetId([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
        }

        $message = new Message();
        $message->content = $request->content;
        $message->sender_id = $request->user_id;
        $message->receiver_id = $request->contact_id;
        $message->conversation_id = $conversation_id;

        $message->save();
        // if ($message) {
        //     event(new NewMessage($message));
        // }
        return response()->json($message, 201);
    }

    public function getUserMessages($contact_id, $userId)
    {

        $messageModel = new Message();
        $messages = $messageModel->getMessagesbyUserID($contact_id, $userId);
        $messagesArray = $messages->toArray();
        $response = [
            'messages' => $messagesArray,
            'contact_id' => $contact_id,
            'user_id' => $userId,

        ];

        if (count($messages) == 0) {
            $response["conversation_id"] = -1;
        } else {
            $response["conversation_id"] = $messages[0]->conversation_id;
        }




        return response()->json($response);
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
