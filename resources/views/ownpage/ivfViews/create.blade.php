@extends('sample')

@section('content')
<div class="p-5">
    <h3>Create Indicatorvaluefile</h3>
    {{-- <a href="{{ route('admin.indicatorvaluefile.index') }}" class="btn btn-success my-1">
            Home
    </a> --}}
    @include('ownpage.ivfViews.indicatorvaluefileFormFont')
        </div>
@endsection
