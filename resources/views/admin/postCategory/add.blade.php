@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add postCategory
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
                        <form role="form" action="{{ URL::to('admin/postCategory/add') }}" method="POST"
                            enctype="multipart/form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" data-validation="length"
                                    onkeyup="ChangeToSlug();" id="slug" data-validation-length='1-255'
                                    placeholder="postCategory's name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" name="slug" class="form-control" id="convert_slug"
                                    data-validation="length" data-validation-length='1-255' placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea style="resize: none" rows="8" class="form-control" id='ckeditor1'
                                    name="description" id="" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Keywords</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="keywords"
                                    id="exampleInputPassword1"></textarea>
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
            //L???y text t??? th??? input title
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //?????i k?? t??? c?? d???u th??nh kh??ng d???u
            slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'a');
            slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, 'e');
            slug = slug.replace(/i|??|??|???|??|???/gi, 'i');
            slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'o');
            slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, 'u');
            slug = slug.replace(/??|???|???|???|???/gi, 'y');
            slug = slug.replace(/??/gi, 'd');
            //X??a c??c k?? t??? ?????t bi???t
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //?????i kho???ng tr???ng th??nh k?? t??? g???ch ngang
            slug = slug.replace(/ /gi, "-");
            //?????i nhi???u k?? t??? g???ch ngang li??n ti???p th??nh 1 k?? t??? g???ch ngang
            //Ph??ng tr?????ng h???p ng?????i nh???p v??o qu?? nhi???u k?? t??? tr???ng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //X??a c??c k?? t??? g???ch ngang ??? ?????u v?? cu???i
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox c?? id ???slug???
            document.getElementById('convert_slug').value = slug;
        }

        $.validate({

        });

        CKEDITOR.replace('ckeditor1');
    </script>
@endsection
