@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    order infomation
                </header>

                <div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif

                    @if (session('Notice'))
                        <div class="alert alert-success">
                            {{ session('Notice') }}
                        </div>
                    @endif
                </div>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('admin/order/edit/' . $order->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Status: </label>
                                @if ($order->status == 0)
                                    Đang chờ xác nhận
                                    <a href="{{ URL::to('admin/order/status/' . $order->id) }}" class="active btn"
                                        ui-toggle-class="">Xác nhận đơn hàng</a>
                                @elseif ($order->status == 1)
                                    Đã xác nhận
                                    <a href="{{ URL::to('admin/order/status/' . $order->id) }}" class="active btn"
                                        ui-toggle-class="">Giao hàng</a>
                                @elseif ($order->status == 2)
                                    Đang giao hàng
                                    <a href="{{ URL::to('admin/order/status/' . $order->id) }}" class="active btn"
                                        ui-toggle-class="">Kết thúc</a>
                                @else
                                    Đã kết thúc
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Code</label>
                                <input type="text" value="{{ $order->code }}" data-validation="length"
                                    data-validation-length='1-255' name="code" class="form-control">
                            </div>

                            @if ($coupon)
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Coupon</label>
                                    <input disabled type="text" value="{{ $coupon->code }}" data-validation="length"
                                        data-validation-length='1-255' name="coupon_code" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Amount: </label>
                                    @if ($coupon->type == 1)
                                        {{ $coupon->amount }} (VNĐ)
                                    @elseif ($coupon->type == 2)
                                        {{ $coupon->amount }} (%)
                                    @else
                                        Coupon not valid
                                    @endif
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputPassword1">Shipping's Fee</label>
                                <textarea style="resize: none" rows="1" class="form-control" name="shipping_fee"
                                    id="exampleInputPassword1">{{ $order->shipping_fee }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Notes</label>
                                <textarea style="resize: none" rows="7" class="form-control" name="notes"
                                    id="exampleInputPassword1">{{ $order->notes }}</textarea>
                            </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Shipping information
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" value="{{ $order->shipping->name }}" data-validation="length"
                                data-validation-length='1-255' name="shipping_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" value="{{ $order->shipping->address }}" data-validation="length"
                                data-validation-length='1-255' name="shipping_address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" value="{{ $order->shipping->phone }}" data-validation="length"
                                data-validation-length='1-255' name="shipping_phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" value="{{ $order->shipping->email }}" data-validation="email"
                                name="shipping_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Notes</label>
                            <textarea style="resize: none" rows="8" class="form-control" id='ckeditor1'
                                name="shipping_notes" id="exampleInputPassword1">{{ $order->shipping->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    {{-- <br> --}}
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Order Details
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th style="width:20px;">
                                            <label class="i-checks m-b-none">
                                                <input type="checkbox"><i></i>
                                            </label>
                                        </th>
                                        <th>Product Name</th>
                                        <th>In Stock</th>
                                        <th>Price</th>
                                        <th>Sales Amount</th>
                                        <th>Total</th>
                                        <th style="width:30px;"></th>
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
                                            @csrf
                                            <td><label class="i-checks m-b-none"><input type="checkbox"
                                                        name="post[]"><i></i></label></td>
                                            <td>{{ $detail->product_name }}</td>
                                            <td>{{ $detail->product->quantity }}</td>
                                            <td>{{ $detail->product_price }}</td>
                                            <td><input {{ $order->status > 1 ? 'disabled' : '' }} style="width:50px;"
                                                    type="number" name="sale_amount[]" data-validation="number" min="1"
                                                    step="1" value="{{ $detail->product_sales_quantity }}"></td>
                                            <td>{{ $detail->product_price * $detail->product_sales_quantity }}</td>
                                            <td>
                                                <a style="visibility:{{ $order->status > 1 ? 'hidden' : '' }};"
                                                    onclick="return confirm('Are you sure you want to delete this detail?')"
                                                    href="{{ URL::to('admin/order/detail/delete/' . $detail->id) }}"
                                                    class="active styling-edit" ui-toggle-class="">
                                                    <i class="fa fa-times text-danger text"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td>Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $total }}</td>
                                        <td></td>
                                    </tr>
                                    @if ($coupon)
                                        @php
                                            $total_with_coupon = $coupon->type == 1 ? $total - $coupon->amount : $total * (1 - $coupon->amount / 100);
                                            $coupon_decrease = $coupon->type == 1 ? $coupon->amount : $total * ($coupon->amount / 100);
                                            $total = $total_with_coupon;
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>Coupon</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>- {{ $coupon_decrease }}</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td>Total </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="total">{{ $total }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button style="visibility:{{ $order->status == 3 ? 'hidden' : '' }};" type="submit"
                                name="update_order_product" class="btn center btn-info">Update</button>
                            </form>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let _token = $('input[name="_token"]').val();
            let total = $("#total").text();
            let total_price = "{{ $order->total_price }}";
            let id = "{{ $order->id }}"
            // console.log(total_price == total);
            if (total != total_price) {
                $.ajax({
                    url: '{{ url('admin/order/total-price') }}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        total: total,
                        id: id,
                    },
                    success: function(data) {
                        console.log(data)
                    }
                });
            }
        })
        $.validate({

        });
    </script>
@endsection
