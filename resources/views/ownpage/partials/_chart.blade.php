<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 border-0">
        <h5 class="fw-bold m-0 text-dark">
            <i class="bi bi-bar-chart-line text-primary me-2"></i>Performance par Indicateur
        </h5>

        <!-- SÉLECTEUR DE TYPE DE GRAPHIQUE -->
        <div class="btn-group btn-group-sm" role="group" id="chartTypeSwitcher">
            <button type="button" class="btn btn-outline-primary active" onclick="switchChartType('bar', 'x', this)">
                <i class="bi bi-bar-chart-fill me-1"></i> Verticaux
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="switchChartType('bar', 'y', this)">
                <i class="bi bi-bar-chart-steps me-1"></i> Horizontaux
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="switchChartType('radar', 'x', this)">
                <i class="bi bi-pie-chart-fill me-1"></i> Radar
            </button>
        </div>
    </div>

    <div class="card-body p-4 pt-0">
        <!-- Zone d'affichage du graphique -->
        <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="projectSummaryChart"></canvas>
        </div>
    </div>
</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Récupération des données transmises par Laravel
    const labels = {!! json_encode($chartLabels) !!};
    const currentData = {!! json_encode($chartCurrent) !!};
    const targetData = {!! json_encode($chartTargets) !!};

    let myChart = null;

    // Ajuste les couleurs et transparences selon le type (Radar vs Barres)
    function getDatasets(type) {
        const isRadar = (type === 'radar');

        return [
            {
                label: 'Valeur Réalisée',
                data: currentData,
                backgroundColor: isRadar ? 'rgba(13, 110, 253, 0.25)' : 'rgba(13, 110, 253, 0.85)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: isRadar ? 2 : 1,
                fill: isRadar,
                borderRadius: isRadar ? 0 : 6
            },
            {
                label: 'Valeur Cible',
                data: targetData,
                backgroundColor: isRadar ? 'rgba(108, 117, 125, 0.20)' : 'rgba(222, 226, 230, 0.85)',
                borderColor: 'rgba(108, 117, 125, 1)',
                borderWidth: isRadar ? 2 : 1,
                fill: isRadar,
                borderRadius: isRadar ? 0 : 6
            }
        ];
    }

    // Fonction globale pour faire basculer le graphique
    window.switchChartType = function(type, indexAxis, btnElement) {
        // 1. Mise à jour des boutons actifs
        document.querySelectorAll('#chartTypeSwitcher .btn').forEach(btn => btn.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        // 2. Destruction de l'instance précédente pour éviter les conflits d'axes (Cartésiens vs Radiaux)
        if (myChart) {
            myChart.destroy();
        }

        const ctx = document.getElementById('projectSummaryChart').getContext('2d');

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            }
        };

        // 3. Configuration des axes selon le type
        if (type !== 'radar') {
            options.indexAxis = indexAxis;
            options.scales = {
                y: { beginAtZero: true },
                x: { beginAtZero: true }
            };
        } else {
            options.scales = {
                r: { beginAtZero: true }
            };
        }

        // 4. Instanciation du nouveau graphique
        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: getDatasets(type)
            },
            options: options
        });
    };

    // Initialisation au chargement (Barres verticales par défaut)
    switchChartType('bar', 'x');
});
</script>
