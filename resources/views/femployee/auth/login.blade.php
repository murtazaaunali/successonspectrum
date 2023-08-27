@extends('femployee.layout.auth')

@section('content')
<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/femployee/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/femployee/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="login-page-main">
    <div class="container-login container">

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/femployee/login') }}">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-7 col-sm-7 pos-rel-0">
                <div class="login-footer-bar-main">
                    <p>Copyright {{ date('Y') }}. Success on the Spectrum. All Rights Reserved</p>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 pos-rel-0 mob-login-bg">
                <div class="logo-login">
                    <!--<img src="{{ asset('assets') }}/images/login-logo.png">-->
                    <img width="186" src="{{ asset('assets') }}/images/login-screen.png">
                </div>
                <div class="login-head">
                    <h2>LOGIN</h2>
                </div>
                <div class="Login-input">
                    <!--<input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block error login-error-txt">
                            <label class="error">{{ $errors->first('email') }}</label>
                        </span>
                    @endif-->
                    <input id="email" type="email" name="email" value="{{ old('personal_email') ?: old('email') }}" placeholder="Email" autofocus>
                    @if ($errors->has('personal_email') || $errors->has('email'))
                         <span class="help-block error login-error-txt">
                            <label class="error">{{ $errors->first('personal_email') ?: $errors->first('email') }}</label>
                        </span>
                    @endif

                    <input id="password" type="password" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block login-error-txt">
                            <label class="error">{{ $errors->first('password') }}</label>
                        </span>
                    @endif

                    <button type="submit" class="btn login-butn">Login</button>
                </div>
                <div class="forget-pasmain">
                    <a class="btn btn-link" href="{{ url('/femployee/password/reset') }}"><i class="fa fa-lock" aria-hidden="true"></i> Forgot Your Password?</a>
                </div>
            </div>
        </div>
    </form>	
    </div>
    <div class="WheelImg">
        <img src="{{ asset('assets') }}/images/login-wheel-img.png">
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(argument) {
            var w = $(window).width();
            var h = "100";
            if($(window).width() <= 1595 && $(window).width() >= 991 ){
                $(".login-page-main").css("background-size", w+"px " + h+"%");
            }
        });
    </script>
<script >
	$(document).ready(function(){
		var widd = $(window).width();
	        $winheight = $(window).height() - 0;
			$('.login-page-main').css("min-height", $winheight);
	});
</script>	
@endsection
