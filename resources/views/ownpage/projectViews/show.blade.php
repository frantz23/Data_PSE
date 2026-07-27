@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="p-5" style="background: linear-gradient(135deg, #ffffff 0%, #f1f8f4 60%, #4caf50 100%);">

        <div class="container-fluid py-4 px-3">

            <!-- 1. EN-TÊTE & ACTIONS -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                            <i class="bi bi-hash"></i>{{ $project->code }}
                        </span>

                        @if ($project->status == 'completed' || $project->status == 'Terminé')
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">Terminé</span>
                        @elseif($project->status == 'in_progress' || $project->status == 'En cours')
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1 rounded-pill">En cours</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-1 rounded-pill">En attente</span>
                        @endif
                    </div>
                    <h2 class="fw-bold text-dark m-0">{{ $project->name }}</h2>
                </div>

                <!-- Boutons d'action (Retour, Modifier, Supprimer) -->
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('indexProject') }}" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> Liste des projets
                    </a>
                    <a href="{{ route('editProject', ['id' => $project->id]) }}" class="btn btn-warning text-white rounded-pill px-3">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>
                    <!-- BOUTON DE SUPPRESSION AJOUTÉ -->
                    <button type="button"
                            data-id="{{ $project->id }}"
                            data-title="{{ $project->name }}"
                            class="btn btn-outline-danger rounded-pill px-3 deleteBtn">
                        <i class="bi bi-trash me-1"></i> Supprimer
                    </button>
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

        <!-- Modal de confirmation -->
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

        <!-- SCRIPTS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // GESTION DE LA SUPPRESSION DU PROJET
                const deleteButtons = document.querySelectorAll('.deleteBtn');

                deleteButtons.forEach(deleteButton => {
                    deleteButton.addEventListener('click', (event) => {
                        event.preventDefault();

                        const id = deleteButton.dataset.id;
                        const title = deleteButton.dataset.title || '';

                        const modalBody = document.querySelector('#confirmModal .modal-body');
                        modalBody.innerHTML = `Êtes-vous sûr de vouloir supprimer le projet <strong>${title}</strong> ? Cette action est irréversible.`;

                        const modalEl = document.querySelector('#confirmModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();

                        const confirmDeleteBtn = document.querySelector('.confirmDeleteAction');

                        // Action au clic sur Supprimer dans le Modal
                        confirmDeleteBtn.onclick = async () => {
                            const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');
                            if (!csrfMeta) {
                                alert("Erreur CSRF token non trouvé.");
                                return;
                            }

                            try {
                                const response = await fetch('/projects/delete/' + id, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfMeta.content,
                                        'Accept': 'application/json'
                                    }
                                });

                                const result = await response.json();

                                if (response.ok && (result.isSuccess || result.success)) {
                                    // Redirection vers la liste des projets
                                    window.location.href = "{{ route('indexProject') }}";
                                } else {
                                    alert(result.message || "Impossible de supprimer ce projet.");
                                }
                            } catch (error) {
                                console.error('Erreur:', error);
                                alert("Une erreur est survenue lors de la suppression.");
                            } finally {
                                modal.hide();
                            }
                        };
                    });
                });

            });
        </script>
    </div>
@endsection
