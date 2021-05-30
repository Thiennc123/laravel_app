@extends('mainpage')

@section('main_content')
    <div class="header">
        <nav class="navbar navbar-light bg-light ">

            @if ($status != 1)
                <form id="search-form" action="{{ route('storeBillInfo1', ['id' => $idStoreBill]) }}" method="POST"
                    class="col-7">
                    @csrf

                    <div class="row col-md-12">
                        <input class="form-control mr-sm-2 col-8" id="search" name="search" type="search"
                            placeholder="Use ProductID" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 col-2" type="submit">Search</button>
                    </div>

                </form>
                <div class="float-right row mr-4 col-4">
                    <input type="hidden" class="idBillStore" name="idStoreBill" value="{{ $idStoreBill }}">
                    <a class=" TSave btn btn-warning" type="btn">Temporary Save </a>
                    <a class=" Save btn btn-primary ml-4" type="btn">Save</a>

                </div>
            @endif



        </nav>
    </div>
    <div class="info mt-0 row mh-100">
        <div class="col-9">
            <table class=" table table-hover" id="user_table">
                <thead>
                    <tr>
                        <th scope=" col" style="width:5%" class="text-center">ID</th>
                        <th scope="col" style="width:30%" class="text-center">Name</th>
                        <th scope="col" style="width:10%" class="text-center">Count</th>
                        <th scope="col" style="width:10%" class="text-center">WholePrice</th>
                        <th scope="col" style="width:1%" class="text-center">Total</th>
                        <th scope="col" style="width:20%" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($listProducts))





                        @foreach ($listProducts as $item)

                            <tr class="thien">
                                <td class="text-center">{{ $item->product_id }}</td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">
                                    <input type="hidden" name="_token"
                                        value="<?php Session::token(); ?>">
                                    <input class="product_id" type="text" value="{{ $item->id }}" name="product_id"
                                        hidden>

                                    <input class="countTotalProduct" type="number" value="{{ $item->count }}"
                                        name="count">

                                </td>
                                <td class="text-center">{{ $item->wPrice }}</td>
                                <td class=" total text-center">{{ $item->wPrice * $item->count }}</td>
                                <td class="text-center">
                                    @if ($status != 1)
                                        <button type="button" class=" remove btn btn-danger">Remove</button>
                                    @endif


                                </td>
                            </tr>



                        @endforeach


                    @endif


                </tbody>
            </table>
        </div>
        <div class=" thien1 col-3 border-left ">
            <div class="f-right position-fixed text-center">
                <div class="form-group">
                    <label for="countProduct">Total Product</label>
                    <input type="text" class="form-control" id="countProduct" value="{{ $listProducts->count() }}"
                        disabled>
                    <small id="emailHelp" class="form-text text-muted">This is sum of product on your bill</small>
                </div>
                <br>
                <div class="form-group">
                    <label for="countProduct">Total Count</label>
                    <input type="text" class="form-control" id="sumProduct" value="{{ $listProducts->sum('count') }}"
                        disabled>

                    <small id="emailHelp" class="form-text text-muted">This is sum of product on your bill</small>
                </div>
                <br>
                <div class="form-group">
                    <label for="countProduct">Total Price</label>
                    <input type="number" class=" totalPrice form-control" id="countPrice" value="{{ $totalPrice }}"
                        disabled>
                    <small id="emailHelp" class="form-text text-muted">This is tatal price use wPrice on your bill</small>
                </div>

            </div>
        </div>
    </div>

    <!--Model add type-->


    <!--Modal add product-->

    <!-- Button trigger modal -->


    <!-- Modal -->

@endsection
