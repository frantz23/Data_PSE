@extends('sample')

@section('title')
editer organisation
@endsection

@section('content')
<div class="container">
    <h3>Edit Organization</h3>
    <a href="{{ route('indexOrganization') }}" class="btn btn-danger my-1">
        Retour
    </a>
    @include('ownpage.organizationViews.organizationFormFont', ['organization' => $organization])
</div>
@endsection