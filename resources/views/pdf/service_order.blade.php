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
            width: 210mm;
            height: 297mm;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 5px;
            font-size: 13px;
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
            background: #e3e3e3;
            text-align: center;
            padding: 0 10px;
            clip-path: polygon(0% 0%, 100% 0%, 92% 100%, 0% 100%);
        }

        .title {
            width: 80%;
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
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 2px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .observations {
            padding: 10px;
            border-radius: 2px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .customer-information {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            border-radius: 2px;
            border: 1px solid #ccc;
            background: #e3e3e3;
        }

        .data {
            display: flex;
            justify-content: space-between;
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
            padding: 5px;
            text-align: left;
        }
    </style>

    <body class="a4">

        @php
            function formatDate(string $date, string $format='d-m-Y'): string {
                return \Carbon\Carbon::parse($date)->format($format);
            }

            function calculateAge(string $birthDate): int {
                return \Carbon\Carbon::parse($birthDate)->age;
            }

            function formatReal(string $value): string {
                $value = floatval($value);
                return 'R$ ' . number_format($value, 2, ',', '.');
            }
        @endphp

        <article class="header">
            <div class="img-area">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="171px" height="53px"/>
            </div>
            <div class="title">
                <h4>Ordem de Serviço - {{ $numberOs }}</h4>
            </div>
        </article>

        <h3>Dados da Venda</h3>

        <article class="initial-information">
            <div><strong>Vendedor:</strong> <span>{{ $seller }}</span></div>
            <div><strong>Nº da Venda:</strong> <span>{{ $numberSale }}</span></div>
            <div><strong>Nº da OS:</strong> <span>{{ $numberOs }}</span></div>
            <div><strong>Data/Hora da venda:</strong> <span>{{ $createdAt }}</span></div>
        </article>

        <h3>Laboratório</h3>

        <article class="initial-information">
            <div><strong>Laboratório:</strong> <span>{{ $laboratory }}</span></div>
            <div><strong>Data do Laboratório:</strong> <span>{{ formatDate($delivery) }}</span></div>
            <div><strong>Data da Entrega:</strong> <span>{{ formatDate($delivery) }}</span></div>
        </article>

        <h3>Observações</h3>
        <p class="observations">{{ $observation }}</p>

        <h3>Informações do Paciente</h3>

        <article class="customer-information">
            <div class="data">
                <div style="display: flex; flex-direction: column">
                    <div><strong>Nome: </strong> <span>{{ $customer->full_name }}</span></div>
                    <div><strong>CPF: </strong> <span>{{ $customer->cpf ?? '-' }}</span></div>
                    <div><strong>RG: </strong> <span>{{ $customer->rg ?? '-' }}</span></div>
                    <div><strong>Nascimento: </strong> <span>{{ formatDate($customer->birth_date) ?? '-' }}</span></div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <div><strong>Idade: </strong> <span>{{ calculateAge($customer->birth_date) ?? '-' }}</span></div>
                    <div><strong>Email: </strong> <span>{{ $customer->email ?? '-' }}</span></div>
                    <div><strong>Contato: </strong> <span>{{ $customer->phone_primary ?? '-' }}</span></div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <div><strong>Convênio: </strong> <span>{{ $customer->agreements->agreement ?? '-' }}</span></div>
                    <div><strong>Nº do Convênio: </strong> <span>{{ $customer->number_agreement ?? '-' }}</span></div>
                </div>
            </div>

            <hr style="color: #dddddd;"/>

            <div class="data">
                <div style="display: flex; flex-direction: column">
                    <div><strong>CEP: </strong> <span>{{ $address->cep ?? '-'}}</span></div>
                    <div><strong>Cidade: </strong> <span>{{ $address->city ?? '-' }}</span></div>
                    <div><strong>UF: </strong> <span>{{ $address->uf ?? '-' }}</span></div>
                </div>
                <div style="display: flex; flex-direction: column">
                    <div><strong>Rua: </strong> <span>{{ $address->street ?? '-' }}</span></div>
                    <div><strong>Número: </strong> <span>{{ $address->number ?? '-' }}</span></div>
                    <div><strong>Bairro: </strong> <span>{{ $address->neighborhood ?? '-' }}</span></div>
                </div>
                <div style="display: flex; flex-direction: column">
                    <div><strong>Referência: </strong> <span>{{ $address->reference ?? '-' }}</span></div>
                    <div><strong>Complemento: </strong> <span>{{ $address->complement ?? '-' }}</span></div>
                </div>
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

        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th style="text-align: center">QTD</th>
                    <th>Descrição da Mercadoria</th>
                    <th>Valor Unit.</th>
                    <th>Desconto</th>
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
                                <strong>Haste:</strong>{{ $frame->haste ?? '-' }}
                                <strong>Cor:</strong>{{ $frame->color ?? '-' }}
                                <strong>Tamanho:</strong>{{ $frame->size ?? '-' }}
                                <strong>Ponte:</strong>{{ $frame->bridge ?? '-' }}
                            </td>
                            <td>{{ formatReal($frame->price) }}</td>
                            <td>Add mais tarde</td>
                            <td>Add mais tarde</td>
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
                                <strong>Índice:</strong>{{ $lens->index }}
                                <strong>Tratamento:</strong>{{ $lens->treatment->treatment }}
                            </td>
                            <td>{{ formatReal($lens->price) }}</td>
                            <td>Add mais tarde</td>
                            <td>Add mais tarde</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right">Valor total da venda</th>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>

        @php
            dd('parou aqui');
        @endphp

        <h3>Informações do Pagamento</h3>

{{--        @php--}}
{{--            $paymentMethod = $serviceOrder->sale->paymentMethod->payment_method ?? null;--}}
{{--            $creditCard = $serviceOrder->sale->creditCards->first();--}}
{{--        @endphp--}}

{{--        @if ($paymentMethod === 'Cartão de Crédito')--}}
{{--            <table>--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Forma de Pagamento</th>--}}
{{--                    <th>Valor da Venda</th>--}}
{{--                    <th>Valor no Crédito</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>{{ $serviceOrder->sale->paymentMethod->payment_method }}</td>--}}
{{--                    <td>{{ formatReal($serviceOrder->sale->total_amount) }}</td>--}}
{{--                    <td>{{ formatReal($creditCard->total_amount) .' ('. $creditCard->card_id . ' X ' . formatReal($creditCard->total_amount/$creditCard->card_id) .')' }}</td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @elseif ($paymentMethod === 'Pix' || $paymentMethod === 'Dinheiro' || $paymentMethod === 'Cartão de Débito')--}}
{{--            <table>--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Forma de Pagamento</th>--}}
{{--                    <th>Valor da Venda</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>{{ $serviceOrder->sale->paymentMethod->payment_method }}</td>--}}
{{--                    <td>{{ formatReal($serviceOrder->sale->total_amount) }}</td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @elseif ($paymentMethod === 'Crediário da Loja')--}}
{{--            @php--}}
{{--                $query = $serviceOrder->sale->paymentCredits->first();--}}
{{--                $formPayment = \App\Models\FormPayment::query()->find($query->form_payment_id);--}}
{{--                $downPayment = $query->down_payment;--}}

{{--                foreach ($query->installments as $installment) {--}}
{{--                }--}}

{{--            @endphp--}}
{{--            <table>--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Forma de Pagamento</th>--}}
{{--                    <th>Entrada</th>--}}
{{--                    <th>À Receber</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>{{ $formPayment->form_payment }}</td>--}}
{{--                    <td>{{ formatReal($downPayment) }}</td>--}}
{{--                    <td>{{ formatReal($query->total_amount - $downPayment) }} ({{$query->installments->count()}} X--}}
{{--                        {{ formatReal($query->installments->first()->amount) }})</td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}

{{--            <table>--}}
{{--                    <thead>--}}
{{--                        <tr>--}}
{{--                            @foreach($query->installments as $item)--}}
{{--                                <th>Pacerla {{ $item->installment }}</th>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        <tr>--}}
{{--                            @foreach($query->installments as $item)--}}
{{--                                <td>--}}
{{--                                    <strong>Valor:</strong>  {{ formatReal($item->amount) }} <br>--}}
{{--                                    <strong>Vencimento:</strong>{{ $item->due_date }}--}}
{{--                                </td>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                    </tbody>--}}
{{--            </table>--}}
{{--        @endif--}}
    </body>
</html>
