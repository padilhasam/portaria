<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Configuracao;
use Exception;
use App\Traits\Loggable; // ✅ Importa o Trait

class ConfiguracaoController extends Controller
{
    use Loggable; // ✅ Usa o Trait

    public function index()
    {
        $config = Configuracao::first();
        return view('pages.configuracoes.index', compact('config'));
    }

    public function updateConfiguracaoPerfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'idioma' => 'nullable|string|in:pt,en',
            'tema_escuro' => 'nullable|boolean',
            'notificacoes' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        try {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }
                $user->foto = $request->file('foto')->store('usuarios', 'public');
            }

            $user->tema_escuro = $request->has('tema_escuro');
            $user->notificacoes = $request->has('notificacoes');
            $user->idioma = $request->input('idioma', 'pt');

            $user->save();

            // ✅ LOG DE ATUALIZAÇÃO DE PERFIL
            $this->registrarLog('UPDATE', 'users', $user->id, "Perfil do usuário {$user->name} atualizado com sucesso.");

            return redirect()->route('index.configuracao')->with('success', 'Perfil atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'users', $user->id, 'Erro ao atualizar perfil do usuário', $e->getMessage());
            return redirect()->route('index.configuracao')->with('error', 'Erro ao atualizar perfil!');
        }
    }

    public function updateConfiguracaoSistema(Request $request)
    {
        $request->validate([
            'nome_sistema' => 'required|string|max:255',
            'email_contato' => 'nullable|email',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        try {
            $config = Configuracao::firstOrNew();

            $config->nome_sistema = $request->nome_sistema;
            $config->email_contato = $request->email_contato;
            $config->notificacoes_email = $request->has('notificacoes_email');
            $config->modo_manutencao = $request->has('modo_manutencao');

            if ($request->hasFile('logo')) {
                if ($config->logo && Storage::disk('public')->exists($config->logo)) {
                    Storage::disk('public')->delete($config->logo);
                }
                $config->logo = $request->file('logo')->store('logos', 'public');
            }

            $config->save();

            // ✅ LOG DE ATUALIZAÇÃO DE CONFIGURAÇÕES DO SISTEMA
            $this->registrarLog('UPDATE', 'configuracoes', $config->id ?? null, "Configurações do sistema atualizadas com sucesso.");

            return redirect()->route('index.configuracao')->with('success', 'Configurações do sistema atualizadas!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'configuracoes', $config->id ?? null, 'Erro ao atualizar configurações do sistema', $e->getMessage());
            return redirect()->route('index.configuracao')->with('error', 'Erro ao atualizar configurações!');
        }
    }
}
