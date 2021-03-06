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
        <h2 class="title text-center">Tât cả sản phẩm</h2>
        <div class="row">
            <div class="col-md-4">
                <label for="amount">Sắp xếp theo</label>
                <form action="">
                    @csrf
                    <select name="sort" id="sort" class="form-control">
                        <option value="">--Lọc--</option>
                        <option {{ Request::get('sort_by') == 'increase' ? 'selected' : '' }}
                            value="{{ Request::url() }}?sort_by=increase">Giá tăng dần</option>
                        <option {{ Request::get('sort_by') == 'decrease' ? 'selected' : '' }}
                            value="{{ Request::url() }}?sort_by=decrease">Giá giảm dần</option>
                        <option {{ Request::get('sort_by') == 'a_to_z' ? 'selected' : '' }}
                            value="{{ Request::url() }}?sort_by=a_to_z">A đến Z</option>
                        <option {{ Request::get('sort_by') == 'z_to_a' ? 'selected' : '' }}
                            value="{{ Request::url() }}?sort_by=z_to_a">Z đến A</option>
                    </select>
                </form>
            </div>

            <div class="col-md-5">
                <form action="">
                    <div class="row">
                        <div class="col-md-11">
                            <label for="amount">Khoảng giá: </label>
                            <input type="hidden" id="min_price" name="min_price" value="{{ $min_price }}">
                            <input type="hidden" id="max_price" name="max_price" value="{{ $max_price }}">
                            <div id="slider-range"> </div>
                            <input type="text" id="amount" readonly
                                style="width:100%;border:0;text-align: center;color:#f6931f; font-weight:bold;">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" name="filter_price" value="Lọc giá" class="btn btn-primary btn-sm ">
                        </div>

                    </div>

                </form>
            </div>
        </div>
        <br>

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
                                <input type="hidden" value="{{ URL::to('/details/' . $product->slug) }}"
                                    class="cart_product_url_{{ $product->id }}">
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
                            {{-- <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li> --}}
                            <li>
                                <button class="button_wishlist" id="{{ $product->id }}" onclick="add_wishlist(this.id);">
                                    <i class="fa fa-plus-square"></i>
                                    <span>Yêu thích</span>
                                </button>
                            </li>
                            <li>
                                <button class="button_wishlist" onclick="add_compare({{ $product->id }});">
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

    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">Bán chạy</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach ($bestsellers as $bestseller)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="{{ URL::to('/details/' . $bestseller->slug) }}">
                                            <img style="height: 200px;"
                                                src="{{ '/uploads/product/' . $bestseller->image }}" alt="" /></a>
                                        <h2>{{ number_format($bestseller->price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                                        <p style="height: 40px;">{{ $bestseller->name }}</p>
                                        <form action="{{ URL::to('/save-cart') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $bestseller->id }}"
                                                class="cart_product_id_{{ $bestseller->id }}">
                                            <input type="hidden" value="{{ $bestseller->name }}"
                                                class="cart_product_name_{{ $bestseller->id }}">
                                            <input type="hidden" value="{{ $bestseller->image }}"
                                                class="cart_product_image_{{ $bestseller->id }}">
                                            <input type="hidden" value="{{ $bestseller->quantity }}"
                                                class="cart_product_quantity_{{ $bestseller->id }}">
                                            <input type="hidden" value="{{ $bestseller->price }}"
                                                class="cart_product_price_{{ $bestseller->id }}">

                                            <input type="hidden" name="qty" type="number" min="1"
                                                class="cart_product_qty_{{ $bestseller->id }}" value="1" />
                                            <input type="hidden" name="productid_hidden" type="hidden"
                                                value="{{ $bestseller->id }}" />
                                            <button type="button" class="btn btn-primary btn-sm add-to-cart"
                                                data-id_product="{{ $bestseller->id }}" name="add-to-cart">Thêm vào giỏ
                                                hàng</button>
                                        </form>
                                    </div>

                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li>
                                            <button class="button_wishlist" id="{{ $bestseller->id }}"
                                                onclick="add_wishlist(this.id);">
                                                <i class="fa fa-plus-square"></i>
                                                <span>Yêu thích</span>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="button_wishlist"
                                                onclick="add_compare({{ $bestseller->id }});">
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
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <!--/recommended_items-->
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
                let id = $(this).data('id_product');

                let cart_product_id = $('.cart_product_id_' + id).val();
                let cart_product_name = $('.cart_product_name_' + id).val();
                let cart_product_image = $('.cart_product_image_' + id).val();
                let cart_product_quantity = $('.cart_product_quantity_' + id).val();
                let cart_product_price = $('.cart_product_price_' + id).val();
                let cart_product_qty = $('.cart_product_qty_' + id).val();
                let _token = $('input[name="_token"]').val();

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
