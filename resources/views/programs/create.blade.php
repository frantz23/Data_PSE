@extends('admin')

@section('content')
<div >
    <h3>Create Program</h3>
    <a href="{{ route('admin.program.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('programs/programForm')
        </div>
@endsection
