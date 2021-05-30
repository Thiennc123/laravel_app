@extends('mainpage')

@section('main_content')
    <div class="header">
        <nav class="navbar navbar-light bg-light ">
            <form id="search-form1" action="{{ url('/searching') }}" method="POST" class="col-7">
                @csrf
                <div class="row col-md-12">
                    <input class="form-control mr-sm-2 col-8" id="search" name="search" type="search"
                        placeholder="Use ProductID" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0 col-2" type="submit">Search</button>
                </div>

            </form>

            <div class="float-right mr-4 col-4">
                <a href="{{ route('addBillStore') }}" class="btn btn-xs btn-info pull-right">New Bill</a>

                <button type=" button" class="btn btn-secondary ">Print Barcode</button>
            </div>

        </nav>
    </div>
    <div class="info mt-0 row mh-100">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope=" col" style="width:5%" class="text-center">ID</th>
                    <th scope="col" style="width:20%" class="text-center">Status</th>
                    <th scope="col" style="width:20%" class="text-center"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($listBillStore as $billStore)


                    <tr class="thien1">
                        <td class="text-center">{{ $billStore->bill_store_id }}</td>
                        <td class="text-center">
                            @php
                                if ($billStore->status === 1) {
                                    echo 'Da Luu';
                                } else {
                                    echo 'chua luu';
                                }
                            @endphp
                        </td>
                        <td class="text-center">

                            @if ($billStore->status === 1)
                                <input type="text" hidden>
                                <a href="/editBillStore/{{ $billStore->id }}" class="btn btn-success">View</a>
                                <a href="/printBillStore/{{ $billStore->id }}" class="btn btn-primary">Print</a>
                            @else

                                <a href="/editBillStore/{{ $billStore->id }}" class="btn btn-info">Edit</a>
                            @endif
                            <a href="/deleteBillStore/{{ $billStore->id }}" class="btn btn-danger">Remove</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!--Model add type-->


    <!--Modal add product-->

    <!-- Button trigger modal -->


    <!-- Modal -->

@endsection
