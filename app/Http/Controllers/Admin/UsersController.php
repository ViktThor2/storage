<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\{Role,Team,User};
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Felhasználók'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::paginate('25');

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');
        $teams = Team::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'teams'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        session()->flash('message', $user->name .' hozzáadva');
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all()->pluck('title', 'id');
        $teams = Team::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('roles', 'team');

        return view('admin.users.edit', compact('roles', 'teams', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        session()->flash('message', $user->name .'frissítve');
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        $user->load('roles', 'team');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('message', $user->name .' törölve');
        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
