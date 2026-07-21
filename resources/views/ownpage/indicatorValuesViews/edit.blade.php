@extends('sample')

@section('content')
    <div class="p-5">
        @include('ownpage.indicatorvaluesViews.indicatorvalueFormFont', ['indicatorvalue' => $indicatorvalue])
    </div>
@endsection
