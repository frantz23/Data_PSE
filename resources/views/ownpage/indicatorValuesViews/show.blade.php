@extends('sample')

@section('title')
    Voir Valeur Indicateur
@endsection

@section('content')
    <div class="container py-4">

        <!-- En-tête / Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('showIndicator', $indicatorValue->id) }}" class="btn btn-outline-secondary btn-sm mb-2">
                    <i class="bi bi-arrow-left"></i> Retour à l'indicateur
                </a>
                <h3 class="fw-bold m-0">Détail de la valeur collectée</h3>
            </div>

            <!-- Boutons d'actions -->
            <div class="d-flex gap-2">
                <a href="{{ route('editIndicatorValue', $indicatorValue->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </a>
                <a href="{{ route('createIVFile', $indicatorValue->id) }}" class="btn border-dark btn-info">
                    <i class="bi bi-puzzle"></i> Pièce(s) justificative(s)</a>
                <a href="#" data-id="{{ $indicatorValue->id }}" class="btn btn-danger deleteBtn">
                    <i class="bi-solid bi-trash"></i> Supprimer
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Colonne Gauche : Détails de la Collecte -->
            <div class="col-lg-8">

                <!-- Carte Principale de la Valeur -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <!-- Statut de Validation -->
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <span class="text-muted fw-bold">Statut de la donnée</span>
                            @if ($indicatorValue->validated)
                                <span class="badge bg-success px-3 py-2 fs-6">
                                    <i class="bi bi-check-circle me-1"></i> Validé
                                </span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                                    <i class="bi bi-clock-history me-1"></i> En attente de validation
                                </span>
                            @endif
                        </div>

                        <!-- Grille des valeurs principales -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded border">
                                    <small class="text-muted d-block text-uppercase fw-bold">Valeur Numérique</small>
                                    <span class="fs-3 fw-bold text-primary">
                                        {{ $indicatorValue->value_numeric !== null ? number_format($indicatorValue->value_numeric, 2, ',', ' ') : '-' }}
                                    </span>
                                    <small class="text-muted ms-1">{{ $indicatorValue->indicator->unit ?? '' }}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded border">
                                    <small class="text-muted d-block text-uppercase fw-bold">Date de rapport</small>
                                    <span class="fs-4 fw-bold text-dark">
                                        {{ $indicatorValue->reporting_date ? \Carbon\Carbon::parse($indicatorValue->reporting_date)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Valeur Texte (si applicable) -->
                        @if ($indicatorValue->value_text)
                            <div class="mb-4">
                                <h6 class="fw-bold text-muted">Valeur qualitative / Texte :</h6>
                                <div class="p-3 bg-light rounded border">
                                    {{ $indicatorValue->value_text }}
                                </div>
                            </div>
                        @endif

                        <!-- Commentaire / Source -->
                        <div class="mb-0">
                            <h6 class="fw-bold text-muted">Commentaire / Source de vérification :</h6>
                            <div class="p-3 bg-light rounded border text-secondary">
                                {{ $indicatorValue->comment ?? 'Aucun commentaire renseigné.' }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Colonne Droite : Rappel du Contexte (Indicateur & Projet) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-secondary text-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Contexte</h5>

                        <div class="mb-3">
                            <small class="text-uppercase opacity-75 d-block">Indicateur lié</small>
                            <a href="{{ route('showIndicator', $indicatorValue->indicator->id) }}"
                                class="text-info fw-bold text-decoration-none fs-5">
                                [{{ $indicatorValue->indicator->code }}] {{ $indicatorValue->indicator->name }}
                            </a>
                        </div>

                        @if ($indicatorValue->indicator->project)
                            <div class="mb-3">
                                <small class="text-uppercase opacity-75 d-block">Projet</small>
                                <span class="fw-semibold">{{ $indicatorValue->indicator->project->name }}</span>
                            </div>
                        @endif

                        <hr class="border-light opacity-25">

                        <div class="d-flex justify-content-between align-items-center opacity-75 small">
                            <span>Saisi le :</span>
                            <span>{{ $indicatorValue->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Carte des pièces jointes / Fichiers -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0 text-dark">
                    <i class="bi bi-paperclip me-2 text-primary"></i>Fichiers et pièces jointes
                    ({{ $indicatorValue->indicatorvaluefiles->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                @if ($indicatorValue->indicatorvaluefiles->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach ($indicatorValue->indicatorvaluefiles as $file)
                            <div class="list-group-item d-flex align-items-center justify-content-between p-3">

                                <!-- Nom et icône du fichier -->
                                <div class="d-flex align-items-center">
                                    @if (str_contains($file->mime_type, 'spreadsheet') ||
                                            str_contains($file->file_name, '.xlsx') ||
                                            str_contains($file->file_name, '.xls'))
                                        <i class="bi bi-file-earmark-excel fs-2 text-success me-3"></i>
                                    @elseif(str_contains($file->mime_type, 'pdf'))
                                        <i class="bi bi-file-earmark-pdf fs-2 text-danger me-3"></i>
                                    @elseif(str_contains($file->mime_type, 'image'))
                                        <i class="bi bi-file-earmark-image fs-2 text-info me-3"></i>
                                    @else
                                        <i class="bi bi-file-earmark-text fs-2 text-secondary me-3"></i>
                                    @endif

                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $file->file_name }}</h6>
                                        <small class="text-muted">
                                            Taille : {{ number_format($file->file_size / 1024, 1) }} Ko •
                                            Ajouté le {{ $file->created_at->format('d/m/Y à H:i') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Bouton Télécharger / Visualiser -->
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    <i class="bi bi-download me-1"></i> Télécharger
                                </a>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-folder2-open fs-1 opacity-50 d-block mb-2"></i>
                        <p class="mb-0 small">Aucune pièce jointe n'a encore été déposée pour cet indicateur.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
                const response = await fetch('/indicatorvalues/speed/' + id, {
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
                    const response = await fetch('/indicatorvalues/delete/' + id, {
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
            const tableHeaders = document.querySelectorAll('#Indicatorvalue th');
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
                const savedSelection = localStorage.getItem('selectedColumns#Indicatorvalue');
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
            const dataTable = document.getElementById('Indicatorvalue');
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
            localStorage.setItem('selectedColumns#Indicatorvalue', JSON.stringify(selectedColumns));
        }

        function loadSavedSelection() {
            const savedSelection = localStorage.getItem('selectedColumns#Indicatorvalue');
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
            const table = document.getElementById('Indicatorvalue');
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
