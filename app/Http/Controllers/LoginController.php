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
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return redirect()->route('login.index')->withErrors(['error' => 'Email ou senha inválidos']);
        }

        // Verifica se o usuário está ativo
        if ($user->status !== 'ativo') {
            $mensagem = $user->status === 'bloqueado'
                ? 'Usuário bloqueado. Contate o administrador.'
                : 'Usuário está em período de férias e não pode acessar o sistema.';
            return redirect()->route('login.index')->withErrors(['error' => $mensagem]);
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
