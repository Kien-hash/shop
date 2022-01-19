<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn đặt hàng</title>
</head>

<body>
    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Thông tin đơn hàng
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <div class="form-group">
                            Trạng thái:
                            @if ($order->status == 0)
                                Đang chờ xác nhận
                            @elseif ($order->status == 1)
                                Đã xác nhận
                            @elseif ($order->status == 2)
                                Đang giao hàng
                            @else
                                Đã kết thúc
                            @endif
                        </div>

                        <div class="form-group">
                            Mã đơn hàng: {{ $order->code }}
                        </div>

                        @if ($coupon)
                            <div class="form-group">
                                Mã giảm giá: {{ $coupon->code }}
                            </div>
                            <div class="form-group">
                                Lượng giảm:
                                @if ($coupon->type == 1)
                                    {{ $coupon->amount }} VNĐ
                                @elseif ($coupon->type == 2)
                                    {{ $coupon->amount }} %
                                @else
                                    Coupon not valid
                                @endif
                            </div>
                        @endif
                        <div class="form-group">
                            Phí vận chuyển: {{ $order->shipping_fee }}
                        </div>

                        <div class="form-group">
                            Ghi chú đơn hàng: {{ $order->notes }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Thông tin vận chuyển
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <div class="form-group">
                            Tên người nhận: {{ $order->shipping->name }}
                        </div>
                        <div class="form-group">
                            Địa chỉ nhận: {{ $order->shipping->address }}
                        </div>
                        <div class="form-group">
                            Số điện thoại người nhận: {{ $order->shipping->phone }}
                        </div>
                        <div class="form-group">
                            Email: {{ $order->shipping->email }}
                        </div>

                        <div class="form-group">
                            Ghi chú giao hàng: {{ $order->shipping->notes }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Các sản phẩm
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng mua</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                @php
                                    $total = 0;
                                @endphp
                                <tbody>
                                    @foreach ($order->order_details as $detail)
                                        @php
                                            $total += $detail->product_price * $detail->product_sales_quantity;
                                        @endphp
                                        <tr>
                                            <td>{{ $detail->product_name }}</td>
                                            <td>{{ $detail->product_price }}</td>
                                            <td>    {{ $detail->product_sales_quantity }}</td>
                                            <td>{{ $detail->product_price * $detail->product_sales_quantity }} VNĐ
                                            </td>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Tổng tiền</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $total }} VNĐ</td>
                                    </tr>
                                    @if ($coupon)
                                        @php
                                            $total_with_coupon = $coupon->type == 1 ? $total - $coupon->amount : $total * (1 - $coupon->amount / 100);
                                            $coupon = $total - $total_with_coupon;
                                            $total = $total_with_coupon;
                                        @endphp
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td></td>
                                            <td></td>
                                            <td> - {{ $coupon }} VNĐ</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Tổng phải trả (Đã bao gồm phí giao hàng): </td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $total + $order->shipping_fee }} VNĐ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

</html>
