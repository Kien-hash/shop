@extends('pages.layouts.index')
@section('content')
    <div class="features_items">
        <h2>Liên hệ với chúng tôi</h2>
        <div class="row">
            <div class="col-md-12">
                <h4>Thông tin liên hệ</h4>
                <p>Địa chỉ 1: Số 1 Giải Phóng, Bách Khoa, Đống Đa, Hà Nội</p>
                <p>Địa chỉ 2: Số 1 Đại Cồ Việt, Hai Bà Trưng, Hà Nội</p>
                <p>Số điện thoại: 0123456789 - 0987654321</p>
                <p>Fanpage: <a href="https://www.facebook.com/dhbkhanoi/" target="_blank">Đại học Bách khoa Hà Nội - Hanoi
                        University of Science and Technology</a> </p>
            </div>
            <div class="col-md-12">
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0"
                                nonce="xCgfZBRB">
                </script>
                <div class="fb-page" data-href="https://www.facebook.com/dhbkhanoi/" data-tabs="timeline"
                    data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true"
                    data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/dhbkhanoi/" class="fb-xfbml-parse-ignore"><a
                            href="https://www.facebook.com/dhbkhanoi/">Đại học Bách khoa Hà Nội - Hanoi University of
                            Science and Technology</a></blockquote>
                </div>
            </div>
            <div class="col-md-12">
                <h4>Bản đồ</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1862.3418120874408!2d105.84032665817615!3d21.005315500472634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac77783f15a5%3A0x27e6029bfd75357d!2zMSBHaeG6o2kgUGjDs25nLCBQaMawxqFuZyBNYWksIMSQ4buRbmcgxJBhLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1642941149453!5m2!1svi!2s"
                    width="100%" height="450" style="border:1px;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

        </div>

    </div>


@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
