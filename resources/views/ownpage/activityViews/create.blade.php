@extends('sample')

@section('content')
<div class="p-5">
    <h3>Create Activity</h3>
    <a href="{{ route('indexActivity') }}" class="btn btn-primary my-1">
            Retour
    </a>
    @include('ownpage.activityViews.activityFormFont')
        </div>
@endsection
