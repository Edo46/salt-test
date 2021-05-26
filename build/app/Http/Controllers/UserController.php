<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('pages.manage-users');
    }

    protected function validasiData($data){
        $pesan = [
            'required' => ':attribute Tidak Boleh Kosong',
            'unique' => ':attribute Harus Unique',
            'exists' => ':attribute Tidak Ada'
        ];
        return validator($data, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'balance' => 'required',
            'password' => 'required',
        ], $pesan);
    }

    protected function validasiDataEdit($data){
        $pesan = [
            'required' => ':attribute Cannot be empty',
            'unique' => ':attribute Must be unique',
            'exists' => ':attribute Not Found'
        ];
        return validator($data, [
            'name' => 'required',
            'email' => 'required',

        ], $pesan);
    }

    public function input(Request $request){
        $validasi = $this->validasiData($request->input());
        if($validasi->passes()){
            $data = new User;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->role = 2;
            $data->balance = $request->balance;
            $data->password = Hash::make($request->password);
            if($data->save()){
                return json_encode(array("success"=>"Berhasil menambahkan user baru"));
            }else{
                return json_encode(array("error"=>"Gagal menambah user baru"));
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
        $data = User::where('role', 2);
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
        $validasi = $this->validasiDataEdit($request->input());
        if($validasi->passes()){
            $data = User::where('id', $id)->first();
            $data->name = $request->name;
            $data->balance = $request->balance;
            $data->role = 2;
            if ($data->email !== $request->email){
                $email = User::where('email', $request->email)->first();
                if ($email === null){
                    $data->email = $request->email;
                } else {
                    return json_encode(array("error"=>"Email ini sudah digunakan oleh orang lain"));
                }
            }
            if ($request->password !== null){
                $data->password = Hash::make($request->password);
            }
            if($data->update()){
                return json_encode(array("success"=>"Berhasil merubah data user"));
            }else{
                return json_encode(array("error"=>"Gagal merubah data user"));
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
