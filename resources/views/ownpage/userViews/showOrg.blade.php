@extends('sample')

@section('title')
Détails de l'utilisateur
@endsection

@section('content')
<div class="container py-4">

    <!-- En-tête : Navigation & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <a href="{{ route('indexUserOrg') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
            <h2 class="h4 fw-bold mb-0 text-dark">Fiche Utilisateur</h2>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('editUserOrg', ['id' => $user->id]) }}" class="btn btn-primary rounded-3 shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Modifier
            </a>
        </div>
    </div>

    <!-- Carte Profil -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">

                <!-- En-tête de carte avec Avatar -->
                <div class="card-body p-4 bg-light border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center fs-3 shadow-sm" style="width: 64px; height: 64px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="h5 fw-bold mb-1 text-dark">{{ $user->name }}</h3>
                            <p class="text-muted mb-0">
                                <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Grille des informations -->
                <div class="card-body p-4">
                    <div class="row g-3">

                        <!-- Identifiant -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">Identifiant (#ID)</span>
                                <span class="fw-bold text-dark">#{{ $user->id }}</span>
                            </div>
                        </div>

                        <!-- Organisation -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">Organisation</span>
                                <span class="fw-semibold text-dark">
                                    @if(isset($user->organization))
                                        <i class="bi bi-building text-primary me-1"></i>{{ $user->organization->name }}
                                    @else
                                        <i class="bi bi-building text-secondary me-1"></i>ID: {{ $user->organization_id }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Sécurité / Mot de passe -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">Mot de passe</span>
                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                    <i class="bi bi-shield-lock me-1"></i>•••••••• (Crypté)
                                </span>
                            </div>
                        </div>

                        <!-- Date de création (si existante) -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">Date d'inscription</span>
                                <span class="fw-medium text-dark">
                                    <i class="bi bi-calendar3 me-1 text-muted"></i>
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : 'N/A' }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Pied de carte -->
                <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('indexUserOrg') }}" class="btn btn-light rounded-pill px-4">
                        Retour
                    </a>
                    <a href="{{ route('editUserOrg', ['id' => $user->id]) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-pencil-square me-1"></i> Modifier cet utilisateur
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
