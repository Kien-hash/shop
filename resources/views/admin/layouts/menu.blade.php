<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="dashboard">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/category/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/category/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Brands</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/brand/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/brand/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/product/add') }}">Add</a></li>
                        <li><a href="{{ URL::to('admin/product/all') }}">List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/order/all') }}">All</a></li>
                        <li><a href="{{ URL::to('admin/order/add') }}">Add</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Coupons</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/coupon/all') }}">All</a></li>
                        <li><a href="{{ URL::to('admin/coupon/add') }}">Add</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Deliveries</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ URL::to('admin/delivery/all') }}">All</a></li>
                        {{-- <li><a href="{{ URL::to('admin/delivery/add') }}">Add</a></li> --}}
                    </ul>
                </li>

            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
