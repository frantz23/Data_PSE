@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

        .info-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .donor-logo-flexible {
            max-width: 100%;
            max-height: 120px;
            /* Limite la hauteur maximale */
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- En-tête de la page -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fa-solid fa-hand-holding-dollar text-primary me-2"></i>Détails du Bailleur
                </h3>
                <p class="text-muted mb-0">Fiche d'information complète de la structure partenaire.</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('indexDonor') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Retour à la liste
                </a>
                <a href="{{ route('editDonor', ['id' => $donor->id]) }}" class="btn btn-success">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Modifier
                </a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    <i class="fa-solid fa-trash me-1"></i> Supprimer
                </button>
            </div>
        </div>

        <!-- Messages de succès/erreur éventuels -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Colonne Gauche : Carte d'identité du Bailleur -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-3 text-center p-4">

                    <!-- Logo / Avatar -->
                    {{-- <div class="mb-3 d-flex justify-content-center">
                        @if ($donor->logo)
                            <img src="{{ asset('storage/' . $donor->logo) }}" alt="{{ $donor->name }}"
                                class="donor-logo-wrapper">
                        @else
                            <div
                                class="donor-logo-wrapper bg-light d-flex align-items-center justify-content-center text-secondary border">
                                <i class="fa-solid fa-building fs-1"></i>
                            </div>
                        @endif
                    </div> --}}
                    <div class="mb-3 d-flex justify-content-center align-items-center p-3 bg-light rounded-3 border"
                        style="min-height: 140px;">
                        @if ($donor->logo)
                            <img src="{{ asset($donor->logo) }}" alt="Logo {{ $donor->name }}" style="width: 30%"
                                class="donor-logo-flexible">
                        @else
                            <div class="text-secondary text-center">
                                <i class="fa-solid fa-building fs-1 d-block mb-1"></i>
                                <small class="text-muted">Aucun logo</small>
                            </div>
                        @endif
                    </div>

                    <!-- Nom & Code -->
                    <h4 class="fw-bold mb-1 text-dark">{{ $donor->name }}</h4>
                    <div class="mb-3">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 fs-6">
                            Code : {{ $donor->code }}
                        </span>
                    </div>

                    <!-- Statut Actif/Inactif -->
                    <div class="mb-4">
                        @if ($donor->isActive == 'true' || $donor->isActive === true || $donor->isActive == 1 || $donor->is_active)
                            <span
                                class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                <i class="fa-solid fa-circle-check me-1"></i> Partenaire Actif
                            </span>
                        @else
                            <span
                                class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Partenaire Inactif
                            </span>
                        @endif
                    </div>

                    <hr class="my-3 text-muted opacity-25">

                    <!-- Métadonnées / Historique -->
                    <div class="text-start small text-muted">
                        <div class="mb-2 d-flex justify-content-between">
                            <span><i class="fa-regular fa-calendar-plus me-1"></i> Créé le :</span>
                            <strong
                                class="text-dark">{{ $donor->created_at ? $donor->created_at->format('d/m/Y à H:i') : 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fa-regular fa-clock me-1"></i> Mis à jour :</span>
                            <strong
                                class="text-dark">{{ $donor->updated_at ? $donor->updated_at->format('d/m/Y à H:i') : 'N/A' }}</strong>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Colonne Droite : Coordonnées & Informations Détaillées -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-circle-info text-primary me-2"></i>Informations Générales
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-4">

                            <!-- Type de bailleur -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <span class="info-label d-block mb-1">Type de structure</span>
                                    <span class="fw-semibold text-dark fs-6">
                                        {{ $donor->type ?? 'Non spécifié' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <span class="info-label d-block mb-1">Adresse Email</span>
                                    @if ($donor->email)
                                        <a href="mailto:{{ $donor->email }}"
                                            class="fw-semibold text-primary text-decoration-none fs-6">
                                            <i class="fa-regular fa-envelope me-1"></i>{{ $donor->email }}
                                        </a>
                                    @else
                                        <span class="text-muted fw-semibold">Non renseigné</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <span class="info-label d-block mb-1">Numéro de Téléphone</span>
                                    @if ($donor->phone)
                                        <a href="tel:{{ $donor->phone }}"
                                            class="fw-semibold text-dark text-decoration-none fs-6">
                                            <i class="fa-solid fa-phone me-1 text-muted"></i>{{ $donor->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted fw-semibold">Non renseigné</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Site Web -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <span class="info-label d-block mb-1">Site Web Offciel</span>
                                    @if ($donor->website)
                                        <a href="{{ Str::startsWith($donor->website, 'http') ? $donor->website : 'https://' . $donor->website }}"
                                            target="_blank" class="fw-semibold text-primary text-decoration-none fs-6">
                                            <i class="fa-solid fa-globe me-1"></i>{{ $donor->website }}
                                        </a>
                                    @else
                                        <span class="text-muted fw-semibold">Non renseigné</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Adresse complète -->
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3 border">
                                    <span class="info-label d-block mb-1">Adresse physique / Siège</span>
                                    <div class="fw-semibold text-dark fs-6">
                                        @if ($donor->address)
                                            <i class="fa-solid fa-location-dot text-danger me-2"></i>{{ $donor->address }}
                                        @else
                                            <span class="text-muted">Aucune adresse enregistrée</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0">Êtes-vous sûr de vouloir supprimer le bailleur <strong>{{ $donor->name }}</strong>
                        ? Cette action est définitive.</p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                    <form action="{{ route('deleteDonor', $donor) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
