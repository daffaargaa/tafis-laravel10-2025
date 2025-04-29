@extends('layouts.index')

@section('head')
@endsection

@section('body')
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ asset('vendor/images/banner-img.png') }}" alt="">
            </div>
            <div class="col-md-4">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    <div class="weight-600 font-20 text-black">Welcome To Tafis Application</div>
                </h4>
                <p class="font-14 max-width-1000">This Tafis Application was made to facilitate the
                    performance of the financial team of PT. Lancar Wiguna Sejahtera.</p>
            </div>
        </div><br>
    </div><br><br><br><br><br>
@endsection

@section('footer')
    <div class="footer-wrap pd-20 mb-10 card-box">
        Copyright &copy; 2024 Tafis - Dept</a> PT. Lancar Wiguna Sejahtera <br> Version 02 . 24
    </div>
@endsection
