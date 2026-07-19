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
                            <a href="{{ route('dashboard') }}" class="btn rounded-3 border-light text-light d-left">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Menu Admin ONG
                            </a>

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
                                <h3 class="mb-0 fw-bold">Projects</h3>
                                <small class="text-muted">
                                    Operational execution of programs
                                </small>
                            </div>

                            <a href="{{ route('createProject') }}" class="btn btn-primary">
                                + New Project
                            </a>
                        </div>

                        <div class="row g-4">

                            @forelse($projects as $project)
                                <div class="col-md-6 col-xl-4">

                                    <div class="card border-0 shadow-sm project-card h-100">

                                        <div class="card-body">

                                            <!-- HEADER -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">

                                                <div>
                                                    <h5 class="fw-bold mb-1">
                                                        {{ $project->name }}
                                                    </h5>

                                                    <small class="text-muted">
                                                        Code: {{ $project->code }}
                                                    </small>
                                                </div>

                                                <span
                                                    class="badge rounded-pill px-3 py-2
                        @if ($project->status === 'active') bg-success
                        @elseif($project->status === 'draft') bg-secondary
                        @elseif($project->status === 'completed') bg-primary
                        @else bg-danger @endif">
                                                    {{ ucfirst($project->status) }}
                                                </span>

                                            </div>

                                            <!-- PROGRAM LINK -->
                                            <div class="mb-2">
                                                <small class="text-muted">Program</small><br>
                                                <strong>
                                                    {{ $project->program->name ?? '-' }}
                                                </strong>
                                            </div>

                                            <!-- DESCRIPTION -->
                                            <p class="text-muted small mb-3">
                                                {{ Str::limit($project->description, 90, '...') }}
                                            </p>

                                            <!-- KPI BLOCK -->
                                            <div class="bg-light rounded p-3 mb-3">

                                                <div class="d-flex justify-content-between small mb-2">
                                                    <span class="text-muted">Budget</span>
                                                    <strong>
                                                        {{ number_format($project->budget, 0, ',', ' ') ?? 0 }}
                                                    </strong>
                                                </div>

                                                <div class="d-flex justify-content-between small mb-2">
                                                    <span class="text-muted">Start</span>
                                                    <span>{{ $project->start_date ?? '-' }}</span>
                                                </div>

                                                <div class="d-flex justify-content-between small">
                                                    <span class="text-muted">End</span>
                                                    <span>{{ $project->end_date ?? '-' }}</span>
                                                </div>

                                            </div>

                                            <!-- PROGRESS (GAR READY) -->
                                            <div class="mb-3">

                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span class="text-muted">Progress</span>
                                                    <span class="text-muted">0%</span>
                                                </div>

                                                <div class="progress" style="height:6px;">
                                                    <div class="progress-bar bg-primary" style="width:0%"></div>
                                                </div>

                                            </div>

                                            <!-- ACTIONS -->
                                            <div class="d-flex gap-2">

                                                <a href="{{ route('showProject', $project->id) }}"
                                                    class="btn btn-outline-primary btn-sm w-100">
                                                    View
                                                </a>

                                                <a href="{{ route('editProject', $project->id) }}"
                                                    class="btn btn-outline-warning btn-sm w-100">
                                                    Edit
                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-12 text-center py-5">
                                    <h5 class="text-muted">No projects found</h5>
                                    <p class="text-muted">Create a project to start execution</p>
                                </div>
                            @endforelse

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
