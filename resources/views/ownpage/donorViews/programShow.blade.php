@extends('sample')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .stat-card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.08) !important;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .donor-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        object-fit: contain;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')
@php
    // --- CALCULS DES MÉTRIQUES GLOBALES ---
    $allActivities = $program->projects->pluck('activities')->flatten();
    $globalProgress = $allActivities->isNotEmpty() ? round($allActivities->avg('completion_rate'), 1) : 0;

    $totalExpenses = $program->projects->sum('actual_expense') ?? 0;
    $budgetRate = ($program->budget > 0) ? round(($totalExpenses / $program->budget) * 100, 1) : 0;

    // Détection du mode Bailleur (Lecture seule)
    $isDonorUser = auth()->user()->donor_id || (method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole('donor'));
@endphp

<div class="container-fluid px-4 py-4">

    <!-- 1. EN-TÊTE & ACTIONS -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold">
                    {{ $program->code }}
                </span>
                <span class="badge
                    @if($program->status === 'active') bg-success-subtle text-success border border-success-subtle
                    @elseif($program->status === 'completed') bg-info-subtle text-info border border-info-subtle
                    @elseif($program->status === 'draft') bg-warning-subtle text-warning border border-warning-subtle
                    @else bg-secondary-subtle text-secondary border border-secondary-subtle @endif rounded-pill px-3 py-1">
                    <i class="bi bi-circle-fill me-1 style="font-size: 0.5rem;""></i>
                    {{ ucfirst($program->status) }}
                </span>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $program->name }}</h3>
            <p class="text-muted small mb-0">
                <i class="bi bi-building me-1"></i> Partenaire de mise en œuvre : <strong>{{ $program->funding_partner ?? 'Non spécifié' }}</strong>
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('donorDashboard') }}" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>

            {{-- Masqué pour les utilisateurs bailleurs (Mode Lecture Seule) --}}
            @if(!$isDonorUser)
                <a href="{{ route('editProgram', $program->id) }}" class="btn btn-outline-warning rounded-pill px-3 btn-sm">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </a>
            @endif
        </div>
    </div>

    <!-- 2. CARTES DE STATISTIQUES & KPIS -->
    <div class="row g-3 mb-4">

        <!-- Progression Physique Globale -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card shadow-sm p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase">Avancement Physique</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $globalProgress }} %</h3>
                    </div>
                    <div class="icon-box bg-success-subtle text-success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success rounded-pill" style="width: {{ min(100, $globalProgress) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Consommation Budgétaire -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card shadow-sm p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase">Budget Alloué</span>
                        <h4 class="fw-bold text-dark mb-0 mt-1">
                            {{ number_format($program->budget, 0, ',', ' ') }} <small class="fs-6 text-muted">{{ $program->currency }}</small>
                        </h4>
                    </div>
                    <div class="icon-box bg-primary-subtle text-primary">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2 small text-muted">
                    <span>Consommé : {{ number_format($totalExpenses, 0, ',', ' ') }} {{ $program->currency }}</span>
                    <span class="fw-bold text-primary">{{ $budgetRate }}%</span>
                </div>
            </div>
        </div>

        <!-- Projets Rattachés -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card shadow-sm p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase">Projets Rattachés</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $program->projects->count() }}</h3>
                    </div>
                    <div class="icon-box bg-info-subtle text-info">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                </div>
                <span class="small text-muted mt-2 d-block">
                    {{ $program->projects->where('status', 'active')->count() }} en cours d'exécution
                </span>
            </div>
        </div>

        <!-- Co-financement -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card shadow-sm p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase">Co-financeurs</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $program->Ddonors->count() }}</h3>
                    </div>
                    <div class="icon-box bg-warning-subtle text-warning">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <span class="small text-muted mt-2 d-block">
                    Total : {{ number_format($program->Ddonors->sum('pivot.amount_contributed'), 0, ',', ' ') }} {{ $program->currency }}
                </span>
            </div>
        </div>

    </div>

    <!-- 3. NAVIGATION PAR ONGLETS -->
    <ul class="nav nav-tabs border-bottom mb-4" id="programTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                <i class="bi bi-info-circle me-1"></i> Vue d'ensemble & Fiche
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab">
                <i class="bi bi-folder me-1"></i> Projets & ONG Exécutantes ({{ $program->projects->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="donors-tab" data-bs-toggle="tab" data-bs-target="#donors" type="button" role="tab">
                <i class="bi bi-bank me-1"></i> Bailleurs & Plan de Financement
            </button>
        </li>
    </ul>

    <!-- 4. CONTENU DES ONGLETS -->
    <div class="tab-content" id="programTabContent">

        {{-- TAB 1: VUE D'ENSEMBLE --}}
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <div class="row g-4">
                <!-- Description -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-file-text text-primary me-2"></i> Description du Programme
                        </h5>
                        <div class="text-secondary leading-relaxed">
                            {!! !empty($program->description) ? nl2br(e($program->description)) : '<p class="text-muted italic">Aucune description disponible pour ce programme.</p>' !!}
                        </div>
                    </div>
                </div>

                <!-- Panneau latéral : Calendrier & Bailleur principal -->
                <div class="col-lg-4">
                    <!-- Bailleur Principal -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h6 class="fw-bold text-muted text-uppercase mb-3 small">Bailleur Principal</h6>
                        @if($program->donor)
                            <div class="d-flex align-items-center gap-3">
                                @if($program->donor->logo && file_exists(public_path($program->donor->logo)))
                                    <img src="{{ asset($program->donor->logo) }}" alt="{{ $program->donor->name }}" class="donor-avatar" style="width: 20%">
                                @else
                                    <div class="donor-avatar d-flex align-items-center justify-content-center text-primary fw-bold">
                                        {{ strtoupper(substr($program->donor->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $program->donor->name }}</h6>
                                    <small class="text-muted">{{ $program->donor->code }} | {{ $program->donor->type ?? 'Bailleur' }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-0"><i class="bi bi-exclamation-circle me-1"></i> Aucun bailleur principal rattaché.</p>
                        @endif
                    </div>

                    <!-- Calendrier -->
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h6 class="fw-bold text-muted text-uppercase mb-3 small">Période d'Exécution</h6>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small">Date de début :</span>
                            <span class="fw-semibold text-dark">{{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted small">Date de fin :</span>
                            <span class="fw-semibold text-dark">{{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 2: PROJETS & ONG EXÉCUTANTES --}}
        <div class="tab-pane fade" id="projects" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Projets Rattachés & Organisations Exécutantes</h5>
                </div>
                <div class="card-body p-0">
                    @if($program->projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="text-muted small text-uppercase">
                                        <th class="ps-4">Projet</th>
                                        <th>ONG Exécutante</th>
                                        <th>Budget Projet</th>
                                        <th>Avancement</th>
                                        <th>Statut</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($program->projects as $project)
                                        @php
                                            $projProgress = $project->activities->avg('completion_rate') ?? 0;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $project->name }}</div>
                                                <small class="text-muted">Code: {{ $project->code ?? 'N/A' }}</small>
                                            </td>

                                            {{-- ONG EXÉCUTANTE --}}
                                            <td>
                                                @if($project->organization)
                                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-medium">
                                                        <i class="bi bi-building me-1 text-primary"></i>
                                                        {{ $project->organization->name }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">Non assignée</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="fw-semibold text-dark">
                                                    {{ number_format($project->budget ?? 0, 0, ',', ' ') }} {{ $program->currency }}
                                                </span>
                                            </td>

                                            <td style="min-width: 140px;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 6px;">
                                                        <div class="progress-bar bg-success rounded-pill" style="width: {{ min(100, $projProgress) }}%;"></div>
                                                    </div>
                                                    <small class="fw-bold text-muted">{{ round($projProgress, 1) }}%</small>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge @if($project->status === 'completed') bg-success-subtle text-success @else bg-warning-subtle text-warning @endif rounded-pill px-2.5">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>

                                            <td class="text-end pe-4">
                                                <a href="{{ route('project_dashboard_Donor', $project->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="bi bi-eye me-1"></i> Consulter
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-folder-blank fs-1 text-muted opacity-50"></i>
                            <p class="text-muted small mt-2 mb-0">Aucun projet n'est rattaché à ce programme pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB 3: BAILLEURS & CO-FINANCEMENT --}}
        <div class="tab-pane fade" id="donors" role="tabpanel">
            <div class="row g-4">

                <!-- Bailleur Principal -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-star me-1"></i> Bailleur Principal
                        </h6>
                        @if($program->donor)
                            <div class="d-flex align-items-start gap-3">
                                @if($program->donor->logo && file_exists(public_path($program->donor->logo)))
                                    <img src="{{ asset($program->donor->logo) }}" alt="{{ $program->donor->name }}" class="donor-avatar" style="width: 20%">
                                @else
                                    <div class="donor-avatar d-flex align-items-center justify-content-center text-primary fw-bold">
                                        {{ strtoupper(substr($program->donor->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $program->donor->name }}</h6>
                                    <p class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i> {{ $program->donor->email ?? 'Non renseigné' }}</p>
                                    <p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i> {{ $program->donor->phone ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-0">Aucun bailleur principal configuré.</p>
                        @endif
                    </div>
                </div>

                <!-- Co-Financeurs (Table Pivot Ddonors) -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-diagram-3 me-1"></i> Partenaires Co-Financeurs
                        </h6>

                        {{-- @if($program->Ddonors->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="text-muted small">
                                            <th>Bailleur</th>
                                            <th>Code</th>
                                            <th class="text-end">Montant Contribué</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($program->Ddonors as $coDonor)
                                            <tr>
                                                <td class="fw-semibold text-dark">{{ $coDonor->name }}</td>
                                                <td><span class="badge bg-light text-dark border">{{ $coDonor->code }}</span></td>
                                                <td class="text-end fw-bold text-success">
                                                    {{ number_format($coDonor->pivot->amount_contributed ?? 0, 0, ',', ' ') }} {{ $program->currency }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted small mb-0">Aucun co-financeur additionnel enregistré pour ce programme.</p>
                        @endif --}}

                        {{$program->funding_partner}}
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
