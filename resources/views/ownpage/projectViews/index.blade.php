@extends('ownpage.pannel.adminONG')

@section('title', 'Projects')

@section('admin-content')
    {{-- EN-TÊTE DE LA PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">🚀 Projects</h4>
            <p class="text-muted small mb-0">Operational execution of programs</p>
        </div>

        <a href="{{ route('createProject') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> New Project
        </a>
    </div>

    {{-- GRILLE DES PROJETS --}}
    <div class="row g-4">
        @forelse($projects as $project)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 bg-light-subtle">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div>
                            <!-- ENTÊTE DE LA CARTE -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ $project->name }}</h6>
                                    <span class="badge bg-white text-secondary border mt-1" style="font-size: 0.7rem;">
                                        Code: {{ $project->code }}
                                    </span>
                                </div>

                                <!-- BADGE DE STATUT (MODERNE) -->
                                <span class="badge rounded-pill
                                    @if ($project->status === 'active') bg-success-subtle text-success border border-success-subtle
                                    @elseif($project->status === 'draft') bg-secondary-subtle text-secondary border border-secondary-subtle
                                    @elseif($project->status === 'completed') bg-primary-subtle text-primary border border-primary-subtle
                                    @else bg-danger-subtle text-danger border border-danger-subtle @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>

                            <!-- PROGRAMME ASSOCIÉ -->
                            <div class="mb-2">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-medium" style="font-size: 0.72rem;">
                                    <i class="bi bi-journal-bookmark me-1"></i>{{ $project->program->name ?? 'No Program' }}
                                </span>
                            </div>

                            <!-- DESCRIPTION -->
                            <p class="text-muted small mb-3">
                                {{ Str::limit($project->description, 85, '...') }}
                            </p>

                            <!-- METADATA (DATES & BUDGET) -->
                            <div class="bg-white p-2 rounded-3 border mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Budget</span>
                                    <strong class="text-dark">{{ number_format($project->budget, 0, ',', ' ') }} {{ $project->currency ?? '' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Start</span>
                                    <span class="text-dark">{{ $project->start_date ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">End</span>
                                    <span class="text-dark">{{ $project->end_date ?? '-' }}</span>
                                </div>
                            </div>

                            <!-- PROGRESSION -->
                            @php
                                $progress = $project->progress ?? 0;
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted fw-medium">Progress</span>
                                    <span class="fw-bold text-dark">{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary rounded-pill" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('showProject', $project->id) }}" class="btn btn-sm btn-outline-primary rounded-2 w-100">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <a href="{{ route('editProject', $project->id) }}" class="btn btn-sm btn-outline-warning rounded-2 w-100">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            {{-- ÉTAT VIDE (EMPTY STATE) --}}
            <div class="col-12 text-center py-5">
                <i class="bi bi-kanban d-block fs-1 text-secondary mb-2 opacity-50"></i>
                <h6 class="fw-bold text-dark mb-1">No projects found</h6>
                <p class="text-muted small mb-3">Create a project to start execution</p>
                <a href="{{ route('createProject') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Create Project
                </a>
            </div>
        @endforelse
    </div>
@endsection
