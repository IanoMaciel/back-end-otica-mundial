<!DOCTYPE html>
<html>
<head>
    <title>Estoque de Armação</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            font-weight: 700;
            color: #1c1c1c;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        thead th {
            background-color: #ff0000;
            color: #ffffff;
            text-align: left;
            padding: 12px;
            font-weight: 500;
            font-size: 14px;
        }

        tbody td {
            text-align: left;
            padding: 10px;
            font-size: 13px;
        }

        tr {
            border-bottom: 1px solid #dadada;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ótica Mundial | Estoque de Lentes</h1>
        <p>Total de Registros: 10</p>
    </div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Nome</th>
        <th>QTD</th>
        <th>Esférico</th>
        <th>Cilíndrico</th>
        <th>Tipo</th>
        <th>Antirreflexo</th>
        <th>Filtro</th>
        <th>Foco Sen.</th>
        <th>Tipo</th>
        <th>Custo(R$)</th>
        <th>Venda(R$)</th>
        <th>Desconto(%)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lenses as $lens)
        <tr>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
