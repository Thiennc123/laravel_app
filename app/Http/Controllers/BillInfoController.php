<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BillStore;
use App\Models\BillInfo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Pivot;
use \Illuminate\Support\Str;


class BillInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //$latestBillStoreID = BillStore::latest()->value('id');
        $product = BillStore::find($id)->product()->get();
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

        $statusBillStore = BillStore::where('id', $id)->value('status');




        return view('BillStoreViews.addBillStore', ['listProducts' => $sorted, 'totalPrice' => $totalPrice, 'idStoreBill' => $id, 'status' => $statusBillStore]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $billStoreID = (int)substr(url()->current(), 32, 2);

        $product_id = substr($request->input('search'), 0, 12);
        $id = Product::where('product_id', 'LIKE', '%' . $product_id . '%')->value('id');
        //$latestBillStoreID = BillStore::latest()->value('id');
        $shop = BillStore::find($billStoreID);


        $products = $shop->product()->get();

        if ($products->isEmpty()) {
            $shop->product()->attach($id, [
                'count' => 1,
            ]);
        } else {

            $thien = $products->contains('id', $id);
            if ($thien !== false) {

                /*$product = $products->where('id', $id);*/
                foreach ($products as $product) {
                    if ($product->id == $id) {

                        $thien = BillInfo::find($product->pivot->id);
                        $thien->count;

                        BillInfo::find($product->pivot->id)->update(array('count' => $thien->count + 1));
                        break;
                    }
                }
            } else {
                $shop->product()->attach($id, [
                    'count' => 1,
                ]);
            }
        }



        return redirect()->route('addBillInfo', ['id' => $billStoreID]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$latestBillStoreID = BillStore::latest()->value('id');
        $product = BillStore::find($id)->product()->get();
        $totalPrice = 0;
        $sorted = $product->sortByDesc(function ($item, $key) {
            return ($item->pivot->id);
        });

        $statusBillStore = BillStore::where('id', $id)->value('status');


        if ($product->isNotEmpty()) {


            foreach ($product as $item) {
                $item['count'] = $item->pivot->count;
                $totalPrice += $item['count'] * $item->wPrice;
            }
        }






        return view('BillStoreViews.addBillStore', ['listProducts' => $sorted, 'totalPrice' => $totalPrice, 'idStoreBill' => $id, 'status' => $statusBillStore]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        //$latestBillStoreID = BillStore::latest()->value('id');
        $shop = BillStore::find($request->input('idBillStore'));


        $products = $shop->product()->get();

        $count = $request->input('count');
        $wPrice = 0;
        $totalPrice = 0;
        $product_id = $request->input('product_id');
        foreach ($products as $product) {
            if ($product->id == $product_id) {

                $thien = BillInfo::find($product->pivot->id);
                $thien->count;
                $wPrice += $product->wPrice;
                BillInfo::find($product->pivot->id)->update(array('count' => $count));
                break;
            }
        }



        foreach ($products as $item) {
            $item['count'] = $item->pivot->count;
            $totalPrice += $item['count'] * $item->wPrice;
        }

        return response()->json([
            'count' => $count,
            'wPrice' => $wPrice,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $shop = BillStore::find($request->input('idBillStore'));
        $shop->product()->detach($id);
    }
}
