@extends('sample')

@section('title')
    Programs
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

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="mb-0">Programs</h3>
                                <small class="text-muted">Manage all your organization programs</small>
                            </div>

                            <a href="{{ route('createProgram') }}" class="btn btn-primary">
                                + Create Program
                            </a>
                        </div>

                        <div class="row g-4">

                            @forelse($programs as $program)
                                <div class="col-md-6 col-lg-4">

                                    <div class="card border-0 shadow-sm h-100 program-card">

                                        <div class="card-body">

                                            <!-- HEADER -->
                                            <div class="d-flex justify-content-between align-items-start mb-2">

                                                <div>
                                                    <h5 class="mb-1">{{ $program->name }}</h5>
                                                    <small class="text-muted">
                                                        {{ $program->code }}
                                                    </small>
                                                </div>

                                                <!-- STATUS BADGE -->
                                                <span
                                                    class="badge
                            @if ($program->status == 'active') bg-success
                            @elseif($program->status == 'draft') bg-secondary
                            @elseif($program->status == 'completed') bg-primary
                            @else bg-danger @endif
                        ">
                                                    {{ ucfirst($program->status) }}
                                                </span>

                                            </div>

                                            <!-- DESCRIPTION -->
                                            <p class="text-muted small mb-3">
                                                {{ Str::limit($program->description, 90) }}
                                            </p>

                                            <!-- METADATA -->
                                            <div class="mb-3">

                                                <div class="d-flex justify-content-between small">
                                                    <span>Budget</span>
                                                    <strong>{{ number_format($program->budget, 0, ',', ' ') }}
                                                        {{ $program->currency }}</strong>
                                                </div>

                                                <div class="d-flex justify-content-between small">
                                                    <span>Start</span>
                                                    <span>{{ $program->start_date ?? '-' }}</span>
                                                </div>

                                                <div class="d-flex justify-content-between small">
                                                    <span>End</span>
                                                    <span>{{ $program->end_date ?? '-' }}</span>
                                                </div>

                                            </div>

                                            <!-- ACTIONS -->
                                            <div class="d-flex gap-2">

                                                <a href="{{ route('showProgram', $program->id) }}"
                                                    class="btn btn-sm btn-outline-primary w-100">
                                                    View
                                                </a>

                                                <a href="{{ route('editProgram', $program->id) }}"
                                                    class="btn btn-sm btn-outline-warning w-100">
                                                    Edit
                                                </a>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            @empty

                                <div class="col-12 text-center py-5">
                                    <h5 class="text-muted">No programs found</h5>
                                    <p class="text-muted">Create your first program to get started</p>
                                </div>
                            @endforelse

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>
@endsection
