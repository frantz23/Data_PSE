@extends('sample')

@section('content')
<div class="p-5">
    <h3>Create Indicatorvalue</h3>
    {{-- <a href="{{ route('admin.indicatorvalue.index') }}" class="btn btn-success my-1">
            Home
    </a> --}}
    @include('ownpage.indicatorValuesViews/indicatorValueFormFont')
        </div>
@endsection
