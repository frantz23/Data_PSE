@extends('sample')

@section('title')
    Voir Projet
@endsection

@section('content')
    <div class="container-fluid py-3">

        <!-- EN-TÊTE ET ACTIONS -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    @if ($program->code)
                        <span class="badge bg-secondary-subtle text-secondary border fw-mono">
                            <i class="bi bi-hash me-1"></i>{{ $program->code }}
                        </span>
                    @endif

                    <!-- Badge de Statut -->
                    @switch($program->status)
                        @case('active')
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                <i class="bi bi-play-circle-fill me-1"></i>En cours
                            </span>
                        @break

                        @case('completed')
                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>Clôturé
                            </span>
                        @break

                        @case('suspended')
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">
                                <i class="bi bi-pause-circle-fill me-1"></i>Suspendu
                            </span>
                        @break

                        @default
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                <i class="bi bi-file-earmark me-1"></i>Brouillon
                            </span>
                    @endswitch
                </div>
                <h2 class="h3 fw-bold text-dark mb-0">{{ $program->name }}</h2>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('indexProgram') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                @if (Route::has('editProgram'))
                    <a href="{{ route('editProgram', $program->id) }}"
                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>
                @endif
                <button type="button" data-id="{{ $program->id }}"
                    class="btn btn-outline-danger btn-sm rounded-pill px-3 deleteBtn">
                    <i class="bi bi-trash me-1"></i> Supprimer
                </button>
            </div>
        </div>

        <!-- CARTES D'INDICATEURS CLÉS (KPIs) -->
        <div class="row g-3 mb-4">
            <!-- KPI Budget -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                            <i class="bi bi-wallet2 fs-3 text-white"></i>
                        </div>
                        <div>
                            <span class="text-white-50 small text-uppercase fw-bold">Budget Total</span>
                            <h4 class="mb-0 fw-bold">
                                {{ number_format($program->budget, 0, ',', ' ') }}
                                <small class="fs-6 fw-normal">{{ $program->currency }}</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Bailleur Principal -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle bg-light p-3 me-3 text-primary">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Bailleur de fonds</span>
                            <h5 class="mb-0 fw-bold text-dark">{{ $program->donor ?? 'Non renseigné' }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Période -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle bg-light p-3 me-3 text-primary">
                            <i class="bi bi-calendar-event fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Période d'exécution</span>
                            <h6 class="mb-0 fw-bold text-dark">
                                @if ($program->start_date && $program->end_date)
                                    {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }}
                                    <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}
                                @else
                                    Non définie
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DÉTAILS DU PROGRAMME -->
        <div class="row g-4">

            <!-- Colonne Gauche : Description & Présentation -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold m-0 text-dark">
                            <i class="bi bi-card-text text-primary me-2"></i> Description & Objectifs
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($program->description)
                            <div class="p-3 bg-light rounded-3 text-secondary lh-lg">
                                {!! nl2br(e($program->description)) !!}
                            </div>
                        @else
                            <p class="text-muted italic">Aucune description renseignée pour ce programme.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Partenaires & Paramètres -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold m-0 text-dark">
                            <i class="bi bi-info-circle text-primary me-2"></i> Informations complémentaires
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-handbag me-2"></i>Partenaire de mise en
                                    œuvre</span>
                                <span
                                    class="fw-semibold text-dark text-end">{{ $program->funding_partner ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-currency-exchange me-2"></i>Devise de
                                    gestion</span>
                                <span class="fw-semibold text-dark">{{ $program->currency }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-calendar-check me-2"></i>Date de démarrage</span>
                                <span class="fw-semibold text-dark">
                                    {{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('d M Y') : 'N/A' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-calendar-x me-2"></i>Date de fin prévue</span>
                                <span class="fw-semibold text-dark">
                                    {{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('d M Y') : 'N/A' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="confirmModalLabel">Delete confirm</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary confirmDeleteAction">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const checkboxs = document.querySelectorAll('input[type="checkbox"]')

        checkboxs.forEach((checkbox) => {

            checkbox.onchange = async (event) => {
                const {
                    checked,
                    name,
                    dataset
                } = event.target;
                const {
                    id
                } = dataset;
                console.log({
                    checked,
                    name,
                    id
                });
                const data = {
                    [name]: checked.toString()
                };
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch('programs/speed/' + id, {
                    method: 'PUT',
                    body: JSON.stringify(
                        data), // Utilisation de JSON.stringify au lieu de JSON.stringfy
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            };
        })

        const deleteButtons = document.querySelectorAll('.deleteBtn')
        deleteButtons.forEach(deleteButton => {
            deleteButton.addEventListener('click', (event) => {
                event.preventDefault();
                const {
                    id,
                    title
                } = deleteButton.dataset
                const modalBody = document.querySelector('.modal-body')
                modalBody.innerHTML = `Are you sure you want to delete this data ?</strong> `
                console.log({
                    id,
                    title
                });
                const modal = new bootstrap.Modal(document.querySelector('#confirmModal'))
                modal.show()
                const confirmDeleteBtn = document.querySelector('.confirmDeleteAction')

                confirmDeleteBtn.addEventListener('click', async () => {
                    const csrfToken = document.head.querySelector('meta[name="csrf-token"]')
                        .content;
                    const response = await fetch('programs/delete/' + id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })

                    const result = await response.json()

                    if (result && result.isSuccess) {
                        window.location.href = window.location.href;
                    }


                    modal.hide()
                })
            })

        });
        document.addEventListener('DOMContentLoaded', function() {
            const tableHeaders = document.querySelectorAll('#Program th');
            const columnSelector = document.getElementById('columnSelector');

            tableHeaders.forEach(function(header, index) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                const div = document.createElement('div');
                a.className = 'dropdown-item';
                div.className = 'form-check form-switch';
                const label = document.createElement('label');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.role = "switch"
                checkbox.className = 'columnSelector form-check-input';
                checkbox.dataset.column = index;
                const savedSelection = localStorage.getItem('selectedColumns#Program');
                checkbox.checked = !!!savedSelection; // Sélectionner par défaut
                checkbox.addEventListener('change', function() {
                    const columnIndex = parseInt(checkbox.dataset.column);
                    toggleColumn(columnIndex, checkbox.checked);
                    saveSelection();
                });

                label.appendChild(document.createTextNode(header.textContent));
                div.appendChild(label)
                div.appendChild(checkbox)
                a.appendChild(div);
                li.appendChild(a);
                columnSelector.appendChild(li);

                header.addEventListener('click', function() {
                    sortTable(index);
                });

                if (savedSelection) {
                    const selectedColumns = JSON.parse(savedSelection);
                    toggleColumn(parseInt(index), selectedColumns.includes(index));
                }
            });


            const checkboxes = document.querySelectorAll('.columnSelector');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const columnIndex = parseInt(checkbox.dataset.column);
                    toggleColumn(columnIndex, checkbox.checked);

                    // Sauvegarde la sélection dans le localStorage
                    saveSelection();
                });
            });

            // Chargement des valeurs sauvegardées dans le localStorage
            loadSavedSelection();
        });

        function toggleColumn(columnIndex, show) {
            const dataTable = document.getElementById('Program');
            const cells = dataTable.querySelectorAll(
                `tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`);

            cells.forEach(function(cell) {
                if (show) {
                    cell.style.display = ''; // Affiche la colonne
                } else {
                    cell.style.display = 'none'; // Masque la colonne
                }
            });
        }

        function saveSelection() {
            const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
                .filter(c => c.checked)
                .map(c => c.dataset.column);
            localStorage.setItem('selectedColumns#Program', JSON.stringify(selectedColumns));
        }

        function loadSavedSelection() {
            const savedSelection = localStorage.getItem('selectedColumns#Program');
            if (savedSelection) {
                const selectedColumns = JSON.parse(savedSelection);
                selectedColumns.forEach(function(columnIndex) {
                    const checkbox = document.querySelector(`.columnSelector[data-column="${columnIndex}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                        toggleColumn(parseInt(columnIndex), true);
                    }
                });
            }
        }

        function sortTable(columnIndex) {
            const table = document.getElementById('Program');
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            console.log({
                rows
            });

            rows.sort((a, b) => {
                const cellA = a.querySelectorAll('td')[columnIndex].textContent;
                const cellB = b.querySelectorAll('td')[columnIndex].textContent;

                return cellA.localeCompare(cellB, undefined, {
                    numeric: true,
                    sensitivity: 'base'
                });
            });

            table.querySelector('tbody').innerHTML = '';
            rows.forEach(row => table.querySelector('tbody').appendChild(row));
        }
    </script>
@endsection
