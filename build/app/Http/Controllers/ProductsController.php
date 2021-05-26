<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use DataTables;

class ProductsController extends Controller
{
    public function index(){
        return view('pages.manage-products');
    }

    protected function validasiData($data){
        $pesan = [
            'required' => ':attribute Tidak Boleh Kosong',
            'unique' => ':attribute Harus Unique',
            'exists' => ':attribute Tidak Ada'
        ];
        return validator($data, [
            'name' => 'required',
            'price' => 'required',
            'balance_value' => 'required',
            'desc' => 'required',
        ], $pesan);
    }

    public function input(Request $request){
        $validasi = $this->validasiData($request->input());
        if($validasi->passes()){
            $data = new Products;
            $data->name = $request->name;
            $data->price = $request->price;
            $data->balance_value = $request->balance_value;
            $data->desc = $request->desc;
            if($data->save()){
                return json_encode(array("success"=>"Berhasil menambahkan produk baru"));
            }else{
                return json_encode(array("error"=>"Gagal menambah produk baru"));
            }
        }else{
            $msg = $validasi->getMessageBag()->messages();
            $err = array();
            foreach ($msg as $key=>$item) {
                $err[] = $item[0];
            }
            return json_encode(array("error"=>$err));
        }
    }

    public function ajaxTable(Request $request){
        $data = Products::get();
        return Datatables::of($data)
            ->addColumn('action', function($data){
                return "
    				<a href=\"#\" class=\"btn btn-sm btn-success btn-raised legitRipple\" id=\"edit\"> Edit</a>
    				<a href=\"#\" class=\"btn btn-sm btn-danger btn-raised legitRipple\" id=\"delete\"> Delete</a>
                ";
            })
            ->make(true);
    }

    public function edit($id, Request $request){
        $validasi = $this->validasiData($request->input());
        if($validasi->passes()){
            $data = Products::where('id', $id)->first();
            $data->name = $request->name;
            $data->price = $request->price;
            $data->balance_value = $request->balance_value;
            $data->desc = $request->desc;
            if($data->update()){
                return json_encode(array("success"=>"Berhasil merubah data produk"));
            }else{
                return json_encode(array("error"=>"Gagal merubah data produk"));
            }
        }else{
            $msg = $validasi->getMessageBag()->messages();
            $err = array();
            foreach ($msg as $key=>$item) {
                $err[] = $item[0];
            }
            return json_encode(array("error"=>$err));
        }
    }

    public function delete($id){
        $data = Products::where('id', $id)->first();
        if($data->delete()){
            return json_encode(array("success"=>"Berhasil menghapus data produk"));
        }else{
            return json_encode(array("error"=>"Gagal menghapus data produk"));
        }
    }
}
