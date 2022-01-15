@extends('pages.layouts.index')

@section('content')
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Login to your account</h2>
                        <form action="{{ URL::to('/login') }}" method="POST" >
                            {{ csrf_field() }}
                            <input type="email" name='email' placeholder="Email Address" />
                            <input type="password" name='password' placeholder="Password" />
                            <span>
                                <input type="checkbox" class="checkbox">
                                Keep me signed in
                            </span>
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>New User Signup!</h2>
                        <form action="{{ URL::to('/signup') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name='name' placeholder="Name" />
                            <input type="email" name='email' placeholder="Email Address" />
                            <input type="password" name='password' placeholder="Password" />
                            <input type="text" name='phone' placeholder="Phone Number" />
                            <button type="submit" class="btn btn-default">Sign up</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>

@endsection

