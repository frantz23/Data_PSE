@extends('ownpage.pannel.adminONG')

@section('title', 'Programs')

@section('admin-content')
    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">📚 Programs</h4>
            <p class="text-muted small mb-0">Manage all your organization programs</p>
        </div>

        <a href="{{ route('createProgram') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Create Program
        </a>
    </div>

    {{-- GRILLE DES PROGRAMMES --}}
    <div class="row g-4">
        @forelse($programs as $program)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 bg-light-subtle">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ $program->name }}</h6>
                                    <span class="badge bg-white text-secondary border mt-1" style="font-size: 0.7rem;">
                                        {{ $program->code }}
                                    </span>
                                </div>

                                <span class="badge rounded-pill
                                    @if ($program->status == 'active') bg-success-subtle text-success border border-success-subtle
                                    @elseif($program->status == 'draft') bg-secondary-subtle text-secondary border border-secondary-subtle
                                    @elseif($program->status == 'completed') bg-primary-subtle text-primary border border-primary-subtle
                                    @else bg-danger-subtle text-danger border border-danger-subtle @endif">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </div>

                            <p class="text-muted small mb-3">
                                {{ Str::limit($program->description, 85) }}
                            </p>

                            <div class="bg-white p-2 rounded-3 border mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Budget</span>
                                    <strong class="text-dark">{{ number_format($program->budget, 0, ',', ' ') }} {{ $program->currency }}</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Start</span>
                                    <span class="text-dark">{{ $program->start_date ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">End</span>
                                    <span class="text-dark">{{ $program->end_date ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('showProgram', $program->id) }}" class="btn btn-sm btn-outline-primary rounded-2 w-100">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <a href="{{ route('editProgram', $program->id) }}" class="btn btn-sm btn-outline-warning rounded-2 w-100">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x d-block fs-1 text-secondary mb-2 opacity-50"></i>
                <h6 class="fw-bold text-dark mb-1">No programs found</h6>
                <p class="text-muted small mb-3">Create your first program to get started</p>
                <a href="{{ route('createProgram') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus-lg me-1"></i> Create Program
                </a>
            </div>
        @endforelse
    </div>
@endsection
