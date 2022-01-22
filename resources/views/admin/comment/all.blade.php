@extends('admin.layouts.index')
@section('content')
    <style>
        ul.list-reply li {
            list-style-type: decimal;
            color: blue;
            margin: 2px 40px;
        }

    </style>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                All comments
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

            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:10%;">Customer</th>
                            <th style="width:20%;">Product</th>
                            <th>Comment</th>
                            <th style="width:10%;">Created at</th>
                            <th style="width:5%;">Display</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            @if ($comment->parent_id != 0)
                                @continue
                            @endif
                            <tr>
                                <td>{{ $comment->name }}</td>
                                <td>
                                    <a
                                        href="{{ URL::to('/details/' . $comment->product->slug) }}">{{ $comment->product->name }}</a>
                                </td>
                                <td>{{ $comment->comment }}
                                    @if ($comment->status == 0)
                                        <ul class="list-reply">
                                            @foreach ($comments as $reply)
                                                @if ($reply->parent_id == $comment->id)
                                                    <li>Replied: {{ $reply->comment }}
                                                        <a onclick="return confirm('Are you sure you want to delete this comment?')"
                                                            href="{{ URL::to('admin/comment/delete/' . $reply->id) }}"
                                                            class="active styling-edit" ui-toggle-class="">
                                                            <i class="fa fa-times text-danger text"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <form action="{{ URL::to('admin/comment/reply/' . $comment->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
                                            <textarea style="width:80%;" name="comment" rows="3" id=""></textarea>
                                            <button type="submit">Reply</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at }}</td>
                                <td>
                                    @if ($comment->status == 0)
                                        <a href="{{ URL::to('admin/comment/inactive/' . $comment->id) }}"><span
                                                class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                                    @else
                                        <a href="{{ URL::to('admin/comment/active/' . $comment->id) }}"><span
                                                class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="return confirm('Are you sure you want to delete this comment?')"
                                        href="{{ URL::to('admin/comment/delete/' . $comment->id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

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
