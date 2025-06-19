<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(auth()->check()){
            return redirect()->route('index.registro');
        }

        return view('pages.authentication.login');
    }

    public function store(LoginRequest $request){
         $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return redirect()->route('login.index')->withErrors(['error' => 'Email ou senha inválidos']);
        }

        Auth::loginUsingId($user->id);

        // Contar notificações não lidas
        $naoLidasCount = $user->notificacoesRecebidas()->wherePivot('read', false)->count();

        if ($naoLidasCount > 0) {
            session()->flash('notificacoes_nao_lidas', $naoLidasCount);
        }

        return redirect()->route('index.registro')->with('success', 'Logado com sucesso!');
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('login.index');
    }
}

