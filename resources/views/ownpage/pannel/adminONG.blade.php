@extends('sample')

@section('title', 'Espace Admin ONG')

@section('content')
    {{-- En-tête de bienvenue AVEC la cloche de notification intégrée --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white sticky-top">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <a href="{{ route('dashboard') }}" class="btn text-danger border rounded-pill btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                <h4 class="fw-bold text-dark mb-1">
                    Bonjour, {{ auth()->user()->name }}
                </h4>
                <p class="text-muted mb-0 small">
                    Bienvenue sur votre espace de pilotage
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 ms-1">
                        {{ auth()->user()->getRoleNames()->first() ?? 'Utilisateur' }}
                    </span>
                </p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-md-inline">
                    <i class="bi bi-calendar3 me-1"></i> {{ now()->translatedFormat('l d F Y') }}
                </span>

                {{-- BOUTON CLOCHE DE NOTIFICATION --}}
                <div class="dropdown">
                    <button
                        class="btn btn-light rounded-circle position-relative p-2 d-flex align-items-center justify-content-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 42px; height: 42px;">
                        <i class="bi bi-bell fs-5 text-dark"></i>
                        @if (auth()->user() && auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light p-1">
                                <span class="visually-hidden">notifications non lues</span>
                                <span style="font-size: 0.65rem;">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-0 overflow-hidden"
                        style="width: 350px;">
                        <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">Notifications</h6>
                            <span class="badge bg-primary-subtle text-primary rounded-pill">
                                {{ auth()->user()->unreadNotifications->count() }} non lue(s)
                            </span>
                        </div>

                        <div class="list-group list-group-flush overflow-auto" style="max-height: 320px;">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ route('markNotificationAsRead', $notification->id) }}"
                                    class="list-group-item list-group-item-action p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong
                                            class="text-dark small">{{ $notification->data['author_name'] ?? 'Utilisateur' }}</strong>
                                        <span class="text-muted"
                                            style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mb-0 text-secondary small">
                                        {{ $notification->data['message'] }}
                                        @if (!empty($notification->data['indicator_code']))
                                            <span
                                                class="badge bg-light text-primary border ms-1">#{{ $notification->data['indicator_code'] }}</span>
                                        @endif
                                    </p>
                                </a>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-bell-slash d-block fs-4 mb-2 text-secondary opacity-50"></i>
                                    <p class="small mb-0">Aucune nouvelle notification</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">

        <div class="row g-4">

            <!-- LEFT SIDEBAR VERTICALE -->
            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 1.5rem; z-index: 10;">
                    <div class="card-body p-3">

                        <!-- En-tête du menu -->
                        <div class="d-flex align-items-center gap-3 px-2 pb-3 mb-3 border-bottom">
                            <div class="bg-primary-subtle text-primary p-2 rounded-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-grid-1x2-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Menu Admin ONG</h6>
                                <span class="text-muted" style="font-size: 0.75rem;">Espace de gestion</span>
                            </div>
                        </div>

                        <!-- Liens du Menu Vertical -->
                        <div class="nav nav-pills flex-column gap-1">
                            <a href="{{ route('indexDash') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexDash*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-speedometer2 fs-5"></i>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('indexProgram') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexProgram*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-journal-bookmark fs-5"></i>
                                <span>Programs</span>
                            </a>

                            <a href="{{ route('indexProject') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexProject*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-kanban fs-5"></i>
                                <span>Projects</span>
                            </a>

                            <a href="{{ route('indexActivity') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexActivity*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-list-check fs-5"></i>
                                <span>Activities</span>
                            </a>

                            <a href="{{ route('indexIndicator') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexIndicator*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-graph-up-arrow fs-5"></i>
                                <span>Indicators</span>
                            </a>

                            <a href="{{ route('indexUserOrg') }}"
                                class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('indexUserOrg*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                                <i class="bi bi-people fs-5"></i>
                                <span>Users</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT (C'est ici qu'injectent les sous-vues) -->
            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        @yield('admin-content')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
