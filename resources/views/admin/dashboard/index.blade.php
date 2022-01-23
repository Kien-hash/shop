@extends('admin.layouts.index')

@section('content')
    <h1>Statistical</h1>
    <div class="row">
        <h2 style="text-align:center;">Sales</h2>
        <form action="" autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Form: <input type="text" id="datepicker" class="form-control"></p>
                <button type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Filter">Filter</button>
            </div>
            <div class="col-md-2">
                <p>To: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>Filter by:
                    <select name="" id="" class="form-control dashboard-filter">
                        <option>----Choose----</option>
                        <option value="lastDay">Last Day</option>
                        <option value="lastWeek">Last Week</option>
                        <option value="lastMonth">Last Month</option>
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

    </div>
    <div class="row">

    </div>
@endsection

@section('scripts')
    <script>
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        });
        $("#datepicker2").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        });

        $("#btn-dashboard-filter").click(function(){
            let _token = $('input[name="_token"]').val();
            let fromDate = $("#datepicker").val();
            let toDate = $("#datepicker2").val();
            $.ajax({
                url: "{{ url('/admin/statistical/filter-by-date')}}",
                method: "POST",
                dataType: "JSON",
                data:{
                    _token: _token,
                    fromDate: fromDate,
                    toDate: toDate,
                },
                success: function(data){
                    console.log(data);
                    // alert(data);
                }
            });

        });
    </script>
@endsection
