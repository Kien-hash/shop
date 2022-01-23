<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <base href="{{ asset('') }}">
    <link href="{{ asset('public/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/lightgallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/prettify.css') }}" rel="stylesheet">


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

    @include('pages.layouts.footer')
    <!--/Footer-->
    <script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('public/frontend/js/main.js') }}"></script>
    <script src="{{ asset('public/frontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('public/frontend/js/prettify.js') }}"></script>

    <script>
        $(document).ready(function() {
            view();
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
                            <p><a href="` + data[i].url + `">Chi tiết</a></p>
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
