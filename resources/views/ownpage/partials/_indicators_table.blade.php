<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 border-0">
        <div>
            <h5 class="fw-bold m-0 text-dark">
                <i class="bi bi-list-check text-primary me-2"></i>Tableau de Suivi des Indicateurs
            </h5>
            <small class="text-muted">État d'avancement des objectifs du projet</small>
        </div>
        <a href="{{ route('createIndicator', ['project_id' => $project->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i> Nouvel Indicateur
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Code & Libellé</th>
                        <th class="text-center">Valeur Cible</th>
                        <th class="text-center">Valeur Réalisée</th>
                        <th style="min-width: 200px;">Progression</th>
                        <th class="text-center">Statut</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indicators as $indicator)
                        @php
                            $target  = max($indicator->target ?? 1, 1);
                            $current = $indicator->current_value ?? 0;
                            $rate    = round(($current / $target) * 100, 1);

                            // Couleurs dynamiques selon le niveau de réalisation
                            if ($rate >= 80) {
                                $badgeBg = 'bg-success';
                                $badgeText = 'En bonne voie';
                                $progressClass = 'bg-success';
                            } elseif ($rate >= 50) {
                                $badgeBg = 'bg-warning';
                                $badgeText = 'Sous vigilance';
                                $progressClass = 'bg-warning';
                            } else {
                                $badgeBg = 'bg-danger';
                                $badgeText = 'En retard';
                                $progressClass = 'bg-danger';
                            }
                        @endphp
                        <tr>
                            <!-- Code & Nom -->
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border me-2">{{ $indicator->code ?? 'IND' }}</span>
                                <strong class="text-dark">{{ $indicator->name }}</strong>
                            </td>

                            <!-- Valeur Cible -->
                            <td class="text-center">
                                <span class="fw-bold text-secondary">{{ number_format($target, 0, ',', ' ') }}</span>
                            </td>

                            <!-- Valeur Réalisée -->
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ number_format($current, 0, ',', ' ') }}</span>
                            </td>

                            <!-- Barre de Progression -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar {{ $progressClass }} rounded-pill"
                                             role="progressbar"
                                             style="width: {{ min($rate, 100) }}%"
                                             aria-valuenow="{{ $rate }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="small fw-bold text-dark" style="min-width: 45px;">{{ $rate }}%</span>
                                </div>
                            </td>

                            <!-- Statut Badge -->
                            <td class="text-center">
                                <span class="badge {{ $badgeBg }} bg-opacity-10 text-{{ str_replace('bg-', '', $badgeBg) }} border border-{{ str_replace('bg-', '', $badgeBg) }}-subtle rounded-pill px-3 py-1 fw-semibold">
                                    {{ $badgeText }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <a href="{{ route('showIndicator', $indicator->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill" title="Voir les détails et saisies">
                                    <i class="bi bi-eye me-1"></i> Détails
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                <p class="mb-1 fw-semibold">Aucun indicateur enregistré pour ce projet.</p>
                                <small>Cliquez sur "Nouvel Indicateur" ci-dessus pour commencer le suivi.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
