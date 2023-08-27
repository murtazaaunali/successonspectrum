@extends('femployee.layout.auth')

<!-- Main Content -->
@section('content')
<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/femployee/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="login-page-main forgot-page-main">
		<div class="container-login container">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/femployee/password/email') }}">
                {{ csrf_field() }}
                
				<div class="row">
					<div class="col-md-7 col-sm-7 pos-rel-0">
						<div class="login-footer-bar-main">
							<p>Copyright 2019. Success on the Spectrum. All Rights Reserved</p>
						</div>
					</div>
					<div class="col-md-5 col-sm-5 pos-rel-0 mob-login-bg">
						<div class="logo-login">
							<img src="{{ asset('assets') }}/images/login-logo.png">
						</div>
                        
                        @if(Session::has('Success'))
							{!! session('Success') !!}
						@endif
                        
						<div class="login-head">
							<h2>Forgot Password</h2>
						</div>
						<div class="Login-input">
							<p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
                            <!--<input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Rigesterd Email Address">-->
                            <input id="email" type="email" name="email" value="{{ old('personal_email') ?: old('email') }}" placeholder="Registered Email Address">

                            <!--@if ($errors->has('email'))
                                <span class="help-block  login-error-txt">
                                    <label class="error">{{ $errors->first('email') }}</label>
                                </span>
                            @endif-->
                            @if ($errors->has('personal_email') || $errors->has('email'))
                                 <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('personal_email') ?: $errors->first('email') }}</label>
                                </span>
                            @endif
                            <button type="submit" class="btn login-butn">SUBMIT</button>
						</div>
						<div class="forget-pasmain ForgetPassTextAlign">
							<a href="{{ url('femployee/login') }}"><i class="fa fa-lock" aria-hidden="true"></i> Remember your login details?</a><a href="#">Login</a>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="WheelImg">
			<img src="{{ asset('assets') }}/images/login-wheel-img.png">
		</div>
		<!-- Mob show -->
	</div>
@endsection
