@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->personal_name }}</h6>
		<p><a href="#">Employee</a> / <a href="#">{{ $Employee->personal_name  }}</a> / Add Certification</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="addCertification">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Certifications</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add Certification</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>

				    	<div class="super-admin-add-relation-main">
				    		<div class="certification_append">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Certification Name<span class="required-field">*</span></label>
						    		<input class="certification_name" type="text" name="certification[0][certification_name]">
						    		<label class="error error1" for="certification[0][certification_name]"></label>
					    		</figure>
					    		<figure class="pos-rel">
						    		<label>Expiration Date<span class="required-field">*</span></label>
						    		<input class="expiration_date expiration_datepicker" type="text" name="certification[0][expiration_date]" placeholder="mm/dd/yy">
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar expiration_datepicker" aria-hidden="true"></i></a>
                                    <label class="error error1" for="certification[0][expiration_date]"></label>
						    	</figure>
						    </div>
						    </div>
							<div class="super-admin-add-relation">
						    	<figure>	
						    		<label></label>
						    		<input class="btn add-certification-dashed" type="button" value="+ Add Certification">
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
		//$('input[name="certification[0][expiration_date]"]').datetimepicker({
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
		
		$("#addCertification").validate({
			rules:{
				'certification[0][certification_name]':{required:true,nameRegex:true},
				'certification[0][expiration_date]':{required:true,date:true},
			},
			messages:{
		  	}
		});

	});


	//Adding validation rules
       
	 var count = 1;
	 $('.add-certification-dashed').click(function(){
	 	var Html = '<div class="super-admin-add-relation mar-top-20px" style="border-bottom: 1px #e3e7ec solid">';
	 			Html +=	'<i class="fa fa-times cut_certification"></i>';
	    		Html +=	'<figure><label>Certification Name<span class="required-field">*</span></label><input type="text" class="certification_name" name="certification['+count+'][certification_name]"><label class="error error1" for="certification['+count+'][certification_name]"></label></figure>';
		    	Html +=	'<figure class="pos-rel"><label>Expiration Date<span class="required-field">*</span></label><input class="expiration_date expiration_datepicker" type="text" name="certification['+count+'][expiration_date]" placeholder="mm/dd/yy"><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar expiration_datepicker" aria-hidden="true"></i></a><label class="error error1" for="certification['+count+'][expiration_date]"></label></figure>';
			Html +=	'</div>	';
	 	$('.certification_append').append(Html);
	    $(".certification_name").each(function(){$(this).rules("add", {required:true,nameRegex:true}) });
	    $(".expiration_date").each(function(){$(this).rules("add", {required:true,date:true}) });
		//$('input[name="certification['+count+'][expiration_date]"]').datetimepicker({
		$('.expiration_datepicker').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		count++;
	 });
	 
	 $(document).on('click','.cut_certification',function(){
 		$(this).parent('.super-admin-add-relation').remove();
 	 });
</script>
 
@endsection
