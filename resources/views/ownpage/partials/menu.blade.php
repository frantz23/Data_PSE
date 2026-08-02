
<style>
    .nav-pills .nav-link {
    transition: all 0.2s ease-in-out;
}

.nav-pills .nav-link:not(.active):hover {
    background-color: #f8f9fa;
    color: #0d6efd !important;
    transform: translateX(3px);
}
</style>

<div class="container-fluid py-2">
    <div class="row g-4">

        <!-- SIDEBAR VERTICALE -->
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 1.5rem; z-index: 10;">
                <div class="card-body p-3">

                    <!-- En-tête du menu -->
                    <div class="d-flex align-items-center gap-3 px-2 pb-3 mb-3 border-bottom">
                        <div class="bg-primary-subtle text-primary p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-grid-1x2-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Menu Admin ONG</h6>
                            <span class="text-muted" style="font-size: 0.75rem;">Espace de gestion</span>
                        </div>
                    </div>

                    <!-- Liens de Navigation -->
                    <div class="nav nav-pills flex-column gap-1">

                        {{-- Dashboard --}}
                        <a href="{{ route('indexDash') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexDash*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Dashboard</span>
                        </a>

                        {{-- Programmes --}}
                        <a href="{{ route('indexProgram') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexProgram*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-journal-bookmark fs-5"></i>
                            <span>Programmes</span>
                        </a>

                        {{-- Projets --}}
                        <a href="{{ route('indexProject') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexProject*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-kanban fs-5"></i>
                            <span>Projets</span>
                        </a>

                        {{-- Activités --}}
                        <a href="{{ route('indexActivity') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexActivity*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-list-check fs-5"></i>
                            <span>Activités</span>
                        </a>

                        {{-- Indicateurs --}}
                        <a href="{{ route('indexIndicator') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexIndicator*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-graph-up-arrow fs-5"></i>
                            <span>Indicateurs</span>
                        </a>

                        {{-- Utilisateurs --}}
                        <a href="{{ route('indexUserOrg') }}"
                           class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('indexUserOrg*') ? 'active bg-primary text-white shadow-sm fw-semibold' : 'text-secondary bg-hover-light' }}">
                            <i class="bi bi-people fs-5"></i>
                            <span>Utilisateurs</span>
                        </a>

                    </div>

                </div>
            </div>
        </div>

        <!-- CONTENU PRINCIPAL A DROITE -->
        <div class="col-lg-9 col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    @yield('admin-content')
                </div>
            </div>
        </div>

    </div>
</div>
