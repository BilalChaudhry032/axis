<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required', 'password' => 'required',
        ]);

        $user = User::where('username', $request->username)
                ->first();

        if(isset($user)) {
            if($user->password == md5($request->password)) {
                User::where('user_id', '=', $user->user_id)->update([
                    'password' => Hash::make($request->password)
                ]);
                Auth::attempt(['username' => $request->username, 'password' => $request->password]);
                
                Session::put('user-session', [
                    'uid' => $user->user_id, 
                    'uname' => $user->name
                ]);
                return redirect('/')->with([
                    'message' => 'Authentication Successful!',
                    'user' => $user
                ]);
            } elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                
                Session::put('user-session', [
                    'uid' => $user->user_id, 
                    'uname' => $user->name
                ]);
                return redirect('/')->with([
                    'message' => 'Authentication Successful!',
                    'user' => $user
                ]);
            } else {
                Session::flush();
                Auth::logout();
                return redirect('/login')->with('message', 'Authentication Failed!');
            }
        } else {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('message', 'Authentication Failed!');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect('/login')->with('message', 'Logout Successfully!');
    }
}
