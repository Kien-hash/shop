@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    brand Edit
                </header>

                <div>
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
                </div>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('admin/brand/edit/' . $brand->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" value="{{ $brand->name }}" onkeyup="ChangeToSlug();"
                                    data-validation="length" data-validation-length='1-255' name="name"
                                    class="form-control" id="slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" value="{{ $brand->slug }}" name="slug" class="form-control"
                                    id="convert_slug" data-validation="length" data-validation-length='1-255'>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea style="resize: none" rows="8" class="form-control" id='ckeditor1'
                                    name="description" id="exampleInputPassword1">{{ $brand->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Keywords</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="keywords"
                                    id="exampleInputPassword1"
                                    placeholder="Mô tả danh mục">{{ $brand->keywords }}</textarea>
                            </div>
                            <button type="submit" name="update_brand_product" class="btn btn-info">Update</button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    @endsection
