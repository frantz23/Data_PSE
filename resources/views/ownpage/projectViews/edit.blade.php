@extends('sample')

@section('content')
    <div class="p-5 text-align-center bg-success text-light">
        <h3>Edit Project</h3>
        <a href="{{ route('indexProject') }}" class="btn btn-danger my-1">
                Retour
        </a><hr>
        @include('ownpage.projectViews.projectFormFont', ['project' => $project])
    </div>
@endsection