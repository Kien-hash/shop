<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="javascript" href="{{ URL::to('admin/dashboard') }}">
                        <i class="fa fa-area-chart"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/category/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/category/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Brands</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/brand/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/brand/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub">
                        {{-- <li><a href="{{ URL::to('admin/customer/add') }}">Add</a></li> --}}
                        <li><a href="{{ URL::to('admin/customer/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-dropbox"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/product/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/product/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/order/all') }}">Manage</a></li>
                        {{-- <li><a href="{{ URL::to('admin/order/add') }}">Add</a></li> --}}
                    </ul>
                </li>

                <li>
                    <a class="javascript" href="{{ URL::to('admin/contact/config') }}">
                        <i class="fa fa-wrench"></i>
                        <span>Config Contact</span>
                    </a>
                </li>

                @hasRole(['admin'])
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-tag fa-lg"></i>
                            <span>Coupons</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/coupon/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/coupon/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-truck"></i>
                            <span>Deliveries</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/delivery/all') }}">List</a></li>
                            {{-- <li><a href="{{ URL::to('admin/delivery/add') }}">Add</a></li> --}}
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-list"></i>
                            <span>Post Categories</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/postCategory/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/postCategory/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-file-text"></i>
                            <span>Posts</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/post/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/post/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-cc-paypal"></i>
                            <span>Payments</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/payment/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/payment/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-clipboard"></i>
                            <span>Banners</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/banner/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/banner/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-comments"></i>
                            <span>Comment</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/comment/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/comment/add') }}">Add</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-user"></i>
                            <span>Users</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ URL::to('admin/user/all') }}">List</a></li>
                            <li><a href="{{ URL::to('admin/user/add') }}">Add</a></li>
                        </ul>
                    </li>
                @endhasRole

            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
