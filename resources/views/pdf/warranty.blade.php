<!DOCTYPE>
<html>
    <head>
        <title>Termo de Garantia - Óculos de Grau</title>
        <style>
            * {
                /*margin: 0;*/
                /*padding: 0;*/
                /*box-sizing: border-box;*/
                font-family: 'Nunito', sans-serif;
            }

            body {
                /*height: 100vh;*/
                color: #333;
                text-align: justify;
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
                /*height: 60px;*/
                background-color: red;
                color: white;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                /*line-height: 53px;*/
                clip-path: polygon(2.7% 0, 100% 0, 100% 100%, 0% 100%);
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <article class="header">
            <div class="img-area">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="171px" height="53px"/>
            </div>
            <div class="title">
                <h4>TERMO DE GARANTIA - ÓCULOS DE GRAU</h4>
            </div>
        </article>

        <h2>Identificação do Produto</h2>

        <ul>
            <li><strong>Produto:</strong>Óculos de Grau</li>
            <li><strong>Marca:</strong>___________________________</li>
            <li><strong>Código de Venda (CV):</strong>___________________________</li>
            <li><strong>Data da Compra:</strong>____/____/______</li>
        </ul>

        <h2>Garantia Legal e Contratual</h2>
        <p>Este produto possui garantia legal de 90 (noventa) dias, conforme o Código de Defesa do Consumidor, contados a partir da data da compra, contra defeitos de fabricação.</p>

        <h2>O que está coberto pela garantia</h2>
        <ul>
            <li>Defeitos de fabricação nas armações ou lentes (quando adquiridas juntamente com a armação);</li>
            <li>Soltura de parafusos, hastes ou plaquetas por falha de montagem;</li>
            <li>Descolamento de lentes (quando aplicável).</li>
        </ul>

        <h2>O que NÂO está coberto pela garantia</h2>
        <p>A garantia não cobre danos decorrentes de mau uso, tais como:</p>
        <ul>
            <li>Quedas, batidas ou impactos;</li>
            <li>Riscos, trincas ou quebras nas lentes ou armação;</li>
            <li>Exposição a altas temperaturas;</li>
            <li>Uso de produtos químicos inadequados (como colas, solventes, álcool, etc.);</li>
            <li>Deformações causadas por pressão, armazenamento inadequado ou manuseio impróprio;</li>
            <li>Modificações ou reparos realizados por terceiros não autorizados;</li>
            <li>Oxidação por contato com suor ou água salgada;</li>
            <li>Perda, furto ou roubo do produto.</li>
        </ul>

        <h2>Instruções para Acionamento da Garantia</h2>
        <p>Para acionar a garantia, o cliente deve apresentar este termo devidamente preenchido, juntamente com o Código de Venda da compra. A análise do produto será feita pela nossa equipe técnica em até 10 dias úteis, podendo o prazo ser estendido em caso de necessidade de envio para o fabricante.</p>

        <h2>Observações Finais</h2>
        <ul>
            <li>A garantia é válida apenas para o primeiro comprador do produto.</li>
            <li>Produtos que apresentarem defeitos fora do prazo de garantia poderão ser avaliados para reparo mediante orçamento prévio.</li>
        </ul>
    </body>
</html>
