<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .erro { color: red; }
    </style>
</head>
<body>
    <h2>📄 Logs do Sistema</h2>
    <table>
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Ação</th>
                <th>Tabela</th>
                <th>Registro</th>
                <th>Descrição</th>
                <th>Erro</th>
                <th>Data/Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->acao }}</td>
                    <td>{{ $log->tabela_afetada }}</td>
                    <td>{{ $log->registro_id ?? '-' }}</td>
                    <td>{{ $log->descricao }}</td>
                    <td class="erro">{{ $log->erro ?? '-' }}</td>
                    <td>{{ $log->criado_em->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
