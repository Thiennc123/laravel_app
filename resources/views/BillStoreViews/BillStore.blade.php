@extends('mainpage')

@section('main_content')
    <div class="header">
        <nav class="navbar navbar-light bg-light ">
            <form id="search-form" action="{{ url('/searching') }}" method="POST" class="col-7">
                @csrf
                <div class="row col-md-12">
                    <input class="form-control mr-sm-2 col-8" id="search" name="search" type="search"
                        placeholder="Use ProductID" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0 col-2" type="submit">Search</button>
                </div>

            </form>
            @yield('menu');

        </nav>
    </div>
    <div class="info mt-0 row mh-100">
        @yield('list_billsrore')
    </div>

    <!--Model add type-->


    <!--Modal add product-->

    <!-- Button trigger modal -->


    <!-- Modal -->

@endsection
