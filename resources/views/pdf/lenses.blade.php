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
                margin: 5px;
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

            tfoot td, tbody td {
                text-align: left;
                padding: 8px;
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

            .nowrap {
                white-space: nowrap;
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
                <h4>ESTOQUE DE LENTES</h4>
            </div>
        </article>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>CÓDIGO</th>
                <th>TIPO</th>
                <th>INDÍCE</th>
                <th>ANT.</th>
                <th>FILTRO</th>
                <th>FOT.</th>
                <th>NOME</th>
                <th>ESF.</th>
                <th>CIL.</th>
                <th>ADI.</th>

                <th>SUR.</th>
                <th>DIÂ.</th>
                <th>ALT.</th>


                <th>CUSTO</th>
                <th>LUCRO</th>
                <th class="nowrap">PREÇO</th>
                <th class="nowrap">CRIADO</th>
                <th class="nowrap">ATU.</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($lenses as $lens)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lens->barcode ?? '-' }}</td>
                    <td>{{ $lens->typeLens->type_lens ?? '-' }}</td>
                    <td>{{ $lens->index }}</td>
                    <td>{{ $lens->treatment->treatment ?? '-' }}</td>
                    <td>{{ $lens->filter ? 'Sim' : 'Não' }}</td>
                    <td>{{ $lens->sensitivity->sensitivity ?? '-' }}</td>
                    <td>{{ $lens->name_lens ?? '-'}}</td>
                    <td class="nowrap">{{ $lens->spherical_start ?? '-' }} / {{ $lens->spherical_end ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->cylindrical_start ?? '-' }} / {{ $lens->cylindrical_end ?? '-' }} </td>
                    <td class="nowrap">{{ $lens->addition_start ?? '-' }} / {{ $lens->addition_end ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->surfacing ? 'DIGITAL' : '-' }}</td>
                    <td class="nowrap">{{ $lens->diameter ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->height ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->purchase_value ? formatReal($lens->purchase_value) : '-' }}</td>
                    <td class="nowrap">{{ $lens->profit ? formatPercentage($lens->profit) : '-'}}</td>
                    <td class="nowrap">{{ $lens->price ? formatReal($lens->price) : '-' }}</td>

                    <td class="nowrap">{{ $lens->created_at ? formatDate($lens->created_at) : '-' }}</td>
                    <td class="nowrap">{{ $lens->updated_at ? formatDate($lens->updated_at) : '-' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="19">
                        <strong>ANT:</strong> ANTIRREFLEXO -
                        <strong>FOT:</strong> FOTOSSENSIBILIDADE -
                        <strong>ESF:</strong> ESFÉRICO -
                        <strong>CIL:</strong> CILINDRO -
                        <strong>ADI:</strong> ADIÇÃO -
                        <strong>SUR:</strong> SURFAÇAGEM -
                        <strong>DIÂ:</strong> DIÂMETRO -
                        <strong>ALT:</strong> ALTURA -
                        <strong>ATU:</strong> ATUALIZADO
                </tr>
            </tfoot>
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
            return Carbon::parse($date)->format($format);
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
