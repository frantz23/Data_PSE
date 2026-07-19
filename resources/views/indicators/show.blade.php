@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Indicator</h3>

        <a href="{{ route('admin.indicator.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $indicator->name }}</td>
</tr>
    <tr>
        <th>Code</th> 
        <td>{{ $indicator->code }}</td>
</tr>
    <tr>
        <th>Description</th> 
        <td>{{ $indicator->description }}</td>
</tr>
    <tr>
        <th>Result_level</th> 
        <td>{{ $indicator->result_level }}</td>
</tr>
    <tr>
        <th>Data_type</th> 
        <td>{{ $indicator->data_type }}</td>
</tr>
    <tr>
        <th>Unit</th> 
        <td>{{ $indicator->unit }}</td>
</tr>
    <tr>
        <th>Baseline</th> 
        <td>{{ $indicator->baseline }}</td>
</tr>
    <tr>
        <th>Target</th> 
        <td>{{ $indicator->target }}</td>
</tr>
    <tr>
        <th>Current_value</th> 
        <td>{{ $indicator->current_value }}</td>
</tr>
    <tr>
        <th>Frequency</th> 
        <td>{{ $indicator->frequency }}</td>
</tr>
    <tr>
        <th>Status</th> 
        <td>{{ $indicator->status }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.indicator.edit', ['id' => $indicator->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection