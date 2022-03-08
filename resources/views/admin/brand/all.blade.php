@extends('admin.layouts.index')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All brands
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
            <div  class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Display</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                <td>{{ $brand->description }}</td>
                                <td>
                                    @if ($brand->status == 0)
                                        <a href="{{ URL::to('admin/brand/inactive/' . $brand->id) }}"><span
                                                class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                                    @else
                                        <a href="{{ URL::to('admin/brand/active/' . $brand->id) }}"><span
                                                class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/brand/edit/' . $brand->id) }}" class="active styling-edit"
                                        ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete this brand?')"
                                        href="{{ URL::to('admin/brand/delete/' . $brand->id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i>
                                    </a>
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
                            {{ $brands->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $brands->firstItem() }} -
                            {{ $brands->lastItem() }} of {{ $brands->total() }} items</small>
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

