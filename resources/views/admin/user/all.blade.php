@extends('admin.layouts.index')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All users
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
                            <th>Email</th>
                            <th>Phone</th>
                            @foreach ($roles as $role)
                                <th>{{ $role->name }}</th>
                            @endforeach
                            <th style="width:50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <form action="{{ URL::to('admin/user/assign-roles') }}" method="POST">
                                @csrf
                                <tr>
                                    <td><label class="i-checks m-b-none"><input type="checkbox"
                                                name="post[]"><i></i></label>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}
                                        <input hidden type="text" name="id" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    @foreach ($roles as $role)
                                        <td><input type="checkbox" name="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}></td>
                                    @endforeach
                                    <td>
                                        <input type="submit" value="Assign roles" class="btn btn-sm btn-default">
                                        <a onclick="return confirm('Are you sure you want to delete this user?')"
                                            href="{{ URL::to('admin/user/delete/' . $user->id) }}"
                                            class="btn btn-sm btn-danger" ui-toggle-class="">
                                            Delete user
                                        </a>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $users->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Records {{ $users->firstItem() }} -
                            {{ $users->lastItem() }} of {{ $users->total() }} items</small>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
