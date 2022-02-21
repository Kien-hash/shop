@extends('pages.layouts.index')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
                </ol>
            </div>

            @if (!Session::get('customer_id'))
                <div class="register-req" style="width:75%">
                    <p>Hãy đăng ký hoặc đăng nhập để đặt hàng giỏ hàng </p>
                </div>
            @endif

            <div class="shopper-informations">
                <div class="row">

                    <div class="col-sm-12 clearfix">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                            </div>
                        @endif
                        <div class="table-responsive cart_info" style="width:75%;">
                            <form action="{{ url('/update-cart') }}" method="POST" >
                                @csrf
                                <table class="table table-condensed" >
                                    <thead>
                                        <tr class="cart_menu">
                                            <td class="image">Hình ảnh</td>
                                            <td class="description">Tên sản phẩm</td>
                                            <td class="price">Giá sản phẩm</td>
                                            <td class="quantity">Số lượng</td>
                                            <td class="total">Thành tiền</td>
                                            <td style="width:40px;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Session::get('cart') == true)
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach (Session::get('cart') as $key => $cart)
                                                @php
                                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                    $total += $subtotal;
                                                @endphp
                                                <tr>
                                                    <td class="cart_product">
                                                        <img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}"
                                                            width="90" alt="{{ $cart['product_name'] }}" />
                                                    </td>
                                                    <td class="cart_description">
                                                        <h4><a href=""></a></h4>
                                                        <p>{{ $cart['product_name'] }}</p>
                                                    </td>
                                                    <td class="cart_price">
                                                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}VNĐ</p>
                                                    </td>
                                                    <td class="cart_quantity">
                                                        <div class="cart_quantity_button">
                                                            <input style="width: 60px;" class="cart_quantity" type="number"
                                                                min="1" name="cart_qty[{{ $cart['session_id'] }}]"
                                                                value="{{ $cart['product_qty'] }}">
                                                        </div>
                                                    </td>
                                                    <td class="cart_total">
                                                        <p class="cart_total_price">
                                                            {{ number_format($subtotal, 0, ',', '.') }}VNĐ
                                                        </p>
                                                    </td>
                                                    <td class="cart_delete">
                                                        <a class="cart_quantity_delete"
                                                            href="{{ url('/del-product/' . $cart['session_id']) }}"><i
                                                                class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                                        class="check_out btn btn-default btn-sm"></td>
                                                <td><a class="btn btn-default check_out"
                                                        href="{{ url('/del-all-product') }}">Xóa tất cả</a></td>
                                                <td>
                                                    @if (Session::get('coupon'))
                                                        <a class="btn btn-default check_out"
                                                            href="{{ url('/unset-coupon') }}">Xóa mã khuyến mãi</a>
                                                    @endif
                                                </td>

                                                <td colspan="2">
                                                    <li>Tổng tiền
                                                        :<span>{{ number_format($total, 0, ',', '.') }}VNĐ</span>
                                                    </li>
                                                    @if (Session::get('coupon'))
                                                        <li>
                                                            @foreach (Session::get('coupon') as $key => $cou)
                                                                @if ($cou['coupon_type'] == 2)
                                                                    Mã giảm : {{ $cou['coupon_amount'] }} %
                                                                    <p>
                                                                        @php
                                                                            $total_coupon = ($total * $cou['coupon_amount']) / 100;
                                                                        @endphp
                                                                    </p>
                                                                    <p>
                                                                        @php
                                                                            $total_after_coupon = $total - $total_coupon;
                                                                        @endphp
                                                                    </p>
                                                                @elseif($cou['coupon_type'] == 1)
                                                                    Mã giảm :
                                                                    {{ number_format($cou['coupon_amount'], 0, ',', '.') }}
                                                                    VNĐ
                                                                    <p>
                                                                        @php
                                                                            $total_coupon = $total - $cou['coupon_amount'];
                                                                        @endphp
                                                                    </p>
                                                                    @php
                                                                        $total_after_coupon = $total_coupon;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </li>
                                                    @endif

                                                    @if (Session::get('fee'))
                                                        <li>
                                                            <a class="cart_quantity_delete"
                                                                href="{{ url('/del-fee') }}"><i
                                                                    class="fa fa-times"></i></a>
                                                            Phí vận chuyển
                                                            <span>{{ number_format(Session::get('fee'), 0, ',', '.') }}VNĐ</span>
                                                        </li>
                                                        <?php $total_after_fee = $total + Session::get('fee'); ?>
                                                    @endif
                                                    <li>Tổng còn:
                                                        @php
                                                            if (Session::get('fee') && !Session::get('coupon')) {
                                                                $total_after = $total_after_fee;
                                                                echo number_format($total_after, 0, ',', '.') . 'VNĐ';
                                                            } elseif (!Session::get('fee') && Session::get('coupon')) {
                                                                $total_after = $total_after_coupon;
                                                                echo number_format($total_after, 0, ',', '.') . 'VNĐ';
                                                            } elseif (Session::get('fee') && Session::get('coupon')) {
                                                                $total_after = $total_after_coupon;
                                                                $total_after = $total_after + Session::get('fee');
                                                                echo number_format($total_after, 0, ',', '.') . 'VNĐ';
                                                            } elseif (!Session::get('fee') && !Session::get('coupon')) {
                                                                $total_after = $total;
                                                                echo number_format($total_after, 0, ',', '.') . 'VNĐ';
                                                            }
                                                        @endphp
                                                    </li>

                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    <center> Làm ơn thêm sản phẩm vào giỏ hàng</center>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>

                            </form>
                            @if (Session::get('cart'))
                                <tr>
                                    <td colspan="3">
                                        <form method="POST" action="{{ url('/check-coupon') }}">
                                            @csrf
                                            <input type="text" id="coupon" class="" name="coupon"
                                                placeholder="{{ Session::get('coupon') ? Session::get('coupon')[0]['coupon_code'] : 'Nhập mã giảm giá' }}">
                                            <button type="button" class="btn btn-default check_coupon" id="check_coupon"
                                                name="">Tính mã giảm giá</button>
                                        </form>
                                        @if (Session::has('customer_id'))
                                            @if (Session::has('shipping_id'))
                                                <a href="{{ URL::to('/payment') }}" class="btn btn-warning ">Đặt hàng</a>
                                            @else
                                                <a href="{{ URL::to('/checkout') }}" class="btn btn-warning ">Đặt hàng</a>
                                            @endif
                                        @else
                                            <a href="{{ URL::to('/login-checkout') }}" class="btn btn-warning ">Đặt hàng</a>
                                        @endif

                                    </td>
                                </tr>
                            @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            $('#check_coupon').click(function() {
                let coupon = $('#coupon').val();
                let _token = $('input[name="_token"]').val();
                if (coupon) {
                    $.ajax({
                        url: '{{ url('/check-coupon') }}',
                        method: 'POST',
                        data: {
                            coupon: coupon,
                            _token: _token
                        },
                        success: function(code) {
                            if (code);
                            else {
                                alert('Mã giảm giá không khả dụng!');
                            }
                            location.reload();
                        }
                    });
                }

            });

            $.validate({});
        });
    </script>

@endsection
