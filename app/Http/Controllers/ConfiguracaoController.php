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
        $config = Configuracao::first(); // Supondo que exista apenas uma linha de config
        return view('pages.configuracoes.index', compact('config'));
    }

    public function updatePerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('index.configuracao')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updateSistema(Request $request)
    {
        $dados = [
            'nome_sistema' => $request->input('nome_sistema'),
            'email_contato' => $request->input('email_contato'),
            'notificacoes_email' => $request->has('notificacoes_email') ? '1' : '0',
            'modo_manutencao' => $request->has('modo_manutencao') ? '1' : '0',
        ];

        foreach ($dados as $chave => $valor) {
            Configuracao::updateOrCreate(['chave' => $chave], ['valor' => $valor]);
        }

        // Upload do logo (opcional)
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            Configuracao::updateOrCreate(['chave' => 'logo'], ['valor' => $logoPath]);
        }

        return redirect()->route('index.configuracao')->with('success', 'Configurações salvas!');
    }
}
