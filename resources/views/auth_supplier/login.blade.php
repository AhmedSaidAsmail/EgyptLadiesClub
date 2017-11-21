<?php //echo "<pre>" . print_r(Session::all(), true)   ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Supplier C-Panel | Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{asset('adminlte/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/square/blue.css')}}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>Supplier</b>C-Panel</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('supplier.login')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group has-feedback">

                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div>
                </form>
                <a href="#">I forgot my password</a><br>
            </div>
        </div>
        <script src="{{asset('adminlte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
        <script src="{{asset('adminlte/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
        </script>
    </body>
</html>
