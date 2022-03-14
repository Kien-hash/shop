@extends('pages.layouts.index')
@section('content')
    <style>
        .button_wishlist {
            border: none;
            color: #B3AFA8;
            background: #ffff;
        }

        ul .nav .nav-pills .nav-justified li {
            text-align: center;
            font-size: 13px;
        }

        ul .nav .nav-pills .nav-justified li {
            color: #B3AFA8;
        }

    </style>
    <div class="features_items">
        <!--features_items-->
        <h2 class="title text-center">Searched Items</h2>
        <h3>Keyword: {{ $keywords }}</h3>
        @foreach ($products as $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a href="{{ URL::to('/details/' . $product->slug) }}">
                                <img style="height: 200px;" src="{{ '/uploads/product/' . $product->image }}"
                                    alt="" /></a>
                            <h2>{{ number_format($product->price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                            <p style="height: 40px;">{{ $product->name }}</p>
                            <form action="{{ URL::to('/save-cart') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $product->id }}"
                                    class="cart_product_id_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->name }}"
                                    class="cart_product_name_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->image }}"
                                    class="cart_product_image_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->quantity }}"
                                    class="cart_product_quantity_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->price }}"
                                    class="cart_product_price_{{ $product->id }}">

                                <input type="hidden" name="qty" type="number" min="1"
                                    class="cart_product_qty_{{ $product->id }}" value="1" />
                                <input type="hidden" name="productid_hidden" type="hidden" value="{{ $product->id }}" />
                                {{-- <input type="submit" value="Thêm vào giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                                    data-id_product="{{ $product->id }}" name="add-to-cart"> --}}
                                <button type="button" class="btn btn-primary btn-sm add-to-cart"
                                    data-id_product="{{ $product->id }}" name="add-to-cart">Thêm vào giỏ hàng</button>
                            </form>
                        </div>

                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                                <button class="button_wishlist" id="{{ $product->id }}" onclick="add_wishlist(this.id);">
                                    <i class="fa fa-plus-square"></i>
                                    <span>Yêu thích</span>
                                </button>
                            </li>
                            <li>
                                <button class="button_wishlist">
                                    <i class="fa fa-plus-square"></i>
                                    <span>So sánh</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <ul class="pagination text-center pagination-sm m-t-none m-b-none">
        {!! $products->links() !!}
    </ul>
    <!--/category-tab-->


@endsection

@section('scripts')
    <script type="text/javascript">

        function add_wishlist(id) {
            let name = $('.cart_product_name_' + id).val();
            let image = "public/uploads/product/" + $('.cart_product_image_' + id).val();
            let price = $('.cart_product_price_' + id).val();
            let url = $('.cart_product_url_' + id).val();
            // console.log(name, image, price, url);
            let newItem = {
                'url': url,
                'id': id,
                'name': name,
                'image': image,
                'price': price,
            }
            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }
            let oldData = JSON.parse(localStorage.getItem('data'));

            if (oldData.find(item => item.id == newItem.id)) {
                alert('Sản phẩm đã có trong danh sách yêu thích');
            } else {
                oldData.push(newItem);
                let string = `
                <div class="row" style="margin:10px 0">
                    <div class="col-md-4">
                        <img src="` + newItem.image + `" width="100%" >
                    </div>
                    <div class="col-md-8 info_wishlist">
                        <p>` + newItem.name + `</p>
                        <p style="color:#FE980F">` + newItem.price + `</p>
                        <p><a href="` + newItem.url + `">Chi tiết</a></p>
                    </div>
                </div>
                `
                $("#row-wishlist").prepend(string);
            }

            localStorage.setItem('data', JSON.stringify(oldData));
        }

        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id_product');

                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();

                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {
                    $.ajax({
                        url: '{{ url('/add-cart') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/show-cart') }}";
                                });
                        }

                    });
                }

            })
        });
    </script>
@endsection
