@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Indicatorvaluefile</h3>

        <a href="{{ route('admin.indicatorvaluefile.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>File_name</th> 
        <td>{{ $indicatorvaluefile->file_name }}</td>
</tr>
    <tr>
        <th>File_path</th> 
        <td>{{ $indicatorvaluefile->file_path }}</td>
</tr>
    <tr>
        <th>Mime_type</th> 
        <td>{{ $indicatorvaluefile->mime_type }}</td>
</tr>
    <tr>
        <th>File_size</th> 
        <td>{{ $indicatorvaluefile->file_size }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.indicatorvaluefile.edit', ['id' => $indicatorvaluefile->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection