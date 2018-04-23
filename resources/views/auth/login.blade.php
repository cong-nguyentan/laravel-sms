<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!--global css starts-->
    <link rel="shortcut icon" href="{!! asset('themes/josh/frontend/images/favicon.png') !!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('themes/josh/frontend/images/favicon.png') !!}" type="image/x-icon">
    <!--end of global css-->

    <!--page level css starts-->
    <link type="text/css" rel="stylesheet" href="{!! asset('themes/josh/frontend/vendors/icheck/skins/all.css') !!}" />
    <link rel="stylesheet" type="text/css" href="{!! asset('themes/josh/frontend/css/login.min.css') !!}">
    <!--end of page level css-->
</head>

<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box animation flipInX">
            <div class="box1">
            <img src="{!! asset('themes/josh/frontend/images/josh-new.png') !!}" alt="logo" class="img-responsive mar">
            <h3 class="text-primary">Login</h3>
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="sr-only"></label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="sr-only"></label>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="checkbox text-left">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
                <input type="submit" class="btn btn-block btn-primary" value="Login">
                <p>Don't have an account? <a href="#"><strong> Sign up</strong></a></p>
            </form>
            </div>
        <div class="bg-light animation flipInX">
            <a href="#">Forgot Password?</a>
        </div>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="{!! asset('themes/josh/frontend/js/jquery.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('themes/josh/frontend/js/bootstrap.min.js') !!}"></script>
<!--global js end-->
<script type="text/javascript" src="{!! asset('themes/josh/frontend/vendors/icheck/icheck.min.js') !!}"></script>
<script>
    $(document).ready(function(){
        $("input[type='checkbox']").iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
    });
</script>
</body>

</html>