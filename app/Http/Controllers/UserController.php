<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $organizations = Organization::all();
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        return view('users/index', ['users' => $users, 'organizations' => $organizations]);
    }

    public function show($id): View
    {
        $user = User::findOrFail($id);

        return view('users/show', ['user' => $user]);
    }
    public function create(): View
    {
        $organizations = Organization::all();

        return view('users/create', ['organizations' => $organizations]);
    }

    public function edit($id): View
    {
        $organizations = Organization::all();

        $user = User::findOrFail($id);
        return view('users/edit', ['user' => $user, 'organizations' => $organizations]);
    }

    public function store(UserFormRequest $req): RedirectResponse
    {
        $data = $req->validated();


        $user = User::create($data);
        return redirect()->route('admin.user.show', ['id' => $user->id]);
    }

    public function update(User $user, UserFormRequest $req)
    {
        $data = $req->validated();



        $user->update($data);

        return redirect()->route('admin.user.show', ['id' => $user->id]);
    }

    public function updateSpeed(User $user, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $user->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(User $user)
    {

        $user->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexUser(): View
    {
        $organizations = Organization::all();
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        return view('ownpage.userViews.index', ['users' => $users, 'organizations' => $organizations]);
    }

    public function showUser($id): View
    {
        $user = User::findOrFail($id);

        return view('ownpage.userViews.show', ['user' => $user]);
    }

    public function createUser(): View
    {
        $organizations = Organization::all();

        return view('ownpage.userViews.create', ['organizations' => $organizations]);
    }

    public function editUser($id): View
    {
        $organizations = Organization::all();

        $user = User::findOrFail($id);
        return view('ownpage.userViews.edit', ['user' => $user, 'organizations' => $organizations]);
    }

    public function storeUser(UserFormRequest $req): RedirectResponse
    {
        $data = $req->validated();


        $user = User::create($data);
        return redirect()->route('showUser', ['id' => $user->id]);
    }

    public function updateUser(User $user, UserFormRequest $req)
    {
        $data = $req->validated();



        $user->update($data);

        return redirect()->route('showUser', ['id' => $user->id]);
    }

    public function deleteUser(User $user)
    {

        $user->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexUserOrg(): View
    {
        $authUser = auth()->user()->organization_id;
        $organizations = Organization::all();
        $users = User::where('organization_id', $authUser)->paginate(5);
        return view('ownpage.userViews.indexOrg', ['users' => $users, 'organizations' => $organizations]);
    }

    public function showUserOrg($id): View
    {
        $user = User::findOrFail($id);

        return view('ownpage.userViews.showOrg', ['user' => $user]);
    }

    public function editUserOrg($id): View
    {
        $authUser = auth()->user()->organization_id;
        $organizations = Organization::where('id', $authUser)->get();


        $user = User::findOrFail($id);
        return view('ownpage.userViews.editOrg', ['user' => $user, 'organizations' => $organizations]);
    }

    public function createUserOrg(): View
    {
        $authUser = auth()->user()->organization_id;
        $organizations = Organization::where('id', $authUser)->get();

        return view('ownpage.userViews.createOrg', ['organizations' => $organizations]);
    }

    public function storeUserOrg(UserFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;

        $user = User::create($data);
        return redirect()->route('showUserOrg', ['id' => $user->id]);
    }

    public function updateUserOrg(User $user, UserFormRequest $req)
    {
        $data = $req->validated();

        $user->update($data);

        return redirect()->route('showUserOrg', ['id' => $user->id]);
    }


    public function deleteUserOrg(User $user): JsonResponse
    {
        try {
            // Suppression de l'utilisateur
            $user->delete();

            return response()->json([
                'isSuccess' => true,
                'message'   => 'L\'utilisateur a été supprimé avec succès.'
            ], 200);

        } catch (Exception $e)
        {
            // Intercepte l'erreur (ex: contrainte de clé étrangère SQL)
            return response()->json([
                'isSuccess' => false,
                'message'   => 'Impossible de supprimer cet utilisateur car il est lié à d\'autres données dans le système.'
            ], 400); // 400 Bad Request
        }
    }
}
