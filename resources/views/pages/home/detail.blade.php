@extends('pages.layouts.index')
@section('content')
    <div class="product-details">
        <!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{ URL::to('/public/uploads/product/' . $product->image) }}" alt="" />
                <h3>ZOOM</h3>
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">

                    <div class="item active">
                        <a href=""><img src="{{ 'public/frontend/images/similar1.jpg' }}" alt=""></a>
                        <a href=""><img src="{{ 'public/frontend/images/similar2.jpg' }}" alt=""></a>
                        <a href=""><img src="{{ 'public/frontend/images/similar3.jpg' }}" alt=""></a>
                    </div>
                </div>

                <a class="left item-control" href="#similar-product" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right item-control" href="#similar-product" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div>

        </div>
        <div class="col-sm-7">
            <div class="product-information">
                <!--/product-information-->
                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                <h2>{{ $product->name }}</h2>
                <p>ID: {{ $product->id }}</p>
                <img src="images/product-details/rating.png" alt="" />

                <form action="{{ URL::to('/save-cart') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $product->id }}" class="cart_product_id_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->name }}" class="cart_product_name_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->image }}" class="cart_product_image_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->quantity }}"
                        class="cart_product_quantity_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->price }}" class="cart_product_price_{{ $product->id }}">
                    <span>
                        <span>{{ number_format($product->price, 0, ',', '.') . 'VNĐ' }}</span>
                        <label>Quantity:</label>
                        <input name="qty" type="number" min="1" class="cart_product_qty_{{ $product->id }}" value="1" />
                        <input name="productid_hidden" type="hidden" value="{{ $product->id }}" />
                    </span>
                    <input type="button" value="Thêm vào giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                        data-id_product="{{ $product->id }}" name="add-to-cart">
                </form>

                <p><b>Còn hàng:</b>{{ $product->quantity > 0 ? 'Còn' : 'Hết' }}</p>
                <p><b>Tình trạng:</b>100% new</p>
                <p><b>Số lượng trong kho:</b> {{ $product->quantity }}</p>
                <p><b>Thương hiệu:</b> {{ $product->brand->name }}</p>
                <p><b>Danh mục:</b> {{ $product->category->name }}</p>
                <a href=""><img src="images/product-details/share.png" class="share img-responsive" alt="" /></a>
            </div>
        </div>
    </div>
    <!--/product-details-->

    <div class="category-tab shop-details-tab">
        <!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết</a></li>

                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
                <p>{!! $product->description !!}</p>
            </div>

            <div class="tab-pane fade" id="companyprofile">
                <p>{!! $product->content !!}</p>
            </div>

            <div class="tab-pane fade" id="reviews">
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                        nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>

                    <form action="#">
                        <span>
                            <input type="text" placeholder="Your Name" />
                            <input type="email" placeholder="Email Address" />
                        </span>
                        <textarea name=""></textarea>
                        <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!--/category-tab-->

    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach ($relates as $relate)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center product-related">
                                        <a href="{{ URL::to('/details/' . $relate->slug) }}">
                                            <img style="height: 200px;"
                                                src="{{ URL::to('public/uploads/product/' . $relate->image) }}" alt="" />
                                        </a>
                                        <h2>{{ number_format($relate->price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                                        <p>{{ $relate->name }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {!! $relates->links() !!}
                    </ul>
                </div>
            </div>

        </div>
    </div>
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
                    if (parseInt(cart_product_quantity) == 0) alert(
                        'Sản phẩm tạm thời hết hàng, hãy chọn sản phẩm khác');
                    else alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
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
