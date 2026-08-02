<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-list-task me-2 text-primary"></i>Résumé des Activités
        </h5>
        <span class="badge bg-primary bg-opacity-10 text-primary">
            {{ $project->activities->count() }} au total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Activité</th>
                    <th>Statut</th>
                    <th>Échéance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($project->activities->take(5) as $activity)
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark">{{ $activity->name ?? $activity->title }}</div>
                            <small class="text-muted">#{{ $activity->code ?? 'ACT-'.$activity->id }}</small>
                        </td>
                        <td>
                            @php
                                $status = $activity->status ?? 'pending';
                                $badgeClass = match($status) {
                                    'completed', 'termine' => 'bg-success',
                                    'in_progress', 'en_cours' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                                $statusLabel = match($status) {
                                    'completed', 'termine' => 'Terminée',
                                    'in_progress', 'en_cours' => 'En cours',
                                    default => 'En attente'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="small text-muted">
                            {{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Aucune activité enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
