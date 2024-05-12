<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{


    public function showChatList($userId){
        $conversations = $this->getChatList($userId);
        return view('chat_list', compact('conversations'));
    }

    public function index()
    {
        $conversations = Conversation::all();
        return view('chat', compact('conversations'));
    }


    public function chats()
    {

        $chatList = DB::table('messages')
            ->select('messages.conversation_id', 'messages.content', 'messages.created_at', 'sender.full_name as sender_name', 'receiver.full_name as receiver_name')
            ->join('users as sender', 'messages.sender_id', '=', 'sender.id')
            ->join('users as receiver', 'messages.receiver_id', '=', 'receiver.id')
            ->whereIn('messages.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('messages')
                    ->groupBy('conversation_id');
            })
            ->orderBy('messages.created_at', 'desc')
            ->get();


        return response()->json(['chats' => $chatList]);
    }

    public function getChatList($userId)
    {
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('conversation_id')
            ->map(function ($messages) {
                $latestMessage = $messages->first();
                return [
                    'conversation_id' => $latestMessage->conversation_id,
                    'latest_message' => [
                        'id' => $latestMessage->id,
                        'content' => $latestMessage->content,
                        'created_at' => $latestMessage->created_at->format('Y-m-d H:i:s'),
                        'sender' => [
                            'id' => $latestMessage->sender->id,
                            'full_name' => $latestMessage->sender->full_name,
                            'profile' => $latestMessage->sender->profile_picture,

                        ],
                        'receiver' => [
                            'id' => $latestMessage->receiver->id,
                            'full_name' => $latestMessage->receiver->full_name,
                            'profile' => $latestMessage->receiver->profile_picture,
                        ],
                    ],
                ];
            })->values();

        return $conversations;
    }
}
