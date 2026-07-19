@extends('sample')

@section('title')
Home
@endsection

@push('styles')
@vite('resources/css/home.css')
@endpush

@section('content')
<section class="hero-section">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg custom-nav">
        <div class="container">
            <a class="navbar-brand brand-logo" href="#">
                Data_<span>PSE</span>
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto"></ul>

                <a class="btn login-btn text-primary rounded-3"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasExample">
                    Se connecter
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="container hero-container">
        <div class="row align-items-center min-vh-75">

            <!-- LEFT -->
            <div class="col-lg-6">
                <span class="hero-badge">
                    Monitoring & Evaluation Platform
                </span>

                <h1 class="hero-title mt-4">
                    Planifiez, suivez et mesurez
                    l’impact réel de vos projets
                </h1>

                <p class="hero-text mt-4">
                    Centralisez vos programmes, projets, activités et indicateurs
                    dans une plateforme moderne dédiée au suivi-évaluation
                    et à la Gestion Axée sur les Résultats (GAR).
                </p>

                <div class="mt-4 d-flex gap-3 flex-wrap">
                    <a class="btn hero-btn-primary"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasExample">
                        Commencer
                    </a>

                    <a href="#" class="btn hero-btn-secondary">
                        En savoir plus
                    </a>
                </div>

                <!-- STATS -->
                <div class="row stats-row mt-5">
                    <div class="col-4">
                        <h3>{{ $organizations }}+</h3>
                        <small>Organisations</small>
                    </div>

                    <div class="col-4">
                        <h3>{{ $projects }}+</h3>
                        <small>Projects</small>
                    </div>

                    <div class="col-4">
                        <h3>5K+</h3>
                        <small>Indicators</small>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-6 text-center">
                <img src="{{ asset('storage/heroImg.png') }}"
                    class="hero-image"
                    alt="Data PSE">
            </div>

        </div>
    </div>

    <!-- LOGIN OFFCANVAS -->
    <div class="offcanvas offcanvas-start custom-offcanvas"
        tabindex="-1"
        id="offcanvasExample">

        <div class="offcanvas-header">
            <h5>Connexion</h5>
            <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label>Email</label>
                    <input type="email"
                        name="email"
                        class="form-control custom-input"
                        required>
                </div>

                <div class="mb-4">
                    <label>Mot de passe</label>
                    <input type="password"
                        name="password"
                        class="form-control custom-input"
                        required>
                </div>

                <div class="mb-4">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <button class="btn login-submit w-100">
                    Connexion
                </button>
            </form>
        </div>
    </div>

</section>
@endsection
