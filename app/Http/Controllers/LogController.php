<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Log; // Use sua model de logs
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
    public function gerar(Request $request)
    {
        $logs = Log::orderBy('created_at', 'desc')
            ->when($request->filled('nivel'), fn($q) => $q->where('nivel', $request->nivel))
            ->when($request->filled('data'), fn($q) => $q->whereDate('created_at', $request->data))
            ->get();

        if ($request->tipo === 'pdf') {
            $pdf = Pdf::loadView('pages.logs.exportar_pdf', compact('logs'));
            return $pdf->download('logs_' . now()->format('Ymd_His') . '.pdf');
        }

        if ($request->tipo === 'txt') {
            $content = '';
            foreach ($logs as $log) {
                $content .= "[{$log->created_at}] {$log->nivel} - {$log->mensagem}" . PHP_EOL;
            }

            $filename = 'logs_' . now()->format('Ymd_His') . '.txt';
            Storage::put($filename, $content);

            return response()->download(storage_path("app/{$filename}"));
        }

        return back()->with('error', 'Tipo de exportação inválido.');
    }
}
