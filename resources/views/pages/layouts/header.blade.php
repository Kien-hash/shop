<header id="header">
    <!--header-->
    {{-- <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--/header_top-->

    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{ URL::to('/') }}"><img src="{{ 'public/frontend/images/home/logo.png' }}"
                                alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                VN
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                VNĐ
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                            <li><a href="{{ URL::to('/show-cart') }}"><i class="fa fa-shopping-cart"></i>Giỏ hàng</a>
                            </li>

                            @if (Session::has('customer_id'))
                                @if (Session::has('shipping_id'))
                                    <li><a href="{{ URL::to('/payment') }}"><i class="fa fa-crosshairs"></i>Thanh
                                            toán</a></li>
                                @else
                                    <li><a href="{{ URL::to('/checkout') }}"><i class="fa fa-crosshairs"></i>Thanh
                                            toán</a></li>
                                @endif
                            @else
                                <li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-lock"></i>Thanh
                                        toán</a></li>
                            @endif


                            @if (Session::has('customer_id'))
                                <li><a href="{{ URL::to('/logout') }}"><i class="fa fa-lock"></i>Đăng xuất</a>
                                </li>
                            @else
                                <li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-lock"></i>Đăng
                                        nhập</a></li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->

    <div class="header-bottom">
        <!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ URL::to('/') }}" class="active">Trang chủ</a></li>
                            <li class="dropdown">
                                <a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach ($postCategories as $postCategory)
                                        <li><a
                                                href="{{ URL::to('/post-category/' . $postCategory->slug) }}">{{ $postCategory->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#">Danh mục<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach ($categories as $category) )
                                        @if ($category->parent_id == 0)
                                            <li><a
                                                    href="{{ URL::to('/category/' . $category->slug) }}">{{ $category->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>

                            <li><a href="{{ URL::to('/show-cart') }}">Giỏ hàng</a></li>
                            <li><a href="{{ URL::to('/contact') }}">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <form action="{{ URL::to('/search') }}" autocomplete="off" method="POST">
                        {{ csrf_field() }}
                        <div class="search_box pull-right">
                            <input name="keywords" id="keywords" type="text" placeholder="Điền từ khóa..." />
                            <div id="search-ajax"></div>
                            {{-- <input type="submit" class="btn btn-success btn-sm" name="search" value="Tìm kiếm"> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
</header>
