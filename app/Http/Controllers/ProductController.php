<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Type;
use App\Helpers\Helper;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('product_id', 'desc')->paginate(10);
        $type = Type::all();
        return view('OrderViews.orderList', ['listProducts' => $product, 'listTypes' => $type]);
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
        $id_type = Type::where('name', $request->loaiKinh)->value('id');
        $product = Product::create([
            'name' => $request->name,
            'product_id' => Helper::IDGenerator(new Product, 'product_id', 9, 'IOP'), //top mean id of product
            'status' => true,
            'wPrice' => $request->giaSi,
            'rPrice' => $request->giaLe,
            'count' => 0,
            'id_type' => $id_type,
        ]);


        $product->save();

        return redirect('/orderList');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchAutoComplete(Request $request)
    {


        $query = $request->get('term', '');
        $products = Product::where('name', 'like', '%' . $query . '%')->where('status', '1')->get();

        $data = [];
        foreach ($products as $items) {
            $data[] = [
                'value' => $items->product_id . ' || ' . $items->name . ' || Giá sỉ: ' . $items->wPrice . ' ||  Số Lượng:' . $items->count,
                'id' => $items->product_id,
            ];
        }

        if (count($data)) {
            return $data;
        } else {
            return ['value' => 'No Result', 'id' => ''];
        }
    }
}
