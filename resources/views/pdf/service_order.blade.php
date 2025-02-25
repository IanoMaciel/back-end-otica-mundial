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
            font-family: Arial, sans-serif;
        }

        .a4 {
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 5px;
            font-size: 12px;
        }

        h3 {
            font-size: 20px;
            margin: 10px 0;
        }

        .header {
            display: flex;
            align-items: center;
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
            /*text-transform: uppercase;*/
            clip-path: polygon(10% 0, 100% 0, 100% 100%, 0% 100%);
        }

        .initial-information {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .observations {
            padding: 10px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .customer-information {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .data {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        thead {
            background-color: #e3e3e3;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 2px;
            text-align: left;
        }
    </style>

    <body class="a4">
        <article class="header">
            <img
                src="{{ asset('images/logo.svg') }}"
                alt="logo"
                width="171px"
                height="53px"
            />
            <div class="title">
                <h4>Ordem de Serviço | {{ $serviceOrder->number_os }}</h4>
            </div>
        </article>

        <h3>Informações da Venda</h3>
        <article class="initial-information">
            <div><strong>Vendedor:</strong> <span>{{ $serviceOrder->sale->user->first_name  }}</span></div>
            <div><strong>Nº da Venda:</strong> <span>{{ $serviceOrder->sale->number_ata }}</span></div>
            <div><strong>Nº da OS:</strong> <span>{{ $serviceOrder->number_os }}</span></div>
            <div><strong>Data/Hora da venda:</strong> <span>{{ $serviceOrder->sale->created_at }}</span></div>
        </article>

        <h3>Laboratório</h3>

        <article class="initial-information">
            @foreach($serviceOrder->sale->lenses as $item)
                <div><strong>Laboratório:</strong> <span></span>{{ $item->laboratory->laboratory }}</div>
            @endforeach
            <div><strong>Data do Lab:</strong> <span>01/01/2025</span></div>
            <div><strong>Data da Entrega:</strong> <span>{{ $serviceOrder->delivery }}</span></div>
        </article>

        <h3>Observações</h3>
        <p class="observations">
            {{ $serviceOrder->observation ?? '-'}}
        </p>

        <h3>Informações do Paciente</h3>

        <article class="customer-information">
            <div class="data">
                <div><strong>Nome: </strong> <span>{{ $serviceOrder->sale->customer->full_name ?? '-'}}</span></div>
                <div><strong>CPF: </strong> <span>{{ $serviceOrder->sale->customer->cpf ?? '-'}}</span></div>
                <div><strong>RG: </strong> <span>{{ $serviceOrder->sale->customer->rg ?? '-'}}</span></div>
                <div><strong>Nascimento: </strong> <span>{{ $serviceOrder->sale->customer->birth_date ?? '-' }}</span></div>
                <div><strong>Idade: </strong> <span>{{ $serviceOrder->sale->customer->birth_date ?? '-' }}</span></div>
                <div><strong>Convênio: </strong> <span>{{ $serviceOrder->sale->customer->agreements->agreement ?? '-'}}</span></div>
                <div><strong>Email: </strong> <span>{{ $serviceOrder->sale->customer->email ?? '-'}}</span></div>
                <div><strong>Contato: </strong> <span>{{ $serviceOrder->sale->customer->phone_primary ?? '-'}}</span></div>
            </div>

            <hr style="color: #dddddd;"/>

            <div class="data">
                <div><strong>CEP: </strong> <span>{{ $serviceOrder->sale->customer->address->cep ?? '-'}}</span></div>
                <div><strong>Cidade: </strong> <span>{{ $serviceOrder->sale->customer->address->city ?? '-' }}</span></div>
                <div><strong>UF: </strong> <span>{{ $serviceOrder->sale->customer->address->uf ?? '-' }}</span></div>
                <div><strong>Rua: </strong> <span>{{ $serviceOrder->sale->customer->address->street ?? '-' }}</span></div>
                <div><strong>Número: </strong> <span>{{ $serviceOrder->sale->customer->address->number ?? '-' }}</span></div>
                <div><strong>Bairro: </strong> <span>{{ $serviceOrder->sale->customer->address->neighborhood ?? '-' }}</span></div>
                <div><strong>Referência: </strong> <span>{{ $serviceOrder->sale->customer->address->reference ?? '-' }}</span></div>
                <div><strong>Complemento: </strong> <span>{{ $serviceOrder->sale->customer->address->complement ?? '-' }}</span></div>
            </div>

        </article>

        <h3>Informações do Grau</h3>

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

        <table>
            <thead>
            <tr>
                <th rowspan="2">Ponte</th>
                <th rowspan="2">Horizontal Maior</th>
                <th rowspan="2">Vertical Maior</th>
                <th rowspan="2">Diagonal Maior</th>
                <th colspan="2" style="text-align: center">DNP V</th>
                <th colspan="2" style="text-align: center">ALT</th>
            </tr>
            <tr>
                <th style="text-align: center">OE</th>
                <th style="text-align: center">OD</th>
                <th style="text-align: center">OE</th>
                <th style="text-align: center">OD</th>
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

        <h3>Descrição da venda</h3>

        @php
            function formatReal(string $value): string {
                $value = floatval($value);
                return 'R$ ' . number_format($value, 2, ',', '.');
            }
        @endphp


        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>QTD</th>
                    <th>Descrição da Mercadoria</th>
                    <th>Valor Unit.</th>
                    <th>Desconto</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @foreach($serviceOrder->sale->frames as $frame)
                <tr>
                    <td>Armação</td>
                    <td>{{ $frame->pivot->quantity }}</td>
                    <td> {{$frame->code . ' ' . $frame->color . ' ' . $frame->size . ' ' . $frame->haste . ' ' . $frame->bridge . ' ' . $frame->brands->brand}}</td>
                    <td>{{ formatReal($frame->pivot->price) }}</td>
                    <td>{{ $frame->pivot->discount . '%' }} ({{ formatReal($frame->pivot->price * ($frame->pivot->discount/100))}})</td>
                    <td>{{ formatReal($frame->pivot->total) }}</td>
                </tr>
            @endforeach
            @foreach($serviceOrder->sale->lenses as $lens)
                <tr>
                    <td>Lente</td>
                    <td>{{ $lens->pivot->quantity }}</td>
                    <td> {{$lens->name_lens}}</td>
                    <td>{{ formatReal($lens->pivot->price) }}</td>
                    <td>{{ $lens->pivot->discount . '%' }} ({{ formatReal($lens->pivot->price * ($lens->pivot->discount/100))}})</td>
                    <td>{{ formatReal($lens->pivot->total) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right">Valor total da venda</th>
                    <td>{{ formatReal($serviceOrder->sale->total_amount) }}</td>
                </tr>
            </tfoot>
        </table>

        <h3>Informações do Pagamento</h3>

        @php
            $paymentMethod = $serviceOrder->sale->paymentMethod->payment_method ?? null;
            $creditCard = $serviceOrder->sale->creditCards->first();
        @endphp

        <article>
            <div><strong>Método de Pagamento: </strong><span>{{ $serviceOrder->sale->paymentMethod->payment_method }}</span></div>
        </article>

        @if($paymentMethod === 'Cartão de Crédito')
            <table>
                <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th>Valor da Venda</th>
                    <th>Valor no Crédito</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $serviceOrder->sale->paymentMethod->payment_method }}</td>
                    <td>{{ formatReal($serviceOrder->sale->total_amount) }}</td>
                    <td>{{ formatReal($creditCard?->total_amount) .' ('. $creditCard->card_id . ' X ' . formatReal($creditCard?->total_amount/$creditCard->card_id) .')' }}</td>
                </tr>
                </tbody>
            </table>
        @endif

        <h3>Crediário da Loja</h3>
        <table>
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Entrada</th>
                    <th>À Receber</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1390,00</td>
                    <td>390,00</td>
                    <td>1000,00 (200 x 5)</td>
                </tr>
            </tbody>
        </table>

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
                    <td>01/01/2025</td>
                    <td>01/02/2025</td>
                    <td>01/03/2025</td>
                    <td>01/04/2025</td>
                    <td>01/05/2025</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
