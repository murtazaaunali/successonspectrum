<!DOCTYPE html>
<html>
  <head>
    <title>@if(isset($page_title)) @if(Auth::guard('admin')->check()) Super Admin @endif {{$page_title}} | {{ config('app.name', 'Success on the Spectrum') }} @else {{ config('app.name', 'Laravel Multi Auth Guard') }} @endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/frontend/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.timepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}?{{ time() }}" />
    <link rel="stylesheet" type="text/css" href="{{ mix('/assets/css/responsive.css') }}?{{ time() }}" />
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/parent.css') }}?{{ time() }}" />
	
    <script src="{{ asset('assets/js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/canvasjs.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/frontend/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
  	<script type="text/javascript" src="{{ asset('assets') }}/frontend/js/jquery.bootstrap.wizard.js"></script>
  	<script type="text/javascript" src="{{ asset('assets') }}/frontend/js/prettify.js"></script>
    <!--<script type="text/javascript" src="{{ asset('assets/js/jquery.samask-masker.js') }}"></script>-->
	<script type="text/javascript" src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
    
  </head>
  <body class="super-admin-body">
    <section>
      <div class="main">
        <div class="container">
          <div class="row">

            <!-- Left Menu Bar -->
            <div class="col-sm-3 col-md-2 col-2 main_left_side">
              @include('parent.layout.menu')
            </div>
            <!-- Left Menu Bar Ends here -->

            <!-- Right Side Content -->
            <div class="col-sm-9 col-md-10 col-2 main_right_side">

              @include('parent.layout.topbar')

              <!-- Content Pages -->
                <div class="bottom-main-super-admin">
                  <div class="bottom-main-super-admin-1">
                    @yield('content')
                  </div>
                </div>
              <!-- Content Pages -->

            </div>
            <!-- Right Side Content -->

          </div>
        </div>
      </div>
    </section>

    @stack('js')
	<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    
    <!-- Check CRSF Token Expires-->
    <script type="text/javascript">
	$(document).ready(function () {
		//refreshToken();	
		setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 
		function refreshToken(){
			$.get('{{ url("refresh-csrf")}}').done(function(data){
				//console.log(data);
				$('[name="_token"]').val(data); // the new token
			});
		}
		setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 
	});
	</script>
    
  </body>
</html>