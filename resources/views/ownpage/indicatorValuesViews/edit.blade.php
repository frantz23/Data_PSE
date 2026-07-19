@extends('sample')

@section('content')
    <div class="p-5">
        <h3>Edit Indicatorvalue</h3>
        {{-- <a href="{{ route('showIndicatorValue', $) }}" class="btn btn-success my-1">
                Home
        </a> --}}
        @include('ownpage.indicatorvaluesViews.indicatorvalueFormFont', ['indicatorvalue' => $indicatorvalue])
    </div>
@endsection
