<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('pages.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.usuarios.register");
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'acesso_tipo' => 'required|string',
        ]);

        $user = User::create([
            'nome' => $validated['nome'],
            'documento' => $validated['documento'],
            'nascimento' => $validated['nascimento'],
            'celular' => $validated['celular'],
            'user' => $validated['user'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'acesso_tipo' => $validated['acesso_tipo'],
            'user_verified' => false,
        ]);

        if ($user) {
            return redirect()->route('index.usuario')->with([
                'success' => true,
                'message' => 'Usuário registrado com sucesso!'
            ]);
        } else {
            return redirect()->route('index.usuario')->with([
                'success' => false,
                'message' => 'Erro ao registrar usuário!'
            ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
