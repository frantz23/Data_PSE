@extends('sample')

@section('title')
Editer Projet
@endsection

@section('content')
<div class="p-5">
        <h3>Edit Program</h3>
        <a href="{{ route('indexProgram') }}" class="btn btn-danger my-1">
                Retour
        </a><hr>
        @include('ownpage.programViews.programFormFont', ['program' => $program])
    </div>
@endsection