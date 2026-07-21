<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                    <i class="bi bi-hash"></i>{{ $project->code }}
                </span>

                @if($project->status == 'completed' || $project->status == 'Terminé')
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">Terminé</span>
                @elseif($project->status == 'in_progress' || $project->status == 'En cours')
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1 rounded-pill">En cours</span>
                @else
                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-1 rounded-pill">En attente</span>
                @endif
            </div>
            <h2 class="fw-bold text-dark m-0">{{ $project->name }}</h2>
        </div>
    </div>

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
