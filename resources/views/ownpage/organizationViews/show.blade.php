@extends('sample')

@section('title')
Détails - {{ $organization->name }}
@endsection

@section('content')
<div class="container py-4">

    <!-- En-tête : Navigation & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <a href="{{ route('indexOrganization') }}" class="btn btn-outline-secondary btn-sm rounded-pill me-2">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
            <h2 class="h4 d-inline-block fw-bold align-middle mb-0">Informations de l'organisation</h2>
        </div>
        <div>
            <a href="{{ route('editOrganization', $organization->id) }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
        </div>
    </div>

    <!-- Carte Principale : Logo, Nom & Statut -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                <!-- Logo -->
                <div class="flex-shrink-0 text-center">
                    @if($organization->logo)
                        <img src="{{ asset('storage/' . $organization->logo) }}"
                             alt="Logo de {{ $organization->name }}"
                             class="rounded border shadow-sm p-1"
                             style="width: 120px; height: 120px; object-fit: contain; background-color: #f8f9fa;">
                    @else
                        <div class="rounded border bg-light d-flex align-items-center justify-content-center text-secondary shadow-sm"
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                    @endif
                </div>

                <!-- Informations En-tête -->
                <div class="flex-grow-1 text-center text-md-start">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                        <h3 class="fw-bold mb-0 text-dark">{{ $organization->name }}</h3>

                        <!-- Badge Statut -->
                        @php
                            $statusClasses = [
                                'active'    => 'bg-success-subtle text-success border-success-subtle',
                                'inactive'  => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                                'suspended' => 'bg-danger-subtle text-danger border-danger-subtle',
                            ];
                            $statusLabels = [
                                'active'    => 'Actif',
                                'inactive'  => 'Inactif',
                                'suspended' => 'Suspendu',
                            ];
                            $class = $statusClasses[$organization->status] ?? 'bg-secondary-subtle text-secondary border-secondary-subtle';
                            $label = $statusLabels[$organization->status] ?? ucfirst($organization->status);
                        @endphp
                        <span class="badge border {{ $class }} px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-circle-fill me-1 small"></i> {{ $label }}
                        </span>
                    </div>

                    <p class="text-muted mb-2">
                        <i class="bi bi-link-45deg me-1"></i> <strong>Slug :</strong> <code>{{ $organization->slug }}</code>
                    </p>

                    <!-- Aperçu Couleur Principale -->
                    @if($organization->primary_color)
                        <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-1 rounded-pill border small">
                            <span class="fw-semibold text-secondary">Couleur de marque :</span>
                            <span class="rounded-circle border" style="width: 18px; height: 18px; background-color: {{ $organization->primary_color }};"></span>
                            <code>{{ $organization->primary_color }}</code>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Grille d'informations détaillées -->
    <div class="row g-4">

        <!-- Bloc : Description -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-text-paragraph text-primary me-2"></i>Description
                    </h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <p class="text-secondary lh-lg mb-0">
                        {{ $organization->description ?? 'Aucune description renseignée pour cette organisation.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Bloc : Contacts -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i>Contact
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 d-flex flex-column gap-3">

                    <div>
                        <span class="text-muted small d-block">Adresse e-mail</span>
                        <a href="mailto:{{ $organization->email }}" class="text-decoration-none fw-semibold text-dark">
                            <i class="bi bi-envelope me-2 text-primary"></i>{{ $organization->email }}
                        </a>
                    </div>

                    <div>
                        <span class="text-muted small d-block">Téléphone</span>
                        <a href="tel:{{ $organization->phone }}" class="text-decoration-none fw-semibold text-dark">
                            <i class="bi bi-telephone me-2 text-primary"></i>{{ $organization->phone }}
                        </a>
                    </div>

                    <div>
                        <span class="text-muted small d-block">Site Web</span>
                        @if($organization->website)
                            <a href="{{ $organization->website }}" target="_blank" class="text-decoration-none fw-semibold text-primary">
                                <i class="bi bi-globe me-2"></i>{{ $organization->website }} <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        @else
                            <span class="text-muted fst-italic">Non renseigné</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- Bloc : Localisation -->
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>Localisation & Adresse
                    </h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <span class="text-muted small d-block">Pays</span>
                            <span class="fw-semibold text-dark"><i class="bi bi-flag me-2 text-secondary"></i>{{ $organization->country }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted small d-block">Ville</span>
                            <span class="fw-semibold text-dark"><i class="bi bi-buildings me-2 text-secondary"></i>{{ $organization->city }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted small d-block">Adresse</span>
                            <span class="fw-semibold text-dark"><i class="bi bi-pin-map me-2 text-secondary"></i>{{ $organization->address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
