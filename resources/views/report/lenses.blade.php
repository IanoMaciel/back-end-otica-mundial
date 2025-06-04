<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Filtros</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/bold/style.css"
    />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f9fafb;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .filter {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            /*max-width: 1100px;*/
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .title h1 {
            font-size: 1.5rem;
            color: #111827;
        }

        .title i {
            font-size: 1.6rem;
            color: #3b82f6;
        }

        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .select-field {
            flex: 1 1 180px;
            display: flex;
            flex-direction: column;
        }

        .select-field label {
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #374151;
        }

        .select-field select {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            font-size: 0.95rem;
            color: #111827;
            outline: none;
            transition: border 0.2s;
        }

        .select-field select:focus {
            border-color: #3b82f6;
        }

        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .active-filters-title {
            font-weight: 600;
            color: #6b7280;
            margin-right: 0.5rem;
        }

        .filter-tag {
            background: #f3f4f6;
            border-radius: 999px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid #d1d5db;
        }

        .filter-tag i {
            cursor: pointer;
            font-size: 1rem;
            color: #9ca3af;
            transition: color 0.2s;
        }

        .filter-tag i:hover {
            color: #ef4444;
        }

        .clear-all-filter {
            margin-left: auto;
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .clear-all-filter:hover {
            background: #dc2626;
        }

        /* Estilo para o título da tabela padronizado */
        .table-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            /*max-width: 1100px;*/
            width: 100%;
            margin-top: 2rem;
        }

        .table-container {
            margin-top: 2rem;
            max-height: 500px;
            overflow: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }

        thead {
            background-color: #f3f4f6;
        }

        thead th {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        tbody td {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #f1f5f9;
        }

        tfoot {
            background-color: #f3f4f6;
        }

        tfoot td {
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
<section class="filter">
    <div class="title">
        <i class="ph-bold ph-funnel-simple"></i>
        <h1>Filtros Disponíveis</h1>
    </div>

    <section class="filter-group">
        <div class="select-field">
            <label>Tipo de Lente</label>
            <select id="filter-type">
                <option disabled selected hidden value="">Selecione</option>
                @foreach($typeLenses as $typeLens)
                    <option value="{{ $typeLens->type_lens }}">{{ $typeLens->type_lens }}</option>
                @endforeach
            </select>
        </div>

        <div class="select-field">
            <label>Índice</label>
            <select id="filter-index">
                <option disabled selected hidden value="">Selecione</option>
                @foreach($indices as $index)
                    <option value="{{ $index->index }}">{{ $index->index }}</option>
                @endforeach
            </select>
        </div>

        <div class="select-field">
            <label>Surfaçagem</label>
            <select id="filter-surfacing">
                <option disabled selected hidden value="">Selecione</option>
                @foreach($surfacings as $surfacing)
                    <option value="{{ $surfacing->surfacing }}">{{ $surfacing->surfacing }}</option>
                @endforeach
            </select>
        </div>

        <div class="select-field">
            <label>Antirreflexo</label>
            <select id="filter-treatment">
                <option disabled selected hidden value="">Selecione</option>
                <@foreach($treatments as $treatment)
                     <option value="{{ $treatment->treatment }}">{{ $treatment->treatment }}</option>
                @endforeach
            </select>
        </div>

        <div class="select-field">
            <label>Fotossensibilidade</label>
            <select id="filter-photosensitivity">
                <option disabled selected hidden value="">Selecione</option>
                @foreach($photosensitivities as $photosensitivity)
                    <option value="{{ $photosensitivity->sensitivity }}">{{ $photosensitivity->sensitivity }}</option>
                @endforeach
            </select>
        </div>
    </section>

    <div class="active-filters">
            <span class="active-filters-title">Filtros ativos:</span>
            <div id="active-filters-container"></div>
        <button id="clear-all-filter" class="clear-all-filter">Limpar filtro</button>
    </div>
</section>


<section class="table-section">
    <div class="title">
        <i class="ph-bold ph-table"></i>
        <h1>Estoque de Lentes</h1>
    </div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>NOME</th>
                <th id="filter-header">TIPO</th>
                <th>INDÍCE</th>
                <th>SUR.</th>
                <th>ANT.</th>
                <th>FILTRO</th>
                <th>FOT.</th>

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
            </tr>
            </thead>

            <tbody>
            @foreach ($lenses as $lens)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lens->name_lens ?? '-'}}</td>

                    <td>{{ $lens->typeLens->type_lens ?? '-' }}</td>
                    <td>{{ $lens->indices->index ?? '-' }}</td>
                    <td>{{ $lens->surfacings->surfacing ?? '-' }}</td>
                    <td>{{ $lens->treatment->treatment ?? '-' }}</td>
                    <td>{{ $lens->filter ? 'FILTRO AZUL' : '-' }}</td>
                    <td>{{ $lens->sensitivity->sensitivity ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->spherical_start ?? '-' }} / {{ $lens->spherical_end ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->cylindrical_start ?? '-' }} / {{ $lens->cylindrical_end ?? '-' }} </td>
                    <td class="nowrap">{{ $lens->addition_start ?? '-' }} / {{ $lens->addition_end ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->diameters->diameter ?? '-' }}</td>
                    <td class="nowrap">{{ $lens->heights->height ?? '-' }}</td>

                    <td class="nowrap">{{ $lens->cost ? formatReal($lens->cost) : '-' }}</td>
                    <td class="nowrap">{{ $lens->profit ? formatPercentage($lens->profit) : '-' }}</td>
                    <td class="nowrap">{{ $lens->minimum_value ? formatReal($lens->minimum_value) : '-'}}</td>
                    <td class="nowrap">{{ $lens->price ? formatReal($lens->price) : '-' }}</td>
                    <td class="nowrap">{{ $lens->laboratory->laboratory ?? '-' }}</td>
                    <td >{{ $lens->delivery . ' DIAS'?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="19">
                    <strong>ESF:</strong> ESFÉRICO -
                    <strong>CIL:</strong> CILINDRO -
                    <strong>ADI:</strong> ADIÇÃO -
                    <strong>DIÂ:</strong> DIÂMETRO -
                    <strong>ALT:</strong> ALTURA -
                    <strong>E. MÍN:</strong> ENTRADA MÍNIMA -
                    <strong>LAB</strong> LABORATÓRIO
            </tr>
            </tfoot>
        </table>
        <div id="no-results" class="no-results" style="display: none;">
            Nenhuma lente encontrada com os filtros selecionados.
        </div>
    </div>
</section>

</body>

<script>
    class LensFilter {
        constructor() {
            this.filters = {
                type: '',
                index: '',
                surfacing: '',
                treatment: '',
                photosensitivity: ''
            };

            this.filterElements = {
                type: document.getElementById('filter-type'),
                index: document.getElementById('filter-index'),
                surfacing: document.getElementById('filter-surfacing'),
                treatment: document.getElementById('filter-treatment'),
                photosensitivity: document.getElementById('filter-photosensitivity')
            };

            this.activeFiltersContainer = document.getElementById('active-filters-container');
            this.clearAllButton = document.getElementById('clear-all-filter');
            this.tableBody = document.getElementById('lens-table-body');
            this.noResultsDiv = document.getElementById('no-results');

            this.init();
        }

        init() {
            // Adicionar event listeners para os selects
            Object.keys(this.filterElements).forEach(key => {
                this.filterElements[key].addEventListener('change', (e) => {
                    this.updateFilter(key, e.target.value);
                });
            });

            // Event listener para o botão limpar tudo
            this.clearAllButton.addEventListener('click', () => {
                this.clearAllFilters();
            });

            this.updateActiveFilters();
            this.applyFilters();
        }

        updateFilter(filterType, value) {
            this.filters[filterType] = value;
            this.updateActiveFilters();
            this.applyFilters();
        }

        updateActiveFilters() {
            this.activeFiltersContainer.innerHTML = '';

            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    const filterTag = document.createElement('div');
                    filterTag.className = 'filter-tag';
                    filterTag.innerHTML = `
                    ${this.filters[key]}
                    <i class="ph ph-x" data-filter="${key}"></i>
                `;

                    filterTag.querySelector('i').addEventListener('click', (e) => {
                        this.removeFilter(e.target.dataset.filter);
                    });

                    this.activeFiltersContainer.appendChild(filterTag);
                }
            });
        }

        removeFilter(filterType) {
            this.filters[filterType] = '';
            this.filterElements[filterType].value = '';
            this.updateActiveFilters();
            this.applyFilters();
        }

        clearAllFilters() {
            Object.keys(this.filters).forEach(key => {
                this.filters[key] = '';
                this.filterElements[key].value = '';
            });
            this.updateActiveFilters();
            this.applyFilters();
        }

        applyFilters() {
            const rows = this.tableBody.querySelectorAll('tr');
            let visibleCount = 0;

            rows.forEach((row, index) => {
                let shouldShow = true;

                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key]) {
                        const rowValue = row.dataset[key] || '';
                        if (rowValue !== this.filters[key]) {
                            shouldShow = false;
                        }
                    }
                });

                if (shouldShow) {
                    row.classList.remove('hidden');
                    visibleCount++;
                    row.cells[0].textContent = visibleCount;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                this.noResultsDiv.style.display = 'block';
            } else {
                this.noResultsDiv.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        new LensFilter();
    });
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
