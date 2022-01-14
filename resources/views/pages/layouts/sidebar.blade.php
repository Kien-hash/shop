<div class="left-sidebar">
    <h2>Danh mục</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->
        <div class="panel panel-default">
            <div class="panel-heading">
                @foreach ($categories as $category)
                    <h4 class="panel-title"><a href="{{ URL::to('/category/' . $category->slug) }}"><span
                                class="pull-right">({{ $category->products->count() }})</span>{{ $category->name }}</a>
                    </h4>
                @endforeach

            </div>
        </div>
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

    <div class="price-range">
        <!--price-range-->
        <h2>Price Range</h2>
        <div class="well text-center">
            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
        </div>
    </div>
    <!--/price-range-->

    <div class="shipping text-center">
        <!--shipping-->
        <img src="{{ 'public/frontend/images/home/shipping.jpg' }}" alt="" />
    </div>
    <!--/shipping-->

</div>
