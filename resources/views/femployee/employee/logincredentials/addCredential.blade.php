@extends('femployee.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->personal_name }}</h6>
		<p><a href="#">Employee</a> / <a href="#">{{ $Employee->personal_name  }}</a> / Add Credential</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="addCredential">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Login Credentials</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add Credentials</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>

				    	<div class="super-admin-add-relation-main">
				    		<div class="credential_append">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>App Name<span class="required-field">*</span></label>
						    		<input class="app_name" type="text" name="credential[0][app_name]" id="credential[0][app_name]" placeholder="App Name">
						    		<label class="error error1" for="credential[0][app_name]"></label>
					    		</figure>
					    		<figure>
						    		<label>URL<span class="required-field">*</span></label>
						    		<input class="url" type="text" name="credential[0][url]" id="credential[0][url]" placeholder="URL">
						    		<label class="error error1" for="credential[0][url]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Username<span class="required-field">*</span></label>
						    		<input class="username" type="text" name="credential[0][username]" id="credential[0][username]" placeholder="Username">
						    		<label class="error error1" for="credential[0][username]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Password<span class="required-field">*</span></label>
						    		<input class="password" type="password" name="credential[0][password]" id="credential[0][password]" placeholder="Password">
						    		<label class="error error1" for="credential[0][password]"></label>
						    	</figure>
						    </div>
						    </div>

							<div class="super-admin-add-relation">
						    	<figure>	
						    		<label></label>
						    		<input class="btn add-credential-dashed" type="button" value="+ Add Credential">
						    	</figure>
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

		$("#addCredential").validate({
			rules:{
				'credential[0][app_name]':{required:true},
				'credential[0][url]':{required:true},
				'credential[0][username]':{required:true},
				'credential[0][password]':{required:true},
			},
			messages:{
		  	}
		});

	});


	//Adding validation rules
       
	 var count = 1;
	 $('.add-credential-dashed').click(function(){
	 	var Html = '<div class="super-admin-add-relation mar-top-20px" style="border-bottom: 1px #e3e7ec solid">';
	 			Html +=	'<i class="fa fa-times cut_credential"></i>';
	    		Html +=	'<figure><label>App Name<span class="required-field">*</span></label><input type="text" class="app_name" name="credential['+count+'][app_name]" placeholder="App Name"><label class="error error1" for="credential['+count+'][app_name]"></label></figure>';
		    	Html +=	'<figure><label>URL<span class="required-field">*</span></label><input class="url" type="text" name="credential['+count+'][url]" placeholder="URL"><label class="error error1" for="credential['+count+'][url]"></label></figure>';
			    Html +=	'<figure><label>Username<span class="required-field">*</span></label><input class="username" type="text" name="credential['+count+'][username]" placeholder="Username"><label class="error error1" for="credential['+count+'][username]"></label></figure>';
			    Html +=	'<figure><label>Password<span class="required-field">*</span></label><input class="password" type="password" name="credential['+count+'][password]" placeholder="Password"><label class="error error1" for="credential['+count+'][password]"></label></figure>';
			Html +=	'</div>	';
	 	$('.credential_append').append(Html);
	 	count++;	

	    $(".app_name").each(function(){$(this).rules("add", {required:true}) });
	    $(".url").each(function(){$(this).rules("add", {required:true}) });
		$(".username").each(function(){$(this).rules("add", {required:true}) });
		$(".password").each(function(){$(this).rules("add", {required:true}) });
	 });
	  $(document).on('click','.cut_credential',function(){
 		$(this).parent('.super-admin-add-relation').remove();
 	});
</script>
 
@endsection
