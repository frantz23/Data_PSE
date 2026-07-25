@extends('sample')

@section('title')
editer organisation
@endsection

@section('content')
<div class="container">
    @include('ownpage.organizationViews.organizationFormFont', ['organization' => $organization])
</div>
@endsection
