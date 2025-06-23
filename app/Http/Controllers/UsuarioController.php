<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por nome, email ou CPF
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

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', strtoupper($request->input('status'))); // Certifique-se que no banco está em maiúsculo
        }

        // Filtro por tipo
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
        'nome' => 'required|string|max:255',
        'documento' => 'required|string|min:11|max:15',
        'nascimento' => 'required|date',
        'celular' => 'required|string|max:20',
        'user' => 'required|string|max:255|unique:users,user',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'status' => 'required|in:ativo,bloqueado,férias',
        'tipo' => 'required|in:administrador,padrao',
    ]);

    $user = User::create([
        'nome' => $validated['nome'],
        'documento' => $validated['documento'],
        'nascimento' => $validated['nascimento'],
        'celular' => $validated['celular'],
        'user' => $validated['user'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'status' => $validated['status'],
        'tipo' => $validated['tipo'],
        'user_verified' => false, // se existir no banco
    ]);

        if ($user) {
            return redirect()->route('index.usuario')->with('success', 'Usuário registrado com sucesso!');
        } else {
            return redirect()->route('index.usuario')->with('error', 'Erro ao registrar usuário!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $usuario = User::findOrFail($id);
        return view('pages.usuarios.register', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'nascimento' => 'required|date',
            'celular' => 'required|string|max:20',
            'user' => 'required|string|max:255|unique:users,user,' . $usuario->id,
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|confirmed|min:6',
            'status' => 'required|in:ativo,bloqueado,férias',
            'tipo' => 'required|in:administrador,padrao',
        ]);

        $usuario->nome = $validated['nome'];
        $usuario->documento = $validated['documento'];
        $usuario->nascimento = $validated['nascimento'];
        $usuario->celular = $validated['celular'];
        $usuario->user = $validated['user'];
        $usuario->email = $validated['email'];
        $usuario->status = $validated['status'];

        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        $usuario->save();

        return redirect()->route('index.usuario')->with('success', 'Usuário atualizado com sucesso!');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            User::findOrFail($id)->delete();
            return redirect()->route('index.usuario')->with('success', 'Usuário excluído com sucesso!');
        }
}
