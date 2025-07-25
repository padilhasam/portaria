<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Models\Veiculo;
use App\Models\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Traits\Loggable; // ✅ Importa o Trait

class VisitanteController extends Controller
{
    use Loggable; // ✅ Usa o Trait

    public function index(Request $request)
    {
        $search = $request->input('search');
        $id_veiculo = $request->input('id_veiculo');
        $id_prestador = $request->input('id_prestador');

        $visitantes = Visitante::query()
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                             ->orWhere('documento', 'like', "%{$this->unmask($search)}%");
            })
            ->when($id_veiculo, function ($query, $id_veiculo) {
                return $query->where('id_veiculo', $id_veiculo);
            })
            ->when($id_prestador, function ($query, $id_prestador) {
                return $query->where('id_prestador', $id_prestador);
            })
            ->with(['veiculo', 'prestador'])
            ->latest()
            ->paginate(10);

        $veiculos = Veiculo::orderBy('placa')->get();
        $prestadores = Prestador::orderBy('empresa')->get();

        return view('pages.visitantes.index', compact('visitantes', 'search', 'veiculos', 'prestadores', 'id_veiculo', 'id_prestador'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $visitantes = Visitante::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('documento', 'like', "%{$this->unmask($search)}%")
            ->limit(10)
            ->get(['id', 'nome', 'documento']);

        return response()->json($visitantes);
    }

    public function create()
    {
        $veiculos = Veiculo::orderBy('placa')->get();
        $prestadores = Prestador::orderBy('empresa')->get();
        return view('pages.visitantes.register', compact('veiculos', 'prestadores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_veiculo'    => 'nullable|integer|exists:veiculos,id',
            'id_prestador'  => 'nullable|integer|exists:prestadores,id',
            'nome'          => 'required|string|max:255',
            'documento'     => 'required|string|min:11|max:15',
            'celular'       => 'required|string|max:20',
            'observacoes'   => 'nullable|string|max:500',
            'status'        => 'nullable|string|in:bloqueado,ativo',
            'image'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $nomeArquivo = $request->file('image')->hashName();
            $request->file('image')->storeAs('visitantes', $nomeArquivo, 'public');
            $data['image'] = $nomeArquivo;
        }

        try {
            $visitante = Visitante::create($data);

            $this->registrarLog('CREATE', 'visitantes', $visitante->id, "Visitante {$visitante->nome} registrado com sucesso.");

            return redirect()->route('index.visitante')->with('success', 'Visitante registrado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'visitantes', null, 'Erro ao registrar visitante', $e->getMessage());

            return redirect()->route('index.visitante')->with('error', 'Erro ao registrar visitante!');
        }
    }

    public function edit($id)
    {
        $visitante = Visitante::findOrFail($id);
        $veiculos = Veiculo::orderBy('placa')->get();
        $prestadores = Prestador::orderBy('empresa')->get();

        return view('pages.visitantes.register', compact('visitante', 'veiculos', 'prestadores'));
    }

    public function update(Request $request, $id)
    {
        $visitante = Visitante::findOrFail($id);

        $data = $request->validate([
            'id_veiculo'    => 'nullable|exists:veiculos,id',
            'id_prestador'  => 'nullable|exists:prestadores,id',
            'nome'          => 'required|string|max:255',
            'documento'     => 'required|string|min:11|max:15',
            'celular'       => 'required|string|max:20',
            'observacoes'   => 'nullable|string|max:500',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data['status'] = $request->has('status') ? 'bloqueado' : 'ativo';

        if ($request->hasFile('image')) {
            $nomeArquivo = $request->file('image')->hashName();
            $request->file('image')->storeAs('visitantes', $nomeArquivo, 'public');
            $data['image'] = $nomeArquivo;
        }

        try {
            $visitante->update($data);

            $this->registrarLog('UPDATE', 'visitantes', $visitante->id, "Visitante {$visitante->nome} atualizado com sucesso.");

            return redirect()->route('index.visitante')->with('success', 'Visitante atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'visitantes', $visitante->id, 'Erro ao atualizar visitante', $e->getMessage());

            return redirect()->route('index.visitante')->with('error', 'Erro ao atualizar visitante!');
        }
    }

    public function destroy($id)
    {
        $visitante = Visitante::findOrFail($id);

        try {
            if ($visitante->image) {
                $path = str_replace('/storage/', '', $visitante->image);
                Storage::disk('public')->delete($path);
            }

            $visitante->delete();

            $this->registrarLog('DELETE', 'visitantes', $id, "Visitante {$visitante->nome} removido com sucesso.");

            return redirect()->route('index.visitante')->with('success', 'Visitante removido com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'visitantes', $id, 'Erro ao remover visitante', $e->getMessage());

            return redirect()->route('index.visitante')->with('error', 'Erro ao remover visitante!');
        }
    }

    private function unmask($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
