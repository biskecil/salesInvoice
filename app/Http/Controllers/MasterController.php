<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    private function SetReturn($success, $message, $data, $error)
    {
        $data_return = [
            "success" => $success,
            "message" => $message,
            "data" => $data,
            "error" => $error
        ];
        return $data_return;
    }
    public function show_grosir()
    {
        return view('grosir.show');
    }
    public function create_grosir()
    {
        return view('grosir.create');
    }
    public function edit_grosir($id)
    {
        $data = DB::table('customer')->where('ID', $id)->first();
        return view('grosir.edit', ['data' => $data]);
    }
    public function update_grosir(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $validated = Validator::make($request->all(), [
                'sw'    => 'required|unique:customer,SW,' . $request->id . ',ID',
                'description' => 'required',
            ]);

            $getSW =   DB::table('customer')
                ->where('ID', $request->id)->first();


            if ($getSW) { // pastikan record ada
                $inv = DB::table('invoice')
                    ->where('Grosir', $getSW->SW)
                    ->count();

                if ($inv > 0) {
                    $data = $this->SetReturn(true, 'Sub grosir sudah digunakan invoice', null, null);
                    return response()->json($data, 422);
                }
            }

            if ($validated->fails()) {
                $data = $this->SetReturn(true, 'Silakan periksa kembali form yang Anda isi', null, null);
                return response()->json($data, 422);
            }

            DB::table('customer')
                ->where('ID', $request->id)
                ->update([
                    'SW' => $request->sw,
                    'Description' => $request->description,
                ]);


            DB::commit();
            $data = $this->SetReturn(true, 'Berhasil Disimpan', null, null);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $data = $this->SetReturn(false, 'Server Error', null, null);
            return response()->json($data, 500);
        }
    }
    public function store_grosir(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $validated = Validator::make($request->all(), [
                'sw'    => 'required|unique:customer,SW',
                'description' => 'required',
            ]);


            if ($validated->fails()) {
                $data = $this->SetReturn(true, 'Silakan periksa kembali form yang Anda isi', null, null);
                return response()->json($data, 422);
            }

            $getLastID = DB::table('customer')
                ->max('ID') + 1;

            DB::table('customer')->insert([
                'ID' => $getLastID,
                'SW' => $request->sw,
                'Description' => $request->description,
            ]);


            DB::commit();
            $data = $this->SetReturn(true, 'Berhasil Disimpan', null, null);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $data = $this->SetReturn(false, 'Server Error', null, null);
            return response()->json($data, 500);
        }
    }
    public function show_grosir_data()
    {
        $data = DB::table('customer')->get();
        return response()->json(['data' => $data]);
    }
}
