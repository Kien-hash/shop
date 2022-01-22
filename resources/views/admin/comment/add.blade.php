@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add comment
                </header>
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
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('admin/comment/add') }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" data-validation="length"
                                    onkeyup="ChangeToSlug();" id="slug" data-validation-length='1-255'
                                    placeholder="comment's name">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea style="resize: none" rows="8" class="form-control" id='ckeditor1'
                                    name="description" id="" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Display</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="0">Enable</option>
                                    <option value="1">Disable</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function ChangeToSlug() {
            var slug;
            //Lấy text từ thẻ input title
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }

        $.validate({

        });

        CKEDITOR.replace('ckeditor1');
    </script>
@endsection
