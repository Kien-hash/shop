<!DOCTYPE html>

<head>
    <title>Shop's admin pages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <base href="{{ asset('') }}">
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('/backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/jquery-ui.min.css') }}">


    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ asset('/backend/css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('/backend/css/style-responsive.css') }}" rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link href="{{ asset('/backend/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/backend/css/font.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/backend/css/morris.css') }}" type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href="{{ asset('/backend/css/monthly.css') }}">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{ asset('/backend/js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('/backend/js/raphael-min.js') }}"></script>
    <script src="{{ asset('/backend/js/morris.js') }}"></script>
    <script src="{{ asset('/backend/ckeditor/ckeditor.js') }}"></script>

</head>

<body>
    <section id="container">
        <!--header start-->
        @include('admin.layouts.header')

        <!--header end-->
        <!--sidebar start-->
        @include('admin.layouts.menu')
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield('content')
            </section>
            <!-- footer -->
            <div class="footer">
                <div class="wthree-copyright">
                    <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
                </div>
            </div>
            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>
    <script src="{{ asset('/backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('/backend/js/scripts.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery.scrollTo.js') }}"></script>

    <script src="{{ asset('/backend/js/datatables.min.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/backend/js/moment.min.js') }}"></script>



    @yield('scripts')

</body>

</html>
