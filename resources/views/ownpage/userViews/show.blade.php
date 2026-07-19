@extends('sample')

@section('title')
Voir Utilisateur
@endsection

@section('content')
<div class="container p-5">
    <h3>Show User</h3>

    <a href="{{ route('indexUser') }}" class="btn btn-danger my-1">
        Retour
    </a>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>{{ $user->password }}</td>
                </tr>
                <tr>
                    <th>Organization</th>
                    <td>{{ $user->organization_id }}</td>
                </tr>

            </tbody>
        </table>

        <div>
            <a href="{{ route('editUser', ['id' => $user->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
        </div>
    </div>
    @endsection