@extends('admin')

@section('content')
    <div >
        <h3>Edit Donor</h3>
        <a href="{{ route('admin.donor.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('donors/donorForm', ['donor' => $donor])
    </div>
@endsection