<!-- Style personnalisé pour réutiliser votre dégradé -->
<style>
    .btn-gradient-dark {
        background: linear-gradient(135deg, #000000 0%, #1a0000 40%, #8B0000 100%);
        color: #ffffff;
        border: none;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    .btn-gradient-dark:hover {
        color: #ffffff;
        opacity: 0.95;
        transform: translateY(-1px);
    }
    .hero-banner {
        background: linear-gradient(135deg, #000000 0%, #1a0000 60%, #4a0000 100%);
    }
</style>

<!-- NAV BAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-shield-lock-fill text-danger me-1"></i> AdminPanel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#organization">Organisations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#utilisateur">Utilisateurs</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO SECTION / BANNER -->
<section class="hero-banner text-white py-4 shadow-sm mb-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Retour au Tableau de bord
        </a>
        <div class="text-center text-md-end">
            <span class="badge bg-danger mb-1">Espace d'administration</span>
            <h5 class="mb-0 fw-light">
                Bienvenue, <span class="fw-bold">{{ auth()->user()->getRoleNames()->first() }}</span>
            </h5>
        </div>
    </div>
</section>

<!-- MAIN CONTENT SECTION -->
<section class="organization pb-5" >
    <div class="container">

        <!-- ================= SECTION 1: ORGANISATION ================= -->
        <div class="d-flex justify-content-between align-items-center mb-3" id="organization">
            <h3 class="fw-bold fs-4 mb-0">
                <i class="bi bi-building-gear text-danger me-2"></i>Organisation
            </h3>
            <a href="{{ route('indexOrganization') }}" class="btn btn-gradient-dark btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Accéder
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <!-- LOGO -->
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('storage/org.jpg') }}"
                             class="rounded-circle border shadow-sm"
                             width="80"
                             height="80"
                             style="object-fit: cover;"
                             alt="Logo organisation">
                    </div>
                    <!-- INFOS -->
                    <div class="col-md-10">
                        <h5 class="fw-bold mb-1">
                            Création des organisations et attribution des administrateurs
                        </h5>
                        <p class="text-muted mb-0">
                            Gérez l'ensemble des structures de votre plateforme, configurez leurs paramètres et supervisez leurs accès dans un espace centralisé.
                        </p>
                    </div>
                </div>

                <hr class="my-3 text-muted opacity-25">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('assignView') }}" class="btn btn-gradient-dark btn-sm rounded-pill px-3">
                        <i class="bi bi-person-plus-fill me-1"></i> Définir Admin Organisation
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= SECTION 2: UTILISATEUR ================= -->
        <div class="d-flex justify-content-between align-items-center mb-3" id="utilisateur">
            <h3 class="fw-bold fs-4 mb-0">
                <i class="bi bi-people-fill text-danger me-2"></i>Utilisateurs
            </h3>
            <a href="{{ route('indexUser') }}" class="btn btn-gradient-dark btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Accéder
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <!-- AVATAR / ICON -->
                    <div class="col-md-2 text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-gear fs-1 text-secondary"></i>
                        </div>
                    </div>
                    <!-- INFOS -->
                    <div class="col-md-10">
                        <h5 class="fw-bold mb-1">
                            Gestion des comptes utilisateurs et rôles
                        </h5>
                        <p class="text-muted mb-0">
                            Consultez la liste des comptes, attribuez les privilèges, gérez les réinitialisations de mots de passe et surveillez l'activité des utilisateurs.
                        </p>
                    </div>
                </div>

                <hr class="my-3 text-muted opacity-25">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('indexUser') }}" class="btn btn-gradient-dark btn-sm rounded-pill px-3">
                        <i class="bi bi-person-lines-fill me-1"></i> Gérer la liste des utilisateurs
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
