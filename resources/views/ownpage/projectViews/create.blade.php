@extends('sample')

@section('title')
Créer Project
@endsection

@section('content')
<div class="p-5 bg-success text-light">
    <h3>Create Project</h3>
    <a href="{{ route('indexProject') }}" class="btn btn-danger my-1">
            Retour
    </a><hr>
    @include('ownpage.projectViews.projectFormFont')
        </div>
@endsection
