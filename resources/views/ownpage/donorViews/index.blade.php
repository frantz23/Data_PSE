@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .table th {
            font-weight: 6-00;
            background-color: #f8f9fa;
            user-select: none;
        }
        .table th:hover {
            cursor: pointer;
            background-color: #e9ecef;
        }
        .dropdown-menu-columns {
            max-height: 300px;
            overflow-y: auto;
            min-width: 200px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- En-tête de la page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-hand-holding-dollar text-primary me-2"></i>Gestion des Bailleurs (Donors)
            </h3>
            <p class="text-muted mb-0">Consultez, gérez et suivez les partenaires financiers de la plateforme.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Sélecteur de Colonnes -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="fa-solid fa-columns me-1"></i> Colonnes
                </button>
                <ul id="columnSelector" class="dropdown-menu dropdown-menu-end dropdown-menu-columns p-2 shadow">
                    <!-- Généré dynamiquement en JS -->
                </ul>
            </div>

            <!-- Bouton Créer -->
            <a href="{{ route('createDonor') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Nouveau Bailleur
            </a>
            <a href="{{ route('ownpage.pannel') }}" class="btn btn-outline-danger">
                <i class="bi-solid fa-plus me-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Carte principale / Tableau -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="Donor" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="px-3">#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Nom du Bailleur</th>
                            <th scope="col">Type</th>
                            <th scope="col">Email</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Site Web</th>
                            <th scope="col">Adresse</th>
                            <th scope="col" class="text-center">Statut</th>
                            <th scope="col" class="text-end px-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donors as $donor)
                            <tr>
                                <td class="px-3 text-muted fw-semibold">{{ $donor->id }}</td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                        {{ $donor->code }}
                                    </span>
                                </td>

                                <td>
                                    @if($donor->logo)
                                        <img src="{{ asset($donor->logo) }}" alt="{{ $donor->name }}" class="rounded-circle border shadow-sm" width="36" height="36" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-secondary border" style="width: 36px; height: 36px;">
                                            <i class="fa-solid fa-building fs-6"></i>
                                        </div>
                                    @endif
                                </td>

                                <td class="fw-bold text-dark">{{ $donor->name }}</td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $donor->type ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    @if($donor->email)
                                        <a href="mailto:{{ $donor->email }}" class="text-decoration-none text-body small">
                                            <i class="fa-regular fa-envelope text-muted me-1"></i>{{ $donor->email }}
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="small">{{ $donor->phone ?? '-' }}</td>

                                <td>
                                    @if($donor->website)
                                        <a href="{{ Str::startsWith($donor->website, 'http') ? $donor->website : 'https://' . $donor->website }}" target="_blank" class="text-primary text-decoration-none small">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>Visiter
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="small text-truncate" style="max-width: 150px;" title="{{ $donor->address }}">
                                    {{ $donor->address ?? '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center mb-0">
                                        <input name="isActive"
                                               id="isActive_{{ $donor->id }}"
                                               data-id="{{ $donor->id }}"
                                               value="true"
                                               class="form-check-input"
                                               type="checkbox"
                                               role="switch"
                                               {{ (isset($donor->isActive) && ($donor->isActive == 'true' || $donor->isActive == 1 || $donor->isActive === true)) || (isset($donor->is_active) && $donor->is_active) ? 'checked' : '' }} />
                                    </div>
                                </td>

                                <td class="text-end px-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('showDonor', ['id' => $donor->id]) }}" class="btn btn-outline-primary" title="Voir les détails">
                                            <i class="bi-solid bi-eye"></i>
                                        </a>
                                        <a href="{{ route('editDonor', ['id' => $donor->id]) }}" class="btn btn-outline-success" title="Modifier">
                                            <i class="bi-solid bi-square"></i>
                                        </a>
                                        {{-- <button type="button" data-id="{{ $donor->id }}" data-name="{{ $donor->name }}" class="btn btn-outline-danger deleteBtn" title="Supprimer">
                                            <i class="bi-solid bi-trash"></i>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    Aucun bailleur enregistré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($donors->hasPages())
                <div class="p-3 border-top d-flex justify-content-center">
                    {{ $donors->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Confirmation de Suppression -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fs-5" id="confirmModalLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Confirmation de suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-0 modal-text-content">Êtes-vous sûr de vouloir supprimer ce bailleur ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger confirmDeleteAction">
                    <i class="fa-solid fa-trash me-1"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. GESTION DU TOGGLE ACTIF / INACTIF (AJAX)
        const checkboxes = document.querySelectorAll('input[name="isActive"]');
        checkboxes.forEach((checkbox) => {
            checkbox.onchange = async (event) => {
                const { checked, name, dataset } = event.target;
                const { id } = dataset;
                const data = { [name]: checked.toString() };
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                try {
                    const response = await fetch('/admin/donors/speed/' + id, {
                        method: 'PUT',
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    if(!response.ok) {
                        alert("Erreur lors de la mise à jour du statut.");
                        event.target.checked = !checked; // revert
                    }
                } catch (error) {
                    console.error(error);
                    event.target.checked = !checked;
                }
            };
        });

        // 2. GESTION DE LA SUPPRESSION (MODAL AJAX)
        let targetDonorId = null;
        const confirmModalElement = document.getElementById('confirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalElement);
        const modalBody = confirmModalElement.querySelector('.modal-text-content');
        const confirmDeleteBtn = confirmModalElement.querySelector('.confirmDeleteAction');

        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                targetDonorId = button.dataset.id;
                const donorName = button.dataset.name || '';

                modalBody.innerHTML = `Êtes-vous sûr de vouloir supprimer le bailleur <strong>${donorName}</strong> ?`;
                confirmModal.show();
            });
        });

        confirmDeleteBtn.addEventListener('click', async () => {
            if (!targetDonorId) return;
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/admin/donors/delete/' + targetDonorId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result && (result.isSuccess || response.ok)) {
                    window.location.reload();
                } else {
                    alert('Erreur lors de la suppression.');
                }
            } catch (error) {
                console.error(error);
                alert('Une erreur réseau est survenue.');
            } finally {
                confirmModal.hide();
            }
        });

        // 3. SÉLECTEUR DYNAMIQUE DE COLONNES & TRI DU TABLEAU
        const tableHeaders = document.querySelectorAll('#Donor th');
        const columnSelector = document.getElementById('columnSelector');

        tableHeaders.forEach(function(header, index) {
            // Ignorer la création du toggle pour la dernière colonne (Actions)
            if (index === tableHeaders.length - 1) return;

            const li = document.createElement('li');
            li.className = 'px-2 py-1';

            const div = document.createElement('div');
            div.className = 'form-check form-switch';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.role = 'switch';
            checkbox.className = 'columnSelector form-check-input me-2';
            checkbox.dataset.column = index;

            const savedSelection = localStorage.getItem('selectedColumns#Donor');
            checkbox.checked = !savedSelection; // Cochés par défaut si pas de sauvegarde

            checkbox.addEventListener('change', function() {
                toggleColumn(index, checkbox.checked);
                saveSelection();
            });

            const label = document.createElement('label');
            label.className = 'form-check-label small text-capitalize';
            label.appendChild(document.createTextNode(header.textContent.trim()));

            div.appendChild(checkbox);
            div.appendChild(label);
            li.appendChild(div);
            columnSelector.appendChild(li);

            // Rendre l'entête cliquable pour trier (sauf Actions)
            header.addEventListener('click', function() {
                sortTable(index);
            });
        });

        // Chargement initial des colonnes masquées/affichées
        loadSavedSelection();

        function toggleColumn(columnIndex, show) {
            const dataTable = document.getElementById('Donor');
            const cells = dataTable.querySelectorAll(`tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`);
            cells.forEach(cell => {
                cell.style.display = show ? '' : 'none';
            });
        }

        function saveSelection() {
            const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
                .filter(c => c.checked)
                .map(c => c.dataset.column);
            localStorage.setItem('selectedColumns#Donor', JSON.stringify(selectedColumns));
        }

        function loadSavedSelection() {
            const savedSelection = localStorage.getItem('selectedColumns#Donor');
            if (savedSelection) {
                const selectedColumns = JSON.parse(savedSelection);
                document.querySelectorAll('.columnSelector').forEach(checkbox => {
                    const colIndex = checkbox.dataset.column;
                    const isChecked = selectedColumns.includes(colIndex);
                    checkbox.checked = isChecked;
                    toggleColumn(parseInt(colIndex), isChecked);
                });
            }
        }

        function sortTable(columnIndex) {
            const table = document.getElementById('Donor');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // Ne pas trier s'il n'y a pas de données
            if (rows.length === 1 && rows[0].querySelectorAll('td').length === 1) return;

            const isAscending = table.dataset.sortOrder !== 'asc';
            table.dataset.sortOrder = isAscending ? 'asc' : 'desc';

            rows.sort((a, b) => {
                const cellA = a.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';
                const cellB = b.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';

                return isAscending
                    ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' })
                    : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: 'base' });
            });

            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }
    });
</script>
@endsection
