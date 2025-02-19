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
            font-family: 'Poppins', sans-serif;
        }

        .a4 {
            /*width: 210mm; !* Largura padrão da folha A4 *!*/
            /*height: 297mm; !* Altura padrão da folha A4 *!*/
            margin: 10px auto; /* Centraliza na tela */
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px; /* Margens internas */
            font-size: 12px;
        }

        h3 {
            margin: 10px 0;
        }

        .header {
            display: flex;
            /*justify-content: center;*/
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
            gap: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .observations {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .customer-information {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ccc;
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
            padding: 8px;
            text-align: left;
        }
    </style>

    <body class="a4">
        <article class="header">
            <img
                src="https://github-production-user-asset-6210df.s3.amazonaws.com/71051791/414767188-9a5e1e23-860c-4dc9-a468-ba8ce9639b7e.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20250219%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20250219T144251Z&X-Amz-Expires=300&X-Amz-Signature=2a357d41c44b5b6764e6a58796e1a604f6e1c4a6494b93fc6434ea7747223d81&X-Amz-SignedHeaders=host"
                alt="logo"
                width="171px"
                height="53px"
            />
            <div class="title">
                <h4>Ordem de Serviço | 3043</h4>
            </div>
        </article>

        <article class="initial-information">
            <div><strong>Nº da Venda:</strong> <span>19098802A</span></div>
            <div><strong>Nº da OS:</strong> <span>3043</span></div>
            <div><strong>Laboratório:</strong> <span>Laboratória Ótica Mundial</span></div>
        </article>

        <article>
            <h3>Observações</h3>
            <p class="observations">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        </article>

        <h3>Informações do Paciente</h3>
        <article class="customer-information">
            <div class="data">
                <div><strong>Nome: </strong> <span>Iano de Benedito Maciel</span></div>
                <div><strong>CPF: </strong> <span>022.954.642-00</span></div>
                <div><strong>RG: </strong> <span>2701672-2</span></div>
                <div><strong>Nascimento: </strong> <span>07/04/2000</span></div>
                <div><strong>Idade: </strong> <span>24 anos</span></div>
                <div><strong>Convênio: </strong> <span>Unimed - 1234566 </span></div>
                <div><strong>Email: </strong> <span>ianomaciel685@icloud.com</span></div>
                <div><strong>Contato: </strong> <span>(92) 98633-8449</span></div>
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
    </body>
</html>
