@extends('sample')

@section('title')
modifier Utilisateur
@endsection

@section('content')
    <div class="container p-5">
        <h3>Edit User</h3>
        <a href="{{ route('indexUser') }}" class="btn btn-success my-1">
                Retour
        </a>
        <hr>
        @include('ownpage.userViews.userFormFont', ['user' => $user])
    </div>
@endsection