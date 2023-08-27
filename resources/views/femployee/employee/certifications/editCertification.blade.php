@extends('femployee.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->personal_name }}</h6>
		<p><a href="#">Employee</a> / <a href="#">{{ $Employee->personal_name }}</a> / Certification Edit</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="editCertification">
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
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Certification Name<span class="required-field">*</span></label>
						    		<input type="text" name="certification_name" value="{{ $certification->certification_name }}">
						    		<label class="error error1" for="certification_name"></label>
					    		</figure>
					    		<figure class="pos-rel">
						    		<label>Expiration Date<span class="required-field">*</span></label>
						    		<input type="text" name="expiration_date" value="{{ $certification->expiration_date }}" class="expiration_datepicker">
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar expiration_datepicker" aria-hidden="true"></i></a>
                                    <label class="error error1" for="expiration_date"></label>
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
		//$('input[name="expiration_date"]').datetimepicker({
		$('.expiration_datepicker').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");

		$("#editCertification").validate({
			rules:{
				certification_name:{required:true,nameRegex:true},
				expiration_date:{required:true,date:true},
			},
			messages:{
		  	}
		});

	});

</script>
 
@endsection
