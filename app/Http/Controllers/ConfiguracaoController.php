<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function index()
    {
         $config = Configuracao::first(); // ou outra lógica
        return view('pages.configuracoes.index', compact('config'));
    }

    public function updateConfiguracaoPerfil(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|string|min:6',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('index.configuracao')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updateConfiguracaoSistema(Request $request)
    {
        $request->validate([
        'nome_sistema' => 'required|string|max:255',
        'email_contato' => 'nullable|email',
        'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $config = Configuracao::firstOrNew(); // ou outra lógica

        $config->nome_sistema = $request->nome_sistema;
        $config->email_contato = $request->email_contato;
        $config->notificacoes_email = $request->has('notificacoes_email');
        $config->modo_manutencao = $request->has('modo_manutencao');

        if ($request->hasFile('logo')) {
            $config->logo = $request->file('logo')->store('logos', 'public');
        }

        $config->save();

        return redirect()->route('index.configuracao')->with('success', 'Configurações salvas!');
    }
}
