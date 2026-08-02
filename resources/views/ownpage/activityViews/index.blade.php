@extends('ownpage.pannel.adminONG')

@section('title', 'Activities')

@section('admin-content')
    {{-- EN-TÊTE DE LA PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">📋 Activities</h4>
            <p class="text-muted small mb-0">Manage and track operational activities</p>
        </div>

        <a href="{{ route('createActivity') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> New Activity
        </a>
    </div>

    {{-- GRILLE DES ACTIVITÉS --}}
    <div class="row g-4">
        @forelse($activities as $activity)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 bg-light-subtle">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div>
                            <!-- ENTÊTE DE LA CARTE -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold text-dark mb-0 text-truncate me-2" style="max-width: 70%;">
                                    {{ $activity->name }}
                                </h6>

                                <!-- BADGE DE STATUT (MODERNE) -->
                                <span class="badge rounded-pill
                                    @if ($activity->status == 'planned') bg-secondary-subtle text-secondary border border-secondary-subtle
                                    @elseif($activity->status == 'ongoing') bg-warning-subtle text-warning border border-warning-subtle
                                    @elseif($activity->status == 'completed') bg-success-subtle text-success border border-success-subtle
                                    @else bg-danger-subtle text-danger border border-danger-subtle @endif">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </div>

                            <!-- PROJET ASSOCIÉ -->
                            <div class="mb-2">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-medium" style="font-size: 0.72rem;">
                                    <i class="bi bi-kanban me-1"></i>{{ $activity->project->name ?? 'No Project' }}
                                </span>
                            </div>

                            <!-- DESCRIPTION -->
                            <p class="text-muted small mb-3">
                                {{ Str::limit($activity->description, 85, '...') }}
                            </p>

                            <!-- PROGRESSION -->
                            @php
                                $rate = $activity->completion_rate ?? 0;
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted fw-medium">Progress</span>
                                    <span class="fw-bold text-dark">{{ $rate }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary rounded-pill" style="width: {{ $rate }}%"></div>
                                </div>
                            </div>

                            <!-- METADATA (INTERVENANTS & DATES) -->
                            <div class="bg-white p-2.5 rounded-3 border mb-3">
                                <div class="row g-2 text-start">
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Attribué à</span>
                                        <strong class="text-dark text-truncate d-block small">{{ $activity->assignee?->name ?? 'Non attribuée' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Créé par</span>
                                        <strong class="text-dark text-truncate d-block small">{{ $activity->creator?->name ?? '-' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">Start</span>
                                        <span class="text-dark d-block small">{{ $activity->start_date ?? '-' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block" style="font-size: 0.7rem;">End</span>
                                        <span class="text-dark d-block small">{{ $activity->end_date ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('showActivity', $activity->id) }}" class="btn btn-sm btn-outline-primary rounded-2 w-100">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <a href="{{ route('editActivity', $activity->id) }}" class="btn btn-sm btn-outline-warning rounded-2 w-100">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            {{-- ÉTAT VIDE --}}
            <div class="col-12 text-center py-5">
                <i class="bi bi-list-check d-block fs-1 text-secondary mb-2 opacity-50"></i>
                <h6 class="fw-bold text-dark mb-1">No activities found</h6>
                <p class="text-muted small mb-3">Start by creating your first activity</p>
                <a href="{{ route('createActivity') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Create Activity
                </a>
            </div>
        @endforelse
    </div>
@endsection
