<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class TransactionHistoryController extends Controller
{
    public function index(){
        return view('pages.transaction-history');
    }

    public function ajaxTable(Request $request){
        $data = Transactions::where('user_id', \Auth::user()->id)->with('product')->get();
        return Datatables::of($data)
            ->editColumn('buydate', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->format('d M Y') : '';
            })
            ->make(true);
    }
}
