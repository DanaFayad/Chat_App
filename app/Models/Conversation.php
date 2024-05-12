<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // conversation has many users & vise versa
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // converation has many msgs but 1 msg belongs to conversation=  1->many
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

  
public function get_all_conversations($user_id){

}
      // Retrieve conversations where the user is either the sender or receiver
//       $conversations = Message::with(['sender', 'receiver'])
//       ->where('sender_id', $userId)
//       ->orWhere('receiver_id', $userId)
//       ->groupBy('conversation_id')
//       ->orderByDesc('created_at')
//       ->get();

//   return response()->json($conversations);


//   $query_result = $this->select('messages.id',)
//   ->where('sender_id', $userId)
//       ->orWhere('receiver_id', $userId)
//       ->groupBy('conversation_id')
//       ->orderByDesc('created_at')
//   ->get();
// return $query_result;
}

