@extends('admin')

@section('content')
    <div >
        <h3>Edit Activity</h3>
        <a href="{{ route('admin.activity.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('activities/activityForm', ['activity' => $activity])
    </div>
@endsection