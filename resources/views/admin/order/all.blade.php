@extends('admin.layouts.index')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All Orders
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif

            @if (session('Notice'))
                <div class="alert alert-success">
                    {{ session('Notice') }}
                </div>
            @endif

            {{-- <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div> --}}
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Code</th>
                            <th>Coupon</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th style="width:30px;"></th>
                            <th style="width:30px;"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $order->code }}</td>
                                <td>{{ $order->coupon }}</td>
                                <td>{{ $order->notes }}</td>
                                <td>
                                    @if ($order->status == 0)
                                        Đang chờ xác nhận
                                    @elseif ($order->status == 1)
                                        Đã xác nhận
                                    @elseif ($order->status == 2)
                                        Đang giao hàng
                                    @else
                                        Kết thúc
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/order/edit/' . $order->id) }}" class="active styling-edit"
                                        ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Are you sure you want to delete this order?')"
                                        href="{{ URL::to('admin/order/delete/' . $order->id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{-- <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $orders->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $orders->firstItem() }} -
                            {{ $orders->lastItem() }} of {{ $orders->total() }} items</small>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#myTable").DataTable();
        });
    </script>
@endsection
