@extends('layouts.landing')
@section('content')
    <div class="container d-flex h-100">
        <div class="row align-items-center w-100">
            <div class="col-md-7 col-lg-5 m-h-auto">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between m-b-30">
                            <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                            <h2 class="m-b-0">Sign In</h2>
                        </div>
                        <form>
                            <div class="form-group">
                                <label class="font-weight-semibold" for="userName">Username:</label>
                                <div class="input-affix">
                                    <i class="prefix-icon anticon anticon-user"></i>
                                    <input type="text" class="form-control" id="userName" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-semibold" for="password">Password:</label>
                                <a class="float-right font-size-13 text-muted" href="">Forget Password?</a>
                                <div class="input-affix m-b-10">
                                    <i class="prefix-icon anticon anticon-lock"></i>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
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