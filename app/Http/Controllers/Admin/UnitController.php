<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Unit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class UnitController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Mennyiségi egységek'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::all();

        return view('admin.unit.index', compact('units'));
    }

    public function create()
    {
        return view('admin.unit.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
        ]);
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->save();

        session()->flash('message', $unit->name .' hozzáadva');
        return redirect()->route('admin.unit.index');
    }

    public function edit(unit $unit)
    {
        return view('admin.unit.edit', compact('unit'));
    }

    public function update(Request $request, $Id)
    {
        $this->validate($request, [
           'name' => 'required',
        ]);
        $unit = Unit::find($Id);
        $unit->name = $request->name;
        $unit->update();

        session()->flash('message', $unit->name .' frissítve');
        return redirect()->route('admin.unit.index');
    }

    public function show(unit $unit)
    {
        return view('admin.unit.show', compact('unit'));
    }

    public function destroy($Id)
    {
        $unit = Unit::find($Id);

        if( count($unit->assets) > 0 ){
            session()->flash('error', 'Nem törölhető olyan mennyiségi egység, ami eszközhöz van kapcsolva');
            return back();
        }

        $unit->delete();

        session()->flash('message', $unit->name .' törölve');
        return redirect()->route('admin.unit.index');
    }

    public function massDestroy(Request $request)
    {
        Unit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


}
