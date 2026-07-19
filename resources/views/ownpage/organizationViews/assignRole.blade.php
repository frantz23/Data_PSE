@extends('sample')

@section('title')
Assigner Role
@endsection

@section('content')
<div class="container p-5">
    <a href="{{ route('ownpage.pannel') }}" class="btn btn-danger rounded-3">Retour</a>
    <hr>
    <div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="bi bi-person-gear"></i>
                Assign User Role
            </h4>
        </div>

        <div class="card-body">
            <p class="text-muted">
                Select an organization, choose a user, and assign a role.
            </p>

            <form action="{{ route('assignOrganizationRole') }}" method="POST">
                @csrf

                <!-- Organization -->
                <div class="mb-3">
                    <label class="form-label">Organization</label>
                    <select name="organization_id" id="organization_select" class="form-control" required>
                        <option value="">-- Select Organization --</option>

                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}">
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('organization_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- User -->
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" id="user_select" class="form-control" required>
                        <option value="">-- Select User --</option>

                        <!-- @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach -->
                    </select>

                    @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Select Role --</option>

                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Assign Role
                </button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('organization_select').addEventListener('change', function () {

        let organizationId = this.value;
        let userSelect = document.getElementById('user_select');

        userSelect.innerHTML = '<option>Loading...</option>';

        if (!organizationId) {
            userSelect.innerHTML = '<option value="">-- Select User --</option>';
            return;
        }

        fetch(`/organization/${organizationId}/users`)
            .then(response => response.json())
            .then(users => {

                userSelect.innerHTML = '<option value="">-- Select User --</option>';

                users.forEach(user => {
                    userSelect.innerHTML += `
                        <option value="${user.id}">
                            ${user.name} (${user.email})
                        </option>
                    `;
                });

            })
            .catch(error => {
                console.error(error);
                userSelect.innerHTML = '<option>Error loading users</option>';
            });

    });

});
</script>
@endsection