@extends('sample')

@section('title')
{{ auth()->user()->getRoleNames()->first() }}
@endsection

@push('styles')
@vite('resources/css/pannel.css')
@endpush

@section('content')

<li class="nav-item dropdown me-3">
    <a class="nav-link position-relative dropdown-toggle hide-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-5"></i>
        @if(auth()->user() && auth()->user()->unreadNotifications->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ auth()->user()->unreadNotifications->count() }}
                <span class="visually-hidden">notifications non lues</span>
            </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-end shadow border-0 py-0 overflow-hidden" style="width: 340px;">
        <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark">Notifications</h6>
            <span class="badge bg-primary rounded-pill">
                {{ auth()->user()->unreadNotifications->count() }} non lue(s)
            </span>
        </div>

        <div class="list-group list-group-flush overflow-auto" style="max-height: 320px;">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <a href="{{ route('markNotificationAsRead', $notification->id) }}" class="list-group-item list-group-item-action p-3">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                        <strong class="text-dark small">{{ $notification->data['author_name'] ?? 'Utilisateur' }}</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0 text-secondary small">
                        {{ $notification->data['message'] }}
                        @if(!empty($notification->data['indicator_code']))
                            <span class="fw-bold text-primary">#{{ $notification->data['indicator_code'] }}</span>
                        @endif
                    </p>
                </a>
            @empty
                <div class="p-4 text-center text-muted small">
                    <i class="bi bi-bell-slash d-block fs-4 mb-2 opacity-50"></i>
                    Aucune nouvelle notification
                </div>
            @endforelse
        </div>
    </div>
</li>

@if(Auth::user()->hasRole('admin'))
    @include('ownpage.pannel.admin')
@endif

@if(Auth::user()->hasRole('adminONG'))
    @include('ownpage.pannel.adminONG')
@endif
@endsection
