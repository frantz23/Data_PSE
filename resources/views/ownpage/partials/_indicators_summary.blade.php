<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-graph-up me-2 text-info"></i>Résumé des Indicateurs
        </h5>
        <span class="badge bg-info bg-opacity-10 text-info">
            {{ $project->indicators->count() }} au total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Indicateur</th>
                    <th>Niveau</th>
                    <th>Progression</th>
                </tr>
            </thead>
            <tbody>
                @forelse($project->indicators->take(5) as $indicator)
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;" title="{{ $indicator->name }}">
                                {{ $indicator->name }}
                            </div>
                            <small class="text-muted">#{{ $indicator->code }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ strtoupper($indicator->result_level ?? 'OUTPUT') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $prog = $indicator->progress ?? 0;
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, $prog) }}%;"></div>
                                </div>
                                <span class="small fw-bold">{{ round($prog, 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Aucun indicateur associé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
