@extends('admin')

@section('content')
    <div >
        <h3>Edit Indicatorvalue</h3>
        <a href="{{ route('admin.indicatorvalue.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('indicatorvalues/indicatorvalueForm', ['indicatorvalue' => $indicatorvalue])
    </div>
@endsection