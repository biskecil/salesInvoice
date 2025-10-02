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
    function parseNumeric($value)
    {
        return  str_replace(',', '', $value);
    }
    public function show_pricelist()
    {
        return view('pricelist.show');
    }
    public function show_grosir()
    {
        return view('grosir.show');
    }
    public function create_grosir()
    {
        return view('grosir.create');
    }
    public function create_pricelist()
    {
        $caratCustom = [1, 3, 13, 4, 5, 6];
        $cust = DB::table('customer')->orderBy('SW', 'ASC')->get();
        $desc = DB::table('product')->select('ID', 'Description')->orderBy('Description', 'ASC')->get();
        $kadar = DB::table('carat')->select(
            'ID',
            'SW',
            DB::raw("CASE
            WHEN SW = '6K' THEN '#0000FF'
            WHEN SW = '8K' THEN '#00FF00'
            WHEN SW = '8KP' THEN '#CFB370'
            WHEN SW = '10K' THEN '#FFFF00'
            WHEN SW = '16K' THEN '#FF0000'
            WHEN SW = '17K' THEN '#FF6E01'
            WHEN SW = '17KP' THEN '#FF00FF'
            WHEN SW = '19K' THEN '#5F2987'
            WHEN SW = '20K' THEN '#FFC0CB'
            ELSE '#808080'
        END as color")
        )
            ->whereIN('ID', $caratCustom)
            ->orderByRaw("FIELD(ID, " . implode(',', $caratCustom) . ")")->get();
        return view('pricelist.create', ['desc' => $desc, 'kadar' => $kadar, 'cust' => $cust]);
    }
    public function edit_grosir($id)
    {
        $data = DB::table('customer')->where('ID', $id)->first();
        return view('grosir.edit', ['data' => $data]);
    }
    public function edit_pricelist($customer, $category, $carat)
    {
        $caratCustom = [1, 3, 13, 4, 5, 6];
        $cust = DB::table('customer')->orderBy('SW', 'ASC')->get();
        $desc = DB::table('product')->select('ID', 'Description')->orderBy('Description', 'ASC')->get();
        $kadar = DB::table('carat')->select(
            'ID',
            'SW',
            DB::raw("CASE
            WHEN SW = '6K' THEN '#0000FF'
            WHEN SW = '8K' THEN '#00FF00'
            WHEN SW = '8KP' THEN '#CFB370'
            WHEN SW = '10K' THEN '#FFFF00'
            WHEN SW = '16K' THEN '#FF0000'
            WHEN SW = '17K' THEN '#FF6E01'
            WHEN SW = '17KP' THEN '#FF00FF'
            WHEN SW = '19K' THEN '#5F2987'
            WHEN SW = '20K' THEN '#FFC0CB'
            ELSE '#808080'
        END as color")
        )
            ->whereIN('ID', $caratCustom)
            ->orderByRaw("FIELD(ID, " . implode(',', $caratCustom) . ")")->get();
        $data = DB::table('pricelist')->where([
            'Customer' => $customer,
            'Category' => $category,
            'Carat' => $carat,
            'Currency' => 40
        ])->first();
        $data->price_format =  number_format($data->Price, 2, '.', ',');
        $data->priceCust_format =  number_format($data->PriceCust, 2, '.', ',');


        return view('pricelist.edit', ['data' => $data, 'desc' => $desc, 'kadar' => $kadar, 'cust' => $cust]);
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
    public function store_pricelist(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $validated = Validator::make($request->all(), [
                'carat'    => 'required',
                'category' => 'required',
                'customer' => 'required',
                'pricecust' => 'required',
                'price' => 'required',
            ]);


            if ($validated->fails()) {
                $data = $this->SetReturn(true, 'Silakan periksa kembali form yang Anda isi', null, null);
                return response()->json($data, 422);
            }


            $cekPrice = DB::table('pricelist')
                ->where([
                    'Customer' =>  $request->customer,
                    'Category' =>  $request->category,
                    'Carat' =>  $request->carat,
                    'Currency' =>  40,
                ])->count();

            if ($cekPrice > 0) {
                $data = $this->SetReturn(true, 'Pricelist sudah ada', null, null);
                return response()->json($data, 422);
            }


            DB::table('pricelist')->insert([
                'Customer' => $request->customer,
                'Category' => $request->category,
                'Carat' => $request->carat,
                'Currency' => 40,
                'Price' =>  $this->parseNumeric($request->price),
                'PriceCust' => $this->parseNumeric($request->pricecust),
            ]);


            DB::commit();
            $data = $this->SetReturn(true, 'Berhasil Disimpan', null, null);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $data = $this->SetReturn(false, 'Server Error', $th->getMessage(), null);
            return response()->json($data, 500);
        }
    }
    public function update_pricelist(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $validated = Validator::make($request->all(), [
                'carat'    => 'required',
                'category' => 'required',
                'customer' => 'required',
                'pricecust' => 'required',
                'price' => 'required',
            ]);


            if ($validated->fails()) {
                $data = $this->SetReturn(true, 'Silakan periksa kembali form yang Anda isi', null, null);
                return response()->json($data, 422);
            }

            DB::table('pricelist')->where([
                'Customer' => $request->customer,
                'Category' => $request->category,
                'Carat' => $request->carat,
                'Currency' => 40,
            ])->update([
                'Price' =>  $this->parseNumeric($request->price),
                'PriceCust' => $this->parseNumeric($request->pricecust),
            ]);


            DB::commit();
            $data = $this->SetReturn(true, 'Berhasil Disimpan', null, null);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $data = $this->SetReturn(false, 'Server Error', $th->getMessage(), null);
            return response()->json($data, 500);
        }
    }
    public function show_pricelist_data()
    {
        $caratCustom = [1, 3, 13, 4, 5, 6];
        $data = DB::table('pricelist')
            ->select(
                'pricelist.*',
                'customer.Description as nama_customer',
                'product.Description as nama_produk',
                'carat.Description as nama_kadar',
            )
            ->join('customer', 'customer.ID', '=', 'pricelist.Customer')
            ->join('product', 'product.ID', '=', 'pricelist.Category')
            ->join('carat', 'carat.ID', '=', 'pricelist.Carat')
            ->where('Currency', 40)
            ->whereIN('carat', $caratCustom)
            ->orderBy('customer.Description', 'ASC')
            ->get()
            ->map(function ($item, $index) {
                $item->ID = $index + 1;
                $item->price_format = number_format($item->Price, 2, '.', ',');
                $item->priceCust_format = number_format($item->PriceCust, 2, '.', ',');
                return $item;
            });


        return response()->json(['data' => $data]);
    }
    public function show_grosir_data()
    {
        $data = DB::table('customer')->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1;
                return $item;
            });
        return response()->json(['data' => $data]);
    }
}
