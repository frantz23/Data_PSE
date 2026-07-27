@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card border-0 shadow-sm rounded-3">
                <!-- En-tête de la carte -->
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="bi {{ isset($user) ? 'bi-pencil-square text-success' : 'bi-person-plus text-primary' }} me-2"></i>
                        {{ isset($user) ? 'Modifier l\'utilisateur' : 'Créer un utilisateur' }}
                    </h4>
                    <a href="{{ route('indexUserOrg') }}" class="btn-close" aria-label="Fermer"></a>
                </div>

                <!-- Corps du formulaire -->
                <div class="card-body p-4">
                    <form action="{{ isset($user) ? route('updateUserOrg', ['user' => $user->id]) : route('storeUserOrg') }}" method="POST">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       placeholder="Ex: Jean Dupont"
                                       value="{{ old('name', $user->name ?? '') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Adresse Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       placeholder="nom@exemple.com"
                                       value="{{ old('email', $user->email ?? '') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Mot de passe
                                @if(!isset($user))
                                    <span class="text-danger">*</span>
                                @else
                                    <small class="text-muted fw-normal">(Laisser vide pour ne pas modifier)</small>
                                @endif
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       placeholder="{{ isset($user) ? '•••••••• (Inchangé)' : 'Saisir un mot de passe' }}"
                                       class="form-control @error('password') is-invalid @enderror"
                                       {{ isset($user) ? '' : 'required' }} />
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Organisation -->
                        <div class="mb-4">
                            <label for="organization_id" class="form-label fw-semibold">Organisation <span class="text-danger">*</span></label>
                            <select name="organization_id" id="organization_id" class="form-select select2 @error('organization_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une organisation --</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}"
                                        {{ old('organization_id', $user->organization_id ?? '') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('indexUserOrg') }}" class="btn btn-light rounded-pill px-4">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> {{ isset($user) ? 'Mettre à jour' : 'Créer l\'utilisateur' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

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
                    const response = await fetch('/users/delete/' + userIdToDelete, {
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
