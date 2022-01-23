<div class="left-sidebar">
    <h2>Danh mục</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->
        @foreach ($categories as $category)
            @if ($category->parent_id == 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordian" href="{{ '#' . $category->slug }}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                <a href="{{ URL::to('/category/' . $category->slug) }}">{{ $category->name }}</a>
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $category->slug }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach ($categories as $child)
                                    @if ($child->parent_id == $category->id)
                                        <li><a href="{{ URL::to('/category/' . $child->slug) }}">{{ $child->name }}
                                            </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <!--/category-products-->

    <div class="brands_products">
        <!--brands_products-->
        <h2>Thương hiệu</h2>
        <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
                @foreach ($brands as $brand)
                    <li><a href="{{ URL::to('/brand/' . $brand->slug) }}"> <span
                                class="pull-right">({{ $brand->products->count() }})</span>{{ $brand->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--/brands_products-->

    <div class="brands_products">
        <!--brands_products-->
        <h2>Sản phẩm yêu thích</h2>
        <div class="brands-name">
            <a href="" id="row-wishlist-delete">Xóa</a>
            <div id="row-wishlist" class="row" style="text-align:center;">

            </div>
        </div>
    </div>
    <!--/brands_products-->

    {{-- <div class="price-range">
        <!--price-range-->
        <h2>Price Range</h2>
        <div class="well text-center">
            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
        </div>
    </div>
    <!--/price-range--> --}}

    <div class="shipping text-center">
        <!--shipping-->
        <img src="{{ 'public/frontend/images/home/shipping.jpg' }}" alt="" />
    </div>
    <!--/shipping-->

</div>
