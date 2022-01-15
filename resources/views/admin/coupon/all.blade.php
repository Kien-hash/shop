@extends('admin.layouts.index')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All coupons
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

            <div class="row w3-res-tb">
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
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $coupon->name }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->quantity }}</td>
                                <td>
                                    @if ($coupon->type == 1)
                                        Flat Discounts (VNĐ)
                                    @elseif ($coupon->type == 2)
                                        Percentage Discounts (%)
                                    @else
                                        Coupon not valid
                                    @endif
                                </td>
                                <td>
                                    @if ($coupon->type == 1)
                                        {{ $coupon->amount }} (VNĐ)
                                    @elseif ($coupon->type == 2)
                                        {{ $coupon->amount }} (%)
                                    @else
                                        Coupon not valid
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/coupon/edit/' . $coupon->id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete this coupon?')"
                                        href="{{ URL::to('admin/coupon/delete/' . $coupon->id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $coupons->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $coupons->firstItem() }} -
                            {{ $coupons->lastItem() }} of {{ $coupons->total() }} items</small>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
