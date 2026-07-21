<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashController extends Controller
{
    public function indexDash(): View
    {
        $orgId = auth()->user()->organization_id;

        // 1. Récupérer les projets de l'organisation AVEC leurs indicateurs
        $projects = Project::where('organization_id', $orgId)
            ->with('indicators')
            ->get();

        $totalProjects = $projects->count();

        // Total de tous les indicateurs de l'organisation
        $totalIndicators = $projects->sum(fn($p) => $p->indicators->count());

        if ($totalProjects > 0) {
            // Projets terminés & Taux d'achèvement
            $completedProjects = $projects->where('status', 'completed')->count();
            $completionRate = round(($completedProjects / $totalProjects) * 100, 1);
            $avgGlobalProgress = round($completionRate ?? 0, 1);

            // 2. Calcul de la Performance Globale de l'Organisation (Méthode 1)
            $projectsPerformance = $projects->map(function ($project) {
                $indicators = $project->indicators;

                // Si le projet n'a pas d'indicateurs, on le néglige dans la moyenne
                if ($indicators->isEmpty()) {
                    return null;
                }

                // Moyenne des indicateurs du projet
                return $indicators->avg(function ($i) {
                    $current = $i->current_value ?? 0;
                    $target  = max($i->target ?? 1, 1);

                    return min(($current / $target) * 100, 100); // Plafonné à 100%
                });
            })->filter(fn($score) => !is_null($score)); // Retire les projets sans indicateurs

            // Moyenne globale de l'ONG
            $globalPerformanceRate = $projectsPerformance->count() > 0
                ? round($projectsPerformance->avg(), 1)
                : 0;

        } else {
            $completedProjects = 0;
            $completionRate = 0;
            $avgGlobalProgress = 0;
            $globalPerformanceRate = 0;
        }

        return view('ownpage.dash', [
            'projects' => $projects,
            'totalIndicators' => $totalIndicators,
            'totalProjects' => $totalProjects,
            'completionRate' => $completionRate,
            'avgGlobalProgress' => $avgGlobalProgress,
            'completedProjects' => $completedProjects,
            'globalPerformanceRate' => $globalPerformanceRate // <-- Nouvelle variable disponible
        ]);
    }

    public function dashProject($id): View
    {
        $project = Project::with('indicators')->findOrFail($id);
        $indicators = $project->indicators;

        // Données pour le graphique résumé (Chart.js)
        $chartLabels = $indicators->pluck('name')->toArray();
        $chartCurrent = $indicators->pluck('current_value')->map(fn($v) => $v ?? 0)->toArray();
        $chartTargets = $indicators->pluck('target')->map(fn($v) => $v ?? 0)->toArray();

        // Calculs globaux pour les KPIs
        $totalIndicators = $indicators->count();
        $performanceRate = $totalIndicators > 0
            ? round($indicators->avg(fn($i) => min((($i->current_value ?? 0) / max($i->target ?? 1, 1)) * 100, 100)), 1)
            : 0;

        return view('ownpage.dashProject', compact(
            'project',
            'indicators',
            'totalIndicators',
            'performanceRate',
            'chartLabels',
            'chartCurrent',
            'chartTargets'
        ));
    }
}
