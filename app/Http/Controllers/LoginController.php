<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('pages.authentication.login');
    }

    public function store(LoginRequest $request){
        $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return redirect()->route('login.index')->withErrors(['error' => 'Email ou senha inválidos']);
        }

        if(!password_verify($request->password, $user->password)){
            return redirect()->route('login.index')->withErrors(['error' => 'Email ou senha inválidos']);
        }

        Auth::loginUsingId($user->id);

        return redirect()->route('vehicle.index')->withErrors(['success' => 'Logado']);
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('login.index');
    }
}