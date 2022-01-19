@extends('pages.layouts.index')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>

            @if (!Session::get('customer_id'))
                <div class="register-req">
                    <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
                </div>
            @endif

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-5 clearfix">
                        <div class="bill-to">
                            <p>Điền thông tin gửi hàng</p>
                            <div class="form-one" style="width:90%;">
                                <form action="" method="POST">
                                    @csrf
                                    @if ($shipping)
                                    <input type="text" name="shipping_email" class="shipping_email"
                                        placeholder="Điền email" data-validation="email"
                                        value="{{$shipping->email}}" >
                                    <input type="text" name="shipping_name" class="shipping_name"
                                        placeholder="Họ và tên người gửi" data-validation="length" data-validation-length='1-255'
                                        value="{{$shipping->name}}" >
                                    <input type="text" name="shipping_address" class="shipping_address"
                                        placeholder="Địa chỉ gửi hàng" data-validation="length" data-validation-length='1-255'
                                        value="{{$shipping->address}}" >
                                    <input type="text" name="shipping_phone" class="shipping_phone"
                                        placeholder="Số điện thoại" data-validation="length" data-validation-length='1-255'
                                        value="{{$shipping->phone}}">
                                    <textarea name="shipping_notes" class="shipping_notes"
                                        placeholder="Ghi chú đơn hàng của bạn" rows="5">{{$shipping->notes}}</textarea>
                                    @else
                                    <input type="text" name="shipping_email" class="shipping_email"
                                        placeholder="Điền email" data-validation="email" >
                                    <input type="text" name="shipping_name" class="shipping_name"
                                        placeholder="Họ và tên người gửi" data-validation="length" data-validation-length='1-255'>
                                    <input type="text" name="shipping_address" class="shipping_address"
                                        placeholder="Địa chỉ gửi hàng" data-validation="length" data-validation-length='1-255'>
                                    <input type="text" name="shipping_phone" class="shipping_phone"
                                        placeholder="Số điện thoại" data-validation="length" data-validation-length='1-255'>
                                    <textarea name="shipping_notes" class="shipping_notes"
                                        placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>
                                    @endif

                                    @if (Session::get('coupon'))
                                        <input type="hidden" name="order_coupon" class="order_coupon"
                                            value="{{ Session::get('coupon')[0]['coupon_code'] }}">
                                    @else
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                    @endif

                                    <div class="">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                            <select name="payment_select"
                                                class="form-control input-sm m-bot15 payment_select">
                                                @foreach ($payments as $payment)
                                                    <option value="{{$payment->id}}">{{$payment->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if (!Session::get('cart'))
                                        <p>Chưa có sản phẩm nào trong giỏ hàng</p>
                                    @elseif (!Session::get('fee'))
                                        <p>Chưa có thiết lập phí vận chuyển</p>
                                    @else
                                        <input type="button" value="Xác nhận đơn hàng" name="send_order"
                                        class="btn btn-primary btn-sm send_order">
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                    <form class="col-sm-4 clearfix">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn thành phố</label>
                            <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                <option value="">--Chọn tỉnh thành phố--</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->matp }}">{{ $city->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn quận huyện</label>
                            <select name="district" id="district"
                                class="form-control input-sm m-bot15 district choose">
                                <option value="">--Chọn quận huyện--</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn xã phường</label>
                            <select name="ward" id="ward" class="form-control input-sm m-bot15 ward">
                                <option value="">--Chọn xã phường--</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Phí vận chuyển</label>
                            @if (Session::get('fee'))
                                <input disabled type="number" class="form-control input-sm m-bot15 order_fee" name="order_fee"
                                    value="{{ Session::get('fee') }}">
                            @else
                                <input disabled type="text" class="form-control input-sm m-bot15 order_fee" name="order_fee"
                                    placeholder="Bạn chưa chọn địa điểm để tính phí vận chuyển" value="">
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="button" value="Tính phí vận chuyển" name="calculate_order"
                                class="btn btn-primary btn-sm calculate_delivery">
                        </div>

                    </form>
                    <br>

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
                        <div class="table-responsive cart_info">
                            <form action="{{ url('/update-cart') }}" method="POST">
                                @csrf
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="cart_menu">
                                            <td class="image">Hình ảnh</td>
                                            <td class="description">Tên sản phẩm</td>
                                            <td class="price">Giá sản phẩm</td>
                                            <td class="quantity">Số lượng</td>
                                            <td class="total">Thành tiền</td>
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
                                                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}VNĐ</p>
                                                    </td>
                                                    <td class="cart_quantity">
                                                        <div class="cart_quantity_button" >
                                                            <input style="width: 60px;" class="cart_quantity" type="number" min="1"
                                                                name="cart_qty[{{ $cart['session_id'] }}]"
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
                                                    <li>Tổng tiền :<span>{{ number_format($total, 0, ',', '.') }}VNĐ</span>
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
                                                            <a class="cart_quantity_delete" href="{{ url('/del-fee') }}"><i class="fa fa-times"></i></a>
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
                                            <tr><td colspan="5"><center> Làm ơn thêm sản phẩm vào giỏ hàng</center></td></tr>
                                        @endif
                                    </tbody>



                            </form>
                            @if (Session::get('cart'))
                                <tr>
                                    <td>
                                        <form method="POST" action="{{ url('/check-coupon') }}">
                                            @csrf
                                            <input type="text" id="coupon" class="form-control" name="coupon"
                                                placeholder="{{Session::get('coupon')?Session::get('coupon')[0]['coupon_code']:'Nhập mã giảm giá'}}"><br>
                                            <button type="button" class="btn btn-default check_coupon" id="check_coupon" name="">Tính mã giảm giá</button>
                                        </form>
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
            if(sessionStorage.getItem('location')){
                shipping_address = sessionStorage.getItem('location');
                $('.shipping_address').val($('.shipping_address').val() + shipping_address);

            }

            $('.choose').on('change', function() {
                let action = $(this).attr('id');
                let ma_id = $(this).val();
                let _token = $('input[name="_token"]').val();
                let result = '';
                if (action == 'city') {
                    result = 'district';
                } else {
                    result = 'ward';
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('/select-delivery') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token,
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });

            $('#check_coupon').click(function() {
                let coupon = $('#coupon').val();
                let _token = $('input[name="_token"]').val();
                if(coupon){
                    $.ajax({
                        url: '{{ url('/check-coupon') }}',
                        method: 'POST',
                        data: {
                            coupon: coupon,
                            _token: _token
                        },
                        success: function(code) {
                            if(code);
                            else {alert('Mã giảm giá không khả dụng!');}
                            location.reload();
                        }
                    });
                }

            });

            $('.calculate_delivery').click(function() {
                let matp = $('.city').val();
                let maqh = $('.district').val();
                let xaid = $('.ward').val();
                let city = $('.city').find(":selected").text();
                let district = $('.district').find(":selected").text();
                let ward = $('.ward').find(":selected").text();
                let _token = $('input[name="_token"]').val();
                if (matp == '' && maqh == '' && xaid == '') {
                    alert('Làm ơn chọn để tính phí vận chuyển');
                } else {

                    $.ajax({
                        url: '{{ url('/calculate-fee') }}',
                        method: 'POST',
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                    let local =' ' + ward + ', ' + district + ', ' + city;
                    sessionStorage.setItem('location', local);

                }
            });

            $('.send_order').click(function() {
                swal({
                        title: "Xác nhận đơn hàng",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Cảm ơn, Mua hàng",

                        cancelButtonText: "Đóng,chưa mua",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            let shipping_email = $('.shipping_email').val();
                            let shipping_name = $('.shipping_name').val();
                            let shipping_address = $('.shipping_address').val();
                            let shipping_phone = $('.shipping_phone').val();
                            let shipping_notes = $('.shipping_notes').val();
                            let shipping_method = $('.payment_select').val();
                            let order_fee = $('.order_fee').val();
                            let order_coupon = $('.order_coupon').val();
                            let _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/confirm-order') }}',
                                method: 'POST',
                                data: {
                                    shipping_email: shipping_email,
                                    shipping_name: shipping_name,
                                    shipping_address: shipping_address,
                                    shipping_phone: shipping_phone,
                                    shipping_notes: shipping_notes,
                                    _token: _token,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    shipping_method: shipping_method
                                },
                                success: function() {
                                    swal("Đơn hàng",
                                        "Đơn hàng của bạn đã được gửi thành công",
                                        "success");
                                }
                            });

                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, hãy hoàn tất đơn hàng", "error");
                        }

                });
            });
        });

        $.validate({});
    </script>

@endsection

