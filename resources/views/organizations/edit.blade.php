@extends('admin')

@section('content')
    <div >
        <h3>Edit Organization</h3>
        <a href="{{ route('admin.organization.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('organizations/organizationForm', ['organization' => $organization])
    </div>
@endsection