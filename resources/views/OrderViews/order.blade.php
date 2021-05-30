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
            <div class="float-right mr-4 col-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">New
                    Prodcut</button>
                <button type="
                        button" class="btn btn-primary" data-toggle="modal" data-target="#addTypeModal">New Type</button>
                <button type=" button" class="btn btn-secondary ">Print Barcode</button>
            </div>

        </nav>
    </div>
    <div class="info mt-0">
        @yield('list_order')
    </div>

    <!--Model add type-->
    <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addTypes') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name Type</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter type">

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal add product-->

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nhập hàng mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addProducts') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Mã Số</label>
                                <input type="text" class="form-control" name="maSo" id="maSo" placeholder="Nhập mã số">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Đặc điểm</label>
                                <input type="text" class="form-control" name="dacDiem" id="dacDiem"
                                    placeholder="Nhập đặc điểm">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputAddress2">Giá sỉ</label>
                                <input type="number" class="form-control" name="giaSi" id="giaSi"
                                    placeholder="Nhập vào giá sỉ" min="0">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputCity">Giá lẻ</label>
                                <input type="number" class="form-control" name="giaLe" id="giaLe" min="0"
                                    placeholder="=Giá sỉ *2">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="loaiKinh">Loại kính</label>
                                <select id="loaiKinh" name='loaiKinh' class="form-control">
                                    <option selected></option>
                                    @foreach ($listTypes as $type)
                                        <option>{{ $type->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="inputCity">Tên của sản phẩm</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#loaiKinh, #dacDiem, #maSo").focusout(function() {
                $('#name').val($('#loaiKinh').val() + ' ' + $('#dacDiem').val() + ' ' + $('#maSo').val());
            });

            $("#giaSi").focusout(function() {
                $('#giaLe').val($('#giaSi').val() * 2);
            });
        });

    </script>
@endsection
