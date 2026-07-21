<div class="row g-3">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3">
            <span class="text-muted small text-uppercase fw-bold">Performance Moyenne</span>
            <h3 class="fw-bold text-primary my-1">{{ $performanceRate }}%</h3>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-primary" style="width: {{ $performanceRate }}%"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3">
            <span class="text-muted small text-uppercase fw-bold">Total Indicateurs</span>
            <h3 class="fw-bold text-dark my-1">{{ $totalIndicators }}</h3>
            <span class="small text-muted">Indicateurs suivis dans ce projet</span>
        </div>
    </div>
</div>
