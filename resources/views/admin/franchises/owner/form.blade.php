@extends('admin.layout.main')

@section('content')


    <form action="" method="post" id="ownerForm">
	    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

		<div class="add-franchise-super-main">
			<h6>{{$sub_title}}</h6>
			<p> <a href="{{ url('admin/franchise/view/'.$Franchise->id) }}">{{$Franchise->name}}</a> / <a href="#">Owner</a> / {{ $breadcrumb }}</p>
			<div class="add-franchise-data-main-1 add-franchise-data-main-2">
				<div id="franchise-demography" class="tab-pane fade in active">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-3 add-owner-bar-main">
				    		<div class="view-tab-content-head add-owner-bar-head">
				    			<h3>{{$sub_title}}</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i> @if($breadcrumb == 'Add Owner') Add Owner @else Update Owner @endif</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="super-admin-add-relation-main">
				    		<div class="super-admin-add-relation border-bot-0">
				    			<figure>
						    		<label>Full Name<span class="required-field">*</span></label>
						    		<input type="text" name="fullname" value="{{$fullname}}">
						    		<label class="error error1" for="fullname"></label>
					    		</figure>
					    		<figure>
						    		<label>Contact Number<span class="required-field">*</span></label>
						    		<input type="text" name="phone" value="{{$phone}}" placeholder="xxx-xxx-xxxx">
						    		<label class="error error1" for="phone"></label>
						    	</figure>
						    	<figure>	
						    		<label>Email Address<span class="required-field">*</span></label>
						    		<input type="text" name="email" value="{{$email}}">
						    		<label class="error error1" for="email"></label>
						    	</figure>
				    		</div>	
				    	</div>
				    </div>
				</div>
			</div>
			<!-- header-bottom-sec -->
		</div>
    </form>

<script type="text/javascript">
	$('document').ready(function(){

		//Phone number validation
		//$('input[name=phone]').samask("000-000-0000");
		$('input[name="phone"]').inputmask({"mask": "999-999-9999"});

		jQuery.validator.addMethod("validate_email", function(value, element) {
		    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
		        return true;
		    } else {
		        return false;
		    }
		}, "Please enter a valid Email.");

		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");
		
		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");
    	
		$( "#ownerForm" ).validate({
		  submitHandler: function(form) {
		    $(form).ajaxSubmit();
		  },
		  rules: {
		    fullname:{required:true,nameRegex:true,},
		    email:{
		    	required:true,
		    	validate_email: true,
		    },
		    phone: {
		      required: true,
		      phoneUS: true,
		      usphonenumb: true,
		    },
		  },
		  messages:{
		  	phone:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			}
		  }
		});		
	});
</script>

@endsection
