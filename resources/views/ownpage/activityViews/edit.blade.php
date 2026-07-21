@extends('sample')

@section('content')
    <div class="p-5">
        @include('ownpage.activityViews.activityFormFont', ['activity' => $activity])
    </div>
@endsection
