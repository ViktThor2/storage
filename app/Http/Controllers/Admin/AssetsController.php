<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Unit;
use App\Asset;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssetRequest;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Eszközök'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::paginate('25');

        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.assets.create', compact('units', 'categories'));
    }

    public function store(Request $request)
    {
        $asset = new Asset();
        $asset->setData($request);
        $asset->setcategory($request);
        $asset->save();

        session()->flash('message', $asset->name .' hozzáadva');
        return redirect()->route('admin.assets.index');
    }

    public function edit(Asset $asset)
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.assets.edit', compact('asset', 'units', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);
        $asset->setData($request);
        $asset->setcategory($request);
        $asset->update();

        session()->flash('message', $asset->name.' frissítve');
        return redirect()->route('admin.assets.index');
    }

    public function show(Asset $asset)
    {
        return view('admin.assets.show', compact('asset'));
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        session()->flash('message', $asset->name .' törölve');
        return back();
    }

    public function massDestroy(MassDestroyAssetRequest $request)
    {
        Asset::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function history($id)
    {
        $asset = Asset::find($id);
        return view('admin.assets.history', compact('asset'));
    }

    public function assetSearch(Request $request)
    {
        $assets = Asset::search($request->input('search'))->paginate('25');

        return view('admin.assets.index', compact('assets'));
    }

}
