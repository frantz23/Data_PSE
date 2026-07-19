@extends('sample')

@section('title')
Créer Utilisateur
@endsection

@section('content')
<div class="container">
    <h3>Create User</h3>
    <a href="{{ route('indexUser') }}" class="btn btn-danger my-1">
            Home
    </a>
    @include('ownpage.userViews/userFormFont')
        </div>
@endsection
