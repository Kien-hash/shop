@extends('pages.layouts.index')

@section('content')
    <section id="cart_items">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="register-req">
            <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div>
        <!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                
            </div>
        </div>

    </section>
@endsection

@section('scripts')
@endsection
