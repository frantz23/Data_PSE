@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Project</h3>

        <a href="{{ route('admin.project.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $project->name }}</td>
</tr>
    <tr>
        <th>Code</th> 
        <td>{{ $project->code }}</td>
</tr>
    <tr>
        <th>Description</th> 
        <td>{{ $project->description }}</td>
</tr>
    <tr>
        <th>Budget</th> 
        <td>{{ $project->budget }}</td>
</tr>
    <tr>
        <th>Start_date</th> 
        <td>{{ $project->start_date }}</td>
</tr>
    <tr>
        <th>End_date</th> 
        <td>{{ $project->end_date }}</td>
</tr>
    <tr>
        <th>Status</th> 
        <td>{{ $project->status }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.project.edit', ['id' => $project->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection