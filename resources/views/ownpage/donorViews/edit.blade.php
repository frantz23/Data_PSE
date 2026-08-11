@extends('sample')

@section('content')
    <div >
        @include('ownpage.donorViews.donorFormFont', ['donor' => $donor])
    </div>
@endsection
