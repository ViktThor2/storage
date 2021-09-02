<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Team;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Rendelők'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teams = Team::paginate('25');

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.teams.create', compact('companies'));
    }

    public function store(StoreTeamRequest $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $team = New Team();
        $team->name = $request->name;
        $team->company_id = $request->company;
        $team->save();

        session()->flash('message', $team->name .' hozzáadva');
        return redirect()->route('admin.teams.index');

    }

    public function edit(Team $team)
    {
        $companies = Company::all();
        return view('admin.teams.edit', compact('team', 'companies'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $team->name = $request->name;
        $team->company_id = $request->company;
        $team->update();

        session()->flash('message', $team->name .' frissítve');
        return redirect()->route('admin.teams.index');
    }

    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function destroy(Team $team)
    {
        if(count($team->stocks) > 0){
            session()->flash('error', 'Csak olyan rendelő törölhető, ahol nincs készleten termék');
            return back();
        }

        $chairs = $team->chairs()->get();
        if( count($chairs) > 0 ) {
            session()->flash('error', 'Nem törölhet olyan rendelőt, aminek vannak munkaállomásai');
            return back();
        }

        $team->delete();

        session()->flash('message', $team->name .' törölve');
        return back();
    }

    public function massDestroy(MassDestroyTeamRequest $request)
    {
        Team::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
