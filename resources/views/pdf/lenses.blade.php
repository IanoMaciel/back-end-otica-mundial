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
                color: #333
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

        /*    action */
            #filter-header {
                cursor: pointer;
                position: relative;
            }

            .filter-dropdown {
                position: absolute;
                background: white;
                border: 1px solid #ddd;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                display: none;
            }

            .filter-option {
                padding: 8px 12px;
                cursor: pointer;
                white-space: nowrap;
            }

            .filter-option:hover {
                background-color: #f0f0f0;
            }

            .filter-option.active {
                background-color: red;
                color: white;
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

                <th>NOME</th>
{{--                <th id="filter-header">TIPO</th>--}}
{{--                <th>SUR.</th>--}}
{{--                <th>INDÍCE</th>--}}
{{--                <th>ANT.</th>--}}
{{--                <th>FILTRO</th>--}}
{{--                <th>FOT.</th>--}}

                <th>ESF.</th>
                <th>CIL.</th>
                <th>ADI.</th>

                <th>DIÂ.</th>
                <th>ALT.</th>

                <th class="nowrap">CUSTO</th>
                <th class="nowrap">LUCRO</th>

                <th class="nowrap">E. MÍN.</th>
                <th class="nowrap">PREÇO</th>
                <th class="nowrap">LAB.</th>
                <th>ENTREGA</th>
{{--                <th>NOME</th>--}}
            </tr>
            </thead>

            <tbody>
            @foreach ($lenses as $lens)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lens->barcode ?? '-' }}</td>

                    <td>{{ $lens->name_lens ?? '-'}}</td>

{{--                    <td>{{ $lens->typeLens->type_lens ?? '-' }}</td>--}}
{{--                    <td>{{ $lens->surfacings->surfacing ?? '-' }}</td>--}}
{{--                    <td>{{ $lens->indices->index ?? '-' }}</td>--}}
{{--                    <td>{{ $lens->treatment->treatment ?? '-' }}</td>--}}
{{--                    <td>{{ $lens->filter ? 'Filtro Azul' : '-' }}</td>--}}
{{--                    <td>{{ $lens->sensitivity->sensitivity ?? '-' }}</td>--}}

                    <td class="nowrap">{{ $lens->spherical_start ?? '-' }} / {{ $lens->spherical_end ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->cylindrical_start ?? '-' }} / {{ $lens->cylindrical_end ?? '-' }} </td>
                    <td class="nowrap">{{ $lens->addition_start ?? '-' }} / {{ $lens->addition_end ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->diameters->diameter ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->heights->height ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->cost ? formatReal($lens->cost) : '-' }}</td>
                    <td class="nowrap">{{ $lens->profit ? formatPercentage($lens->profit) : '-' }}</td>
                    <td class="nowrap">{{ $lens->minimum_value ? formatReal($lens->minimum_value) : '-'}}</td>
                    <td class="nowrap">{{ $lens->price ? formatReal($lens->price) : '-' }}</td>

{{--                    <td class="nowrap">{{ $lens->created_at ? formatDate($lens->created_at) : '-' }}</td>--}}
{{--                    <td class="nowrap">{{ $lens->updated_at ? formatDate($lens->updated_at) : '-' }}</td>--}}
                    <td class="nowrap">{{ $lens->laboratory->laboratory ?? '-' }}</td>
                    <td >{{ $lens->delivery . ' DIAS'?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="19">
{{--                        <strong>ANT:</strong> ANTIRREFLEXO ---}}
{{--                        <strong>FOT:</strong> FOTOSSENSIBILIDADE ---}}
                        <strong>ESF:</strong> ESFÉRICO -
                        <strong>CIL:</strong> CILINDRO -
                        <strong>ADI:</strong> ADIÇÃO -
{{--                        <strong>SUR:</strong> SURFAÇAGEM ---}}
                        <strong>DIÂ:</strong> DIÂMETRO -
                        <strong>ALT:</strong> ALTURA -
                        <strong>E. MÍN:</strong> ENTRADA MÍNIMA -
                        <strong>LAB</strong> LABORATÓRIO
{{--                        <strong>ATU:</strong> ATUALIZADO--}}
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

        document.addEventListener('DOMContentLoaded', function () {
            const printButton = document.querySelector('.action button');
            const filterHeader = document.getElementById('filter-header');
            let currentFilter = null;

            // Função para criar o dropdown
            function createFilterDropdown(types) {
                const dropdown = document.createElement('div');
                dropdown.className = 'filter-dropdown';

                // Opção "Todos"
                const allOption = document.createElement('div');
                allOption.className = 'filter-option' + (!currentFilter ? ' active' : '');
                allOption.textContent = 'Todos';
                allOption.addEventListener('click', () => filterTable(''));
                dropdown.appendChild(allOption);

                // Opções de tipos
                types.forEach(type => {
                    const option = document.createElement('div');
                    option.className = 'filter-option' + (currentFilter === type ? ' active' : '');
                    option.textContent = type;
                    option.addEventListener('click', () => filterTable(type));
                    dropdown.appendChild(option);
                });

                return dropdown;
            }

            // Função para filtrar a tabela
            function filterTable(type) {
                currentFilter = type === '' ? null : type;
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const typeCell = row.querySelector('td:nth-child(4)'); // 4ª coluna é o TIPO
                    if (!type || typeCell.textContent === type) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Evento de clique no header
            if (filterHeader) {
                filterHeader.addEventListener('click', function(e) {
                    // Coletar todos os tipos únicos
                    const types = [...new Set(
                        Array.from(document.querySelectorAll('tbody td:nth-child(4)'))
                            .map(td => td.textContent)
                            .filter(text => text.trim() !== '-')
                    )].sort();

                    // Remover dropdown anterior
                    const existingDropdown = document.querySelector('.filter-dropdown');
                    if (existingDropdown) existingDropdown.remove();

                    // Criar e exibir novo dropdown
                    const dropdown = createFilterDropdown(types);
                    this.appendChild(dropdown);

                    // Posicionar dropdown
                    const rect = this.getBoundingClientRect();
                    dropdown.style.display = 'block';
                    dropdown.style.top = rect.height + 'px';
                    dropdown.style.left = '0';
                });
            }

            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(e) {
                if (!filterHeader.contains(e.target)) {
                    const dropdown = document.querySelector('.filter-dropdown');
                    if (dropdown) dropdown.remove();
                }
            });

            // Print button
            if (printButton) {
                printButton.addEventListener('click', function() {
                    window.print();
                });
            }
        });s
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
