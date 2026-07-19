@extends('sample')

@section('title')
    Indicateurs
@endsection

@section('content')
    <div class="container-fluid py-4">

        <div class="row">

            <!-- LEFT SIDEBAR -->
            <div class="col-md-3">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="mb-3 fw-bold">
                            <i class="bi bi-grid-1x2-fill"></i>
                            Menu Admin ONG
                        </h5>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    📊 Dashboard
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    🏢 Organization
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('indexProgram') }}" class="text-decoration-none">
                                    📚 Programs
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('indexProject') }}" class="text-decoration-none">
                                    🧩 Projects
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('indexActivity') }}" class="text-decoration-none">
                                    📋 Activities
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('indexIndicator') }}" class="text-decoration-none">
                                    📈 Indicators
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    👥 Users
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-md-9">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        {{-- CONTENT WILL BE INJECTED HERE --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="mb-0 fw-bold">Indicators</h3>
                                <small class="text-muted">
                                    Create Indicator Here
                                </small>
                            </div>

                            <a href="{{ route('createIndicator') }}" class="btn btn-primary">
                                + New Indicator
                            </a>
                        </div>
                        <div class="row">
                            @forelse($indicators as $indicator)
                                {{-- {{ $progress =
                                $indicator->target > 0 ? min(100, round(($indicator->current_value / $indicator->target) * 100)) : 0 }} --}}
                                <div class="col-md-6 col-xl-4">
                                    <div class="card border-0 shadow-sm indicator-card h-100">
                                        <div class="card-body d-flex flex-column justify-between">

                                            <div>
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <h5 class="fw-bold mb-1">
                                                            {{ $indicator->name }}
                                                        </h5>
                                                        <small class="text-muted">
                                                            Code: {{ $indicator->code }}
                                                        </small>
                                                    </div>

                                                    <span
                                                        class="badge rounded-pill px-3 py-2
                            @if ($indicator->status === 'active') bg-success
                            @elseif($indicator->status === 'draft') bg-warning text-dark
                            @else bg-secondary @endif">
                                                        {{ ucfirst($indicator->status) }}
                                                    </span>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <small class="text-muted">Projet</small><br>
                                                        <strong class="text-truncate d-inline-block"
                                                            style="max-width: 150px;">
                                                            {{ $indicator->project->name ?? '-' }}
                                                        </strong>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted">Niveau GAR</small><br>
                                                        <span
                                                            class="badge
                                @if ($indicator->result_level === 'impact') bg-dark
                                @elseif($indicator->result_level === 'outcome') bg-info text-dark
                                @else bg-light text-dark border @endif">
                                                            {{ strtoupper($indicator->result_level) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <p class="text-muted small mb-3">
                                                    {{ Str::limit($indicator->description ?? 'Aucune description fournie.', 90, '...') }}
                                                </p>

                                                <div class="bg-light rounded p-3 mb-3">
                                                    <div class="d-flex justify-content-between small mb-2">
                                                        <span class="text-muted">Ligne de base</span>
                                                        <strong>
                                                            {{ number_format($indicator->baseline, 0, ',', ' ') }}
                                                            {{ $indicator->unit }}
                                                        </strong>
                                                    </div>

                                                    <div class="d-flex justify-content-between small mb-2">
                                                        <span class="text-muted">Valeur Actuelle</span>
                                                        <strong class="text-primary">
                                                            {{ number_format($indicator->current_value, 0, ',', ' ') }}
                                                            {{ $indicator->unit }}
                                                        </strong>
                                                    </div>

                                                    <div class="d-flex justify-content-between small mb-2">
                                                        <span class="text-muted">Target</span>
                                                        <strong>
                                                            {{ number_format($indicator->target, 0, ',', ' ') }}
                                                            {{ $indicator->unit }}
                                                        </strong>
                                                    </div>

                                                    <div class="d-flex justify-content-between small">
                                                        <span class="text-muted">Fréquence</span>
                                                        <span
                                                            class="fw-medium text-capitalize">{{ $indicator->frequency }}</span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between small mb-1">
                                                        <span class="text-muted">Réalisation</span>
                                                        <span class="fw-bold text-dark">{{ $indicator->progress }}%</span>
                                                    </div>

                                                    <div class="progress" style="height:6px;">
                                                        <div class="progress-bar
                                @if ($indicator->progress >= 100) bg-success
                                @elseif($indicator->progress >= 50) bg-primary
                                @else bg-warning @endif"
                                                            role="progressbar" style="width: {{ $indicator->progress }}%"
                                                            aria-valuenow="{{ $indicator->progress }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 mt-auto pt-2">
                                                <a href="{{ route('showIndicator', $indicator->id) }}"
                                                    class="btn btn-outline-primary btn-sm w-100">
                                                    Voir
                                                </a>

                                                <a href="{{ route('editIndicator', $indicator->id) }}"
                                                    class="btn btn-outline-warning btn-sm w-100">
                                                    Éditer
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <h5 class="text-muted">Aucun indicateur trouvé</h5>
                                    <p class="text-muted">Créez un indicateur pour commencer le suivi-évaluation</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
