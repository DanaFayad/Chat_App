<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{




    public function showChat($contact_id, $userId)
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

        return view('chat', $response);
    }

    public function showChatList($user_id)
    {
        $user_id = Auth::id();
        $usersModel = new User();
        $user_contacts = $usersModel->user_contacts($user_id);
        $conversations = $this->getChatList($user_id);
        $result = array();
        $result["contacts"] = ($user_contacts);
        $result["conversations"] = ($conversations);
        $result["current_user_id"] = ($user_id);

        return view('chat_list', $result);
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
        ->map(function ($messages) use ($userId) {
            $latestMessage = $messages->first();
            
            // get contact user info
            if ($latestMessage->sender_id == $userId) {
                $contactUser = $latestMessage->receiver;
            } else {
                $contactUser = $latestMessage->sender;
            }
            
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
                'contact_user' => [
                    'id' => $contactUser->id,
                    'full_name' => $contactUser->full_name,
                    'profile' => $contactUser->profile_picture,
                ],
            ];
        })->values();
    
    return $conversations;
    
    }

    public function getUserContacts()
    {
        $usersModel = new User();
        $id = Auth::id();
        $result = $usersModel->user_contacts($id);
        echo json_encode($result);
    }


    public function getUserContacts_by_id($id)
    {
        $usersModel = new User();
        $result = $usersModel->user_contacts($id);
        echo json_encode($result);
    }


    public function getUserContactsAndChatsList($id)
    {
        $usersModel = new User();
        $user_id = ($id == -1) ? Auth::id() : $id;
        $user_contacts = $usersModel->user_contacts($user_id);
        $conversations = $this->getChatList($user_id);
        $result = array();
        $result["contacts"] = ($user_contacts);
        $result["conversations"] = ($conversations);
        echo json_encode($result);
    }


    
}
