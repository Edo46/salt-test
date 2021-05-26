<?php

namespace App\Http\Controllers;

use App\Jobs\AddBalanceJobs;
use App\Jobs\TransactionJobs;
use App\User;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;

class TopUpController extends Controller
{
    public function index(){
        return view('pages.topup-index');
    }

    public function checkoutPage($id){
        $checkout = Transactions::where('order_code', $id)->with('user', 'product')->first();
        return view('pages.checkout', ['checkout' => $checkout]);
    }

    public function ajaxTable(Request $request){
        $data = Products::get();
        return Datatables::of($data)
            ->addColumn('action', function($data){
                return "
    				<a href=\"#\" class=\"btn btn-sm btn-success btn-raised legitRipple\" id=\"buy\"> Buy</a>
                ";
            })
            ->make(true);
    }

    public function buy($id){
        $product = Products::where('id', $id)->first();
        $buy = new Transactions();
        $buy->order_code = mt_rand(0, 0xffff);
        $buy->user_id = \Auth::user()->id;
        $buy->product_id = $product->id;
        $buy->total = $product->price;
        if($buy->save()){
            return json_encode(array("success"=>"Berhasil menambahkan produk baru", 'order_code' => $buy->order_code));
        }else{
            return json_encode(array("error"=>"Gagal menambah produk baru"));
        }
    }

    public function checkoutProcess($id, Request $request)
    {
        $status = $request->status;
        $transaction = Transactions::where('order_code', $id)->first();
        $procesJobTransaction = (new TransactionJobs($transaction, $status));
        if ($request->status === 'verified'){
            if (dispatch($procesJobTransaction)){
                $user = User::where('id', Auth::user()->id)->first();
                $user->balance = $user->balance + $transaction->product->balance_value;

                if($user->update()){
                    return json_encode(array("success"=>"Berhasil topup"));
                }else{
                    return json_encode(array("error"=>"Gagal memproses topup"));
                }
            }
        } else {
            if (dispatch($procesJobTransaction)){
                return json_encode(array("success"=>"Berhasil membatalkan transaksi"));
            }
        }
    }
}
