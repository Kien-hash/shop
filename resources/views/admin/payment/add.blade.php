@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Category
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
                        <form role="form" action="{{ URL::to('admin/payment/add') }}" method="POST"
                            enctype="multipart/form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" data-validation="length"
                                    onkeyup="ChangeToSlug();" id="slug" data-validation-length='1-255'
                                    placeholder="Category's name">
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
        $.validate({

        });

        CKEDITOR.replace('ckeditor1');
    </script>
@endsection
