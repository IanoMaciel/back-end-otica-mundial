<!DOCTYPE html>
<html>
<head>
    <title>Estoque de Lentes</title>
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
        <h3>Ótica Mundial - Estoque de Lentes</h3>
        <p>Registros: {{ count($lenses) }}</p>
    </div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Tipo</th>
        <th>Indíce</th>
        <th>Antirreflexo</th>
        <th>Filtro</th>
        <th>Foco Sen.</th>
        <th>Nome</th>
        <th>Esf.</th>
        <th>Cil.</th>
        <th>Qtd</th>
        <th>Custo(R$)</th>
        <th>Lucro(%)</th>
        <th>Venda(R$)</th>
        <th>Desconto(%)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lenses as $lens)
        <tr>
            <td>{{ $lens->id }}</td>
            <td>{{ $lens->barcode }}</td>
            <td>{{ $lens->typeLens->type_lens }}</td>
            <td>{{ $lens->index }}</td>
            <td>{{ $lens->treatment->treatment }}</td>
            <td>{{ $lens->filter ? 'Sim' : 'Não' }}</td>
            <td>{{ $lens->sensitivity->sensitivity }}</td>
            <td>{{ $lens->name_lens }}</td>
            <td>{{ $lens->spherical }}</td>
            <td>{{ $lens->cylindrical }}</td>
            <td>{{ $lens->amount }}</td>
            <td>{{ 'R$ ' . $lens->purchase_value }}</td>
            <td>{{ $lens->profit . '%'}}</td>
            <td>{{ 'R$ ' . $lens->price }}</td>
            <td>{{ $lens->discount . '%'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
