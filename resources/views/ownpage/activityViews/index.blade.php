@extends('sample')

@section('title')
    Activités
@endsection

@section('content')
    <div class="container-fluid py-4">

        <div class="row">

            <!-- LEFT SIDEBAR -->
            <div class="col-md-3">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="mb-3 fw-bold">
                            <a href="{{ route('dashboard') }}" class="btn rounded-3 border-light text-dark d-left">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Menu Admin ONG
                            </a>

                        </h5>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <a href="{{ route('indexDash') }}" class="text-decoration-none">
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
                                <a href="#" class="text-decoration-none">
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
                                <h3 class="mb-0 fw-bold">Activities</h3>
                                <small class="text-muted">
                                    Create Activities Here
                                </small>
                            </div>

                            <a href="{{ route('createActivity') }}" class="btn btn-primary">
                                + New Activity
                            </a>
                        </div>

                        <div class="row">
                            @forelse($activities as $activity)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card activity-card border-0 shadow-sm h-100">

                                        <div class="card-body">

                                            <div class="d-flex justify-content-between align-items-start mb-3">

                                                <div>
                                                    <h5 class="fw-bold mb-1">
                                                        {{ $activity->name }}
                                                    </h5>

                                                    <small class="text-muted">
                                                        {{ $activity->project->name ?? 'No Project' }}
                                                    </small>
                                                </div>

                                                @if ($activity->status == 'planned')
                                                    <span class="badge bg-secondary">
                                                        Planned
                                                    </span>
                                                @elseif($activity->status == 'ongoing')
                                                    <span class="badge bg-warning text-dark">
                                                        Ongoing
                                                    </span>
                                                @elseif($activity->status == 'completed')
                                                    <span class="badge bg-success">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        Cancelled
                                                    </span>
                                                @endif

                                            </div>

                                            <p class="text-muted small mb-3">
                                                {{ Str::limit($activity->description, 100) }}
                                            </p>

                                            <div class="mb-2">
                                                <small class="fw-semibold">
                                                    Progress
                                                </small>

                                                <div class="progress mt-1" style="height:8px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $activity->completion_rate }}%">
                                                        <!--width: {{ $activity->completion_rate }}%-->
                                                    </div>
                                                </div>

                                                <small class="text-muted">
                                                    {{ $activity->completion_rate }}%
                                                </small>
                                            </div>

                                            <div class="row text-center mt-4">

                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        Attribué à
                                                    </small>

                                                    <strong>
                                                        {{ $activity->assignee?->name ?? 'Non attribuée' }}
                                                    </strong>
                                                </div>

                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        Créé par
                                                    </small>

                                                    <strong>
                                                        {{ $activity->creator?->name }}
                                                    </strong>
                                                </div>

                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        Start
                                                    </small>

                                                    <strong>
                                                        {{ $activity->start_date }}
                                                    </strong>
                                                </div>

                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        End
                                                    </small>

                                                    <strong>
                                                        {{ $activity->end_date }}
                                                    </strong>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="card-footer bg-transparent border-0">

                                            <div class="d-flex justify-content-between">

                                                <a href="{{ route('showActivity', $activity->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    View
                                                </a>

                                                <a href="{{ route('editActivity', $activity->id) }}"
                                                    class="btn btn-outline-warning btn-sm">
                                                    Edit
                                                </a>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @empty

                                <div class="col-12">
                                    <div class="alert alert-info">
                                        No activities found. Start by creating one.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
