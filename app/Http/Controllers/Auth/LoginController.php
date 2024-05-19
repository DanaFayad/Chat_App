<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function sign_in(Request $request)
    {
        $user_credentials = $request->only('username', 'password');
        if (Auth::attempt($user_credentials)) {
            $id = Auth::id(); 
            return redirect()->intended('chat_list/'.$id);
        }
        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }
}
