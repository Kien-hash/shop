@extends('admin.layouts.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    user Edit
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
                        <form role="form" action="{{ URL::to('admin/user/edit/' . $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" data-validation="length"
                                    data-validation-length='1-255' value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" data-validation="length"
                                    data-validation-length='1-255' value="{{ $user->phone }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" data-validation="email"
                                    value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label>Change Password</label>
                                <input id="check-box" type="checkbox">
                            </div>
                            <div id="change-password" class="form-group" hidden>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control password1" name="password"
                                        data-validation="length" data-validation-length='6-255'
                                        placeholder="User's Password">
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <input type="password" class="form-control password2" data-validation="length"
                                        data-validation-length='6-255' placeholder="Password Retype">
                                    <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"></div>
                                </div>
                            </div>

                            <button type="submit" id="btn" class="btn btn-info">Update</button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#check-box").change(function() {
                if ($(this).is(':checked')) {
                    $("#change-password").removeAttr('hidden');
                } else {
                    $("#change-password").attr("hidden",true);
                }
            });

            function checkPasswordMatch() {
                var password = $(".password1").val();
                var confirmPassword = $(".password2").val();
                if (password != confirmPassword) {
                    $("#CheckPasswordMatch").html("Passwords does not match!");
                    $("#btn").attr("disabled", true);
                } else
                    $("#CheckPasswordMatch").html("Passwords match.");
            }
            $(".password2").change(checkPasswordMatch);
        });

        $.validate({

        });
    </script>
@endsection
