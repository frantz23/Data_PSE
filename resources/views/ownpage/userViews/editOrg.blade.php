@extends('sample')

@section('title')
modifier Utilisateur
@endsection

@section('content')
    <div class="container p-5">
        @include('ownpage.userViews.userFormOrg', ['user' => $user])
    </div>
@endsection
