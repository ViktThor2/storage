<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Chair,Team};
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class ChairController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Munkaállomások'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chairs = Chair::paginate('25');

        return view('admin.chair.index', compact('chairs'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('admin.chair.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
        ]);
        $chair = new Chair();
        $chair->team_id = $request->team_id;
        $chair->name = $request->name;
        $chair->save();

        session()->flash('message', 'A(z) '. $chair->name .' hozzáadva');
        return redirect()->route('admin.chair.index');
    }

    public function edit(Chair $chair)
    {
        $teams = Team::all();
        return view('admin.chair.edit', compact('chair', 'teams'));
    }

    public function update(Request $request, $Id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $chair = Chair::find($Id);
        $chair->team_id = $request->team_id;
        $chair->name = $request->name;
        $chair->update();

        session()->flash('message', 'A(z) '. $chair->name .' frissítve');
        return redirect()->route('admin.chair.index');
    }

    public function show(Chair $chair)
    {
        return view('admin.chair.show', compact('chair'));
    }

    public function destroy($Id)
    {
        $chair = Chair::find($Id);
        $chair->delete();

        session()->flash('message', 'A(z) '. $chair->name .' törölve');
        return redirect()->route('admin.chair.index');
    }

    public function massDestroy(Request $request)
    {
        Chair::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
