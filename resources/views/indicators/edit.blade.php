@extends('admin')

@section('content')
    <div >
        <h3>Edit Indicator</h3>
        <a href="{{ route('admin.indicator.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('indicators/indicatorForm', ['indicator' => $indicator])
    </div>
@endsection