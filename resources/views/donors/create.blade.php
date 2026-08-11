@extends('admin')

@section('content')
<div >
    <h3>Create Donor</h3>
    <a href="{{ route('admin.donor.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('donors/donorForm')
        </div>
@endsection
