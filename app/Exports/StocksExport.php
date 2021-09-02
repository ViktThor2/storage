<?php

namespace App\Exports;

use App\{Asset, Stock};
use Maatwebsite\Excel\Concerns\FromCollection;

class StocksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $assets = Asset::paginate('25');
        $stock = New Stock();
        $products = $stock->getProducts($assets);

        return $products;
    }
}
