@extends('sample')

@section('title')
    Assigner Indicateur
@endsection

@section('content')
    <form action="{{ route('attachIndicator', $activity->id) }}" method="POST" class="d-flex gap-2">

        @csrf

        <select name="indicator_id" class="form-select form-select-sm" required>
            <option value="" selected disabled>Choisir un indicateur à associer...</option>
            @foreach ($availableIndicators as $indicator)
                <option value="{{ $indicator->id }}">
                    [{{ $indicator->code }}] {{ $indicator->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm text-nowrap">
            <i class="bi bi-link-45deg"></i> Associer
        </button>
    </form>
@endsection
