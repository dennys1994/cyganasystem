<!DOCTYPE html>
<html>
<head>
    <title>Lista de Compras</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Compras</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Usuário Solicitante</th>
                <th>Setor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ $compra->description }}</td>
                    <td>{{ $compra->user->name ?? 'Desconhecido' }}</td>
                    <td>{{ $compra->user->role->name ?? 'Desconhecido' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
