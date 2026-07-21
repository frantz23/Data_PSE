@extends('sample')

@section('title')
Project Resume
@endsection

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- 1. EN-TÊTE & KPIs CLÉS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Tableau de Bord des Projets</h2>
            <p class="text-muted small m-0">Vue d'ensemble et suivi des performances des projets</p>
        </div>
    </div>

    <!-- RANGÉE DE STATISTIQUES RAPIDES -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="bi bi-folder2-open fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Total Projets</span>
                        <span class="fs-4 fw-bold text-dark">{{ $projects->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="bi bi-play-circle fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">En Cours</span>
                        <span class="fs-4 fw-bold text-dark">{{ $projects->where('status', 'active')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3 text-warning">
                        <i class="bi bi-clock-history fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Terminé</span>
                        <span class="fs-4 fw-bold text-dark">{{ $projects->where('status', 'completed')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3 text-info">
                        <i class="bi bi-graph-up-arrow fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Indicateurs Suivis</span>
                        <span class="fs-4 fw-bold text-dark">{{ $projects->sum(fn($totalIndicator) => $totalIndicator->indicators->count())  ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 w-100">
        <div class="row bg-secondary w-100 rounded-3 shadow-sm text-light text-bold p-2">
            <h2 class="fw-bold text-light m-0">Performance globale de l'organisation</h2>
            <div class="">
                    <span class="text-white-50 text-uppercase fw-bold small">Avancement Global Moyen</span>
                    <p class="display-5 fw-bold mt-2 mb-0">{{ $globalPerformanceRate }}%</p>
                    <p class="text-white-50 small mt-2">
                        Prend en compte la progression partielle de tous les projets en cours.
                    </p>

                    <div class="progress bg-dark bg-opacity-25" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $globalPerformanceRate }}%"></div>
                    </div>
                </div>
        </div>

    </div>

    <!-- 2. BARRE DE RECHERCHE ET FILTRES -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('indexProject') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Rechercher un projet par nom ou code..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="in_progress" {{ request('status') == 'active' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-outline-secondary w-100">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. GRILLE DES CARTES DE PROJETS -->
    <div class="row g-4">
        @forelse($projects as $project)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 hover-shadow transition-all">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">

                        <div>
                            <!-- Badge Statut & Code -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-hash me-1"></i>{{ $project->code ?? 'PRJ-'.$project->id }}
                                </span>

                                @if($project->status == 'completed')
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2">Terminé</span>
                                @elseif($project->status == 'active')
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2">En cours</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary fw-bold px-3 py-2">En attente</span>
                                @endif
                            </div>

                            <!-- Titre et Description -->
                            <h5 class="fw-bold text-dark mb-2">
                                <a href="{{ route('showProject', $project->id) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $project->name }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-4 line-clamp-2">
                                {{ Str::limit($project->description ?? 'Aucune description fournie pour ce projet.', 100) }}
                            </p>
                        </div>

                        <div>
                            <!-- Progression de réalisation globale -->
                            @php $progress = $project->progress_percentage ?? 0; @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span class="text-muted">Avancement global</span>
                                    <span class="text-dark">{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <!-- Métadonnées (Indicateurs & Dates) -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top text-muted small">
                                <div>
                                    <i class="bi bi-speedometer2 me-1"></i>
                                    <strong>{{ $project->indicators_count ?? $project->indicators->count() }}</strong> indicateurs
                                </div>
                                <div>
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : 'N/A' }}
                                </div>
                            </div>

                            <!-- Bouton d'accès direct au Dashboard -->
                            <div class="mt-4">
                                <a href="{{ route('dashProject', $project->id) }}" class="btn btn-outline-primary w-100 rounded-pill fw-semibold">
                                    Voir le Dashboard <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="bi bi-folder-x fs-1 text-muted mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark">Aucun projet trouvé</h5>
                    <p class="text-muted small">Commencez par ajouter votre premier projet pour alimenter le tableau de bord.</p>
                    <div>
                        <a href="{{ route('createProject') }}" class="btn btn-primary rounded-pill px-4">
                            Créer un projet
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION (si applicable) -->
    @if(method_exists($projects, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $projects->links() }}
        </div>
    @endif

</div>
@endsection
