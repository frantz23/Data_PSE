@extends('admin')

@section('content')
    <div >
        <h3>Edit Indicatorvaluefile</h3>
        <a href="{{ route('admin.indicatorvaluefile.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('indicatorvaluefiles/indicatorvaluefileForm', ['indicatorvaluefile' => $indicatorvaluefile])
    </div>
@endsection