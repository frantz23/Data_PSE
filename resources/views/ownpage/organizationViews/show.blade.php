@extends('sample')

@section('title')
Infos Organisation
@endsection

@section('content')
<div class="container">
    <h3>Les informations de l'Organization</h3>

    <a href="{{ route('indexOrganization') }}" class="btn btn-danger my-1">
        Retour
    </a>
    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $organization->name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $organization->slug }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $organization->description }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $organization->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $organization->phone }}</td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td>{{ $organization->website }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $organization->country }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $organization->city }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $organization->address }}</td>
                </tr>
                <tr>
                    <th>Logo</th>
                    <td>{{ $organization->logo }}</td>
                </tr>
                <tr>
                    <th>Primary_color</th>
                    <td>{{ $organization->primary_color }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $organization->status }}</td>
                </tr>

            </tbody>
        </table>

        <div>
            <a href="{{ route('editOrganization', ['id' => $organization->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
        </div>
    </div>

    @endsection