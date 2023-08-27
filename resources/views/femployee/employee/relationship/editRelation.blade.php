@extends('femployee.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Employee->personal_name }}</h6>
		<p><a href="#">Employee</a> / Contact Edit</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="editRelation">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Emergency Contacts</h3>
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
						    		<label>Relationship Type<span class="required-field">*</span></label>
						    		<input type="text" name="relationship_type" value="{{ $emergency_contact->relationship }}">
						    		<label class="error error1" for="relationship_type"></label>
					    		</figure>
					    		<figure>
						    		<label>Full Name<span class="required-field">*</span></label>
						    		<input type="text" name="fullname" value="{{ $emergency_contact->fullname }}">
						    		<label class="error error1" for="fullname"></label>
						    	</figure>
						    	<figure>	
						    		<label>Phone Number<span class="required-field">*</span></label>
						    		<input type="text" name="phonenumber" value="{{ $emergency_contact->phone_number }}" placeholder="xxx-xxx-xxxx">
						    		<label class="error error1" for="phonenumber"></label>
						    	</figure>
						    	<figure>	
						    		<label>Email Address<span class="required-field">*</span></label>
						    		<input type="email" name="email" value="{{ $emergency_contact->email }}">
						    		<label class="error error1" for="email"></label>
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

		//Phone number validation
		//$('input[name=phonenumber]').samask("000-000-0000");
		$('input[name=phonenumber]').inputmask({"mask": "999-999-9999"});

		jQuery.validator.addMethod("validate_email", function(value, element) {

		    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
		        return true;
		    } else {
		        return false;
		    }
		}, "Please enter a valid Email.");
		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");

		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");
    	
		$("#editRelation").validate({
			rules:{
				relationship_type:{required:true,nameRegex:true},
				fullname:{required:true,nameRegex:true},
				phonenumber:{required:true, phoneUS:true,usphonenumb:true},
				email:{required:true, validate_email:true},
			},
			messages:{
			  	phonenumber:{
					phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
				}
		  	}
			
		});

	});

</script>
 
@endsection
