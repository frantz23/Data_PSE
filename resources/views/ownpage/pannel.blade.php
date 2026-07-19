@extends('sample')

@section('title')
{{ auth()->user()->getRoleNames()->first() }}
@endsection

@push('styles')
@vite('resources/css/pannel.css')
@endpush

@section('content')
@if(Auth::user()->hasRole('admin'))
    @include('ownpage.pannel.admin')
@endif

@if(Auth::user()->hasRole('adminONG'))
    @include('ownpage.pannel.adminONG')
@endif
@endsection