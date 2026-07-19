@extends('sample')

@section('content')
    <div class="p-5">
        <h3>Edit Activity</h3>
        <a href="{{ route('indexActivity') }}" class="btn btn-primary my-1">
                Retour
        </a>
        <hr>
        @include('ownpage.activityViews.activityFormFont', ['activity' => $activity])
    </div>
@endsection