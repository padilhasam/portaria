<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Traits\Loggable; // ✅ Importa o Trait

class UsuarioController extends Controller
{
    use Loggable; // ✅ Habilita o Trait

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%")
                  ->orWhere('user', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', strtolower($request->input('status')));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', strtolower($request->input('tipo')));
        }

        $usuarios = $query->orderBy('nome')->paginate(10);

        return view('pages.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view("pages.usuarios.register");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'      => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'nascimento'=> 'required|date',
            'celular'   => 'required|string|max:20',
            'user'      => 'required|string|max:255|unique:users,user',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|confirmed|min:6',
            'status'    => 'required|in:ativo,bloqueado,férias',
            'tipo'      => 'required|in:administrador,padrao',
        ]);

        try {
            $user = User::create([
                'nome'          => $validated['nome'],
                'documento'     => $validated['documento'],
                'nascimento'    => $validated['nascimento'],
                'celular'       => $validated['celular'],
                'user'          => $validated['user'],
                'email'         => $validated['email'],
                'password'      => Hash::make($validated['password']),
                'status'        => $validated['status'],
                'tipo'          => $validated['tipo'],
                'user_verified' => false,
            ]);

            // ✅ Usa o Trait para registrar o log
            $this->registrarLog('CREATE', 'users', $user->id, "Usuário {$user->nome} criado com sucesso.");

            return redirect()->route('index.usuario')->with('success', 'Usuário registrado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'users', null, 'Erro ao criar usuário', $e->getMessage());

            return back()->with('error', 'Erro ao registrar usuário!');
        }
    }

    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('pages.usuarios.register', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'nome'      => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'nascimento'=> 'required|date',
            'celular'   => 'required|string|max:20',
            'user'      => 'required|string|max:255|unique:users,user,' . $usuario->id,
            'email'     => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password'  => 'nullable|confirmed|min:6',
            'status'    => 'required|in:ativo,bloqueado,férias',
            'tipo'      => 'required|in:administrador,padrao',
        ]);

        try {
            $usuario->update([
                'nome'       => $validated['nome'],
                'documento'  => $validated['documento'],
                'nascimento' => $validated['nascimento'],
                'celular'    => $validated['celular'],
                'user'       => $validated['user'],
                'email'      => $validated['email'],
                'status'     => $validated['status'],
                'tipo'       => $validated['tipo'],
                'password'   => !empty($validated['password']) ? Hash::make($validated['password']) : $usuario->password,
            ]);

            $this->registrarLog('UPDATE', 'users', $usuario->id, "Usuário {$usuario->nome} atualizado.");

            return redirect()->route('index.usuario')->with('success', 'Usuário atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'users', $usuario->id, 'Erro ao atualizar usuário', $e->getMessage());

            return back()->with('error', 'Erro ao atualizar usuário!');
        }
    }

    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        try {
            $usuario->delete();

            $this->registrarLog('DELETE', 'users', $id, "Usuário {$usuario->nome} excluído.");

            return redirect()->route('index.usuario')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'users', $id, 'Erro ao excluir usuário', $e->getMessage());

            return back()->with('error', 'Erro ao excluir usuário!');
        }
    }
}
