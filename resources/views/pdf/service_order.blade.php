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
            <div><strong>Data da Entrega:</strong> <span>20/01/2025</span></div>
        </article>

        <article>
            <h3>Observações</h3>
            <p class="observations">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        </article>

        <h3>Informações do Paciente</h3>
        <article class="customer-information">
            <div class="data">
                <div><strong>Nome: </strong> <span>{{ $serviceOrder->sale->customer->full_name }}</span></div>
                <div><strong>CPF: </strong> <span>{{ $serviceOrder->sale->customer->cpf }}</span></div>
                <div><strong>RG: </strong> <span>{{ $serviceOrder->sale->customer->rg }}</span></div>
                <div><strong>Nascimento: </strong> <span>{{ $serviceOrder->sale->customer->birth_date ?? '-' }}</span></div>
                <div><strong>Idade: </strong> <span>{{ $serviceOrder->sale->customer->birth_date ?? '-' }}</span></div>
                <div><strong>Convênio: </strong> <span>{{ $serviceOrder->sale->customer->agreements->agreement }}</span></div>
                <div><strong>Email: </strong> <span>{{ $serviceOrder->sale->customer->email }}</span></div>
                <div><strong>Contato: </strong> <span>{{ $serviceOrder->sale->customer->phone_primary }}</span></div>
            </div>

            <hr style="color: #dddddd;"/>

            <div class="data">
                <div><strong>CEP: </strong> <span>69.104-208</span></div>
                <div><strong>Cidade: </strong> <span>Itacoatiara</span></div>
                <div><strong>UF: </strong> <span>AM</span></div>
                <div><strong>Rua: </strong> <span>Rua Adamastor de Figueiredo</span></div>
                <div><strong>Número: </strong> <span>3147</span></div>
                <div><strong>Bairro: </strong> <span>Jauary I</span></div>
                <div><strong>Referência: </strong> <span>Próximo a LP Campos</span></div>
                <div><strong>Complemento: </strong> <span>Casa</span></div>
            </div>

        </article>

        <h3>Informações do Grau</h3>
        <table>
            <thead>
                <tr>
                    <th>Longe</th>
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
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                </tr>
                <tr>
                    <th>OD</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                    <th>-</th>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
            <tr>
                <th rowspan="2">Ponte</th>
                <th rowspan="2">Horizontal Maior</th>
                <th rowspan="2">Horizontal Menor</th>
                <th rowspan="2">Diagonal Maior</th>
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
                <td>156</td>
                <td>12</td>
                <td>15</td>
                <td>2</td>
                <td>1</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
            </tr>
            </tbody>
        </table>

        <h3>Dados da Compra</h3>
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
                <tr>
                    <td>Armação</td>
                    <td>1</td>
                    <td>Informação da armação</td>
                    <td>1200,00</td>
                    <td>Pix-40%</td>
                    <td>720,00</td>
                </tr>
                <tr>
                    <td>Lente</td>
                    <td>2</td>
                    <td>Informação da lente</td>
                    <td>800,00</td>
                    <td>Crédito-20%</td>
                    <td>640,00</td>
                </tr>
                <tr>
                    <td>Acessório</td>
                    <td>1</td>
                    <td>Informação do acessório</td>
                    <td>30,00</td>
                    <td>-</td>
                    <td>30,00</td>
                </tr>
            </tbody>
        </table>

        <h3>Pagamento</h3>
        <table>
            <thead>
                <tr>
                    <th>Pagamento</th>
                    <th>Valor</th>
                    <th>Plano</th>
                    <th>Entrada</th>
                </tr>
            </thead>
        </table>

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
