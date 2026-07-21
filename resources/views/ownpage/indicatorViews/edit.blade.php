@extends('sample')

@section('title')
Editer Indicateur
@endsection

@section('content')
    <div class="p-5">
        @include('ownpage.indicatorViews.indicatorFormFont', ['indicator' => $indicator])
    </div>
@endsection
