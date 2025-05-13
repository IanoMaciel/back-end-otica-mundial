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
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Nunito', sans-serif;
            }

            body {
                height: 100%;
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

            tr {
                border-bottom: 1px solid #dadada;
            }

            .nowrap {
                white-space: nowrap;
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
                margin-top: 20px;
                display: flex;
                justify-content: space-between;

                font-size: 12px;

                div {
                    display: flex;
                    gap: 10px;
                };

                /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/

                border: 1px dashed #c1c1c1;

                width: 100%;
                padding: 10px;
                text-transform: uppercase;
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
                <span>ÓTICAS MUNDIAL - AV. ARMINDO AUZIER Nº 1544 - SANTO ANTÔNIO - ITACOATIARA</span>
                <span>CNPJ: 08.912.557/0001-00</span>
                <span>(92) 99351-6311 </span>
            </div>
        </article>

        <article class="customer">
            <div style="display: flex; flex-direction: column; width: 100%">
                <div style="display: flex; gap: 10px">
                    <div>
                        <span style="color:#6b7280">NOME:</span>
                        <span style="font-weight: 500">IANO DE BENEDITO MACIEL</span>
                    </div>
                    <div>
                        <span style="color:#6b7280">DATA DE NASCIMENTO:</span>
                        <span style="font-weight: 500">07/04/2000</span>
                    </div>
                    <div>
                        <span style="color:#6b7280">IDADE:</span>
                        <span style="font-weight: 500">25 ANOS</span>
                    </div>
                </div>

                <div style="display: flex; gap: 10px">
                    <div>
                        <span style="color:#6b7280">CPF:</span>
                        <span style="font-weight: 500">000.000.000-00</span>
                    </div>

                    <div>
                        <span style="color:#6b7280">RG:</span>
                        <span style="font-weight: 500">2701672-2</span>
                    </div>

                    <div>
                        <span style="color:#6b7280">CONVÊNIO:</span>
                        <span style="font-weight: 500">fulano de tal</span>
                        <span style="font-weight: 500">asdasda</span>
                    </div>
                </div>

                <div style="display: flex; gap: 10px">
                    <div>
                        <span style="color:#6b7280">CONTATO:</span>
                        <span style="font-weight: 500">(92) 98633-8449</span>
                    </div>

                    <div>
                        <span style="color:#6b7280">E-MAIL:</span>
                        <span style="font-weight: 500">iano@iano.com</span>
                    </div>
                </div>

                <div>
                    <span style="color:#6b7280">ENDEREÇO:</span>
                    <span style="font-weight: 500">RUA ADAMASTOR DE FIGUEIREDO, 3147, JAUARY I, 69104.208, ITACOATIARA-AMAZONAS</span>
                </div>
            </div>
        </article>

        <h1 style="margin: 20px 0;">RECIBO DE VENDA</h1>

        <table>
            <thead>
                <tr>
                    <th>ITEM</th>
                    <th>CATEGORIA</th>
                    <th>DESCRIÇÃO</th>
                    <th class="nowrap">QTD.</th>
                    <th class="nowrap">V. UNI.</th>
                    <th class="nowrap">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>ARMAÇÃO</td>
                    <td style="text-transform: uppercase">uisque commodo quis erat sed pretium. Curabitur sodales egestas diam, vitae hendrerit lorem venenatis et.</td>
                    <td class="nowrap">2</td>
                    <td class="nowrap">R$ 988,00</td>
                    <td class="nowrap">R$ 1.976,00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>LENTE</td>
                    <td style="text-transform: uppercase">uisque commodo quis erat sed pretium. Curabitur sodales egestas diam, vitae hendrerit lorem venenatis et.</td>
                    <td class="nowrap">1</td>
                    <td class="nowrap">R$ 700,00</td>
                    <td class="nowrap">R$ 700,00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>ACESSORÓRIO</td>
                    <td style="text-transform: uppercase">uisque commodo quis erat sed pretium. Curabitur sodales egestas diam, vitae hendrerit lorem venenatis et.</td>
                    <td class="nowrap">1</td>
                    <td class="nowrap">R$ 700,00</td>
                    <td class="nowrap">R$ 700,00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>R$ 2.676,00</strong></td>
                </tr>
            </tfoot>
        </table>
        <small>
            <strong>QTD:</strong> QUANTIDADE -
            <strong>V. UNITÁRIO:</strong> VALOR UNITÁRIO
        </small>
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

