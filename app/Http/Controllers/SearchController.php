<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchAutoComplete(Request $request)
    {

        //alert($request);

        /*$query = $request->get('term','');
        $products = Product::where('name', 'LIKE', '%'.$query.'%')->where('status','1')->get();

        $data = [];
        foreach($products as $items)
        {
            $data[] = [
                'value'->$items->name,
                'id'->$items->product_id,
            ];
        }

        if(count($data))
        {
            return $data;
        }else{
            return ['value'=>'No Result','id'=>''];
        }*/
    }
}
