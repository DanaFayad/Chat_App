<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// class User extends Model
// {
//     use HasFactory;
// }


class User extends Authenticatable
{


    // 1 user can have multiple conversation & converstaion can has multiple users
    // many -> manay 
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }
}
