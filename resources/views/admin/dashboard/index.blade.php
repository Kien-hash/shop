@extends('admin.layouts.index')

@section('content')
    <h1>Statistical</h1>
    <div class="row">
        <h3 style="text-align:center;">Sales</h3>
        <form action="" autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Form: <input type="text" id="datepicker" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>To: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-1">
                <button type="button" style="margin-top: 25px; " id="btn-dashboard-filter" class="btn btn-primary btn-sm"
                    value="Filter">Filter</button>
            </div>
            <div class="col-md-2">
                <p>Filter by:
                    <select name="" id="" class="form-control dashboard-filter">
                        <option>----Choose----</option>
                        <option value="lastWeek">Last 7 days</option>
                        <option value="lastMonth">Last 30 days</option>
                        <option value="lastYear">Last Year</option>
                    </select>
                </p>
            </div>
        </form>

        <div class="col-md-12">
            <div id="myFirstChart" style="height:250px;"> </div>
        </div>
    </div>

    <div class="row">
        <style>
            .table.table-bordered.table-dark {
                background-color: black;
            }

        </style>
        <h4 style="text-align:center;">Summary</h4>
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">Order</th>
                    <th scope="col">Product</th>
                    <th scope="col">Sales</th>
                    <th scope="col">Profit</th>
                    {{-- <th scope="col">All</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="order"></td>
                    <td id="product"></td>
                    <td id="sales"></td>
                    <td id="profit"></td>
                    {{-- <td></td> --}}
                </tr>
            </tbody>
        </table>

    </div>
    <div class="row">

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            chart30Days();
        });
        var chart = new Morris.Bar({
            element: 'myFirstChart',
            pointFillColors: ['#ffffff'],
            fillOpacity: 0.3,
            hideHover: 'true',
            parseTime: false,
            xkey: 'date',
            ykeys: ['order_quantity', 'sale_money', 'profit', 'product_quantity'],
            behaveLikeLine: true,
            labels: ['Order Quantity', 'Sales', 'Profit', 'Product Quantity'],
        });

        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            yearRange: "2021:2030"
        });
        $("#datepicker2").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            yearRange: "2021:2030"
        });

        $(".dashboard-filter").change(function() {
            let _token = $('input[name="_token"]').val();
            let value = $(this).val();

            $.ajax({
                url: "{{ url('/admin/statistical/filter-by-select') }}",
                method: "POST",
                data: {
                    _token: _token,
                    value: value,
                },
                success: function(data) {
                    console.log(JSON.parse(data));
                    if (data != 'error'){
                        chart.setData(JSON.parse(data));
                        sumChange(JSON.parse(data));
                    }
                }
            });
        });

        $("#btn-dashboard-filter").click(function() {
            let _token = $('input[name="_token"]').val();
            let fromDate = $("#datepicker").val();
            let toDate = $("#datepicker2").val();
            $.ajax({
                url: "{{ url('/admin/statistical/filter-by-date') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
                    fromDate: fromDate,
                    toDate: toDate,
                },
                success: function(data) {
                    if (data == 'error') alert('Please check for valid days');
                    else {
                        let result = convertDataToResult(fromDate, toDate, data);
                        chart.setData(result);
                        sumChange(result);
                    }
                }
            });

        });

        function chart30Days() {
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/admin/statistical/filter-by-select') }}",
                method: "POST",
                data: {
                    _token: _token,
                    value: 'lastMonth',
                },
                success: function(data) {
                    // console.log(JSON.parse(data));
                    if (data != 'error'){
                        chart.setData(JSON.parse(data));
                        sumChange(JSON.parse(data));
                    }
                }
            });
        }

        function sumChange(data) {
            let order = data.reduce((n, {order_quantity}) => n + order_quantity, 0);
            let product = data.reduce((n, {product_quantity}) => n + product_quantity, 0);
            let profit = data.reduce((n, {profit}) => n + profit, 0);
            let sales = data.reduce((n, {sale_money}) => n + sale_money, 0);

            $("#order").text(order);
            $("#product").text(product);
            $("#profit").text(new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' }).format(profit));
            $("#sales").text(new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' }).format(sales));
        }

        var convertDataToResult = function(fromDate, toDate, data) {
            let days = enumerateDaysBetweenDates(fromDate, toDate);
            let i = 0;
            let result = [];
            days.forEach(function(element) {
                let index = data.findIndex(x => x.date === element);
                let newItem = {};
                if (index >= 0) {
                    newItem = {
                        date: element,
                        order_quantity: data[index].order_quantity,
                        sale_money: data[index].sale_money,
                        profit: data[index].profit,
                        product_quantity: data[index].product_quantity,
                    }
                } else {
                    newItem = {
                        date: element,
                        order_quantity: 0,
                        sale_money: 0,
                        profit: 0,
                        product_quantity: 0
                    }
                }
                result.push(newItem);
            });
            return result;
        }

        var enumerateDaysBetweenDates = function(startDate, endDate) {
            var dates = [];
            while (moment(startDate) <= moment(endDate)) {
                dates.push(startDate);
                startDate = moment(startDate).add(1, 'days').format("YYYY-MM-DD");
            }
            return dates;
        };
    </script>
@endsection
