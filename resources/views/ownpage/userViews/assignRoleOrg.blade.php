@extends('ownpage.pannel.adminONG')

@section('title', 'Assigner un Rôle')

@section('admin-content')
    {{-- EN-TÊTE DE LA PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-gear text-primary me-2"></i>Assignation de Rôle
            </h4>
            <p class="text-muted small mb-0">Attribuez un rôle spécifique à un membre au sein d'une organisation</p>
        </div>

        <a href="{{ route('ownpage.pannel') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Retour au panel
        </a>
    </div>

    {{-- MESSAGE DE SUCCÈS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FORMULAIRE D'ASSIGNATION --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">

                    <form action="{{ route('assignOrgRole') }}" method="POST">
                        @csrf

                        <!-- 1. Organisation -->
                        <div class="mb-3">
                            <label for="organization_select" class="form-label fw-semibold text-dark">
                                1. Sélectionner l'Organisation <span class="text-danger">*</span>
                            </label>
                            <select name="organization_id" id="organization_select" class="form-select @error('organization_id') is-invalid @enderror" required>
                                <option value="">-- Choisir une organisation --</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 2. Utilisateur -->
                        <div class="mb-3">
                            <label for="user_select" class="form-label fw-semibold text-dark">
                                2. Sélectionner l'Utilisateur <span class="text-danger">*</span>
                            </label>
                            <select name="user_id" id="user_select" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">-- Choisissez d'abord une organisation --</option>
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 3. Rôle -->
                        <div class="mb-4">
                            <label for="role_select" class="form-label fw-semibold text-dark">
                                3. Choisir le Rôle à assigner <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role_select" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Choisir un rôle --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('ownpage.pannel') }}" class="btn btn-light border rounded-pill px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Confirm & Assign
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT CORRIGÉ --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const orgSelect = document.getElementById('organization_select');
        const userSelect = document.getElementById('user_select');

        orgSelect.addEventListener('change', function () {
            let organizationId = this.value;

            userSelect.innerHTML = '<option value="">Chargement des utilisateurs...</option>';

            if (!organizationId) {
                userSelect.innerHTML = '<option value="">-- Choisissez d\'abord une organisation --</option>';
                return;
            }

            // Route corrigée vers /adminONG/{organization}/users
            fetch(`/adminONG/${organizationId}/users`)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(users => {
                    userSelect.innerHTML = '<option value="">-- Choisir un utilisateur --</option>';

                    if (users.length === 0) {
                        userSelect.innerHTML = '<option value="">Aucun utilisateur dans cette organisation</option>';
                        return;
                    }

                    users.forEach(user => {
                        userSelect.innerHTML += `
                            <option value="${user.id}">
                                ${user.name} (${user.email})
                            </option>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    userSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
    });
    </script>
@endsection
