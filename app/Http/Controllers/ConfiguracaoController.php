<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $config = Configuracao::first(); // Carrega as configurações do sistema
        return view('pages.configuracoes.index', compact('config'));
    }

    public function updateConfiguracaoPerfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Corrigido: estava 'nome'
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'idioma' => 'nullable|string|in:pt,en',
            'tema_escuro' => 'nullable|boolean',
            'notificacoes' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;

        // Atualiza senha se informada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Atualiza foto de perfil
        if ($request->hasFile('foto')) {
            // Remove foto antiga se existir
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->foto = $request->file('foto')->store('usuarios', 'public');
        }

        // Preferências do usuário
        $user->tema_escuro = $request->has('tema_escuro');
        $user->notificacoes = $request->has('notificacoes');
        $user->idioma = $request->input('idioma', 'pt');

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

        $config = Configuracao::firstOrNew(); // Pega ou cria uma nova instância

        $config->nome_sistema = $request->nome_sistema;
        $config->email_contato = $request->email_contato;
        $config->notificacoes_email = $request->has('notificacoes_email');
        $config->modo_manutencao = $request->has('modo_manutencao');

        if ($request->hasFile('logo')) {
            // Remove logo antiga se existir
            if ($config->logo && Storage::disk('public')->exists($config->logo)) {
                Storage::disk('public')->delete($config->logo);
            }

            $config->logo = $request->file('logo')->store('logos', 'public');
        }

        $config->save();

        return redirect()->route('index.configuracao')->with('success', 'Configurações do sistema atualizadas!');
    }
}