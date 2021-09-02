<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Importer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreImporterRequest;
use Gate;

class ImporterController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Beszállítók'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $importers = Importer::paginate('25');

        return view('admin.importer.index', compact('importers'));
    }

    public function create()
    {
        return view('admin.importer.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
           'company_name' => 'required',
            'tax_number' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'adress' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $importer = new Importer();
        $importer->setRequest($request);
        $importer->save();

        session()->flash('message', $importer->name .' hozzáadva');
        return redirect()->route('admin.importer.index');
    }

    public function edit(Importer $importer)
    {
        return view('admin.importer.edit', compact('importer'));
    }

    public function update(Request $request, $Id)
    {
        $this->validate($request, [
            'name' => 'required',
            'company_name' => 'required',
            'tax_number' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'adress' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $importer = Importer::find($Id);
        $importer->setRequest($request);
        $importer->update();

        session()->flash('message', $importer->name .' frissítve');
        return redirect()->route('admin.importer.index');
    }

    public function show(Importer $importer)
    {
        return view('admin.importer.show', compact('importer'));
    }

    public function destroy($Id)
    {
        $importer = Importer::find($Id);
        $importer->delete();

        session()->flash('message', $importer->name .' törölve');
        return redirect()->route('admin.importer.index');
    }

    public function massDestroy(Request $request)
    {
        Importer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function importerSearch(Request $request)
    {
        $importers = Importer::search($request->input('search'))->paginate('25');

        return view('admin.importer.index', compact('importers'));
    }

}
