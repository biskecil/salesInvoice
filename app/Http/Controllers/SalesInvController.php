<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use stdClass;

class SalesInvController extends Controller
{
    //
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
            return response()->json(['price' => $data->Price > 0 ?  $data->Price / 100  : 0, 'priceCust' => $data->PriceCust > 0 ? $data->PriceCust / 100 : 0]);
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
    public function getDataNota(Request $request)
    {
        $term = $request->get('search');
        $data = DB::table('invoice')
            ->select('SW')
            ->when($term, function ($query, $term) {
                return $query->where('SW', 'like', "%{$term}%");
            })
            ->groupBy('SW')
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
    public function noNotaFormat($kodePameran, $grosir, $transDate, $urutan)
    {
        $kode_pameran =  $kodePameran == 'Pameran' ? 'P' : 'I';
        $transDate = Carbon::parse($transDate);
        $monthMM   = $transDate->format('m');
        $yearYY    = $transDate->format('y');
        $notaNum = str_pad($urutan, 4, '0', STR_PAD_LEFT);

        $noNota = $kode_pameran . $grosir . $yearYY . $monthMM . $notaNum;

        return $noNota;
    }
    public function edit($noNota)
    {
        $data = DB::table('invoice')
            ->select(
                'invoice.*',
                DB::raw("CONCAT(
            CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
            Grosir,
            DATE_FORMAT(TransDate, '%y%m'),
            LPAD(SW, 4, '0')
        ) as noNota")
            )
            ->whereRaw("CONCAT(
        CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
        Grosir,
        DATE_FORMAT(TransDate, '%y%m'),
        LPAD(SW, 4, '0')
    ) = ?", [$noNota])
            ->first();

        if ($data) {
            $getGrosirID = DB::select("SELECT ID FROM customer WHERE SW = ?", [$data->Grosir]);
            $data_item = DB::table('invoiceitem')
                ->select(
                    'invoiceitem.*',
                    'product.SW as productSW',
                    'product.Description as desc_item',
                    'carat.SW as caratSW',
                )
                ->addSelect([
                    'custprice' => DB::table('invoiceitem')
                        ->selectRaw('SUM(priceCust)')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1),
                    'nettcust' => DB::table('invoiceitem')
                        ->selectRaw('SUM(NettoCust) ')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1)
                ])
                ->leftJoin('product', 'product.ID', '=', 'invoiceitem.Product')
                ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')
                ->where('invoiceitem.IDM', $data->ID);

            $data_list = $data_item->get()->map(function ($item) {
                $item->custom_field = $item->IDM;
                $item->gw = number_format($item->Weight, 2, '.', '');
                $item->nw =  number_format($item->Netto, 3, '.', '');
                $item->price =  number_format($item->Price, 3, '.', '');
                $item->priceCust =  number_format($item->PriceCust, 3, '.', '');
                $item->netCust =  number_format($item->NettoCust, 3, '.', '');
                $item->isHargaCheck = $item->custprice + $item->nettcust  > 0 ? true : false;
                return $item;
            });



            $invoice = new stdClass();
            $invoice->invoice_number = $data->noNota;
            $invoice->ID = $data->ID;
            $invoice->SW = $data->SW;
            $invoice->TransDate = $data->TransDate;
            $invoice->Customer = $data->Customer;
            $invoice->Person = $data->Person;
            $invoice->Address = $data->Address;
            $invoice->SubGrosir = $data->SubGrosir;
            $invoice->Phone = $data->Phone;
            $invoice->Event = $data->Event;
            $invoice->Grosir = $getGrosirID[0]->ID;
            $invoice->Venue = $data->Venue;
            $invoice->Weight = $data->Weight;
            $invoice->Remarks = $data->Remarks;
            $invoice->Carat = $data_item->first()->caratSW;
            $invoice->ItemList = $data_list;
            $invoice->isHarga = $data_item->first()->custprice + $data_item->first()->nettcust  > 0 ? true : false;


            //return response()->json($invoice);

            $cust = DB::table('customer')->orderBy('Description')->get();
            $desc = DB::table('product')->select('ID', 'Description')->get();
            $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();


            $html = view('invoice.edit', ['desc' => $desc, 'kadar' => $kadar, 'data' => $invoice, 'cust' => $cust])->render();

            return response()->json([
                'html' => $html,
                'data' => $invoice
            ]);
        } else {
            return response()->json(['status' => 'Data kosong'], 500);
        }
    }
    public function detail($noNota)
    {
        $data = DB::table('invoice')
            ->select(
                'invoice.*',
                DB::raw("CONCAT(
                CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
                Grosir,
                DATE_FORMAT(TransDate, '%y%m'),
                LPAD(SW, 4, '0')
            ) as noNota")
            )
            ->whereRaw("CONCAT(
            CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
            Grosir,
            DATE_FORMAT(TransDate, '%y%m'),
            LPAD(SW, 4, '0')
        ) = ?", [$noNota])
            ->first();

        if ($data) {
            $getGrosirID = DB::select("SELECT ID,SW FROM customer WHERE SW = ?", [$data->Grosir]);
            $data_item = DB::table('invoiceitem')
                ->select(
                    'invoiceitem.*',
                    'product.SW as productSW',
                    'product.Description as desc_item',
                    'carat.SW as caratSW',
                )
                ->addSelect([
                    'custprice' => DB::table('invoiceitem')
                        ->selectRaw('SUM(priceCust)')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1),
                    'nettcust' => DB::table('invoiceitem')
                        ->selectRaw('SUM(NettoCust) ')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1)
                ])
                ->leftJoin('product', 'product.ID', '=', 'invoiceitem.Product')
                ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')

                ->where('invoiceitem.IDM', $data->ID);

            $data_list = $data_item->get()->map(function ($item) {
                $item->custom_field = $item->IDM;
                $item->gw = number_format($item->Weight, 2, '.', '');
                $item->nw =  number_format($item->Netto, 3, '.', '');
                $item->price =  number_format($item->Price, 3, '.', '');
                $item->priceCust =  number_format($item->PriceCust, 3, '.', '');
                $item->netCust =  number_format($item->NettoCust, 3, '.', '');
                $item->isHargaCheck = $item->custprice + $item->nettcust  > 0 ? true : false;
                return $item;
            });


            $invoice = new stdClass();
            $invoice->invoice_number = $data->noNota;
            $invoice->ID = $data->ID;
            $invoice->SW = $data->SW;
            $invoice->TransDate = $data->TransDate;
            $invoice->Customer = $data->Customer;
            $invoice->Person = $data->Person;
            $invoice->Address = $data->Address;
            $invoice->SubGrosir = $data->SubGrosir;
            $invoice->Phone = $data->Phone;
            $invoice->Event = $data->Event;
            $invoice->Grosir = $getGrosirID[0]->SW;
            $invoice->Venue = $data->Venue;
            $invoice->Weight = $data->Weight;
            $invoice->Remarks = $data->Remarks;
            $invoice->Carat = $data_item->first()->caratSW;
            $invoice->ItemList = $data_list;
            $invoice->isHarga = $data_item->first()->custprice + $data_item->first()->nettcust  > 0 ? true : false;


            //return response()->json($invoice);

            $cust = DB::table('customer')->orderBy('Description')->get();
            $desc = DB::table('product')->select('ID', 'Description')->get();
            $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();


            $html = view('invoice.detail', ['desc' => $desc, 'kadar' => $kadar, 'data' => $invoice, 'cust' => $cust])->render();

            return response()->json([
                'html' => $html,
                'data' => $invoice
            ]);
        } else {
            return response()->json(['status' => 'Data kosong'], 500);
        }
    }
    public function form()
    {
        $invoice =  DB::table('invoice')->orderByDesc('ID')->whereNotIN('id', [0])->limit(10)->get();

        $invoice->transform(function ($row) {

            $kode_pameran =  $row->Event == 'Pameran' ? 'P' : 'I';

            $transDate = Carbon::parse($row->TransDate);
            $monthMM   = $transDate->format('m');
            $yearYY    = $transDate->format('y');

            $notaNum = str_pad($row->SW, 4, '0', STR_PAD_LEFT);

            $row->invoice_number = $kode_pameran . $row->Grosir . $yearYY . $monthMM . $notaNum;

            return $row;
        });

        $cust = DB::table('customer')->orderBy('Description')->get();
        $desc = DB::table('product')->select('ID', 'Description')->get();
        $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();
        return view('invoice.form', ['desc' => $desc, 'kadar' => $kadar, 'cust' => $cust, 'data' => $invoice]);
    }
    public function cetakNota($noNota)
    {
        $data = DB::table('invoice')
            ->select(
                'invoice.*',
                DB::raw("CONCAT(
            CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
            Grosir,
            DATE_FORMAT(TransDate, '%y%m'),
            LPAD(SW, 4, '0')
        ) as noNota")
            )
            ->selectRaw('UPPER(SubGrosir) as subgrosir')
            ->selectRaw('UPPER(Address) as tempat')
            ->selectRaw('UPPER(Customer) as pelanggan')
            ->addSelect([
                'totalgw' => DB::table('invoiceitem')
                    ->selectRaw('SUM(Weight)')
                    ->whereColumn('invoiceitem.IDM', 'invoice.id')
                    ->limit(1),
                'totalnw' => DB::table('invoiceitem')
                    ->selectRaw('SUM(Netto)')
                    ->whereColumn('invoiceitem.IDM', 'invoice.id')
                    ->limit(1)
            ])
            ->whereRaw("CONCAT(
                CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
                Grosir,
                DATE_FORMAT(TransDate, '%y%m'),
                LPAD(SW, 4, '0')
            ) = ?", [$noNota])
            ->first();
        if ($data) {
            $getGrosirID = DB::select("SELECT ID,Description FROM customer WHERE SW = ?", [$data->Grosir]);
            $data_item = DB::table('invoiceitem')
                ->select(
                    'invoiceitem.*',
                    'product.SW as productSW',
                    'product.Description as productDesc',
                    'carat.SW as caratSW',
                    'carat.Description as caratDesc',
                )
                ->addSelect([
                    'custprice' => DB::table('invoiceitem')
                        ->selectRaw('SUM(priceCust)')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1),
                    'nettcust' => DB::table('invoiceitem')
                        ->selectRaw('SUM(NettoCust) ')
                        ->where('invoiceitem.IDM', $data->ID)
                        ->limit(1)
                ])
                ->leftJoin('product', 'product.ID', '=', 'invoiceitem.Product')
                ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')
                ->where('invoiceitem.IDM', $data->ID);

            $data_list = $data_item->get()->map(function ($item) {
                $item->custom_field = $item->IDM;
                $item->gw = number_format($item->Weight, 2, '.', '');
                $item->nw =  number_format($item->Netto, 3, '.', '');
                $item->price =  number_format($item->Price * 100, 1, '.', '');
                return $item;
            });

            $invoice = new stdClass();
            $invoice->ID = $data->ID;
            $invoice->SW = $data->noNota;
            $invoice->TransDate = Carbon::parse($data->TransDate)->format('d/m/Y');
            $invoice->Customer = $data->Customer;
            $invoice->Grosir = $getGrosirID[0]->Description;
            $invoice->Person = $data->Person;
            $invoice->Address = $data->Address;
            $invoice->Remarks = $data->Remarks;
            $invoice->totalgw = $data->totalgw;
            $invoice->totalnw = $data->totalnw;
            $invoice->Carat = $data_item->first()->caratSW;
            $invoice->ItemList = $data_list;
            $invoice->QRvalue = $this->Qrformat($data->subgrosir, $data->tempat, $data->pelanggan);
        }
        return view('invoice.cetakNota', ['data' => $invoice]);
    }
    public function cetakBarcode($noNota)
    {
        $data = DB::table('invoice')
            ->select(
                'invoice.*',
                DB::raw("CONCAT(
            CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
            Grosir,
            DATE_FORMAT(TransDate, '%y%m'),
            LPAD(SW, 4, '0')
        ) as noNota")
            )
            ->selectRaw('UPPER(SubGrosir) as subgrosir')
            ->selectRaw('UPPER(Address) as tempat')
            ->selectRaw('UPPER(Customer) as pelanggan')
            ->addSelect([
                'totalgw' => DB::table('invoiceitem')
                    ->selectRaw('SUM(Weight)')
                    ->whereColumn('invoiceitem.IDM', 'invoice.id')
                    ->limit(1),
            ])
            ->whereRaw("CONCAT(
                CASE WHEN Event = 'Pameran' THEN 'P' ELSE 'I' END,
                Grosir,
                DATE_FORMAT(TransDate, '%y%m'),
                LPAD(SW, 4, '0')
            ) = ?", [$noNota])->first();

        $data_item = DB::table('invoiceitem')
            ->select(
                'carat.SW as caratSW'
            )
            ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')
            ->where('invoiceitem.IDM', $data->ID)
            ->first();


        $data->invoice_number = $data->noNota;
        $data->totalgw = number_format($data->totalgw, 2, '.', '');
        $data->carat = $data_item->caratSW;

        $data->QRvalue = $this->Qrformat($data->subgrosir, $data->tempat, $data->pelanggan);
               
        return view('invoice.cetakBarcode', ['data' => $data]);
    }
    public function Qrformat($subgrosir, $tempat, $pelanggan)
    {
        $QRvalue = new stdClass();
        $QRvalue->it = '1';
        $QRvalue->nt = $subgrosir;
        $QRvalue->at = $tempat;
        $QRvalue->pt = $pelanggan;
        $QRvalue->kp = 'LG';

        return json_encode($QRvalue);
    }
    public function create()
    {
        $cust = DB::table('customer')->orderBy('Description')->get();
        $desc = DB::table('product')->select('ID', 'Description')->get();
        $kadar = DB::table('carat')->select('ID', 'SW')->orderBy('SW')->get();
        return view('invoice.create', ['desc' => $desc, 'kadar' => $kadar, 'cust' => $cust]);
    }
    public function getDataNotaAll()
    {
        $data = DB::table('invoiceitem')
            ->select(
                'invoiceitem.*',
                'invoice.Event',
                'invoice.Grosir',
                'invoice.TransDate',
                'invoice.SW',
                'invoice.ID',
                'invoice.Customer',
                'invoice.Address',
                'invoice.Phone',
                'invoice.Venue',
                'product.SW as productSW',
                'product.Description as productDesc',
                'carat.Description as caratDesc',
                'carat.SW as caratSW'
            )
            ->leftJoin('invoice', 'invoiceitem.IDM', '=', 'invoice.ID')
            ->leftJoin('product', 'product.ID', '=', 'invoiceitem.Product')
            ->leftJoin('carat', 'carat.ID', '=', 'invoiceitem.Carat')
            ->whereNotIn('invoice.ID', [0])
            ->get()
            ->map(function ($row) {

                $row->invoice_number =   $this->noNotaFormat($row->Event, $row->Grosir, $row->TransDate, $row->SW);
                return $row;
            });
        return response()->json(['data' => $data]);
    }
    public function show()
    {
        return view('invoice.show');
    }
    public function update($id, Request $request)
    {
        $validated = Validator::make($request->all(), [
            'transDate'   => 'required|date',
            'customer'    => 'required',
            'event'       => 'required',
            'grosir'      => 'required',
            'cadar'       => 'required|array|min:1',
        ]);

        if ($validated->fails()) {
            $data = $this->SetReturn(true, 'Cek Form', null, null);
            return response()->json($data, 500);
        }


        try {
            DB::beginTransaction();
            //code...
            $getGrosirID = DB::select("SELECT SW FROM customer WHERE ID = ?", [$request->grosir]);

            DB::table('invoice')
                ->where('ID', $id)
                ->update([
                    'TransDate' => $request->transDate,
                    'Customer' => $request->customer,
                    'Address' => $request->alamat,
                    'Phone' => $request->phone,
                    'Event' => $request->event,
                    'Grosir' => $getGrosirID[0]->SW,
                    'Weight' => 0,
                    'Remarks' => $request->catatan,
                    'Venue' => $request->tempat,
                    'DocNo' => NULL,
                    'Currency' => NULL,
                    'Person' => $request->pembeli,
                    'SubGrosir' => $request->sub_grosir,
                ]);

            $cekOpnameItem = DB::table('invoiceitem')->where('IDM', $id);

            if (count($request->cadar) > 0) {
                $cekOpnameItem->delete();
                $total_weight = 0;
                for ($i = 0; $i < count($request->cadar); $i++) {
                    $total_weight +=  $request->wbruto[$i];
                    $descCat = $request->category[$i];
                    $descCarat = $request->cadar[$i];
                    $getProductSW = DB::select("SELECT ID FROM product WHERE Description = ?", [$descCat]);
                    $getCarat = DB::select("SELECT ID FROM carat  WHERE SW  = ?", [$descCarat]);

                    DB::table('invoiceitem')->insertGetId([
                        'IDM' => $id,
                        'Ordinal' => $i + 1,
                        'Product' =>  $getProductSW[0]->ID,
                        'Carat' =>  $getCarat[0]->ID,
                        'Weight' => $request->wbruto[$i],
                        'Price' => $request->price[$i],
                        'Netto' => $request->wnet[$i],
                        'PriceCust' => isset($request->harga) ? $request->pricecust[$i] : 0,
                        'NettoCust' => isset($request->harga) ? $request->wnetocust[$i] : 0,
                    ]);
                }
                DB::table('invoice')->where('ID', $id)->update(["Weight" => $total_weight]);
            }
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

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'transDate'   => 'required|date',
            'customer'    => 'required',
            'event'       => 'required',
            'grosir'      => 'required',
            'cadar'       => 'required|array|min:1',
        ]);

        if ($validated->fails()) {
            $data = $this->SetReturn(true, 'Cek Form', null, null);
            return response()->json($data, 422);
        }


        try {
            DB::beginTransaction();
            //code...
            $getLastInvID = DB::table('invoice')->max('ID') + 1;
            $getGrosirID = DB::select("SELECT SW FROM customer WHERE ID = ?", [$request->grosir]);

            $transDate = Carbon::parse($request->transDate);
            $month     = $transDate->format('m');
            $year      = $transDate->format('Y');

            $getLastNotaID = DB::table('invoice')
                ->whereMonth('TransDate', $month)
                ->whereYear('TransDate', $year)
                ->max('SW');

            $inv =  DB::table('invoice')->insert([
                'ID' => $getLastInvID,
                'SW' => $getLastNotaID ? $getLastNotaID + 1 : 1,
                'TransDate' => $request->transDate,
                'Customer' => $request->customer,
                'Address' => $request->alamat,
                'Phone' => $request->phone,
                'Event' => $request->event,
                'Grosir' => $getGrosirID[0]->SW,
                'Weight' => 0,
                'Remarks' => $request->catatan,
                'Venue' => $request->tempat,
                'DocNo' => NULL,
                'Currency' => NULL,
                'Person' => $request->pembeli,
                'SubGrosir' => $request->sub_grosir,
            ]);

            if (count($request->cadar) > 0) {
                $total_weight = 0;
                for ($i = 0; $i < count($request->cadar); $i++) {
                    $total_weight +=  $request->wbruto[$i];
                    $descCat = $request->category[$i];
                    $descCarat = $request->cadar[$i];
                    $getProductSW = DB::select("SELECT ID FROM product WHERE Description = ?", [$descCat]);
                    $getCarat = DB::select("SELECT ID FROM carat  WHERE SW  = ?", [$descCarat]);

                    DB::table('invoiceitem')->insertGetId([
                        'IDM' => $getLastInvID,
                        'Ordinal' => $i + 1,
                        'Product' =>  $getProductSW[0]->ID,
                        'Carat' =>  $getCarat[0]->ID,
                        'Weight' => $request->wbruto[$i],
                        'Price' => $request->price[$i],
                        'Netto' => $request->wnet[$i],
                        'PriceCust' => isset($request->harga) ? $request->pricecust[$i] : 0,
                        'NettoCust' => isset($request->harga) ? $request->wnetocust[$i] : 0,
                    ]);
                }
                DB::table('invoice')->where('ID', $getLastInvID)->update(["Weight" => $total_weight]);
            }
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
}
