@extends('pages.layouts.index')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {!! session()->get('message') !!}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!! session()->get('error') !!}
                </div>
            @endif
            @php
                $cart = Session::get('coupon');
                print_r($cart);

            @endphp
            <div class="table-responsive cart_info">
                <form action="{{ url('/update-cart') }}" method="POST">
                    @csrf
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Image</td>
                                <td class="description">Description</td>
                                {{-- <td class="quantity">Số lượng tồn</td> --}}
                                <td class="price">Price</td>
                                <td class="quantity">Quantity</td>
                                <td class="total">Total</td>
                                <td></td>
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
                                            <p>{{ number_format($cart['product_price'], 0, ',', '.') }}đ</p>
                                        </td>
                                        <td class="cart_quantity">
                                            <div class="cart_quantity_button">
                                                <input class="cart_quantity" type="number" min="1"
                                                    name="cart_qty[{{ $cart['session_id'] }}]"
                                                    value="{{ $cart['product_qty'] }}">
                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">
                                                {{ number_format($subtotal, 0, ',', '.') }}đ
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
                                    <td><input type="submit" value="Update Cart" name="update_qty"
                                            class="check_out btn btn-default btn-sm"></td>
                                    <td><a class="btn btn-default check_out" href="{{ url('/del-all-product') }}">Delete
                                            All</a></td>
                                    <td>
                                        @if (Session::get('coupon'))
                                            <a class="btn btn-default check_out" href="{{ url('/unset-coupon') }}">Delete
                                                Coupon</a>
                                        @endif
                                    </td>

                                    <td>
                                        @if (Session::get('customer_id'))
                                            <a class="btn btn-default check_out" href="{{ url('/checkout') }}">Order</a>
                                        @else
                                            <a class="btn btn-default check_out"
                                                href="{{ url('/login-checkout') }}">Order</a>
                                        @endif
                                    </td>


                                    <td colspan="2">
                                        <li>Total :<span>{{ number_format($total, 0, ',', '.') }}đ</span></li>
                                        @if (Session::get('coupon'))
                                            <li>
                                                @foreach (Session::get('coupon') as $key => $cou)
                                                    @if ($cou['coupon_condition'] == 2)
                                                        Coupon : {{ $cou['coupon_number'] }} %
                                                        <p>
                                                            @php
                                                                $coupon_code = $cou['coupon_code'];
                                                                $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                                echo '<p><li>Total amount:' . number_format($total_coupon, 0, ',', '.') . 'đ</li></p>';
                                                            @endphp
                                                        </p>
                                                        <p>
                                            <li>Total (with coupon)
                                                :{{ number_format($total - $total_coupon, 0, ',', '.') }}đ
                                            </li>
                                            </p>
                                        @elseif($cou['coupon_condition'] == 1)
                                            Coupon : {{ number_format($cou['coupon_number'], 0, ',', '.') }} k
                                            <p>
                                                @php
                                                    $total_coupon = $total - $cou['coupon_number'];

                                                @endphp
                                            </p>
                                            <p>
                                                <li>Total (with coupon and tax)
                                                    :{{ number_format($total_coupon, 0, ',', '.') }}đ</li>
                                            </p>
                                        @endif
                            @endforeach
                            </li>
                            @endif
                            {{-- <li>Thuế <span></span></li>
							<li>Phí vận chuyển <span>Free</span></li> --}}

                            </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5">
                                    <center>
                                        @php
                                            echo 'Please add products to cart!';
                                        @endphp
                                    </center>
                                </td>
                            </tr>
                            @endif
                        </tbody>

                </form>
                @if (Session::get('cart'))
                    <tr>
                        <td>
                            <form method="POST" action="{{ url('/check-coupon') }}">
                                @csrf
                                <input type="text" class="form-control" name="coupon"
                                    placeholder="{{ Session::get('coupon') == null ? 'Enter Coupon' : $coupon_code }}"><br>
                                <input type="submit" class="btn btn-default check_coupon" name="check_coupon"
                                    value="Check Coupon">
                            </form>
                        </td>
                    </tr>
                @endif
                </table>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
@endsection
