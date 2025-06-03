<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />

    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/bold/style.css"
    />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            padding: 10px 20%;
        }

        .title {
            display: flex;
            gap: 10px;

            h1, i {
                font-size: 30px;
            }
        }

        .filter-area {
            display: flex;
            justify-content: space-between;
        }

        .select-field {
            display: flex;
            flex-direction: column;

            label {
                font-weight: 600;
            }

            select {
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>
    <section style="display: flex; flex-direction: column; gap: 10px">
        <div class="title">
            <i class="ph-bold ph-funnel-simple"></i>
            <h1>Filtros Disponíveis</h1>
        </div>

        <section class="filter-area">
            <div class="select-field">
                <label>Tipo de Lente</label>
                <select>
                    <option disabled selected hidden value="">Selecione</option>
                    <option value="">MULTIFOCAL COMPO MÉDIO</option>
                    <option value="">VISÃO SIMPLES</option>
                    <option value="">MULTIFOCAL CAMPO PEQUENO</option>
                </select>
            </div>

            <div class="select-field">
                <label>Índice</label>
                <select>
                    <option disabled selected hidden value="">Selecione</option>
                    <option value="">1.56</option>
                    <option value="">1.66</option>
                    <option value="">1.70</option>
                </select>
            </div>

            <div class="select-field">
                <label>Surfaçagem</label>
                <select>
                    <option disabled selected hidden value="">Selecione</option>
                    <option value="">BLOCO DIGITAL</option>
                    <option value="">PRONTA</option>
                    <option value="">BLOCO CONVENCIONAL</option>
                </select>
            </div>

            <div class="select-field">
                <label>Antirreflexo</label>
                <select>
                    <option disabled selected hidden value="">Selecione</option>
                    <option value="">AR VERDE</option>
                    <option value="">AR AZUL</option>
                    <option value="">INCOLOR</option>
                </select>
            </div>

            <div class="select-field">
                <label>Fotossensibilidade</label>
                <select>
                    <option disabled selected hidden value="">Selecione</option>
                    <option value="">FOTOSSENSIVEL 80%</option>
                    <option value="">FOTOSSENSIVEL 70%</option>
                    <option value="">FOTOSSENSIVEL 65%</option>
                </select>
            </div>
        </section>

        <div>
            <p>Filtros ativos:</p>
            <span>Visão Simples</span>
        </div>
    </section>
</body>
</html>
