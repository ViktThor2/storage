<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStockRequest;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\{Importer,Stock,Asset,Team,Chair, Doctor};
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StocksController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $assets = Asset::paginate('25');
        $stock = New Stock();
        $products = $stock->getProducts($assets);

        return view('admin.stocks.index')
            ->with('teams', $teams)
            ->with('assets', $assets)
            ->with('products', $products);
    }

    public function create()
    {
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.stocks.create', compact('assets'));
    }

    public function store(StoreStockRequest $request)
    {
        $stock = Stock::create($request->all());

        return redirect()->route('admin.stocks.index');

    }

    public function edit(Stock $stock)
    {
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $stock->load('asset', 'team');

        return view('admin.stocks.edit', compact('assets', 'stock'));
    }

    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $stock->update($request->all());

        return redirect()->route('admin.stocks.index');
    }

    public function show(Stock $stock)
    {
        $stock->load('asset.transactions.user.team');

        return view('admin.stocks.show', compact('stock'));
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return back();
    }

    public function massDestroy(MassDestroyStockRequest $request)
    {
        Stock::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function instock()
    {
        $teams = Team::all();
        $importers = Importer::all();

        $assets = Asset::paginate('25');

        return view('admin.stocks.instock')
            ->with('assets', $assets)
            ->with('importers', $importers)
            ->with('teams', $teams);
    }

    public function outstock()
    {
        $doctors = Doctor::all();
        $chairs = Chair::all();
        $teams = Team::all();

        $assets = Asset::paginate('25');

        return view('admin.stocks.outstock')
            ->with('assets', $assets)
            ->with('chairs', $chairs)
            ->with('doctors', $doctors)
            ->with('teams', $teams);
    }

    public function betweenstock()
    {
        abort_if(Gate::denies('Raktárak közötti készletmozgás'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teams = Team::all();

        $assets = Asset::paginate('25');

        return view('admin.stocks.betweenstock')
            ->with('assets', $assets)
            ->with('teams', $teams);
    }

    public function stockSearch(Request $request)
    {
        $teams = Team::all();
        $importers = Importer::all();
        $stocks = Stock::all();

        $assets = Asset::search($request->input('search'))->paginate('25');

        $stock = New Stock();
        $products = $stock->getProducts($assets);

        return view('admin.stocks.index')
            ->with('assets', $assets)
            ->with('products', $products)
            ->with('importers', $importers)
            ->with('teams', $teams)
            ->with('stocks', $stocks);
    }

    public function instockSearch(Request $request)
    {
        $assets = Asset::search($request->input('search'))->paginate('25');

        $teams = Team::all();
        $importers = Importer::all();

        return view('admin.stocks.instock')
            ->with('assets', $assets)
            ->with('importers', $importers)
            ->with('teams', $teams);
    }

    public function outstockSearch(Request $request)
    {
        $doctors = Doctor::all();
        $chairs = Chair::all();
        $teams = Team::all();

        $assets = Asset::search($request->input('search'))->paginate('25');

        return view('admin.stocks.outstock')
            ->with('assets', $assets)
            ->with('chairs', $chairs)
            ->with('doctors', $doctors)
            ->with('teams', $teams);
    }

    public function betweenstockSearch(Request $request)
    {
        $teams = Team::all();

        $assets = Asset::search($request->input('search'))->paginate('25');

        return view('admin.stocks.betweenstock')
            ->with('assets', $assets)
            ->with('teams', $teams);
    }
}
