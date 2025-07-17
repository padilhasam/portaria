<?php

namespace App\Http\Controllers;

use App\Models\Correspondencia;
use App\Models\Morador;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\Loggable; // ✅ Importando o Trait
use Exception;

class CorrespondenciaController extends Controller
{
    use Loggable; // ✅ Habilita o uso do Trait

    public function index(Request $request)
    {
        $moradores = Morador::orderBy('nome')->get();

        $query = Correspondencia::with('morador')->orderBy('recebida_em', 'desc');

        if ($request->filled('id_morador')) {
            $query->where('id_morador', $request->id_morador);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('inicio')) {
            $query->whereDate('recebida_em', '>=', $request->inicio);
        }

        if ($request->filled('fim')) {
            $query->whereDate('recebida_em', '<=', $request->fim);
        }

        $correspondencias = $query->paginate(10)->withQueryString();

        return view('pages.correspondencias.index', compact('correspondencias', 'moradores'));
    }

    public function create()
    {
        $moradores = Morador::orderBy('nome')->get();
        return view('pages.correspondencias.register', compact('moradores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_morador' => 'required|exists:moradores,id',
            'tipo' => 'required|string',
            'remetente' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string|max:500',
        ]);

        try {
            $correspondencia = Correspondencia::create([
                'id_morador' => $request->id_morador,
                'tipo' => $request->tipo,
                'remetente' => $request->remetente,
                'observacoes' => $request->observacoes,
                'status' => 'Recebida',
                'recebida_em' => Carbon::now(),
            ]);

            $this->registrarLog('CREATE', 'correspondencias', $correspondencia->id, "Correspondência registrada para o morador ID {$correspondencia->id_morador}.");

            return redirect()->route('index.correspondencia')->with('success', 'Correspondência registrada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'correspondencias', null, 'Erro ao registrar correspondência.', $e->getMessage());
            return redirect()->route('index.correspondencia')->with('error', 'Erro ao registrar correspondência!');
        }
    }

    public function edit(string $id)
    {
        $correspondencia = Correspondencia::findOrFail($id);
        $moradores = Morador::orderBy('nome')->get();
        return view('pages.correspondencias.register', compact('correspondencia', 'moradores'));
    }

    public function update(Request $request, string $id)
    {
        $correspondencia = Correspondencia::findOrFail($id);

        $request->validate([
            'tipo' => 'required|string',
            'remetente' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string|max:500',
            'status' => 'required|in:Recebida,Entregue',
        ]);

        try {
            $correspondencia->update($request->all());

            $this->registrarLog('UPDATE', 'correspondencias', $correspondencia->id, "Correspondência #{$correspondencia->id} atualizada com sucesso.");

            return redirect()->route('index.correspondencia')->with('success', 'Correspondência atualizada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'correspondencias', $correspondencia->id, "Erro ao atualizar correspondência #{$correspondencia->id}.", $e->getMessage());
            return redirect()->route('index.correspondencia')->with('error', 'Erro ao atualizar correspondência!');
        }
    }

    public function destroy(string $id)
    {
        $correspondencia = Correspondencia::findOrFail($id);

        try {
            $correspondencia->delete();

            $this->registrarLog('DELETE', 'correspondencias', $id, "Correspondência #{$id} removida com sucesso.");

            return redirect()->route('index.correspondencia')->with('success', 'Correspondência removida com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'correspondencias', $id, "Erro ao remover correspondência #{$id}.", $e->getMessage());
            return redirect()->route('index.correspondencia')->with('error', 'Erro ao remover correspondência!');
        }
    }

    public function entregar($id)
    {
        $correspondencia = Correspondencia::findOrFail($id);

        try {
            $correspondencia->status = 'Entregue';
            $correspondencia->entregue_em = Carbon::now();
            $correspondencia->save();

            $this->registrarLog('UPDATE', 'correspondencias', $id, "Correspondência #{$id} entregue ao morador.");

            return redirect()->route('index.correspondencia')->with('success', 'Correspondência entregue com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'correspondencias', $id, "Erro ao marcar entrega da correspondência #{$id}.", $e->getMessage());
            return redirect()->route('index.correspondencia')->with('error', 'Erro ao entregar correspondência!');
        }
    }
}
