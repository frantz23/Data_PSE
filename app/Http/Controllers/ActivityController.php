<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityFormRequest;
use App\Models\Activity;
use App\Models\Indicator;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(5);
        return view('activities/index', ['activities' => $activities]);
    }

    public function show($id): View
    {
        $activity = Activity::findOrFail($id);

        return view('activities/show', ['activity' => $activity]);
    }
    public function create(): View
    {
        // $users = User::where('organization_id', auth()->user()->organization_id)->get();
        // $activities = Activity::where('id', '!=', $activity->id ?? null)->get();
        // $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        $organizationId = auth()->user()->organization_id;

        $users = User::where('organization_id', $organizationId)->get();

        $projects = Project::where('organization_id', $organizationId)->get();

        $activities = Activity::where('organization_id', $organizationId)
            ->whereNull('parent_activity_id')
            ->get();
        return view('activities/create', ['users' => $users, 'activities' => $activities, 'projects' => $projects]);
    }

    public function edit($id): View
    {
        $users = User::where('organization_id', auth()->user()->organization_id)->get();
        $organizationId = auth()->user()->organization_id;
        $activity = Activity::findOrFail($id);
        $activities = Activity::where('organization_id', $organizationId)
            ->where('id', '!=', $activity->id)
            ->get();
        $projects = Project::where('organization_id', $organizationId)->get();
        return view('activities/edit', ['activity' => $activity, 'users' => $users, 'activities' => $activities, 'projects' => $projects]);
    }

    public function store(ActivityFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['completion_rate'] = $data['completion_rate'] ?? 0;

        $activity = Activity::create($data);
        return redirect()->route('admin.activity.show', ['id' => $activity->id]);
    }

    public function update(Activity $activity, ActivityFormRequest $req)
    {
        $data = $req->validated();



        $activity->update($data);

        return redirect()->route('admin.activity.show', ['id' => $activity->id]);
    }

    public function updateSpeed(Activity $activity, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $activity->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Activity $activity)
    {

        $activity->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexActivity(): View
    {
        // $activities = Activity::orderBy('created_at', 'desc')->paginate(5);
        $activities = Activity::with([
            'project',
            'assignee'
        ])->where('organization_id', auth()->user()->organization_id)
            ->paginate(12);

        return view('ownpage.activityViews.index', ['activities' => $activities]);
    }

    public function showActivity($id): View
    {
        $activity = Activity::with(['children', 'parent'])->findOrFail($id);
        $outputIndicator = $activity->indicators()->where('result_level','output')->count();
        $outcometIndicator = $activity->indicators()->where('result_level','outcome')->count();
        $impactIndicator = $activity->indicators()->where('result_level','impact')->count();

        return view('ownpage.activityViews.show', ['activity' => $activity, 'outputIndicator' =>$outputIndicator, 'outcomeIndicator' => $outcometIndicator, 'impactIndicator' => $impactIndicator]);
    }
    public function createActivity(): View
    {
        $organizationId = auth()->user()->organization_id;

        $users = User::where('organization_id', $organizationId)->get();

        $projects = Project::where('organization_id', $organizationId)->get();

        $activities = Activity::where('organization_id', $organizationId)
            ->whereNull('parent_activity_id')
            ->get();
        return view('ownpage.activityViews.create', ['users' => $users, 'activities' => $activities, 'projects' => $projects]);
    }

    public function editActivity($id): View
    {
        $users = User::where('organization_id', auth()->user()->organization_id)->get();
        $organizationId = auth()->user()->organization_id;
        $activity = Activity::findOrFail($id);
        $activities = Activity::where('organization_id', $organizationId)
            ->where('id', '!=', $activity->id)
            ->get();
        $projects = Project::where('organization_id', $organizationId)->get();
        return view('ownpage.activityViews.edit', ['activity' => $activity, 'users' => $users, 'activities' => $activities, 'projects' => $projects]);
    }

    public function storeActivity(ActivityFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['completion_rate'] = $data['completion_rate'] ?? 0;

        $activity = Activity::create($data);
        return redirect()->route('showActivity', ['id' => $activity->id]);
    }

    public function updateActivity(Activity $activity, ActivityFormRequest $req)
    {
        $data = $req->validated();



        $activity->update($data);

        return redirect()->route('showActivity', ['id' => $activity->id]);
    }

    public function assignedIndicator(Activity $activity): View
    {
        // 1. Vérification de sécurité (s'assurer que l'activité appartient à l'organisation)
        abort_if($activity->organization_id !== auth()->user()->organization_id, 403);

        // 2. Chargement des relations sur l'activité unique
        $activity->load(['project', 'assignee']);

        // 3. Récupération des indicateurs disponibles
        $availableIndicators = Indicator::with('activities')->where('project_id',$activity->project_id)->get();

        return view('ownpage.activityViews.assignedIndicator', ['activity' => $activity, 'availableIndicators' => $availableIndicators]);
    }

    public function attachIndicator(Request $request, Activity $activity)
    {
        $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
        ]);

        // On attache l'indicateur sans supprimer les autres
        $activity->indicators()->syncWithoutDetaching($request->indicator_id);

        return redirect()
            ->route('showActivity', $activity)
            ->with('success', 'Indicateur associé avec succès !');
    }
}
