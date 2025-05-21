<!DOCTYPE>
<html>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <header>
        <title>Ordem de Serviço</title>
    </header>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            height: 100%;
            color: #333;
            /*font-size: 12px;*/
            text-transform: uppercase;
        }

        h3 {
            font-size: 20px;
            margin: 10px 0;
        }

        .header {
            display: flex;
            width: 100%;
            align-items: center;
        }

        .img-area {
            /*background: #f1f1f1;*/
            text-align: center;
            padding: 0 10px;
            clip-path: polygon(0% 0%, 100% 0%, 92% 100%, 0% 100%);
        }

        .title {
            width: 100%;
            height: 53px;
            background-color: red;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            line-height: 53px;
            clip-path: polygon(2.7% 0, 100% 0, 100% 100%, 0% 100%);
            text-transform: uppercase;
        }

        .initial-information {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            /*align-items: center;*/
            gap: 10px;
            padding: 5px;
            border-radius: 1px;
            border: 1px dashed #c1c1c1;
            font-size: 12px;
        }

        .data {
            display: flex;
            justify-content: space-between;
            gap: 10px;
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
            font-weight: 600;
            font-size: 12px;
        }

        tbody td {
            text-align: left;
            padding: 5px;
            font-size: 12px;
        }

        tr {
            border-bottom: 1px solid #dadada;
        }

        small {
            font-size: 12px;
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
                <h4>ORDEM DE SERVIÇO N° {{ $numberOs }}</h4>
            </div>
        </article>

        <h4 style="margin-top: 20px">Informações do Paciente</h4>
        <h5>DETALHES</h5>

        <article class="initial-information">
            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">Nome: </span>
                    <span style="font-weight: 500">{{ $customer->full_name ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">CPF: </span>
                    <span style="font-weight: 500">{{ $customer->cpf ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">RG: </span>
                    <span style="font-weight: 500">{{ $customer->rg ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Nascimento: </span>
                    <span style="font-weight: 500">{{ $customer->birth_date ? formatDate($customer->birth_date) : '-' }}</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">Idade: </span>
                    <span style="font-weight: 500">{{ $customer->birth_date ? calculateAge($customer->birth_date) : '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Email: </span>
                    <span style="font-weight: 500">{{ $customer->email ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Contato: </span>
                    <span style="font-weight: 500">{{ $customer->phone_primary ?? '-' }}</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">Convênio: </span>
                    <span style="font-weight: 500">{{ $customer->agreements->agreement ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Nº do Convênio: </span>
                    <span style="font-weight: 500">{{ $customer->number_agreement ?? '-' }}</span>
                </div>
            </div>
        </article>

        <h5>ENDEREÇO</h5>
        <article class="initial-information">
            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">CEP: </span>
                    <span style="font-weight: 500">{{ $address->cep ?? '-'}}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Cidade: </span>
                    <span style="font-weight: 500">{{ $address->city ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">UF: </span>
                    <span style="font-weight: 500">{{ $address->uf ?? '-' }}</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">Rua: </span>
                    <span style="font-weight: 500">{{ $address->street ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Número: </span>
                    <span style="font-weight: 500">{{ $address->number ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Bairro: </span>
                    <span style="font-weight: 500">{{ $address->neighborhood ?? '-' }}</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column">
                <div>
                    <span style="color:#6b7280">Referência: </span>
                    <span style="font-weight: 500">{{ $address->reference ?? '-' }}</span>
                </div>
                <div>
                    <span style="color:#6b7280">Complemento: </span>
                    <span style="font-weight: 500">{{ $address->complement ?? '-' }}</span>
                </div>
            </div>
        </article>

        <h4>LABORATÓRIO</h4>

        <article class="initial-information">
            <div style="display: flex;">
                <span style="color:#6b7280">Laboratório:</span>
                <span style="font-weight: 500">{{ $laboratory }}</span>
            </div>
            <div style="display: flex;">
                <span style="color:#6b7280">Data do Laboratório:</span>
                <span style="font-weight: 500">{{ formatDate($delivery) }}</span>
            </div>
            <div style="display: flex;">
                <span style="color:#6b7280">Data da Entrega:</span>
                <span style="font-weight: 500">{{ formatDate($delivery) }}</span>
            </div>
        </article>

        <h4>OBSERVAÇÕES</h4>
        <p class="initial-information">{{ $observation }}</p>

        <h4>Informações do Grau</h4>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Esférico</th>
                    <th>Cilindro</th>
                    <th>Eixo</th>
                    <th>DNP</th>
                    <th>Altura</th>
                    <th>Adição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>OE</th>
                    <td>{{ $serviceOrder->spherical_left ?? '-' }}</td>
                    <td>{{ $serviceOrder->cylindrical_left ?? '-' }}</td>
                    <td>{{ $serviceOrder->axis_left ?? '-' }}</td>
                    <td>{{ $serviceOrder->dnp_left ?? '-' }}</td>
                    <td>{{ $serviceOrder->height_left ?? '-' }}</td>
                    <td>{{ $serviceOrder->addition_left ?? '-' }}</td>
                </tr>
                <tr>
                    <th>OD</th>
                    <td>{{ $serviceOrder->spherical_right ?? '-' }}</td>
                    <td>{{ $serviceOrder->cylindrical_right ?? '-' }}</td>
                    <td>{{ $serviceOrder->axis_right ?? '-' }}</td>
                    <td>{{ $serviceOrder->dnp_right ?? '-' }}</td>
                    <td>{{ $serviceOrder->height_right ?? '-' }}</td>
                    <td>{{ $serviceOrder->addition_right ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <small>
            <strong>OE:</strong> OLHO ESQUERDO -
            <strong>OD:</strong> OLHO DIREITO -
            <strong>DPN:</strong> DISTÂNCIA NASO-PUPILAR
        </small>

        <div style="margin: 20px 0"></div>

        <table>
            <thead>
            <tr>
                <th rowspan="2">Ponte</th>
                <th rowspan="2">HORIZONTAL MAIOR</th>
                <th rowspan="2">VERTICAL MAIOR</th>
                <th rowspan="2">DIAGONAL MAIOR</th>
                <th colspan="2">DNP V</th>
                <th colspan="2">ALT</th>
            </tr>
            <tr>
                <th>OE</th>
                <th>OD</th>
                <th>OE</th>
                <th>OD</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $serviceOrder->bridge ?? '-'}}</td>
                <td>{{ $serviceOrder->larger_horizontal ?? '-'}}</td>
                <td>{{ $serviceOrder->larger_vertical ?? '-'}}</td>
                <td>{{ $serviceOrder->larger_diagonal ?? '-'}}</td>
                <td>{{ $serviceOrder->dnp_v_left ?? '-'}}</td>
                <td>{{ $serviceOrder->dnp_v_right ?? '-'}}</td>
                <td>{{ $serviceOrder->alt_left ?? '-' }}</td>
                <td>{{ $serviceOrder->alt_right ?? '-' }}</td>
            </tr>
            </tbody>
        </table>
        <small>
            <strong>DNP V:</strong> DISTÂNCIA NASO-PUPILAR -
            <strong>ALT</strong> ALTURA -
            <strong>OE:</strong> OLHO ESQUERDO -
            <strong>OD:</strong> OLHO DIREITO
        </small>

        <div style="margin: 20px 0"></div>
        <h4>DADOS DA VENDA</h4>

        <article class="initial-information">
            <div style="display: flex;">
                <span style="color:#6b7280">VENDEDOR:</span>
                <span style="font-weight: 500">{{ $seller }}</span>
            </div>
            <div style="display: flex;">
                <span style="color:#6b7280">NÚMERO:</span>
                <span style="font-weight: 500">{{ $numberSale }}</span>
            </div>
            <div style="display: flex;">
                <span style="color:#6b7280">DATA/HORA:</span>
                <span style="font-weight: 500">{{ $createdAt }}</span>
            </div>
        </article>

        <h5>DETALHES</h5>

        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th style="text-align: center">QTD</th>
                    <th>Descrição</th>
                    <th>Valor Unit.</th>
                    <th>Desc. (R$)</th>
                    <th>Desc. (%)</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($frames))
                    @foreach($frames as $frame)
                        <tr>
                            <td>Armação</td>
                            <td style="text-align: center">{{ $frame->pivot->quantity }}</td>
                            <td>
                                <strong>Código:</strong>{{ $frame->code ?? '-' }}
                                <strong>Tamanho:</strong>{{ $frame->size ?? '-' }}
                                <strong>Ponte:</strong>{{ $frame->bridge ?? '-' }}
                                <strong>Haste:</strong>{{ $frame->haste ?? '-' }}
                            </td>
                            <td>{{ formatReal($frame->price) }}</td>
                            <td>{{ $frame->pivot->discount_value ? formatReal($frame->pivot->discount_value) : '-' }}</td>
                            <td>{{ $frame->pivot->discount_percentage ? formatPercentage($frame->pivot->discount_percentage) : '-' }}</td>
                            <td>{{ formatReal($frame->pivot->total) }}</td>
                        </tr>
                    @endforeach
                @endif

                @if(isset($lenses))
                    @foreach($lenses as $lens)
                        <tr>
                            <td>Lente</td>
                            <td style="text-align: center">{{ $lens->pivot->quantity }}</td>
                            <td>
                                <strong>Tipo:</strong>{{ $lens->typeLens->type_lens }}
                                <strong>Índice:</strong>{{ $lens->indices->index ?? '' }}
                                <strong>Tratamento:</strong>{{ $lens->treatment->treatment }}
                            </td>
                            <td>{{ formatReal($lens->price) }}</td>
                            <td>{{ $lens->pivot->discount_value ? formatReal($lens->pivot->discount_value) : '-' }}</td>
                            <td>{{ $lens->pivot->discount_percentage ? formatPercentage($lens->pivot->discount_percentage) : '-' }}</td>
                            <td>{{ formatReal($lens->pivot->total) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right">Valor total da venda</th>
                    <td>{{ $serviceOrder->sale->total_amount ? formatReal($serviceOrder->sale->total_amount) : '-' }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin: 20px 0"></div>
        <h5>PAGAMENTO</h5>

        <table>
            <thead>
                <tr>
                    <th>FORMA DE PAGAMENTO</th>
                    <th>Valor R$</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cartão de Crédito</td>
                    <td>R$ 1020 (2x 510,00)</td>
                </tr>
                <tr>
                    <td>Pix</td>
                    <td>R$ 99</td>
                </tr>
            </tbody>
        </table>

        <div style="margin: 20px 0"></div>

{{--        @php--}}

{{--            dd($payment->paymentMethod);--}}

{{--        @endphp--}}

{{--        @dd('parou aqui');--}}
{{--        --}}{{-- Pagamento no Crediário da Loja --}}
        <table>
            <thead>
                <tr>
                    <th>Parcela 1</th>
                    <th>Parcela 2</th>
                    <th>Parcela 3</th>
                    <th>Parcela 4</th>
                    <th>Parcela 5</th>
                    <th>Parcela 6</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>26-03-2025</td>
                    <td>26-03-2025</td>
                    <td>26-03-2025</td>
                    <td>26-03-2025</td>
                    <td>26-03-2025</td>
                    <td>26-03-2025</td>
                </tr>
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

        function formatDate(string $date, string $format='d-m-Y'): string {
            return Carbon::parse($date)->format($format);
        }

        function calculateAge(string $birthDate): int {
            return Carbon::parse($birthDate)->age;
        }

        function formatReal(string $value): string {
            $value = floatval($value);
            return 'R$ ' . number_format($value, 2, ',', '.');
        }

        function formatPercentage($value): string {
            return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.') . '%';
        }
    @endphp
</html>
