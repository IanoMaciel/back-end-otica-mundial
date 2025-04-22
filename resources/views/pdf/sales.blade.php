<!DOCTYPE html>
<html>
    <head>
        <title>Estoque de Lentes</title>

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
                display: flex;
                /*justify-content: center;*/
                flex-direction: column;
                align-items: center;
            }

            .a4 {
                width: 210mm;
                height: 297mm;
                background: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 5px;
                font-size: 13px;
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
                flex-direction: column;
                align-items: center;
                justify-content: center;

                background-color: red;
                color: white;
                font-size: 12px;
                font-weight: 600;
                text-align: center;
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
                /*margin-top: 20px;*/
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .action {
                width: 100% ;
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

            .customer {
                border: 1px solid #6b7280;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                div {
                    display: flex;
                    gap: 10px;
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
    <body class="a4">
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
                <span>ÓTICAS MUNDIAL - AV. ARMINDO AUZIER Nº 1544 - SANTO ANTÔNIO - ITACOATIARA</span>
                <span>CNPJ: 08.912.557/0001-00</span>
                <span>(92) 99351-6311 </span>
            </div>
        </article>

        <article class="customer">
            <div>
                <span style="color:#6b7280">NOME:</span>
                <span style="font-weight: bold">Iano de Benedito Maciel</span>
            </div>
            <div>
                <span style="color:#6b7280">CPF:</span>
                <span style="font-weight: bold">000.000.000-00</span>
            </div>
            <div>
                <span style="color:#6b7280">RG:</span>
                <span style="font-weight: bold">Iano de Benedito Maciel</span>
            </div>
            <div>
                <span style="color:#6b7280">CONTATO:</span>
                <span style="font-weight: bold">000.000.000-00</span>
            </div>
            <div>
                <span style="color:#6b7280">E-MAIL:</span>
                <span style="font-weight: bold">iano@iano.com</span>
            </div>
            <div>
                <span style="color:#6b7280">CONVÊNIO:</span>
                <span style="font-weight: bold">fulano de tal</span>
                <span style="font-weight: bold">asdasda</span>
            </div>
        </article>

        <h1>RECIBO DE VENDA</h1>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>CÓDIGO ARMAÇÃO</th>
                <th>COR</th>
                <th>FORNECEDOR</th>
                <th>MARCA</th>
                <th>MATERIAL</th>
            </tr>
            </thead>
            <tbody>
        {{--    @foreach ($frames as $frame)--}}
        {{--        <tr>--}}
        {{--            <td>{{ $frame->id }}</td>--}}
        {{--            <td>{{ $frame->code }} {{ $frame->size}}/{{ $frame->haste }} {{ $frame->bridge }}</td>--}}
        {{--            <td>{{ $frame->color }}</td>--}}
        {{--            <td>{{ $frame->suppliers->name }}</td>--}}
        {{--            <td>--}}
        {{--                {{ $frame->brands->brand }}--}}
        {{--                @if ($frame->brands->discount)--}}
        {{--                    - {{ $frame->brands->discount }}--}}
        {{--                @endif--}}
        {{--            </td>--}}
        {{--            <td>{{ $frame->materials->material }}</td>--}}
        {{--            <td>{{ $frame->amount }}</td>--}}
        {{--            <td>{{ $frame->price }}</td>--}}
        {{--            <td>{{ $frame->purchase_value }}</td>--}}
        {{--            <td>{{ $frame->discount }}</td>--}}
        {{--            <td>{{ $frame->profit }}</td>--}}
        {{--        </tr>--}}
        {{--    @endforeach--}}
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

        function formatPercentage($value) {
            return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.') . '%';
        }

    @endphp
</html>

