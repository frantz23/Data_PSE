<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;

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

}
