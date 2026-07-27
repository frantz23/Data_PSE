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
                <button type="button" data-id="{{ $program->id }}" data-name="{{ $program->name }}"
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

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="confirmModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger confirmDeleteAction">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // GESTION DE LA SUPPRESSION DE PROGRAMME (AJAX)
            // ==========================================
            let programIdToDelete = null;
            const confirmModalEl = document.getElementById('confirmModal');
            const confirmModal = confirmModalEl ? new bootstrap.Modal(confirmModalEl) : null;
            const confirmDeleteBtn = document.querySelector('.confirmDeleteAction');

            // Clic sur le bouton de suppression
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    programIdToDelete = this.getAttribute('data-id');
                    const programName = this.getAttribute('data-name') || '';

                    const modalBody = confirmModalEl.querySelector('.modal-body');
                    if (modalBody) {
                        modalBody.innerHTML = `Êtes-vous sûr de vouloir supprimer le programme <strong>${programName}</strong> ? Cette action est irréversible.`;
                    }

                    if (confirmModal) {
                        confirmModal.show();
                    }
                });
            });

            // Confirmation dans la Modal
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', async function() {
                    if (!programIdToDelete) return;

                    // Vérification du token CSRF
                    const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');
                    if (!csrfMeta) {
                        alert("Erreur : Le token CSRF est introuvable dans le header <head> de votre layout.");
                        return;
                    }

                    try {
                        // Requête vers la route de suppression des programmes
                        const response = await fetch('/programs/delete/' + programIdToDelete, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfMeta.content,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();

                        if (response.ok && (result.isSuccess || result.success)) {
                            // Redirection vers l'index car la page actuelle de détail n'existera plus
                            window.location.href = "{{ route('indexProgram') }}";
                        } else {
                            alert(result.message || "Impossible de supprimer ce programme.");
                        }
                    } catch (error) {
                        console.error("Erreur de suppression :", error);
                        alert("Une erreur réseau est survenue lors de la suppression.");
                    } finally {
                        if (confirmModal) confirmModal.hide();
                    }
                });
            }
        });
    </script>
@endsection
