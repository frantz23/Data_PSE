@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Indicatorvalue</h3>

        <a href="{{ route('admin.indicatorvalue.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Value_numeric</th> 
        <td>{{ $indicatorvalue->value_numeric }}</td>
</tr>
    <tr>
        <th>Value_text</th> 
        <td>{{ $indicatorvalue->value_text }}</td>
</tr>
    <tr>
        <th>Reporting_date</th> 
        <td>{{ $indicatorvalue->reporting_date }}</td>
</tr>
    <tr>
        <th>Comment</th> 
        <td>{{ $indicatorvalue->comment }}</td>
</tr>
    <tr>
        <th>Validated</th> 
        <td>{{ $indicatorvalue->validated }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.indicatorvalue.edit', ['id' => $indicatorvalue->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection