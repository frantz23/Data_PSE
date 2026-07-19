@extends('sample')

@section('title')
Create Indicator
@endsection

@section('content')
<div class="p-5">
    <h3>Create Indicator</h3>
    <a href="{{ route('indexIndicator') }}" class="btn btn-danger my-1">
            Retour
    </a>
    <hr>
    @include('ownpage.indicatorViews.indicatorFormFont')
        </div>
@endsection
