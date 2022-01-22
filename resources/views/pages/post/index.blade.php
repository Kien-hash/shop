@extends('pages.layouts.index')

@section('content')
    <div class="features_items">
        <h2 class="title text-center">{{ $post->name }}</h2>
        <div class="product-image-wrapper" style="border:none;">
            <div class="single-products" style="margin:10px 0;padding:2px;">
                <p>{!! $post->content !!}</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="related-items">
        <h2>Bài viết liên quan</h2>
        <style>
            ul.post-related li {
                list-style-type: disc;
                font-size: 16px;
                padding: 6px;
            }

        </style>
        <ul class="post-related">
            @php
                $i = 0;
            @endphp
            @foreach ($post->category->posts as $item)
                @if ($item->id == $post->id)
                    @continue
                @endif
                <li><a href="{{ 'post/' . $item->slug }}">{{ $item->name }}</a></li>
                @if ($i++ > 3)
                    @break
                @endif
            @endforeach
        </ul>
    </div>
    {{-- <ul class="pagination pagination-sm m-t-none m-b-none">
        {!! $posts->links() !!}
    </ul> --}}
@endsection

@section('scripts')

@endsection
