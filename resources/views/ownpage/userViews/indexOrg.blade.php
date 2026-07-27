@extends('sample')

@section('title')
Utilisateurs
@endsection

@section('content')
<div class="container py-4">

    <!-- En-tête : Titre & Navigation -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <a href="{{ route('ownpage.pannel') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
            <h2 class="h4 fw-bold mb-0 text-dark">Gestion des Utilisateurs</h2>
        </div>

        <!-- Actions & Filtres -->
        <div class="d-flex align-items-center gap-2">
            <!-- Selector de colonnes -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-sliders me-1"></i> Colonnes
                </button>
                <ul id="columnSelector" class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="min-width: 200px;">
                    <!-- Généré dynamiquement en JS -->
                </ul>
            </div>

            <!-- Bouton Ajouter -->
            <a href="{{ route('createUserOrg') }}" class="btn btn-primary rounded-3 shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Créer un utilisateur
            </a>
        </div>
    </div>

    <!-- Carte Tableau -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="User" class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr class="text-secondary small text-uppercase fw-semibold" style="cursor: pointer;">
                            <th scope="col" class="ps-4">N# <i class="bi bi-arrow-down-up ms-1 text-muted small"></i></th>
                            <th scope="col">Nom <i class="bi bi-arrow-down-up ms-1 text-muted small"></i></th>
                            <th scope="col">Email <i class="bi bi-arrow-down-up ms-1 text-muted small"></i></th>
                            <th scope="col">Mot de passe <i class="bi bi-arrow-down-up ms-1 text-muted small"></i></th>
                            <th scope="col">Organisation <i class="bi bi-arrow-down-up ms-1 text-muted small"></i></th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 fw-semibold text-secondary">#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-medium text-dark">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary">
                                    <i class="bi bi-envelope me-1 text-muted"></i>{{ $user->email }}
                                </td>
                                <td>
                                    <span class="text-muted font-monospace fs-6">••••••••</span>
                                </td>
                                <td>
                                    @if(isset($user->organization))
                                        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                            <i class="bi bi-building me-1 text-primary"></i>{{ $user->organization->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill">
                                            ID: {{ $user->organization_id }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('showUserOrg', ['id' => $user->id]) }}" class="btn btn-sm btn-outline-primary" title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('editUserOrg', ['id' => $user->id]) }}" class="btn btn-sm btn-outline-success" title="Modifier">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" data-id="{{ $user->id }}" class="btn btn-sm btn-outline-danger deleteBtn" title="Supprimer">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                    Aucun utilisateur trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Footer -->
        @if($users->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Confirmation Suppression -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="confirmModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmation de suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body py-4 text-secondary">
                ...
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger confirmDeleteAction rounded-pill px-4">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Conservé -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ==========================================
        // 1. GESTION DE LA SUPPRESSION (AJAX)
        // ==========================================
        let userIdToDelete = null;
        const confirmModalEl = document.getElementById('confirmModal');
        const confirmModal = confirmModalEl ? new bootstrap.Modal(confirmModalEl) : null;
        const confirmDeleteBtn = document.querySelector('.confirmDeleteAction');

        // Clic sur l'un des boutons de suppression du tableau
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Récupération sécurisée de l'ID depuis data-id
                userIdToDelete = this.getAttribute('data-id');

                const modalBody = confirmModalEl.querySelector('.modal-body');
                if (modalBody) {
                    modalBody.innerHTML = `Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>#${userIdToDelete}</strong> ? Cette action est irréversible.`;
                }

                if (confirmModal) {
                    confirmModal.show();
                }
            });
        });

        // Clic sur le bouton de confirmation dans la Modal
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', async function() {
                if (!userIdToDelete) return;

                // Vérification du token CSRF
                const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');
                if (!csrfMeta) {
                    alert("Erreur : Le token CSRF est introuvable dans le header <head> de votre layout.");
                    return;
                }

                try {
                    // URL CORRIGÉE : /adminONG/users/delete/
                    const response = await fetch('/adminONG/users/delete/' + userIdToDelete, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfMeta.content,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok && (result.isSuccess || result.success)) {
                        window.location.reload(); // Recharge la page si succès
                    } else {
                        alert(result.message || "Impossible de supprimer cet utilisateur.");
                    }
                } catch (error) {
                    console.error("Erreur de suppression :", error);
                    alert("Une erreur réseau est survenue lors de la suppression.");
                } finally {
                    if (confirmModal) confirmModal.hide();
                }
            });
        }

        // ==========================================
        // 2. SÉLECTEUR DE COLONNES & TRI
        // ==========================================
        const tableHeaders = document.querySelectorAll('#User th');
        const columnSelector = document.getElementById('columnSelector');

        if (columnSelector) {
            tableHeaders.forEach(function(header, index) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                const div = document.createElement('div');
                a.className = 'dropdown-item py-1';
                div.className = 'form-check form-switch m-0 d-flex justify-content-between align-items-center';

                const label = document.createElement('label');
                label.className = 'form-check-label me-3 text-secondary style-sm';
                label.style.cursor = 'pointer';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.role = "switch";
                checkbox.className = 'columnSelector form-check-input';
                checkbox.dataset.column = index;

                const savedSelection = localStorage.getItem('selectedColumns#User');
                checkbox.checked = !!!savedSelection;

                checkbox.addEventListener('change', function() {
                    const columnIndex = parseInt(checkbox.dataset.column);
                    toggleColumn(columnIndex, checkbox.checked);
                    saveSelection();
                });

                const headerText = header.childNodes[0].textContent.trim();
                label.appendChild(document.createTextNode(headerText));

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
    });

    function toggleColumn(columnIndex, show) {
        const dataTable = document.getElementById('User');
        if (!dataTable) return;
        const cells = dataTable.querySelectorAll(`tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`);
        cells.forEach(cell => cell.style.display = show ? '' : 'none');
    }

    function saveSelection() {
        const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
            .filter(c => c.checked)
            .map(c => c.dataset.column);
        localStorage.setItem('selectedColumns#User', JSON.stringify(selectedColumns));
    }

    function loadSavedSelection() {
        const savedSelection = localStorage.getItem('selectedColumns#User');
        if (savedSelection) {
            const selectedColumns = JSON.parse(savedSelection);
            document.querySelectorAll('.columnSelector').forEach(checkbox => {
                const colIdx = checkbox.dataset.column;
                const isChecked = selectedColumns.includes(colIdx);
                checkbox.checked = isChecked;
                toggleColumn(parseInt(colIdx), isChecked);
            });
        }
    }

    function sortTable(columnIndex) {
        const table = document.getElementById('User');
        if (!table) return;
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        if (rows.length === 1 && rows[0].querySelectorAll('td').length === 1) return;

        rows.sort((a, b) => {
            const cellA = a.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';
            const cellB = b.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';
            return cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' });
        });

        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }
</script>
@endsection
