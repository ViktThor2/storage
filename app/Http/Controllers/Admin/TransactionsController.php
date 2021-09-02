<?php

namespace App\Http\Controllers\Admin;

use App\{Asset,Stock,Transaction,User};
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Exception;
use Gate;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TransactionsController
 * @package App\Http\Controllers\Admin
 */
class TransactionsController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        abort_if(Gate::denies('Tranzakciók'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transactions = Transaction::paginate('25');

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transactions.create', compact('assets', 'users'));
    }

    /**
     * @param StoreTransactionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());

        return redirect()->route('admin.transactions.index');
    }

    /**
     * @param Transaction $transaction
     * @return Factory|View
     */
    public function edit(Transaction $transaction)
    {
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transaction->load('asset', 'team', 'user');

        return view('admin.transactions.edit', compact('assets', 'users', 'transaction'));
    }

    /**
     * @param UpdateTransactionRequest $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    /**
     * @param Transaction $transaction
     * @return Factory|View
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('asset', 'team', 'user');

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * @param Transaction $transaction
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back();
    }

    /**
     * @param MassDestroyTransactionRequest $request
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        Transaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function transactionSearch(Request $request)
    {
        $transactions = Transaction::search($request->input('search'))->paginate('25');

        return view('admin.transactions.index', compact('transactions'));
    }

}
