<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Models\Program;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(5);
        return view('projects/index', ['projects' => $projects]);
    }

    public function show($id): View
    {
        $project = Project::findOrFail($id);

        return view('projects/show',['project' => $project]);
    }
    public function create(): View
    {
        $programs = Program::where('organization_id', auth()->user()->organization_id)
        ->orderBy('name')
        ->get();
        return view('projects/create',compact('programs'));
    }

    public function edit($id): View
    {
        $programs = Program::where('organization_id', auth()->user()->organization_id)
        ->orderBy('name')
        ->get();
        $project = Project::findOrFail($id);
        return view('projects/edit', ['project' => $project, 'programs' => $programs]);
    }

    public function store(ProjectFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code']= Project::generateCode();


        $project = Project::create($data);
        return redirect()->route('admin.project.show', ['id' => $project->id]);
    }

    public function update(Project $project, ProjectFormRequest $req)
    {
        $data = $req->validated();



        $project->update($data);

        return redirect()->route('admin.project.show', ['id' => $project->id]);
    }

    public function updateSpeed(Project $project, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $project->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Project $project)
    {

        $project->delete();

        return [
            'isSuccess' => true
        ];
    }
    public function indexProject(): View
    {
        $projects = Project::where('organization_id', auth()->user()->organization_id)->paginate(12);
        return view('ownpage.projectViews.index', ['projects' => $projects]);
    }
    public function showProject($id): View
    {
        $project = Project::findOrFail($id);

        return view('ownpage.projectViews.show',['project' => $project]);
    }
    public function createProject(): View
    {
        $programs = Program::where('organization_id', auth()->user()->organization_id)
        ->orderBy('name')
        ->get();
        return view('ownpage.projectViews.create',compact('programs'));
    }
    public function editProject($id): View
    {
        $programs = Program::where('organization_id', auth()->user()->organization_id)
        ->orderBy('name')
        ->get();
        $project = Project::findOrFail($id);
        return view('ownpage.projectViews.edit', ['project' => $project, 'programs' => $programs]);
    }

    public function storeProject(ProjectFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code']= Project::generateCode();


        $project = Project::create($data);
        return redirect()->route('showProject', ['id' => $project->id]);
    }

    public function updateProject(Project $project, ProjectFormRequest $req)
    {
        $data = $req->validated();



        $project->update($data);

        return redirect()->route('admin.project.show', ['id' => $project->id]);
    }

}
