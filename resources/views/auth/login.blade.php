@extends('layouts.auth')
@section('content')
    <div class="container d-flex h-100">
        <div class="row align-items-center w-100">
            <div class="col-md-7 col-lg-5 m-h-auto">
                @include('layouts.notice')
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="m-b-30">
                            <p class="text-center">
                                <img class="img-fluid" alt="" src="{{ url('img/logo.png') }}" style="width: 50%">
                            </p>
                            <h6 class="m-b-0 text-center">{{ config('app.name') }}</h6>
                            <p class="m-b-0 text-center">Authorised Access Only</p>
                        </div>
                        <form method="post" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-semibold" for="userName">Email:</label>
                                <div class="input-affix">
                                    <i class="prefix-icon anticon anticon-mail"></i>
                                    <input type="text" class="form-control" id="userName" name="email" placeholder="Email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-semibold" for="password">Password:</label>
                                <a class="float-right font-size-13 text-muted" href="">Forget Password?</a>
                                <div class="input-affix m-b-10">
                                    <i class="prefix-icon anticon anticon-lock"></i>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-size-13 text-muted">
                                                    Don't have an account?
                                                    <a class="small" href=""> Signup</a>
                                                </span>
                                    <button class="btn btn-primary">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection