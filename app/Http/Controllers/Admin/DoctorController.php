<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Doctor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Orvosok'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctors = doctor::paginate('25');

        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctor.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
        ]);

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->save();

        session()->flash('message', $doctor->name .' hozzáadva');
        return redirect()->route('admin.doctor.index');
    }

    public function edit(doctor $doctor)
    {
        return view('admin.doctor.edit', compact('doctor'));
    }

    public function update(Request $request, $Id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $doctor = doctor::find($Id);
        $doctor->name = $request->name;
        $doctor->update();

        session()->flash('message', $doctor->name .' frissítve');
        return redirect()->route('admin.doctor.index');
    }

    public function show(doctor $doctor)
    {
        return view('admin.doctor.show', compact('doctor'));
    }

    public function destroy($Id)
    {
        $doctor = doctor::find($Id);
        $doctor->delete();

        session()->flash('message', $doctor->name .' törölve');
        return redirect()->route('admin.doctor.index');
    }

    public function massDestroy(Request $request)
    {
        Doctor::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


}
