@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="p-5" style="background: linear-gradient(135deg, #ffffff 0%, #f1f8f4 60%, #4caf50 100%);">

        {{-- <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $project->name }}</td>
                    </tr>
                    <tr>
                        <th>Code</th>
                        <td>{{ $project->code }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $project->description }}</td>
                    </tr>
                    <tr>
                        <th>Budget</th>
                        <td>{{ $project->budget }}</td>
                    </tr>
                    <tr>
                        <th>Start_date</th>
                        <td>{{ $project->start_date }}</td>
                    </tr>
                    <tr>
                        <th>End_date</th>
                        <td>{{ $project->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $project->status }}</td>
                    </tr>

                </tbody>
            </table>

            <div>
                <a href="{{ route('editProject', ['id' => $project->id]) }}" class="btn btn-warning my-1">
                    <i class="bi bi-edit"></i> Edit
                </a>
            </div>
        </div> --}}

        <div class="container-fluid py-4 px-3">

    <!-- 1. EN-TÊTE & ACTIONS -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                    <i class="bi bi-hash"></i>{{ $project->code }}
                </span>

                @if($project->status == 'completed' || $project->status == 'Terminé')
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">Terminé</span>
                @elseif($project->status == 'in_progress' || $project->status == 'En cours')
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1 rounded-pill">En cours</span>
                @else
                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-1 rounded-pill">En attente</span>
                @endif
            </div>
            <h2 class="fw-bold text-dark m-0">{{ $project->name }}</h2>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('indexProject') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Liste des projets
            </a>
            <a href="{{ route('editProject', ['id' => $project->id]) }}" class="btn btn-warning text-white rounded-pill px-3">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
        </div>
    </div>

    <!-- 2. CARTES D'INFORMATIONS CLÉS (KPIs) -->
    <div class="row g-3 mb-4">

        <!-- Budget -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="bi bi-cash-stack fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Budget Alloué</span>
                        <h4 class="fw-bold text-dark mb-0">
                            {{ number_format($project->budget ?? 0, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Période / Dates -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="bi bi-calendar-range fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Période du Projet</span>
                        <div class="fw-bold text-dark small">
                            Du {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : 'N/A' }}
                        </div>
                        <div class="fw-bold text-dark small">
                            Au {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nombre d'Indicateurs liés -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3 text-info">
                        <i class="bi bi-speedometer2 fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Indicateurs de suivi</span>
                        <h4 class="fw-bold text-dark mb-0">
                            {{ $project->indicators->count() ?? 0 }} <small class="fs-6 text-muted">indicateur(s)</small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. DESCRIPTION & DÉTAILS -->
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="bi bi-file-text me-2 text-primary"></i>Description du Projet
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <p class="text-secondary leading-relaxed mb-0">
                        {!! nl2br(e($project->description ?? 'Aucune description détaillée fournie pour ce projet.')) !!}
                    </p>
                </div>
            </div>

            <!-- 4. LISTE DES INDICATEURS DU PROJET -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="bi bi-list-check me-2 text-primary"></i>Indicateurs Rattachés
                    </h5>
                    <a href="{{ route('createIndicator', ['project_id' => $project->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i>Ajouter un indicateur
                    </a>
                </div>
                <div class="card-body p-0">
                    @forelse($project->indicators as $indicator)
                        <div class="d-flex align-items-center justify-content-between p-3 border-top hover-bg-light">
                            <div>
                                <span class="badge bg-light text-dark border me-2">[{{ $indicator->code }}]</span>
                                <strong class="text-dark">{{ $indicator->name }}</strong>
                            </div>
                            <a href="{{ route('showIndicator', $indicator->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-info-circle fs-2 d-block mb-2 opacity-50"></i>
                            <p class="mb-0 small">Aucun indicateur n'est rattaché à ce projet pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- PANNEAU LATÉRAL : RÉSUMÉ DES INFOS -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Informations générales
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-bottom">
                            <span class="text-muted">Code projet</span>
                            <span class="fw-bold">{{ $project->code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-bottom">
                            <span class="text-muted">Créé le</span>
                            <span class="fw-bold">{{ $project->created_at ? $project->created_at->format('d/m/Y') : 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted">Dernière mise à jour</span>
                            <span class="fw-bold">{{ $project->updated_at ? $project->updated_at->format('d/m/Y à H:i') : 'N/A' }}</span>
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
                    const response = await fetch('/projects/speed/' + id, {
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
                        const response = await fetch('/projects/delete/' + id, {
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
                const tableHeaders = document.querySelectorAll('#Project th');
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
                    const savedSelection = localStorage.getItem('selectedColumns#Project');
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
                const dataTable = document.getElementById('Project');
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
                localStorage.setItem('selectedColumns#Project', JSON.stringify(selectedColumns));
            }

            function loadSavedSelection() {
                const savedSelection = localStorage.getItem('selectedColumns#Project');
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
                const table = document.getElementById('Project');
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
