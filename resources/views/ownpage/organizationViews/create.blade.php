@extends('sample')

@section('title')
créer organisation
@endsection

@section('content')
<div class="container">
    <h3>Create Organization</h3>
    <a href="{{ route('indexOrganization') }}" class="btn btn-success my-1">
            Retour
    </a>
    <hr>
    @include('ownpage.organizationViews.organizationFormFont')
        </div>
@endsection