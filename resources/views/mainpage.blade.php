@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="{{ route('orderList') }}"><i class="fas fa-home"></i>Order</a></li>
                <li><a href="#"><i class="fas fa-user"></i>Products</a></li>
                <li><a href="{{ route('billStoreList') }}"><i class="fas fa-address-card"></i>Store</a></li>

            </ul>
            <div class="social_media">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="main_content">
            @yield('main_content')
        </div>
    </div>
@endsection
