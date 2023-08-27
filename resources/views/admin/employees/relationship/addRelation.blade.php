@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->fullname }}</h6>
		<p><a href="#">Employee / </a><a href="#">{{ $Employee->fullname  }} /</a> Add Contacts</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="addRelation">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Emergency Contacts</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add Contacts</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>

				    	<div class="super-admin-add-relation-main">
				    		<div class="emergency_append">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Relationship Type<span class="required-field">*</span></label>
						    		<input class="relation_type" type="text" name="emergency[0][relationship_type]" id="emergency[0][relationship_type]">
						    		<label class="error error1" for="emergency[0][relationship_type]"></label>
					    		</figure>
					    		<figure>
						    		<label>Full Name<span class="required-field">*</span></label>
						    		<input class="fullname" type="text" name="emergency[0][fullname]" id="emergency[0][fullname]">
						    		<label class="error error1" for="emergency[0][fullname]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Phone Number<span class="required-field">*</span></label>
						    		<input class="phonenumber" type="text" name="emergency[0][phonenumber]" id="emergency[0][phonenumber]" placeholder="xxx-xxx-xxxx">
						    		<label class="error error1" for="emergency[0][phonenumber]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Email Address<span class="required-field">*</span></label>
						    		<input class="email" type="email" name="emergency[0][email]" id="emergency[0][email]">
						    		<label class="error error1" for="emergency[0][email]"></label>
						    	</figure>
						    </div>
						    </div>

							<div class="super-admin-add-relation">
						    	<figure>	
						    		<label></label>
						    		<input class="btn add-relation-dashed" type="button" value="+ Add Relationship">
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

		//$('input[name="emergency[0][phonenumber]"]').samask("000-000-0000");
		$('input[name="emergency[0][phonenumber]"]').inputmask({"mask": "999-999-9999"});

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
    	    	
		$("#addRelation").validate({
			rules:{
				'emergency[0][relationship_type]':{required:true,nameRegex:true},
				'emergency[0][fullname]':{required:true,nameRegex:true},
				'emergency[0][phonenumber]':{required:true, phoneUS:true, usphonenumb:true},
				'emergency[0][email]':{required:true},
			},
			messages:{
			  	'emergency[0][phonenumber]':{
					phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
				},
		  	}
		});

	});


	//Adding validation rules
       
	 var count = 1;
	 $('.add-relation-dashed').click(function(){
	 	var Html = '<div class="super-admin-add-relation mar-top-20px" style="border-bottom: 1px #e3e7ec solid">';
	 			Html +=	'<i class="fa fa-times cut_relation"></i>';
	    		Html +=	'<figure><label>Relationship Type<span class="required-field">*</span></label><input type="text" class="relation_type" name="emergency['+count+'][relationship_type]"><label class="error error1" for="emergency['+count+'][relationship_type]"></label></figure>';
		    	Html +=	'<figure><label>Full Name<span class="required-field">*</span></label><input class="fullname" type="text" name="emergency['+count+'][fullname]"><label class="error error1" for="emergency['+count+'][fullname]"></label></figure>';
			    Html +=	'<figure><label>Phone Number<span class="required-field">*</span></label><input class="phonenumber" type="text" name="emergency['+count+'][phonenumber]" placeholder="xxx-xxx-xxxx"><label class="error error1" for="emergency['+count+'][phonenumber]"></label></figure>';
			    Html +=	'<figure><label>Email Address<span class="required-field">*</span></label><input class="email" type="text" name="emergency['+count+'][email]"><label class="error error1" for="emergency['+count+'][email]"></label></figure>';
			Html +=	'</div>	';
	 	$('.emergency_append').append(Html);
	 	//$('input[name="emergency['+count+'][phonenumber]"]').samask("000-000-0000");
		$('input[name="emergency['+count+'][phonenumber]"]').inputmask({"mask": "999-999-9999"});
	 	count++;	

	    $(".relation_type").each(function(){$(this).rules("add", {required:true,nameRegex:true}) });
	    $(".fullname").each(function(){$(this).rules("add", {required:true,nameRegex:true}) });
	    $(".phonenumber").each(function(){
	    	$(this).rules("add", {
	    		required:true,
	    		phoneUS:true,
	    		usphonenumb:true,
	    		messages:{
	    			phoneUS:'Please Enter a Valid Phone Number. (Eg: 541-123-1233)',
	    		}
	    	}); 
	    });
	    $(".email").each(function(){
	    	$(this).rules("add", {
	    		required:true,
	    		validate_email:true,
	    	}); 
	    });
	    
	 });
	  $(document).on('click','.cut_relation',function(){
 		$(this).parent('.super-admin-add-relation').remove();
 	});
</script>
 
@endsection
