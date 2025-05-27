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


    </body>
</html>
