<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <base href="{{ asset('') }}">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/lightgallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/jquery-ui.min.css') }}" rel="stylesheet">



    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->

<body>

    <!--/header-->
    @include('pages.layouts.header')

    @include('pages.layouts.slider')
    <!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('pages.layouts.sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    <section>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="model-compare"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="row-compare">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>T??n s???n ph???m</th>
                                        <th>Gi??</th>
                                        <th>H??nh ???nh</th>
                                        <th>Th??ng s??? k?? thu???t</th>
                                        <th>Chi ti???t</th>
                                        <th>X??a</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr id="row-compare`+id+`" >
                                        <td>`+newItem.name+`</td>
                                        <td>`+newItem.price+`</td>
                                        <td><img width="200" width="100%" src="`+newItem.image+`" alt=""></td>
                                        <td></td>
                                        <td><a href="`+newItem.url+`">Xem s???n ph???m</a></td>
                                        <td onclick="delete_compare(`+id+`)"><a style="cursor: pointer;">X??a so s??nh</a></td>
                                    </tr> --}}

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('pages.layouts.footer')
    <!--/Footer-->
    <script src="{{ asset('/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/frontend/js/main.js') }}"></script>
    <script src="{{ asset('/frontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('/frontend/js/prettify.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery-ui.min.js') }}"></script>


    <script>
        function add_compare(id) {
            $("#model-compare").text("Ch??? cho ph??p so s??nh t???t ??a 4 s???n ph???m");
            let name = $('.cart_product_name_' + id).val();
            let image = "public/uploads/product/" + $('.cart_product_image_' + id).val();
            let price = $('.cart_product_price_' + id).val();
            let url = $('.cart_product_url_' + id).val();

            console.log(name, image, price, url);
            let newItem = {
                'url': url,
                'id': id,
                'name': name,
                'image': image,
                'price': price,
            }
            if (localStorage.getItem('compare') == null) {
                localStorage.setItem('compare', '[]');
            }
            let oldData = JSON.parse(localStorage.getItem('compare'));

            if (oldData.find(item => item.id == newItem.id)) {
                // alert('S???n ph???m ???? c?? trong danh s??ch y??u th??ch');
            } else {
                if (oldData.length <= 3) {
                    oldData.push(newItem);
                    $("#row-compare").find('tbody').prepend(`
                        <tr id="row-compare` + id + `" >
                            <td>` + newItem.name + `</td>
                            <td>` + newItem.price + `</td>
                            <td><img width="200" width="100%" src="` + newItem.image + `" alt=""></td>
                            <td></td>
                            <td><a href="` + newItem.url + `">Xem s???n ph???m</a></td>
                            <td onclick="delete_compare(` + id + `)"><a style="cursor: pointer;">X??a so s??nh</a></td>
                        </tr>
                    `);

                }
            }

            localStorage.setItem('compare', JSON.stringify(oldData));
            $("#exampleModalLong").modal();
        }

        function delete_compare(id) {
            if (localStorage.getItem('compare') != null) {
                let data = JSON.parse(localStorage.getItem('compare'));
                var index = data.findIndex(item => item.id == id);
                data.splice(index, 1);
                localStorage.setItem('compare', JSON.stringify(data));
                document.getElementById('row-compare' + id).remove();
            }
        }

        function view_compare() {
            if (localStorage.getItem('compare') != null) {
                let data = JSON.parse(localStorage.getItem('compare'));

                data.reverse();
                document.getElementById('row-wishlist').style.overflow = 'scroll';
                document.getElementById('row-wishlist').style.height = '600px';

                for (let i = 0; i < data.length; i++) {
                    $("#row-compare").find('tbody').append(`
                        <tr id="row-compare` + data[i].id + `" >
                            <td>` + data[i].name + `</td>
                            <td>` + data[i].price + `</td>
                            <td><img width="200" width="100%" src="` + data[i].image + `" alt=""></td>
                            <td></td>
                            <td><a href="` + data[i].url + `">Xem s???n ph???m</a></td>
                            <td onclick="delete_compare(` + data[i].id + `)"><a style="cursor: pointer;">X??a so s??nh</a></td>
                        </tr>
                    `);
                }
            }
        }


        $(document).ready(function() {
            view();
            view_compare();
            let min = parseInt($("#min_price").val());
            let max = parseInt($("#max_price").val());
            let currentMin = {{ Request::get('min_price') ? Request::get('min_price') : 0 }} ;
            let currentMax = {{ Request::get('max_price') ? Request::get('max_price') : 0 }} ;
            currentMin = currentMin ? currentMin : min;
            currentMax = currentMax ? currentMax : max;

            $("#slider-range").slider({
                range: true,
                min: min,
                max: max,
                step: 10000,
                values: [currentMin, currentMax],
                slide: function(event, ui) {
                    $("#amount").val(ui.values[0] + "VN?? - " + ui.values[1] + 'VN??');
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });
            $("#amount").val($("#slider-range").slider("values", 0) +
                "VN?? - " + $("#slider-range").slider("values", 1) + "VN??");

            $("#sort").on("change", function() {
                let url = this.value;
                // console.log(url);
                if (url) window.location = url;
                return false;
            });

            $("#keywords").keyup(function() {
                let query = $(this).val();
                // console.log(query);
                if (query) {
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '{{ url('/ajax-search') }}',
                        method: 'POST',
                        data: {
                            query: query,
                            _token: _token,
                        },
                        success: function(data) {
                            $("#search-ajax").fadeIn();
                            $("#search-ajax").html(data);
                        }
                    })
                } else {
                    $("#search-ajax").fadeOut();
                }
            })
        });

        $(document).on('click', '.li-search-ajax', function() {
            $("#keywords").val($(this).text());
            $("#search-ajax").fadeOut();
        });

        $("#row-wishlist-delete").click(function() {
            localStorage.removeItem('data');
            window.location.reload(true)
        });

        function view() {
            if (localStorage.getItem('data') != null) {
                let data = JSON.parse(localStorage.getItem('data'));

                data.reverse();
                document.getElementById('row-wishlist').style.overflow = 'scroll';
                document.getElementById('row-wishlist').style.height = '600px';

                for (let i = 0; i < data.length; i++) {
                    let string = `
                    <div class="row" style="margin:10px 0">
                        <div class="col-md-4">
                            <img src="` + data[i].image + `" width="100%" >
                        </div>
                        <div class="col-md-8 info_wishlist">
                            <p>` + data[i].name + `</p>
                            <p style="color:#FE980F">` + data[i].price + `</p>
                            <p><a href="` + data[i].url + `">Chi ti???t</a></p>
                        </div>
                    </div>
                    `
                    $("#row-wishlist").append(string);
                }
            }
        }
    </script>
    @yield('scripts')

</body>

</html>
