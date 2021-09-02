<?php

namespace App\Http\Controllers\Admin;

use App\{Asset, Chair, Stock, Transaction, User};
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Mail\CriticalStock;

class StockTransaction extends Controller
{
    public function add(Request $request, $id)
    {
        if ($request->stock < 1) {
            return redirect()->route('admin.stocks.index')->with([
                'error' => 'Hiba : Minimum mennyiség 1 darab',
            ]);
        }

        $transaction = new Transaction();
        $transaction->action_id = 1;
        $transaction->team_id   = $request->team_id;
        $transaction->company_id = $transaction->team->company->id;
        $transaction->importer_id = $request->importer;

        $transaction->setData($request, $id);
        $transaction->save();

        $stock = Stock::search($id, $request->team_id)->get();
        if(count($stock) > 0) {
            Stock::search($id, $request->team_id)->increment('current_stock', $request->stock);
        }
        else {
            $stock = new Stock();
            $stock->current_stock = $request->stock;
            $stock->asset_id = $transaction->asset_id;
            $stock->team_id = $transaction->team_id;
            $stock->save();
        }
        session()->flash('message', $transaction->stock.' '.$transaction->asset->name . ' hozzá adva. Ide : '. $transaction->team->name );
        return redirect()->route('admin.stocks.index');
    }

    public function remove(Request $request, $id)
    {
        if ($request->stock < 1) {
            session()->flash('error', 'Minimum mennyiség : 1');
            return back();
        }
        $chair = Chair::find($request->chair_id);
        $stocks = Stock::search($id, $chair->team_id)->get();
        foreach ($stocks as $stock) {
            if($stock->current_stock - $request->stock < $stock->asset->critical_stock) {

                $mail = new CriticalStock($stock);
                \Mail::to(auth()->user()->email)->send($mail);
            }
            if($stock->current_stock < $request->stock) {
                session()->flash('error', 'Nincs elegendő termék.');
                return back();
            }
        }

        if(count($stocks) > 0) {
            Stock::search($id, $chair->team_id)->decrement('current_stock', $request->stock);
            session()->flash('message', $request->stock.' '. $stock->asset->name . ' eltávolítva. Innen : '. $stock->team->name );
        } else {
            session()->flash('error', 'Ebben a raktárban nincs ebből a termékből');
            return back();
        }

        $transaction = new Transaction();
        $transaction->action_id = 2;
        $transaction->team_id = $chair->team_id;
        $transaction->chair_id = $request->chair_id;
        if($request->doctor_id) {
            $transaction->doctor_id = $request->doctor_id;
        }
        $transaction->setData($request, $id);
        $transaction->save();

        return redirect()->route('admin.stocks.index');
    }

    public function discard(Request $request, $id)
    {
        if ($request->stock < 1) {
            session()->flash('error', 'Minimum mennyiség : 1');
            return back();
        }
        $chair = Chair::find($request->chair_id);
        $stocks = Stock::search($id, $chair->team_id)->get();
        foreach ($stocks as $stock) {
            if($stock->current_stock - $request->stock < $stock->asset->critical_stock) {
                $mail = new CriticalStock($stock);
                \Mail::to(auth()->user()->email)->send($mail);
            }
            if($stock->current_stock < $request->stock) {
                session()->flash('error', 'Nincs elegendő termék.');
                return back();
            }
        }

        if(count($stocks) > 0) {
            Stock::search($id, $chair->team_id)->decrement('current_stock', $request->stock);
            session()->flash('message', $request->stock.' '. $stock->asset->name . ' leselejtezve. Innen : '. $stock->team->name );
        } else {
            session()->flash('error', 'Ebben a raktárban nincs ebből a termékből');
            return back();
        }

        $transaction = new Transaction();
        $transaction->action_id = 3;
        $transaction->team_id = $chair->team_id;
        $transaction->chair_id = $request->chair_id;
        if($request->doctor_id) {
            $transaction->doctor_id = $request->doctor_id;
        }
        $transaction->setData($request, $id);
        $transaction->save();

        return redirect()->route('admin.stocks.index');
    }

    public function between(Request $request, $id)
    {
        if ($request->stock < 1) {
            session()->flash('error', 'Minimum mennyiség : 1');
            return back();
        }

        $stocks = Stock::search($id, $request->from_team)->get();
        foreach ($stocks as $stock) {
            if($stock->current_stock - $request->stock < $stock->asset->critical_stock) {
                $mail = new CriticalStock($stock);
                \Mail::to(auth()->user()->email)->send($mail);
            }
            if($stock->current_stock < $request->stock) {
                session()->flash('error', 'Nincs elegendő termék.');
                return back();
            }
        }

        if(count($stocks) > 0) {

            // Készletmozgás csökkent
            Stock::search($id, $request->from_team)->decrement('current_stock', $request->stock);
        } else {
            session()->flash('error', 'Ebben a raktárban nincs ebből a termékből');
            return back();
        }

        // Készletmozgás hozzáad
        $stock = Stock::search($id, $request->to_team)->get();
        if(count($stock) > 0) {
            Stock::search($id, $request->to_team)->increment('current_stock', $request->stock);
        }
        else {
            $stock = new Stock();
            $stock->current_stock = $request->stock;
            $stock->asset_id = $id;
            $stock->team_id = $request->to_team;
            $stock->save();
        }


        $transaction = new Transaction();
        $transaction->action_id = 5;
        $transaction->team_id = $request->from_team;
        $transaction->setDataBetween($request, $id, $request->from_team);
        $transaction->save();

        $transaction = new Transaction();
        $transaction->action_id = 4;
        $transaction->setDataBetween($request, $id, $request->to_team);
        $transaction->save();

        session()->flash('message', $transaction->stock.' '. $transaction->asset->name. ' áthelyezve');
        return redirect()->route('admin.stocks.index');
    }


}
