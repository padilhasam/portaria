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
        $request->validate([
            'nome' => 'required|string|max:255',
            'user' => 'required|string|max:255|unique:users,user',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'acesso_tipo' => 'required|string',
        ], [
            
            'acesso_tipo.required' => 'Por favor, escolha o tipo de acesso.',
            'nome.required' => 'O nome completo é obrigatório.',
            'user.required' => 'O nome de usuário é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não conferem!',
        ]);

        User::create([
            'nome' => $request->nome,
            'user' => $request->user,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografando a senha
            'acesso_tipo' => $request->acesso_tipo,
            'user_verified' => false, // padrão como não verificado
        ]);

        return redirect()->route('index.usuario')->with('success', 'Usuário cadastrado com sucesso!');
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
