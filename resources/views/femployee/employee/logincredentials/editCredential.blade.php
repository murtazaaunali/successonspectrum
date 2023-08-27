@extends('femployee.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->personal_name }}</h6>
		<p><a href="#">Employee</a> / <a href="#">{{ $Employee->personal_name }}</a> / Credential Edit</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="editCredential">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Login Credentials</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="super-admin-add-relation-main">
				    		<div class="emergency_append">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>App Name<span class="required-field">*</span></label>
						    		<input type="text" name="app_name" value="{{ $credential->app_name }}" placeholder="App Name">
						    		<label class="error error1" for="app_name"></label>
					    		</figure>
					    		<figure>
						    		<label>URL<span class="required-field">*</span></label>
						    		<input type="text" name="url" value="{{ $credential->url }}" placeholder="URL">
						    		<label class="error error1" for="url"></label>
						    	</figure>
						    	<figure>	
						    		<label>Username<span class="required-field">*</span></label>
						    		<input type="text" name="username" value="{{ $credential->username }}" placeholder="Username">
						    		<label class="error error1" for="username"></label>
						    	</figure>
						    	<figure>	
						    		<label>Password<span class="required-field">*</span></label>
						    		<input type="password" name="password" value="{{ $credential->password }}" placeholder="Password">
						    		<label class="error error1" for="password"></label>
						    	</figure>
						    </div>
						    </div>
				    	</div>

			    </form>
			    
			    </div>
			</div>
		</div>
		<!-- header-bottom-sec -->
	</div>	



<script type="text/javascript">

	$(document).ready(function() {

		$("#editCredential").validate({
			rules:{
				app_name:{required:true},
				url:{required:true},
				username:{required:true},
				password:{required:true},
			},
			messages:{
		  	}
			
		});

	});

</script>
 
@endsection
