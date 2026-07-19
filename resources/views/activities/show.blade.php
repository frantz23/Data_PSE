@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Activity</h3>

        <a href="{{ route('admin.activity.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $activity->name }}</td>
</tr>
    <tr>
        <th>Description</th> 
        <td>{{ $activity->description }}</td>
</tr>
    <tr>
        <th>Budget</th> 
        <td>{{ $activity->budget }}</td>
</tr>
    <tr>
        <th>Start_date</th> 
        <td>{{ $activity->start_date }}</td>
</tr>
    <tr>
        <th>End_date</th> 
        <td>{{ $activity->end_date }}</td>
</tr>
    <tr>
        <th>Status</th> 
        <td>{{ $activity->status }}</td>
</tr>
    <tr>
        <th>Completion_rate</th> 
        <td>{{ $activity->completion_rate }}</td>
</tr>
    <tr>
        <th>User_id</th> 
        <td>{{ $activity->user_id }}</td>
</tr>
    <tr>
        <th>Assigned_to</th> 
        <td>{{ $activity->assigned_to }}</td>
</tr>
    <tr>
        <th>Parent_activity_id</th> 
        <td>{{ $activity->parent_activity_id }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.activity.edit', ['id' => $activity->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection