@extends('admin')

@section('content')
<div >
    <h3>Create Indicatorvaluefile</h3>
    <a href="{{ route('admin.indicatorvaluefile.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('indicatorvaluefiles/indicatorvaluefileForm')
        </div>
@endsection
