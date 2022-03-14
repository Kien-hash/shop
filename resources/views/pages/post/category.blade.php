@extends('pages.layouts.index')

@section('content')
    <div class="features_items">
        <h2 class="title text-center">{{ $postCategory->name }}</h2>
        <div class="product-image-wrapper" style="border:none;">
            @foreach ($posts as $post)
                <div class="single-products" style="margin:10px 0;padding:2px;">
                    <div class="text-center">
                        <img src="{{ '/uploads/post/' . $post->image }}" alt="{{ $post->slug }}"
                            style="width:30%;height:150px;float:left;padding:5px;">
                        <h4 style="color: #000; padding: 5px;">{{ $post->name }}</h4>
                        <p>{!! $post->description !!}</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ 'post/' . $post->slug }}" class="btn btn-default btn-sm">Xem bài viết</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            @endforeach
        </div>
    </div>
    <ul class="pagination pagination-sm m-t-none m-b-none">
        {!! $posts->links() !!}
    </ul>
@endsection

@section('scripts')

@endsection
