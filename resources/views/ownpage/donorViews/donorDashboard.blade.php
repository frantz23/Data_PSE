@extends('sample')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .donor-avatar {
            width: 64px;
            height: 64px;
            object-fit: contain;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.08) !important;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4 py-4">

        <!-- 1. BANNIÈRE D'ACCUEIL BAILLEUR -->
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4 overflow-hidden position-relative">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if ($donor->logo && file_exists(public_path($donor->logo)))
                                <img src="{{ asset($donor->logo) }}" alt="Logo {{ $donor->name }}"
                                    class="donor-avatar rounded-3 " style="width: 10%; border: 3px gray solid">
                            @else
                                <div
                                    class="donor-avatar d-flex align-items-center justify-content-center text-primary fw-bold fs-4">
                                    {{ strtoupper(substr($donor->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <span class="badge bg-white text-primary rounded-pill px-3 py-1 mb-1 fw-semibold">Espace
                                    Partenaire</span>
                                <h2 class="fw-bold mb-0 text-white">{{ $donor->name }}</h2>
                            </div>
                        </div>
                        <p class="mb-0 text-white-50 fs-6">
                            Bienvenue sur votre portail de suivi. Retrouvez ici l'état d'avancement en temps réel de vos
                            programmes et projets financés.
                        </p><br>
                        <a href="{{route('dashboard')}}" class="btn btn-outline-light rounded-3">Retour au pannel</a>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span
                            class="badge {{ $donor->isActive ? 'bg-success' : 'bg-secondary' }} border border-light px-3 py-2 rounded-pill fs-6">
                            <i class="fa-solid {{ $donor->isActive ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                            {{ $donor->isActive ? 'Partenaire Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CARTES DE STATISTIQUES & KPIS -->
        <div class="row g-3 mb-4">

            <!-- Total Programmes / Projets -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Programmes Financés</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_projects'] }}</h3>
                        </div>
                        <div class="icon-box bg-primary-subtle text-primary">
                            <i class="fa-solid fa-diagram-project"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- En cours -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">En Cours d'Exécution</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['active_projects'] }}</h3>
                        </div>
                        <div class="icon-box bg-warning-subtle text-warning">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achevés -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Programmes Achevés</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['completed_projects'] }}</h3>
                        </div>
                        <div class="icon-box bg-success-subtle text-success">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Taux d'exécution moyen -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Progression Globale</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($stats['global_progress'], 1) }} %
                            </h3>
                        </div>
                        <div class="icon-box bg-info-subtle text-info">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. LISTE DES PROGRAMMES FINANCÉS -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div
                        class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-folder-open text-primary me-2"></i>Programmes Financés
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        @if ($programs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="text-muted small text-uppercase">
                                            <th class="ps-4">Programme</th>
                                            <th>Code</th>
                                            <th>Contribution</th>
                                            <th>Progression</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($programs as $program)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark">{{ $program->name ?? $program->title }}
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ Str::limit($program->description ?? 'Aucune description', 60) }}</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-dark border">{{ $program->code ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    @if (isset($program->budget))
                                                        <span class="fw-semibold text-success">
                                                            {{ number_format($program->budget, 0, ',', ' ') }}
                                                            {{ $program->currency }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted small">N/A</span>
                                                    @endif
                                                </td>
                                                <td style="min-width: 160px;">
                                                    {{-- <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-success"
                                                             role="progressbar"
                                                             style="width: {{ $program->global_progress ?? 0 }}%;"
                                                             aria-valuenow="{{ $program->global_progress ?? 0 }}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small fw-semibold text-muted">{{ $program->projects()->name ?? 0 }}%</span>
                                                </div> --}}
                                                    @php
                                                        $progress =
                                                            $program->projects
                                                                ->pluck('activities')
                                                                ->flatten()
                                                                ->avg('completion_rate') ?? 0;
                                                    @endphp

                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ $progress }}%;"></div>
                                                    </div>
                                                    <small class="text-muted">{{ round($progress, 1) }} %</small>
                                                </td>
                                                <td>
                                                    @if (($program->status ?? '') === 'completed')
                                                        <span
                                                            class="badge bg-success-subtle text-success border border-success-subtle">Achevé</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning-subtle text-warning border border-warning-subtle">En
                                                            cours</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('Programdonor', $program->id)}}" class="btn btn-outline-info rounded-3">Voir</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <!-- Etat vide -->
                            <div class="text-center py-5 px-3">
                                <div class="text-muted mb-3">
                                    <i class="fa-solid fa-folder-blank fs-1 opacity-50"></i>
                                </div>
                                <h6 class="fw-bold text-secondary">Aucun programme attribué pour le moment</h6>
                                <p class="text-muted small mb-0">Les programmes financés par votre structure s'afficheront
                                    ici dès leur rattachement.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
