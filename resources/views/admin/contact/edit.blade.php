@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    contact Edit
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
                        <form role="form" action="{{ URL::to('admin/contact/config/') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputPassword1">General Information</label>
                                <textarea style="resize: none" rows="8" class="form-control" id='ckeditor1'
                                    name="contact">{{ $contact ? $contact->contact : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Map</label>
                                <textarea style="resize: none" rows="8" class="form-control"
                                    name="map">{{ $contact ? $contact->map : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fanpage</label>
                                <textarea style="resize: none" rows="8" class="form-control"
                                    name="fanpage">{{ $contact ? $contact->fanpage : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control">
                            </div>
                            <button type="submit" name="update_contact_product" class="btn btn-info">Update</button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $.validate({});

        CKEDITOR.replace('ckeditor1');
    </script>
@endsection
