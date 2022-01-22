@extends('admin.layouts.index')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
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

            <div class="panel-heading">
                Add deliveries
            </div>

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('admin/delivery/add') }}" method="POST" enctype="multipart/form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <label>Province (City)</label>
                            <select name="matp" id='city' class="form-control input-sm m-bot15 choose city">
                                <option value="">----Choose Province (City)-----</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->matp }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>District</label>
                            <select name="maqh" id='district' class="form-control input-sm m-bot15 choose district">
                                <option value="">----Choose District-----</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ward (Vilage)</label>
                            <select name="xaid" id='ward' class="form-control input-sm m-bot15 ward">
                                <option value="">----Choose Ward (Vilage)-----</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Shipping's Fee</label>
                            <input type="number" class="form-control fee" min=1000 step=1000 id='' name="fee"
                                data-validation="number" placeholder="Delivery's fee">
                        </div>

                        <button type="submit" name='add-delivery' class="btn btn-info add-delivery">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All deliveries
            </div>

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
                            <th>Province (City)</th>
                            <th>District</th>
                            <th>Ward (Vilage)</th>
                            <th>Shipping's Fee</th>
                            <th></th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                            @if ($delivery->id == 1)
                                <tr>
                                    <form action="{{ URL::to('admin/delivery/edit/' . $delivery->id) }}" method="POST">
                                    @csrf
                                    <td></td>
                                    <td></td>
                                    <td>Default Shipping Fee:</td>
                                    <td></td>
                                    <td><input type="number" name="fee" data-validation="number" min="0" step="1000" value="{{ $delivery->fee }}"></td>
                                    <td><input type="submit" name='update' value='update'></td>
                                    <td>
                                        {{-- <a onclick="return confirm('Are you sure you want to delete this delivery?')"
                                            href="{{ URL::to('admin/delivery/delete/' . $delivery->id) }}"
                                            class="active styling-edit" ui-toggle-class="">
                                            <i class="fa fa-times text-danger text"></i>
                                        </a> --}}
                                    </td>
                                    </form>
                                </tr>
                            @continue
                            @endif
                                <tr>
                                    <form action="{{ URL::to('admin/delivery/edit/' . $delivery->id) }}" method="POST">
                                    @csrf
                                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                                    <td>{{$delivery->city->name}}</td>
                                    <td>{{$delivery->district->name}}</td>
                                    <td>{{$delivery->ward->name}}</td>
                                    <td><input type="number" name="fee" data-validation="number" min="0" step="1000" value="{{ $delivery->fee }}"></td>
                                    <td><input type="submit" name='update' value='update'></td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to delete this delivery?')"
                                            href="{{ URL::to('admin/delivery/delete/' . $delivery->id) }}"
                                            class="active styling-edit" ui-toggle-class="">
                                            <i class="fa fa-times text-danger text"></i>
                                        </a>
                                    </td>
                                    </form>
                                </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{-- <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $deliveries->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $deliveries->firstItem() }} -
                            {{ $deliveries->lastItem() }} of {{ $deliveries->total() }} items</small>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';
                if (action == 'city') {
                    result = 'district';
                } else {
                    result = 'ward';
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('/select-delivery') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token,
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
        $.validate({});
        $(document).ready(function() {
            $("#myTable").DataTable();
        });
    </script>
@endsection
