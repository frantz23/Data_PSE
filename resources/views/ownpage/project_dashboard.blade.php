@extends('sample')

@section('content')
    <div class="container-fluid py-4 px-4">

        {{-- 1. EN-TÊTE DU PROJET --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">PROJET
                                #{{ $project->code }}</span>
                            <span
                                class="badge bg-secondary text-capitalize">{{ $project->program->name ?? 'Programme N/A' }}</span>
                            <span class="badge {{ $project->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <h2 class="fw-bold text-dark mb-1">{{ $project->name }}</h2>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar3 me-1"></i> Période :
                            <strong>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : 'N/A' }}</strong>
                            au
                            <strong>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : 'N/A' }}</strong>
                        </p>
                    </div>

                    @if (Auth::user()->hasRole('donor'))
                        <a href="{{ route('Programdonor', $project->id) }}" class="btn btn-primary rounded-pill px-3">
                             Retour
                        </a>
                    @else
                        <div class="d-flex gap-2">
                            <a href="{{ route('showProject', $project->id) }}"
                                class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Fiche Projet
                            </a>
                            <a href="{{ route('editProject', $project->id) }}" class="btn btn-primary rounded-pill px-3">
                                <i class="bi bi-pencil me-1"></i> Modifier
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 2. CARTES KPIS (RÉPONSES RAPIDES AU CHEF DE PROJET) --}}
        <div class="row g-3 mb-4">
            {{-- Progression globale --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted text-uppercase fw-bold">Avancement Global</small>
                            <h3 class="fw-bold text-primary mb-0 mt-1">{{ $globalProgress }}%</h3>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary fs-3">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activités prévues vs terminées --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted text-uppercase fw-bold">Activités Terminées</small>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $completedActivities }} / {{ $totalActivities }}
                            </h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success fs-3">
                            <i class="bi bi-check2-square"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Indicateurs d'Extrant (Output) --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted text-uppercase fw-bold">Indicateurs Output</small>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $outputIndicatorsCount }}</h3>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info fs-3">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Budget Projet --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted text-uppercase fw-bold">Budget Total</small>
                            <h3 class="fw-bold text-dark mb-0 mt-1">
                                {{ number_format($project->budget ?? 0, 0, ',', ' ') }} <small
                                    class="fs-6">{{ $project->program->currency }}</small>
                            </h3>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning fs-3">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3 & 4. TABLEAUX PRINCIPAUX (ACTIVITÉS & INDICATEURS) --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                @include('ownpage.partials._activities_summary')
            </div>
            <div class="col-lg-6">
                @include('ownpage.partials._indicators_summary')
            </div>
        </div>

        {{-- 5 & 6. DERNIÈRES COLLECTES & JUSTIFICATIFS DEPOSÉS --}}
        <div class="row g-4 mb-4">
            {{-- Dernières collectes (IndicatorValue) --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Dernières
                            Collectes de Données</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Indicateur</th>
                                    <th>Valeur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestValues as $val)
                                    <tr>
                                        <td class="fw-semibold text-truncate" style="max-width: 200px;">
                                            {{ $val->indicator->name ?? '-' }}
                                        </td>
                                        <td>{{ $val->value_numeric ?? $val->value_text }}
                                            {{ $val->indicator->unit ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($val->reporting_date)->format('d/m/Y') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $val->validated ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $val->validated ? 'Validé' : 'En attente' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Aucune collecte récente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Derniers justificatifs (IndicatorValueFile) --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0 text-dark"><i
                                class="bi bi-file-earmark-check me-2 text-success"></i>Derniers Justificatifs Déposés</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($latestFiles as $file)
                                <li class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf fs-4 text-danger"></i>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 180px;">
                                                {{ $file->filename ?? 'Document' }}
                                            </h6>
                                            <small class="text-muted d-block">
                                                {{ $file->indicatorValue->indicator->code ?? 'N/A' }} •
                                                {{ $file->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($file->path) }}" target="_blank"
                                        class="btn btn-sm btn-light border">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </li>
                            @empty
                                <div class="text-center text-muted py-4">Aucun justificatif déposé.</div>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- 7. GRAPHIQUE RÉSUMÉ --}}
        <div class="row">
            <div class="col-12">
                @include('ownpage.partials._chart')
            </div>
        </div>

    </div>
@endsection
