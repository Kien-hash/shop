@extends('pages.layouts.index')
@section('content')
    <style>
        .lSSlideOuter .lSPager.lSGallery img {
            display: block;
            height: 140px;
            max-width: 100%;
        }

        li.active {
            border: 2px solid #FE980F;
        }

        .style-comment {
            border: 2px solid #ddd;
            border-radius: 10px;
            background: #F0F0E9;
        }

    </style>

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

    <div class="product-details">
        <!--product-details-->
        <div class="col-sm-5">
            <ul id="imageGallery">
                <li data-thumb="{{ asset('/uploads/product/' . $product->image) }}"
                    data-src="{{ asset('/uploads/product/' . $product->image) }}">
                    <img width="100%" height="330" src="{{ asset('/uploads/product/' . $product->image) }}" />
                </li>
                @foreach ($product->galleries as $gallery)
                    <li data-thumb="{{ asset('/uploads/gallery/' . $gallery->image) }}"
                        data-src="{{ asset('/uploads/gallery/' . $gallery->image) }}">
                        <img width="100%" height="330" src="{{ asset('/uploads/gallery/' . $gallery->image) }}" />
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-sm-7">
            <div class="product-information">
                <!--/product-information-->
                <h2>{{ $product->name }}</h2>
                <p>ID: {{ $product->id }}</p>

                <form action="{{ URL::to('/save-cart') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $product->id }}" class="cart_product_id_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->name }}" class="cart_product_name_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->image }}" class="cart_product_image_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->quantity }}"
                        class="cart_product_quantity_{{ $product->id }}">
                    <input type="hidden" value="{{ $product->price }}" class="cart_product_price_{{ $product->id }}">
                    <span>
                        <span>{{ number_format($product->price, 0, ',', '.') . 'VN??' }}</span>
                        <label>Quantity:</label>
                        <input name="qty" type="number" min="1" class="cart_product_qty_{{ $product->id }}" value="1" />
                        <input name="productid_hidden" type="hidden" value="{{ $product->id }}" />
                    </span>
                    <input type="button" value="Th??m v??o gi??? h??ng" class="btn btn-primary btn-sm add-to-cart"
                        data-id_product="{{ $product->id }}" name="add-to-cart">
                </form>

                <p><b>C??n h??ng:</b>{{ $product->quantity > 0 ? 'C??n' : 'H???t' }}</p>
                <p><b>T??nh tr???ng:</b>100% new</p>
                <p><b>S??? l?????ng trong kho:</b> {{ $product->quantity }}</p>
                <p><b>Th????ng hi???u:</b> {{ $product->brand->name }}</p>
                <p><b>Danh m???c:</b> {{ $product->category->name }}</p>
            </div>
        </div>
    </div>
    <!--/product-details-->

    <div class="category-tab shop-details-tab">
        <!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li><a href="#details" data-toggle="tab">M?? t???</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi ti???t</a></li>

                <li class="active"><a href="#reviews" data-toggle="tab">????nh gi??</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="details">
                <p>{!! $product->description !!}</p>
            </div>

            <div class="tab-pane fade" id="companyprofile">
                <p>{!! $product->content !!}</p>
            </div>

            <div class="tab-pane fade active in" id="reviews">
                <div class="col-sm-12">
                    <ul class="list-inline rating" title="????nh gi?? trung b??nh">
                        @for ($count = 1; $count <= 5; $count++)
                            @php
                                if ($count <= $rating) {
                                    $color = 'color:#ffcc00';
                                } else {
                                    $color = 'color:#ccc';
                                }
                            @endphp

                            <li title="rating" id="{{ $product->id }}-{{ $count }}"
                                data-index="{{ $count }}" data-product_id="{{ $product->id }}"
                                data-rating="{{ $rating }}" class="rating"
                                style="cursor: pointer; {{ $color }} ;font-size:30px">&#9733</li>

                        @endfor
                    </ul>
                    {{-- <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul> --}}

                    @foreach ($comments as $comment)
                        @if ($comment->parent_id != 0)
                            @continue
                        @endif
                        <div class="row style-comment">
                            <div class="col-md-2">
                                <img src="{{ asset('/frontend/images/user.png') }}" alt="" width="100%"
                                    class="img img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-10">
                                <label style="color: green;">@ {{ $comment->name }} </label>
                                <p>{{ $comment->created_at }}</p>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div>
                        {{-- <br> --}}
                        @foreach ($comments as $reply)
                            @if ($reply->parent_id == $comment->id)
                                <div class="row style-comment" style="width: 80%; margin: 5px 40px">
                                    <div class="col-md-2">
                                        <img src="{{ asset('/frontend/images/admin.png') }}"
                                            class="img img-responsive img-thumbnail">
                                    </div>
                                    <div class="col-md-10   ">
                                        <label style="color: red;">@ {{ $reply->name }} </label>
                                        <p>{{ $reply->comment }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <br>
                    @endforeach

                    @if (Session::get('customer_id'))
                        <p><b>Vi???t ????nh gi?? c???a b???n</b></p>
                        <form action="{{ URL::to('/add-comment') }}" method="POST">
                            @csrf
                            <span>
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                                <input type="hidden" name="product_id" value="{{ $product->id }}" />

                                <input type="text" name="name" placeholder="Your Name" value="{{ $customer->name }}" />
                                <input type="email" placeholder="Email Address" value="{{ $customer->email }}" />
                            </span>
                            <textarea name="comment"></textarea>
                            {{-- <b>Rating: </b> <img src="images/product-details/rating.png" alt="" /> --}}
                            <button type="submit" class="btn btn-default pull-right">
                                G???i
                            </button>

                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
    <!--/category-tab-->

    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">S???n ph???m li??n quan</h2>

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
                                                src="{{ URL::to('/uploads/product/' . $relate->image) }}" alt="" />
                                        </a>
                                        <h2>{{ number_format($relate->price, 0, ',', '.') . ' ' . 'VN??' }}</h2>
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
        $.validate({});

        function remove_backGround(product_id) {
            for (let i = 1; i <= 5; i++) {
                $("#" + product_id + "-" + i).css('color', '#ccc');
            }
        }

        $(document).on('mouseenter', '.rating', function() {
            let index = $(this).data("index");
            let product_id = $(this).data("product_id");
            // alert(product_id);
            remove_backGround(product_id);
            for (let i = 1; i <= index; i++) {
                $("#" + product_id + "-" + i).css('color', '#ffcc00');
            }

        });

        $(document).on('mouseleave', '.rating', function() {
            let index = $(this).data("index");
            let product_id = $(this).data("product_id");
            let rating = $(this).data("rating");
            remove_backGround(product_id);
            for (let i = 1; i <= rating; i++) {
                $("#" + product_id + "-" + i).css('color', '#ffcc00');
            }
        });

        $(document).on('click', '.rating', function() {
            let index = $(this).data("index");
            let product_id = $(this).data("product_id");
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/add-rating') }}',
                method: 'POST',
                data: {
                    index: index,
                    product_id: product_id,
                    _token: _token,
                },
                success: function(data) {
                    if (data == 'done') {
                        alert('B???n ???? ????nh gi?? ' + index + " tr??n 5");
                        location.reload();
                    } else {
                        alert('L??i ????nh gi??');
                    }
                }

            });

        });

        $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 3,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });

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
                        'S???n ph???m t???m th???i h???t h??ng, h??y ch???n s???n ph???m kh??c');
                    else alert('L??m ??n ?????t nh??? h??n ' + cart_product_quantity);
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
                                    title: "???? th??m s???n ph???m v??o gi??? h??ng",
                                    text: "B???n c?? th??? mua h??ng ti???p ho???c t???i gi??? h??ng ????? ti???n h??nh thanh to??n",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem ti???p",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "??i ?????n gi??? h??ng",
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
