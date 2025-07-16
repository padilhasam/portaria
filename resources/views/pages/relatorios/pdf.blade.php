<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Acessos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        p.small {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <h1>Relatório de Acessos</h1>
    <p class="small">Gerado em: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de Acesso</th>
                <th>Data/Hora</th>
                <th>Apartamento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registros as $registro)
                <tr>
                    <td>{{ $registro->id }}</td>
                    <td>{{ ucfirst($registro->tipo_acesso) }}</td>
                    <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $registro->apartamento ? 'Bloco ' . $registro->apartamento->bloco . ' - Apto. ' . $registro->apartamento->numero : '—' }}
                    </td>
                    <td>{{ ucfirst($registro->status ?? '—') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro encontrado para os filtros selecionados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        SECURE ACCESS &copy; {{ now()->year }} — Relatório de Acessos
    </div>

</body>
</html>
