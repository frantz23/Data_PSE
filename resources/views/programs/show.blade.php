@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Program</h3>

        <a href="{{ route('admin.program.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $program->name }}</td>
</tr>
    <tr>
        <th>Code</th> 
        <td>{{ $program->code }}</td>
</tr>
    <tr>
        <th>Description</th> 
        <td>{{ $program->description }}</td>
</tr>
    <tr>
        <th>Budget</th> 
        <td>{{ $program->budget }}</td>
</tr>
    <tr>
        <th>Donor</th> 
        <td>{{ $program->donor }}</td>
</tr>
    <tr>
        <th>Currency</th> 
        <td>{{ $program->currency }}</td>
</tr>
    <tr>
        <th>Funding_partner</th> 
        <td>{{ $program->funding_partner }}</td>
</tr>
    <tr>
        <th>Start_date</th> 
        <td>{{ $program->start_date }}</td>
</tr>
    <tr>
        <th>End_date</th> 
        <td>{{ $program->end_date }}</td>
</tr>
    <tr>
        <th>Status</th> 
        <td>{{ $program->status }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.program.edit', ['id' => $program->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection