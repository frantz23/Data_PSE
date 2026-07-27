@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title')
    Détails Indicateur - {{ $indicator->code }}
@endsection

@section('content')
    <div class="p-5">
        <div class="container-fluid py-4">

            {{-- HEADER & ACTIONS --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('indexIndicator') }}">Indicateurs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $indicator->code }}</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold text-dark mb-0">
                        {{ $indicator->name }}
                    </h2>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('indexIndicator') }}" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <a href="{{ route('editIndicator', $indicator->id) }}" class="btn btn-warning btn-sm px-3 text-dark">
                        <i class="bi bi-pencil me-1"></i> Éditer
                    </a>

                    {{-- ✅ Ajout de data-title pour le modal --}}
                    <a href="#" data-id="{{ $indicator->id }}" data-title="{{ $indicator->name }}" class="btn btn-danger btn-sm px-3 deleteBtn">
                        <i class="bi bi-trash me-1"></i> Supprimer
                    </a>

                    <a href="{{ route('createIndicatorValue', $indicator->id) }}" class="btn btn-info btn-sm px-3 text-dark">
                        <i class="bi bi-collection me-1"></i> Collecte de données
                    </a>
                </div>
            </div>

            <div class="row g-4">

                {{-- COLONNE GAUCHE (Niveau de réalisation & Activités) --}}
                <div class="col-lg-8">

                    {{-- NIVEAU DE RÉALISATION --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Niveau de Réalisation</h5>
                                <span class="fs-4 fw-extrabold text-primary">{{ $indicator->progress }}%</span>
                            </div>

                            <div class="progress mb-4" style="height: 10px;">
                                <div class="progress-bar
                                    @if ($indicator->progress >= 100) bg-success
                                    @elseif($indicator->progress >= 50) bg-primary
                                    @else bg-warning @endif"
                                    role="progressbar" style="width: {{ $indicator->progress }}%"
                                    aria-valuenow="{{ $indicator->progress }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>

                            <div class="row text-center g-3">
                                <div class="col-4">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block uppercase font-mono">Ligne de base</small>
                                        <span class="fs-5 fw-bold text-dark">
                                            {{ number_format($indicator->baseline, 0, ',', ' ') }}
                                        </span>
                                        <small class="text-muted">{{ $indicator->unit }}</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="bg-light rounded p-3 border border-primary-subtle">
                                        <small class="text-primary d-block uppercase font-mono fw-semibold">Valeur Actuelle</small>
                                        <span class="fs-4 fw-bold text-primary">
                                            {{ number_format($indicator->current_value, 0, ',', ' ') }}
                                        </span>
                                        <small class="text-primary">{{ $indicator->unit }}</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block uppercase font-mono">Cible Ciblée</small>
                                        <span class="fs-5 fw-bold text-dark">
                                            {{ number_format($indicator->target, 0, ',', ' ') }}
                                        </span>
                                        <small class="text-muted">{{ $indicator->unit }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Description & Méthodologie</h5>
                            <p class="text-muted mb-0" style="white-space: pre-line;">
                                {{ $indicator->description ?? 'Aucune description spécifique renseignée pour cet indicateur.' }}
                            </p>
                        </div>
                    </div>

                    {{-- ACTIVITÉS CONTRIBUTRICES --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Activités Contributrices</h5>
                            <span class="badge bg-secondary rounded-pill">
                                {{ $indicator->activities->count() }} activité(s)
                            </span>
                        </div>
                        <div class="card-body p-0">
                            @forelse($indicator->activities as $activity)
                                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">{{ $activity->name }}</h6>
                                        <a href="{{ route('showActivity', $activity->id) }}" class="btn btn-sm btn-outline-secondary">Visualiser</a>
                                    </div>
                                    <span class="badge bg-light text-dark border">
                                        {{ ucfirst($activity->status ?? 'active') }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <p class="mb-0">Aucune activité n'est associée à cet indicateur pour le moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- COLONNE DROITE (Informations générales) --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Informations Générales</h5>

                            <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="text-muted">Statut</span>
                                <span class="badge rounded-pill px-3 py-2
                                    @if ($indicator->status === 'active') bg-success
                                    @elseif($indicator->status === 'draft') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($indicator->status) }}
                                </span>
                            </div>

                            <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="text-muted">Niveau GAR</span>
                                <span class="badge
                                    @if ($indicator->result_level === 'impact') bg-dark
                                    @elseif($indicator->result_level === 'outcome') bg-info text-dark
                                    @else bg-light text-dark border @endif">
                                    {{ strtoupper($indicator->result_level) }}
                                </span>
                            </div>

                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block">Projet associé</small>
                                <strong class="text-dark">
                                    {{ $indicator->project->name ?? 'Non assigné' }}
                                </strong>
                            </div>

                            <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="text-muted">Fréquence de collecte</span>
                                <span class="fw-semibold text-dark text-capitalize">{{ $indicator->frequency }}</span>
                            </div>

                            <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="text-muted">Type de données</span>
                                <span class="fw-semibold text-dark text-capitalize">{{ $indicator->data_type }}</span>
                            </div>

                            <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="text-muted">Unité de mesure</span>
                                <span class="fw-semibold text-dark">{{ $indicator->unit }}</span>
                            </div>

                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block">Créé par</small>
                                <span class="fw-medium text-dark">{{ $indicator->user->name ?? 'Système' }}</span>
                            </div>

                            <div class="d-flex justify-content-between small text-muted">
                                <span>Créé le :</span>
                                <span>{{ $indicator->created_at?->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- TABLEAU DES VALEURS --}}
            <div class="card border-0 shadow-sm mt-4 bg-secondary text-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Valeurs de l'indicateur</h5>

                    <div class="table-responsive">
                        {{-- ✅ Ajout de id="Indicator" pour la compatibilité JS --}}
                        <table id="Indicator" class="table table-light table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Valeur numérique</th>
                                    <th scope="col">Valeur texte</th>
                                    <th scope="col">Date de rapport</th>
                                    <th scope="col">Commentaire</th>
                                    <th scope="col">Est Validé ?</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($indicatorValues as $ind)
                                    <tr>
                                        <td class="fw-bold">{{ $ind->value_numeric ?? '-' }}</td>
                                        <td>{{ $ind->value_text ?? '-' }}</td>
                                        <td>
                                            {{ $ind->reporting_date ? \Carbon\Carbon::parse($ind->reporting_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $ind->comment ?? '-' }}</td>
                                        <td>
                                            @if ($ind->validated)
                                                <span class="badge bg-success">Validé</span>
                                            @else
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('showIndicatorValue', $ind->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">
                                            Aucune valeur enregistrée pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL DE CONFIRMATION DE SUPPRESSION -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fs-5 fw-bold text-dark" id="confirmModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Confirmation de suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body py-4">
                    <!-- Contenu dynamique -->
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger rounded-pill px-3 confirmDeleteAction">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. GESTION DE LA SUPPRESSION (DELETE)
            const deleteButtons = document.querySelectorAll('.deleteBtn');
            const modalEl = document.querySelector('#confirmModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            const confirmDeleteBtn = document.querySelector('.confirmDeleteAction');

            deleteButtons.forEach(deleteButton => {
                deleteButton.addEventListener('click', (event) => {
                    event.preventDefault();

                    const { id, title } = deleteButton.dataset;
                    const modalBody = modalEl.querySelector('.modal-body');

                    modalBody.innerHTML = `Êtes-vous sûr de vouloir supprimer l'indicateur <strong>${title || ''}</strong> ? Cette action est irréversible.`;
                    modal.show();

                    confirmDeleteBtn.onclick = async () => {
                        const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');

                        try {
                            const response = await fetch('/indicators/delete/' + id, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfMeta ? csrfMeta.content : '',
                                    'Accept': 'application/json'
                                }
                            });

                            const result = await response.json();

                            if (response.ok && result.isSuccess) {
                                // ✅ REDIRECTION VERS LA LISTE (évite le 404 sur reload)
                                window.location.href = "{{ route('indexIndicator') }}";
                            } else {
                                alert(result.message || "Impossible de supprimer cet indicateur.");
                            }
                        } catch (error) {
                            console.error('Erreur lors de la suppression :', error);
                            alert("Une erreur réseau est survenue.");
                        } finally {
                            modal.hide();
                        }
                    };
                });
            });

            // 2. SELECTION DYNAMIQUE DE COLONNES (#Indicator)
            const tableHeaders = document.querySelectorAll('#Indicator th');
            const columnSelector = document.getElementById('columnSelector');

            if (columnSelector && tableHeaders.length > 0) {
                tableHeaders.forEach((header, index) => {
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    const div = document.createElement('div');
                    const label = document.createElement('label');
                    const checkbox = document.createElement('input');

                    a.className = 'dropdown-item';
                    div.className = 'form-check form-switch';
                    checkbox.type = 'checkbox';
                    checkbox.role = 'switch';
                    checkbox.className = 'columnSelector form-check-input';
                    checkbox.dataset.column = index;

                    const savedSelection = localStorage.getItem('selectedColumns#Indicator');
                    checkbox.checked = !savedSelection;

                    checkbox.addEventListener('change', function() {
                        const columnIndex = parseInt(checkbox.dataset.column);
                        toggleColumn(columnIndex, checkbox.checked);
                        saveSelection();
                    });

                    label.appendChild(document.createTextNode(header.textContent.trim()));
                    div.appendChild(label);
                    div.appendChild(checkbox);
                    a.appendChild(div);
                    li.appendChild(a);
                    columnSelector.appendChild(li);

                    header.addEventListener('click', function() {
                        sortTable(index);
                    });
                });

                loadSavedSelection();
            }

            function toggleColumn(columnIndex, show) {
                const dataTable = document.getElementById('Indicator');
                if (!dataTable) return;

                const cells = dataTable.querySelectorAll(
                    `tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`
                );

                cells.forEach(cell => {
                    cell.style.display = show ? '' : 'none';
                });
            }

            function saveSelection() {
                const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
                    .filter(c => c.checked)
                    .map(c => c.dataset.column);
                localStorage.setItem('selectedColumns#Indicator', JSON.stringify(selectedColumns));
            }

            function loadSavedSelection() {
                const savedSelection = localStorage.getItem('selectedColumns#Indicator');
                if (savedSelection) {
                    const selectedColumns = JSON.parse(savedSelection);
                    selectedColumns.forEach(columnIndex => {
                        const checkbox = document.querySelector(`.columnSelector[data-column="${columnIndex}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                            toggleColumn(parseInt(columnIndex), true);
                        }
                    });
                }
            }

            // 3. TRI DU TABLEAU
            function sortTable(columnIndex) {
                const table = document.getElementById('Indicator');
                if (!table) return;

                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                rows.sort((a, b) => {
                    const cellA = a.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';
                    const cellB = b.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';

                    return cellA.localeCompare(cellB, undefined, {
                        numeric: true,
                        sensitivity: 'base'
                    });
                });

                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            }
        });
    </script>
@endsection
