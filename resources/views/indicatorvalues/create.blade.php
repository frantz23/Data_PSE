@extends('admin')

@section('content')
<div >
    <h3>Create Indicatorvalue</h3>
    <a href="{{ route('admin.indicatorvalue.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('indicatorvalues/indicatorvalueForm')
        </div>
@endsection
