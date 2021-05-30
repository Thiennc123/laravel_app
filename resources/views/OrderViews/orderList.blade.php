@extends('OrderViews.order')

@section('list_order')

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope=" col" style="width:5%" class="text-center">ID</th>
                <th scope="col" style="width:20%" class="text-center">Name</th>
                <th scope="col" style="width:15%" class="text-center">Inventory Number</th>
                <th scope="col" style="width:15%" class="text-center">Wholesale price</th>
                <th scope="col" style="width:20%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listProducts as $product)


                <tr>
                    <td class="text-center">{{ $product->product_id }}</td>
                    <td class="text-center">{{ $product->name }}</td>
                    <td class="text-center">{{ $product->count }}</td>
                    <td class="text-center">{{ $product->wPrice }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger">Remove</button>
                        <button type="button" class="btn btn-info">Edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $listProducts->links() }}
    </div>

@endsection
