<section class="hero">

    <div class="container">
        <a href="{{ route('dashboard') }}" class="btn rounded-3 border-light text-light d-left"><i class="bi bi-bookmark-dash"></i> || Retour au Tableau de bord</a>
        <center>Bienvenue cher {{ auth()->user()->getRoleNames()->first() }}</center>
    </div>
</section>
<hr style="box-shadow: 2px 2px 2px 2px #1a0000">
<!-- <section class="organization">
    <div class="container">
        <h2><span><i class="bi bi-building-fill-add"></i></span>Section organisation</h2>

    </div>
</section> -->
<section class="organization py-5">
    <div class="container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">
                <i class="bi bi-building-fill-add text-danger"></i>
                Organisation
            </h2>

            <a href="{{ route('indexOrganization') }}" class="btn  btn-sm"
                style="
                     background: linear-gradient(135deg,#000000 0%,#1a0000 40%,#8B0000 100%
                    );
                color: white;
            ">
                <i class="bi bi-building-fill-add"></i> Accéder
            </a>
        </div>

        <!-- ORGANIZATION CARD -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="row align-items-center">

                    <!-- LOGO -->
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('storage/org.jpg') }}"
                            class="rounded-circle border"
                            width="80"
                            height="80"
                            alt="logo">
                    </div>

                    <!-- INFOS -->
                    <div class="col-md-6">
                        <h4 class="mb-1">
                            Creation des organisations puis leur administrateur
                        </h4>

                        <p class="text-muted mb-1">
                            Informations principales de l'organisation.
                            Un espace unique pour gérer une organisation.
                        </p>
                    </div>


                </div>

                <hr>
                <a href="{{ route('assignView') }}" class="btn  btn-sm"
                    style="
                     background: linear-gradient(135deg,#000000 0%,#1a0000 40%,#8B0000 100%
                    );
                    color: white;
                    ">
                    <i class="bi bi-building-fill-add"></i> Définir Admin Organisation
                </a>


            </div>
        </div>

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
            <h2 class="fw-bold">
                <i class="bi bi-person-circle text-danger"></i> Utilisateur
            </h2>

            <a href="{{ route('indexUser') }}" class="btn  btn-sm"
                style="
                     background: linear-gradient(135deg,#000000 0%,#1a0000 40%,#8B0000 100%
                    );
                color: white;
            ">
                <i class="bi bi-building-fill-add"></i> Accéder
            </a>
        </div>

        <!-- ORGANIZATION CARD -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="row align-items-center">

                    <!-- LOGO -->
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('storage/org.jpg') }}"
                            class="rounded-circle border"
                            width="80"
                            height="80"
                            alt="logo">
                    </div>

                    <!-- INFOS -->
                    <div class="col-md-6">
                        <h4 class="mb-1">
                            Creation des organisations puis leur administrateur
                        </h4>

                        <p class="text-muted mb-1">
                            Informations principales de l'organisation.
                            Un espace unique pour gérer une organisation.
                        </p>
                    </div>


                </div>

                <hr>
                <a href="{{ route('assignView') }}" class="btn  btn-sm"
                    style="
                     background: linear-gradient(135deg,#000000 0%,#1a0000 40%,#8B0000 100%
                    );
                    color: white;
                    ">
                    <i class="bi bi-building-fill-add"></i> Définir Admin Organisation
                </a>


            </div>
        </div>

    </div>
</section>