<!DOCTYPE html>
<html>
<head>
    <title>Estoque de Armação</title>
    <style>
        body {
            /*font-family: Ubuntu Light, "sans-serif";*/
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
            background-color: #474747; /* Verde */
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
    </style>
</head>
<body>
<h1>Registro de Armação</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>CÓDIGO ARMAÇÃO</th>
        <th>COR</th>
        <th>FORNECEDOR</th>
        <th>MARCA</th>
        <th>MATERIAL</th>
        <th>QTD.</th>
        <th>VENDA</th>
        <th>COMPRA</th>
        <th>DESC%</th>
        <th>LUCRO%</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($frames as $frame)
        <tr>
            <td>{{ $frame->id }}</td>
            <td>{{ $frame->code }} {{ $frame->size}}/{{ $frame->haste }} {{ $frame->bridge }}</td>
            <td>{{ $frame->color }}</td>
            <td>{{ $frame->suppliers->name }}</td>
            <td>
                {{ $frame->brands->brand }}
                @if ($frame->brands->discount)
                    - {{ $frame->brands->discount }}
                @endif
            </td>
            <td>{{ $frame->materials->material }}</td>
            <td>{{ $frame->amount }}</td>
            <td>{{ $frame->price }}</td>
            <td>{{ $frame->purchase_value }}</td>
            <td>{{ $frame->discount }}</td>
            <td>{{ $frame->profit }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

