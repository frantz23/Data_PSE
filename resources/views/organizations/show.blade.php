@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Organization</h3>

        <a href="{{ route('admin.organization.index') }}" class="btn btn-success my-1">
            Home
        </a>
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
            <a href="{{ route('admin.organization.edit', ['id' => $organization->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection