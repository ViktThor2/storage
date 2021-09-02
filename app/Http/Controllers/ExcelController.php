<?php

namespace App\Http\Controllers;

use App\Exports\{UsersExport, AssetsExport, StocksExport};
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function users()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function assets()
    {
      return Excel::download(new AssetsExport, 'termekek.xlsx');
      return back();
    }

    public function stocks()
    {
        return Excel::download(new StocksExport, 'keszlet.xlsx');
        return back();
    }
}
