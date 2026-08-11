@extends('ownpage.pannel.adminONG')

@section('title', 'Indicateurs')

@section('admin-content')
    {{-- EN-TÊTE DE LA PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">🎯 Indicateurs</h4>
            <p class="text-muted small mb-0">Suivez la performance et les résultats (GAR) de vos projets</p>
        </div>

        <a href="{{ route('createIndicator') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> New Indicator
        </a>
    </div>

    {{-- GRILLE DES INDICATEURS --}}
    <div class="row g-4">
        @forelse($indicators as $indicator)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 bg-light-subtle">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div>
                            <!-- ENTÊTE DE LA CARTE -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 text-truncate me-2" style="max-width: 170px;">
                                        {{ $indicator->name }}
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        Code: <span class="fw-semibold text-dark">{{ $indicator->code }}</span>
                                    </small>
                                </div>

                                <!-- BADGE DE STATUT -->
                                <span
                                    class="badge rounded-pill
                                    @if ($indicator->status === 'active') bg-success-subtle text-success border border-success-subtle
                                    @elseif($indicator->status === 'draft') bg-warning-subtle text-warning border border-warning-subtle
                                    @else bg-secondary-subtle text-secondary border border-secondary-subtle @endif">
                                    {{ ucfirst($indicator->status) }}
                                </span>
                            </div>

                            <!-- PROJET ET NIVEAU GAR -->
                            <div class="d-flex justify-content-between align-items-center mb-3 pt-1">
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle fw-medium text-truncate"
                                    style="max-width: 140px; font-size: 0.72rem;">
                                    <i class="bi bi-folder me-1"></i>{{ $indicator->project->name ?? 'Aucun projet' }}
                                </span>

                                <span
                                    class="badge
                                    @if ($indicator->result_level === 'impact') bg-dark text-white
                                    @elseif($indicator->result_level === 'outcome') bg-info-subtle text-info border border-info-subtle
                                    @else bg-light text-dark border @endif"
                                    style="font-size: 0.7rem;">
                                    GAR: {{ strtoupper($indicator->result_level) }}
                                </span>
                            </div>

                            <!-- DESCRIPTION -->
                            <p class="text-muted small mb-3">
                                {{ Str::limit($indicator->description ?? 'Aucune description fournie.', 85, '...') }}
                            </p>

                            <!-- METRICS / TABLEAU DES VALEURS -->
                            <div class="bg-white p-2.5 rounded-3 border mb-3">
                                <div class="row g-2 text-start">
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Ligne de base</span>
                                        <strong class="text-dark small">
                                            {{ number_format($indicator->baseline, 0, ',', ' ') }} {{ $indicator->unit }}
                                        </strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Valeur Actuelle</span>
                                        <strong class="text-primary small">
                                            {{ number_format($indicator->current_value, 0, ',', ' ') }}
                                            {{ $indicator->unit }}
                                        </strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Cible (Target)</span>
                                        <strong class="text-dark small">
                                            {{ number_format($indicator->target, 0, ',', ' ') }} {{ $indicator->unit }}
                                        </strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Fréquence</span>
                                        <span
                                            class="fw-semibold text-capitalize text-dark small">{{ $indicator->frequency }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- PROGRESSION / RÉALISATION -->
                            @php
                                $progress = $indicator->progress ?? 0;
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted fw-medium">Réalisation</span>
                                    <span class="fw-bold text-dark">{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar rounded-pill
                                        @if ($progress >= 100) bg-success
                                        @elseif($progress >= 50) bg-primary
                                        @else bg-warning @endif"
                                        role="progressbar" style="width: {{ min(100, $progress) }}%"
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('showIndicator', $indicator->id) }}"
                                class="btn btn-sm btn-outline-primary rounded-2 w-100">
                                <i class="bi bi-eye me-1"></i> Voir
                            </a>
                            <a href="{{ route('editIndicator', $indicator->id) }}"
                                class="btn btn-sm btn-outline-warning rounded-2 w-100">
                                <i class="bi bi-pencil me-1"></i> Éditer
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            {{-- ÉTAT VIDE --}}
            <div class="col-12 text-center py-5">
                <i class="bi bi-graph-up-arrow d-block fs-1 text-secondary mb-2 opacity-50"></i>
                <h6 class="fw-bold text-dark mb-1">Aucun indicateur trouvé</h6>
                <p class="text-muted small mb-3">Créez un indicateur pour commencer le suivi-évaluation</p>
                <a href="{{ route('createIndicator') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Créer un indicateur
                </a>
            </div>
        @endforelse
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $indicators->links('pagination::bootstrap-5') }}
    </div>


@endsection
