<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvController extends Controller
{
    //
    public function getDataPrice(Request $request)
    {
        $category =   DB::table('product')
            ->where([
                'Description' => $request->category,
            ])
            ->first();

        $carat =  DB::table('carat')
            ->where([
                'SW' => $request->carat,
            ])
            ->first();

        $data = DB::table('pricelist')
            ->where([
                'Customer' => $request->customer,
                'Category' => $category->ID,
                'Carat' => $carat->ID,
                'Currency' => 40
            ])
            ->first();

        if ($data) {
            return response()->json(['price' => $data->Price, 'priceCust' => $data->PriceCust]);
        } else {
            return response()->json(['data' => 0]);
        }
    }
    public function getDataSubGros(Request $request)
    {
        $term = $request->get('search');
        $data = DB::table('invoice')
            ->select('SubGrosir')
            ->when($term, function ($query, $term) {
                return $query->where('SubGrosir', 'like', "%{$term}%");
            })
            ->groupBy('SubGrosir')
            ->get();
        return response()->json($data);
    }
    public function getDataGros($id)
    {
        $data = DB::table('customer')
            ->where('ID', $id)
            ->get();
        return response()->json($data);
    }
    public function edit($id)
    {
        $desc = DB::table('product')->select('ID', 'Description')->get();
        $cust = DB::table('pricelist')->select('Customer')->groupBy('Customer')->get();
        $kadar = DB::table('carat')->select('ID', 'Description')->get();
        $data = DB::table('invoice')->where('ID', $id)->first();
        return response()->json(['data' => $data, 'status' => 'success']);
        return view('invoice.edit', ['desc' => $desc, 'kadar' => $kadar, 'data' => $data, 'cust' => $cust]);
    }
    public function form()
    {
        $cust = DB::table('customer')->orderBy('Description')->get();
        $desc = DB::table('product')->select('ID', 'Description')->get();
        $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();
        return view('invoice.form', ['desc' => $desc, 'kadar' => $kadar, 'cust' => $cust]);
    }
    public function create()
    {
        $cust = DB::table('customer')->orderBy('Description')->get();
        $desc = DB::table('product')->select('ID', 'Description')->get();
        $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();
        return view('invoice.create', ['desc' => $desc, 'kadar' => $kadar, 'cust' => $cust]);
    }
    public function show()
    {
        $data = DB::table('invoiceitem')
            ->select(
                'invoiceitem.*',
                'invoice.*',
                'product.Description as category_name',
                'carat.Description as carat_name'
            )
            ->leftJoin('invoice', 'invoiceitem.IDM', '=', 'invoice.ID')
            ->leftJoin('product', 'product.ID', '=', 'invoiceitem.Product')
            ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')
            ->get();
        return view('invoice.show', ['data' => $data]);
    }
    public function store(Request $request)
    {
        // return response()->json($request->all());
        // dd(json_decode(json_encode($request->all())));


        $validated = $request->validate([
            'transDate'   => 'required|date',
            'customer'    => 'required|string',
            'event'       => 'required|string',
            'grosir'      => 'required|string',
            'tempat'      => 'required|string',
            'pembeli'     => 'required|string',
            'sub_grosir'  => 'required|string',
            'alamat'      => 'required|string',
            'cadar'       => 'required|array|min:1',
            'phone'       => 'nullable|string',
            'catatan'     => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            //code...
            $getLastInvID = DB::table('invoice')->max('ID') + 1;

            $inv =  DB::table('invoice')->insert([
                'ID' => $getLastInvID,
                'SW' => 1,
                'TransDate' => $request->transDate,
                'Customer' => $request->customer,
                'Address' => $request->alamat,
                'Phone' => $request->phone,
                'Event' => $request->event,
                'Grosir' => $request->grosir,
                'Weight' => 0,
                'Remarks' => $request->catatan,
                'Venue' => $request->tempat,
                'DocNo' => NULL,
                'Currency' => NULL,
                'Person' => $request->pembeli,
                'SubGrosir' => $request->sub_grosir,
            ]);

            if (count($request->cadar) > 0) {

                for ($i = 0; $i < count($request->cadar); $i++) {
                    $descCat = $request->category[$i];
                    $descCarat = $request->cadar[$i];
                    $getProductSW = DB::select("SELECT ID FROM product WHERE Description = '$descCat' ");
                    $getCarat = DB::select("SELECT ID FROM carat  WHERE SW  = '$descCarat'");

                    DB::table('invoiceitem')->insertGetId([
                        'IDM' => $getLastInvID,
                        'Ordinal' => $i + 1,
                        'Product' =>  $getProductSW[0]->ID,
                        'Carat' =>  $getCarat[0]->ID,
                        'Weight' => $request->wbruto[$i],
                        'Price' => $request->price[$i],
                        'Netto' => $request->wnet[$i],
                        'PriceCust' => $request->pricecust[$i],
                        'NettoCust' => $request->wnetocust[$i],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('sales.form')->with('success', "Invoice berhasil dibuat");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('sales.form')->with('error', "Gagal membuat invoice");
        }
    }
}
