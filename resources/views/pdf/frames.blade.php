<!DOCTYPE html>
<html>
    <head>
        <title>Estoque de Armação</title>

        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
        />

        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
        />

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin: 20px;
                color: #333;
            }

            .header {
                display: flex;
                width: 100%;
                align-items: center;
            }

            .img-area {
                text-align: center;
                padding: 0 10px;
                clip-path: polygon(0% 0%, 100% 0%, 92% 100%, 0% 100%);
            }

            .title {
                width: 100%;
                height: 53px;

                display: flex;
                align-items: center;
                justify-content: center;

                background-color: red;
                color: white;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                line-height: 53px;
                clip-path: polygon(2.7% 0, 100% 0, 100% 100%, 0% 100%);
                text-transform: uppercase;
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
                background-color: red;
                color: #ffffff;
                text-align: left;
                padding: 10px;
                font-weight: 600;
                font-size: 14px;
            }

            tbody td {
                text-align: left;
                padding: 10px;
                font-size: 12px;
            }

            tr { border-bottom: 1px solid #dadada; }

            .action {
                display: flex;
                justify-content: end;
                align-content: center;
                margin-bottom: 20px;

                button {
                    display: flex;
                    align-content: center;
                    justify-content: center;

                    gap: 5px;

                    background: red;
                    color: white;
                    padding: 5px 10px;
                    border: none;
                    border-radius: 2px;

                    cursor: pointer;
                    font-weight: 600;
                }
            }

            @media print {
                .action {
                    display: none;
                }

                body {
                    margin: 0;
                    padding: 15px;
                }
            }
        </style>
    </head>

    @php
        use Carbon\Carbon;

        Carbon::setLocale('pt_BR');

        function formatDate(string $date, string $format='d-m-Y'): string {
            return \Carbon\Carbon::parse($date)->format($format);
        }

        function formatFullDate(string $date): string {
            return Carbon::parse($date)->translatedFormat('d \\d\\e F \\d\\e Y \\à\\s H:i');
        }

        function formatReal(string $value): string {
            $value = floatval($value);
            return 'R$ ' . number_format($value, 2, ',', '.');
        }

    @endphp

    <body>
        <div class="action">
            <button type="button">
                <i class="ph-fill ph-export"></i>
                <span>IMPRIMIR</span>
            </button>
        </div>
        <article class="header">
            <div class="img-area">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="171px" height="53px"/>
            </div>
            <div class="title">
                <h4>ESTOQUE DE ARMAÇÃO</h4>
            </div>
        </article>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>ARMAÇÃO</th>
                <th>GRIFE</th>
                <th>MATERIAL</th>
                <th>COR</th>
                <th>FORNECEDOR</th>
                <th>QTD</th>
                <th>PREÇO</th>
                <th>CRIADO EM</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($frames as $frame)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $frame->code }} {{ $frame->size ?? '-'}} {{ $frame->bridge  ?? '-'}} {{ $frame->haste  ?? '-'}} </td>
                    <td>
                        {{ $frame->brands->brand  ?? '-'}}
                    </td>
                    <td>{{ $frame->materials->material  ?? '-'}}</td>
                    <td>{{ $frame->color ?? '-'}}</td>
                    <td>{{ $frame->suppliers->name  ?? '-'}}</td>
                    <td>{{ $frame->amount  ?? '-'}}</td>
                    <td>{{ $frame->price ? formatReal($frame->price) : '-' }}</td>
                    <td>{{ $frame->created_at ? formatFullDate($frame->created_at) : '-'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printButton = document.querySelector('.action button');

            if (printButton) {
                printButton.addEventListener('click', function () {
                    window.print();
                });
            }
        });
    </script>

</html>
