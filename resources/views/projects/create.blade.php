@extends('admin')

@section('content')
<div >
    <h3>Create Project</h3>
    <a href="{{ route('admin.project.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('projects/projectForm')
        </div>
@endsection
