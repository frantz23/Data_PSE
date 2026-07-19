@extends('admin')

@section('content')
<div >
    <h3>Create Activity</h3>
    <a href="{{ route('admin.activity.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('activities/activityForm')
        </div>
@endsection
