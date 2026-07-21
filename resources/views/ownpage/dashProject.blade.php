@extends('sample')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary mb-1">PROJET #{{ $project->code }}</span>
            <h2 class="fw-bold text-dark m-0">{{ $project->name }}</h2>
        </div>
        <a href="{{ route('showProject', $project->id) }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-eye me-1"></i> Fiche Projet
        </a>
    </div>

    <!-- 1. Les Cartes KPIs -->
    @include('ownpage.partials._kpis')

    <!-- 2. Le Graphique Résumé -->
    <div class="row my-4">
        <div class="col-12">
            @include('ownpage.partials._chart')
        </div>
    </div>

    <!-- 3. Le Tableau des Indicateurs -->
    @include('ownpage.partials._indicators_table')

</div>
@endsection
