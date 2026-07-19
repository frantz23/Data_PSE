<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationFormRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(): View
    {
        $organizations = Organization::orderBy('created_at', 'desc')->paginate(5);
        return view('organizations/index', ['organizations' => $organizations]);
    }

    public function show($id): View
    {
        $organization = Organization::findOrFail($id);

        return view('organizations/show', ['organization' => $organization]);
    }
    public function create(): View
    {
        return view('organizations/create');
    }

    public function edit($id): View
    {
        $organization = Organization::findOrFail($id);
        return view('organizations/edit', ['organization' => $organization]);
    }

    public function store(OrganizationFormRequest $req): RedirectResponse
    {
        $data = $req->validated();



        $organization = Organization::create($data);
        return redirect()->route('admin.organization.show', ['id' => $organization->id]);
    }

    public function update(Organization $organization, OrganizationFormRequest $req)
    {
        $data = $req->validated();



        $organization->update($data);

        return redirect()->route('admin.organization.show', ['id' => $organization->id]);
    }

    public function updateSpeed(Organization $organization, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $organization->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Organization $organization)
    {

        $organization->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexOrganization(): View
    {
        $organizations = Organization::orderBy('created_at', 'desc')->paginate(5);
        $admin = Organization::with(['users' => function ($q) {
            $q->role('adminONG');
        }])->get();
        return view('ownpage.organizationViews.index', ['organizations' => $organizations, 'admin' => $admin]);
    }

    public function showOrganization($id): View
    {
        $organization = Organization::findOrFail($id);

        return view('ownpage.organizationViews.show', ['organization' => $organization]);
    }

    public function createOrganization(): View
    {
        return view('ownpage.organizationViews.create');
    }

    public function editOrganization($id): View
    {
        $organization = Organization::findOrFail($id);
        return view('ownpage.organizationViews.edit', ['organization' => $organization]);
    }

    public function storeOrganization(OrganizationFormRequest $req): RedirectResponse
    {
        $data = $req->validated();



        $organization = Organization::create($data);
        return redirect()->route('showOrganization', ['id' => $organization->id]);
    }

    public function updateOrganization(Organization $organization, OrganizationFormRequest $req)
    {
        $data = $req->validated();



        $organization->update($data);

        return redirect()->route('showOrganization', ['id' => $organization->id]);
    }

    public function deleteOrganization(Organization $organization)
    {

        $organization->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function assignView(): View
    {
        $organizations = Organization::all();
        $users = User::all();
        $roles = Role::all();
        return view('ownpage.organizationViews.assignRole', ['organizations' => $organizations, 'users' => $users, 'roles' => $roles]);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);

        // 1 seul rôle par user
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role assigned successfully.');
    }

    public function getUsers($organizationId)
    {
        $users = User::where('organization_id', $organizationId)
            ->select('id', 'name', 'email')
            ->get();

        return response()->json($users);
    }
}
