<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Configuracao;
use Exception;
use App\Traits\Loggable;

class ConfiguracaoController extends Controller
{
    use Loggable;

    public function index()
    {
        // Pega a primeira configuração, ou null se não existir
        $config = Configuracao::first();
        return view('pages.configuracoes.index', compact('config'));
    }

    public function updateConfiguracaoPerfil(Request $request)
    {
        $user = auth()->user();

        // Validação
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'idioma' => 'nullable|string|in:pt,en',
            'tema_escuro' => 'nullable|boolean',
            'notificacoes' => 'nullable|boolean',
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                // Remove foto antiga
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Armazena nova foto
                $user->foto = $request->file('foto')->store('usuarios', 'public');
            }

            // Campos booleanos (checkbox)
            $user->tema_escuro = $request->boolean('tema_escuro', false);
            $user->notificacoes = $request->boolean('notificacoes', false);
            $user->idioma = $request->input('idioma', 'pt');

            $user->save();

            // Log de atualização do perfil
            $this->registrarLog('UPDATE', 'users', $user->id, "Perfil do usuário {$user->name} atualizado com sucesso.");

            return redirect()->route('index.configuracao')->with('success', 'Perfil atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'users', $user->id, 'Erro ao atualizar perfil do usuário', $e->getMessage());
            return redirect()->route('index.configuracao')->with('error', 'Erro ao atualizar perfil! ' . $e->getMessage());
        }
    }

    public function updateConfiguracaoSistema(Request $request)
    {
        // Validação
        $request->validate([
            'nome_sistema' => 'required|string|max:255',
            'email_contato' => 'nullable|email',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'notificacoes_email' => 'nullable|boolean',
            'modo_manutencao' => 'nullable|boolean',
            // Adicione mais campos aqui conforme sua tabela config
        ]);

        try {
            // Busca a primeira configuração ou cria nova (sem duplicatas)
            $config = Configuracao::firstOrNew(['id' => 1]);

            $config->nome_sistema = $request->nome_sistema;
            $config->email_contato = $request->email_contato;
            $config->notificacoes_email = $request->boolean('notificacoes_email', false);
            $config->modo_manutencao = $request->boolean('modo_manutencao', false);

            if ($request->hasFile('logo')) {
                if ($config->logo && Storage::disk('public')->exists($config->logo)) {
                    Storage::disk('public')->delete($config->logo);
                }
                $config->logo = $request->file('logo')->store('logos', 'public');
            }

            $config->save();

            $this->registrarLog('UPDATE', 'configuracoes', $config->id, "Configurações do sistema atualizadas com sucesso.");

            return redirect()->route('index.configuracao')->with('success', 'Configurações do sistema atualizadas!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'configuracoes', $config->id ?? null, 'Erro ao atualizar configurações do sistema', $e->getMessage());
            return redirect()->route('index.configuracao')->with('error', 'Erro ao atualizar configurações! ' . $e->getMessage());
        }
    }
}
