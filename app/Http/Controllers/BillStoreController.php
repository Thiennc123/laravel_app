<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillStore;
use App\Helpers\Helper;
use App\Models\BillInfo;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use PDF;

class BillStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $collection = BillStore::orderBy('bill_store_id', 'desc')->get();
        $billStore = $collection->reject(function ($value, $key) {
            return $value->status === -1;
        });


        //$billStore = BillStore::orderBy('bill_store_id', 'desc')->where('status', '<>', -1)->paginate(10);
        return view('BillStoreViews.listBillStore', ['listBillStore' => $billStore]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newBill = BillStore::create([

            'bill_store_id' => Helper::IDGenerator(new BillStore, 'bill_store_id', 9, 'IBS'), //top mean id bill store

        ]);


        $newBill->save();
        $latestBillStoreID = BillStore::latest()->value('id');
        return redirect()->route('addBillInfo', ['id' => $latestBillStoreID]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $status = $request->input('status');
        $billStore = BillStore::find($id);

        $billStore->status = $status;
        $billStore->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listBillStore = BillStore::all();

        foreach ($listBillStore as $billStore) {
            if ($billStore->status == -1) {
                $billStore->delete();
            }
        }

        $billStore = BillStore::where('id', $id)->delete();

        return redirect('/showBillStore');
    }

    public function updateProductAfterSave($id)
    {


        $listBillInfo = BillInfo::where('bill_store_id', $id)->get();

        $listProduct = Product::all();

        foreach ($listBillInfo as $billInfo) {

            foreach ($listProduct as $product) {

                if ($billInfo->product_id == $product->id) {
                    $product->count = $product->count + $billInfo->count;
                    $product->update();

                    break;
                }
            }
        }

        return redirect('/showBillStore');
    }

    public function printOder($check_code)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($check_code));
        return $pdf->stream();
    }


    public function print_order_convert($check_code)
    {
        $product = BillStore::find($check_code)->product()->get();
        $totalPrice = 0;
        $sorted = $product->sortByDesc(function ($item, $key) {
            return ($item->pivot->id);
        });





        if ($product->isNotEmpty()) {


            foreach ($product as $item) {
                $item['count'] = $item->pivot->count;
                $totalPrice += $item['count'] * $item->wPrice;
            }
        }

        $date = BillStore::where('id', $check_code)->value('updated_at');
        $billStore_id = BillStore::where('id', $check_code)->value('bill_store_id');
        $output = '<style>
                         body{
                                font-family: DejaVu Sans;
                                line-height: 5px;
                            }

                        table, th, td {
                                border: 1px solid black;
                                 border-collapse: collapse;
                        
                        }

                        th, td {
                                 padding: 15px;
                        }
                </style>

            <h1><center>Shop Mắt Kính WILI</center></h1></br>
            <h5>Mã số bill: ' . $billStore_id . '</h5> </br>
            <h5>Date:  ' . $date . ' </h5> </br>
            <h5>Tên người nhập: Thiện đẹp trai</h5></br>
            <h5>Số sản phẩm trong bill:  ' . $sorted->sum('count') . '</h5></br>
            

            <table style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 10%" >STT</th>
                        <th style="width: 50%">Name</th>
                        <th style="width: 10%" >Count</th>
                        <th  style="width: 10%">Price</th>
                        <th style="width: 20%" >Total</th>
                        
                    </tr>
                </thead>
                <tbody>
                        ';
        $i = 1;
        foreach ($sorted as $key => $item) {

            $output .= '

                            <tr class="thien">
                                <td>' . $i . '</td>
                                <td>' . $item->name . '</td>
                                <td> ' . $item->count . '</td>
                                <td class="text-center">' . $item->wPrice . '</td>
                                <td class=" total text-center">' . $item->wPrice * $item->count . '</td>
                               
                            </tr>';
            $i++;
        }





        $output .= '</tbody>
            </table></br>
            <h5>Tổng tiền: ' . $totalPrice . '</h5>
            ';

        return $output;
    }
}
