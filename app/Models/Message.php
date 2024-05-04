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
}
