@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Donor</h3>

        <a href="{{ route('admin.donor.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Code</th> 
        <td>{{ $donor->code }}</td>
</tr>
    <tr>
        <th>Name</th> 
        <td>{{ $donor->name }}</td>
</tr>
    <tr>
        <th>Type</th> 
        <td>{{ $donor->type }}</td>
</tr>
    <tr>
        <th>Email</th> 
        <td>{{ $donor->email }}</td>
</tr>
    <tr>
        <th>Phone</th> 
        <td>{{ $donor->phone }}</td>
</tr>
    <tr>
        <th>Website</th> 
        <td>{{ $donor->website }}</td>
</tr>
    <tr>
        <th>Address</th> 
        <td>{{ $donor->address }}</td>
</tr>
    <tr>
        <th>Logo</th> 
        <td>{{ $donor->logo }}</td>
</tr>
    <tr>
        <th>IsActive</th> 
        <td>
            <div class="form-check form-switch">
                <input name="isActive" disabled id="isActive" value="true" data-bs-toggle="toggle"  {{ $donor->isActive == 'true' ? 'checked' : '' }} class="form-check-input" type="checkbox" role="switch" />
            </div>
        </td>
    </tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.donor.edit', ['id' => $donor->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection