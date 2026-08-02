@extends('sample')

@section('title', 'Tableau de bord')

@push('styles')
    @vite('resources/css/pannel.css')
@endpush

@section('content')
<div class="container-fluid py-4">



    {{-- Contenu selon le rôle --}}
    @if(Auth::user()->hasRole('admin'))
        @include('ownpage.pannel.admin')
    @endif

    @if(Auth::user()->hasRole('adminONG'))
        @include('ownpage.pannel.adminONG')
    @endif

</div>
@endsection
