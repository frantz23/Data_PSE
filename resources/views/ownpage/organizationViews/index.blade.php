@extends('sample')

@section('title')
    Gestion Organisation
@endsection

@push('styles')
    @vite('resources/css/organization.css')
@endpush

@section('content')
    <div class="container py-4">
        <!-- En-tête de la page -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <a href="{{ route('ownpage.pannel') }}" class="btn btn-outline-secondary btn-sm rounded-pill me-2">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                <h2 class="h4 d-inline-block fw-bold align-middle mb-0">Organisations</h2>
            </div>
            <a href="{{ route('createOrganization') }}" class="btn btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Créer une organisation
            </a>
        </div>

        <!-- Grille de cartes -->
        <div class="row g-4 mb-4">
            @forelse($organizations as $organization)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <!-- Image de l'organisation -->
                        @if ($organization->logo)
                            <img src="{{ asset('storage/' . $organization->logo) }}" alt="Logo de {{ $organization->name }}"
                            style="max-height: 80px; width: auto; max-width: 100%; object-fit: contain;"
                            class="img-fluid">
                        @else
                            <img src="{{ asset('images/org.jpg') }}" class="card-img-top" alt="{{ $organization->name }}"
                                style="height: 150px; object-fit: cover;">
                        @endif


                        <!-- Corps de la carte -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $organization->name }}</h5>

                            <p class="card-text text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($organization->description, 80, '...') }}
                            </p>

                            <!-- Administrateur -->
                            <div class="bg-light p-2 rounded-2 mb-3 d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="bi bi-person-badge me-1"></i>Admin:</span>
                                @if ($organization->users->first())
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">
                                        {{ $organization->users->first()->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                        Non assigné
                                    </span>
                                @endif
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('showOrganization', $organization->id) }}"
                                    class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="bi bi-info-circle me-1"></i> Détails
                                </a>
                                <button type="button" data-id="{{ $organization->id }}"
                                    class="btn btn-outline-danger btn-sm deleteBtn" title="Supprimer">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="bi bi-building-exclamation display-4"></i>
                    </div>
                    <h5 class="fw-bold">Aucune organisation trouvée</h5>
                    <p class="text-muted">Commencez par en créer une nouvelle en cliquant sur le bouton ci-dessus.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $organizations->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal de Confirmation de Suppression -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-5" id="confirmModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmation de suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fermer"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0 text-secondary">Êtes-vous sûr de vouloir supprimer cette organisation ? Cette action est
                        irréversible.</p>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger confirmDeleteAction">
                        <i class="bi bi-trash3 me-1"></i> Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
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
            const response = await fetch('/organizations/speed/' + id, {
                method: 'PUT',
                body: JSON.stringify(data), // Utilisation de JSON.stringify au lieu de JSON.stringfy
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
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch('/organizations/delete/' + id, {
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
        const tableHeaders = document.querySelectorAll('#Organization th');
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
            const savedSelection = localStorage.getItem('selectedColumns#Organization');
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
        const dataTable = document.getElementById('Organization');
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
        localStorage.setItem('selectedColumns#Organization', JSON.stringify(selectedColumns));
    }

    function loadSavedSelection() {
        const savedSelection = localStorage.getItem('selectedColumns#Organization');
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
        const table = document.getElementById('Organization');
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
</script> --}}

    <script>
        // --- 1. GESTION DE LA SUPPRESSION ---
        let organizationIdToDelete = null;

        const modalElement = document.getElementById('confirmModal');
        const confirmModal = modalElement ? new bootstrap.Modal(modalElement) : null;
        const confirmDeleteBtn = document.querySelector('.confirmDeleteAction');

        // Ouverture de la modale et enregistrement de l'ID à supprimer
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                organizationIdToDelete = button.dataset.id;
                if (confirmModal) {
                    confirmModal.show();
                }
            });
        });

        // Un SEUL écouteur sur le bouton de confirmation dans la modale
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', async () => {
                if (!organizationIdToDelete) return;

                const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) {
                    alert("Erreur : Le token CSRF est introuvable dans la balise <head>.");
                    return;
                }

                try {
                    const response = await fetch('/organizations/delete/' + organizationIdToDelete, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfTokenMeta.content
                        }
                    });

                    const result = await response.json();

                    if (response.ok && result.isSuccess) {
                        window.location.reload(); // Recharge la page correctement
                    } else {
                        alert('Erreur lors de la suppression : ' + (result.message || 'Action impossible.'));
                    }
                } catch (error) {
                    console.error('Erreur lors de la suppression:', error);
                    alert('Une erreur serveur ou réseau est survenue.');
                } finally {
                    if (confirmModal) confirmModal.hide();
                }
            });
        }

        // --- 2. GESTION DU TABLEAU (Sécurisée si le tableau n'existe pas) ---
        function toggleColumn(columnIndex, show) {
            const dataTable = document.getElementById('Organization');
            if (!dataTable) return; // Empêche le script de planter si le tableau n'existe pas sur cette vue

            const cells = dataTable.querySelectorAll(
                `tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`
            );

            cells.forEach(cell => {
                cell.style.display = show ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('Organization');
            if (!table) return; // Ne tente pas d'initialiser les colonnes s'il s'agit d'un affichage en cartes

            const tableHeaders = table.querySelectorAll('th');
            const columnSelector = document.getElementById('columnSelector');

            if (tableHeaders && columnSelector) {
                tableHeaders.forEach(function(header, index) {
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    const div = document.createElement('div');
                    a.className = 'dropdown-item';
                    div.className = 'form-check form-switch';
                    const label = document.createElement('label');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.role = "switch";
                    checkbox.className = 'columnSelector form-check-input';
                    checkbox.dataset.column = index;

                    const savedSelection = localStorage.getItem('selectedColumns#Organization');
                    checkbox.checked = !savedSelection;

                    checkbox.addEventListener('change', function() {
                        toggleColumn(index, checkbox.checked);
                        saveSelection();
                    });

                    label.appendChild(document.createTextNode(header.textContent));
                    div.appendChild(label);
                    div.appendChild(checkbox);
                    a.appendChild(div);
                    li.appendChild(a);
                    columnSelector.appendChild(li);
                });
            }
        });
    </script>
@endsection
