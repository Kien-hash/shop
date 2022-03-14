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
                Add Galleries
            </div>

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('admin/gallery/add') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div id="error_gallery"></div>
                        <div class="col-sm-1"> <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        </div>
                        <div class="col-sm-10">
                            <input type="file" id="file" name="file[]" class="form-control" accept="image/*" multiple>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" name='add-gallery' class="btn btn-success">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Product's galleries
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
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Image</th>
                            <th style="width:40px;">Manage</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($galleries as $gallery)
                            <tr>
                                <form action="{{ URL::to('admin/gallery/edit/' . $gallery->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <td><label class="i-checks m-b-none"><input type="checkbox"
                                                name="post[]"><i></i></label></td>
                                    <td>
                                        <textarea name="name" rows="5"
                                            style="width:100%;height:150px;">{{ $gallery->name }}</textarea>
                                    </td>
                                    <td>
                                        <img src="{{ $gallery->image != '' ? '/uploads/gallery/' . $gallery->image : '' }}"
                                            width="150" height="150" alt="" />
                                        <input type="file" name="image">
                                    </td>
                                    <td><input type="submit" name='update' value='update'></td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to delete this gallery?')"
                                            href="{{ URL::to('admin/gallery/delete/' . $gallery->id) }}"
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
                            {{ $galleries->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $galleries->firstItem() }} -
                            {{ $galleries->lastItem() }} of {{ $galleries->total() }} items</small>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#file").change(function() {
                let error = '';
                let files = $("#file")[0].files;

                if (files.length > 5) {
                    error = '<p> Maximum of files must be 5.</p>';
                } else if (files.length == '') {
                    error = '<p> File must not be empty.</p>';
                } else if (files.size > 20000000) {
                    error = '<p> File must smaller 20MB </p>';
                }

                if (error != '') {
                    $("#file").val('');
                    $("#error_gallery").html('<span class="text-danger">' + error + '</span>');
                }
            });
            $("#myTable").DataTable();

        });
    </script>
@endsection
