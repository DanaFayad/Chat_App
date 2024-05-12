<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // 1 message can have 1 converstaion  and converstaion has many msg=many-> 1

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getMessagesbyUserID($userId)
    {
        $query_result = $this->select('messages.conversation_id', 'messages.id', 'messages.content', 'messages.created_at', 'sender.id as sender_id', 'sender.full_name as sender_name', 'sender.profile_picture as sender_profile_picture', 'receiver.id as receiver_id', 'receiver.full_name as receiver_name', 'receiver.profile_picture as receiver_profile_picture')
            ->leftJoin('users as sender', 'messages.sender_id', '=', 'sender.id')
            ->leftJoin('users as receiver', 'messages.receiver_id', '=', 'receiver.id')
            ->where('sender.id', $userId)
            ->orWhere('receiver.id', $userId)
            ->groupBy('messages.conversation_id')
            ->orderBy('messages.created_at', 'desc')
            ->get();
        return $query_result;
    }


    public function getMessagesbyConversationID($conversation_id)
    {
        
        $query_result = $this->select('messages.conversation_id', 'messages.id', 'messages.content', 'messages.created_at', 'sender.id as sender_id', 'sender.full_name as sender_name', 'sender.profile_picture as sender_profile_picture', 'receiver.id as receiver_id', 'receiver.full_name as receiver_name', 'receiver.profile_picture as receiver_profile_picture')
            ->leftJoin('users as sender', 'messages.sender_id', '=', 'sender.id')
            ->leftJoin('users as receiver', 'messages.receiver_id', '=', 'receiver.id')
            ->where('messages.conversation_id', $conversation_id)
            ->orderBy('messages.created_at', 'asc')
            ->get();
        return $query_result;
    }
}
