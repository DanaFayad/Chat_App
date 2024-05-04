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
}
