@extends('pages.layouts.index')
@section('content')
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
                                <img style="height: 200px;" src="{{ 'public/uploads/product/' . $product->image }}"
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
                                {{-- <input type="submit" value="Add to Cart" class="btn btn-primary btn-sm add-to-cart"
                                    data-id_product="{{ $product->id }}" name="add-to-cart"> --}}
                                <button type="button" class="btn btn-primary btn-sm add-to-cart"
                                    data-id_product="{{ $product->id }}" name="add-to-cart">Thêm vào giỏ hàng</button>
                            </form>
                        </div>

                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
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

    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">recommended items</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ 'public/frontend/images/home/recommend3.jpg' }}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add
                                        to cart</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <!--/recommended_items--> --}}

@endsection

@section('scripts')
    <script type="text/javascript">
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
