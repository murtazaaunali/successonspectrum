@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<!--<h6>{{ $Employee->fullname }}</h6>
		<p><a href="#">Employee</a> / <a href="#">{{ $Employee->fullname}}</a> / Edit Benefits</p>-->
        <h6>{{ $Employee->personal_name}}</h6>
		<p><a href="#">Employee /</a><a href="#">{{ $Employee->personal_name }} /</a>Edit Benefits</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    <form action="" method="post" id="editBenifits">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >

						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>Benefits Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>

				    	<div class="super-admin-add-relation-main">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Desired Pay<span class="required-field">*</span></label>
						    		<input type="text" name="desired_pay" value="{{ $Employee->career_desired_pay }}">
						    		<label class="error error1" for="desired_pay"></label>
					    		</figure>
                                <figure>
						    		<label>Starting Pay Rate (Yearly)<span class="required-field">*</span></label>
						    		<!--<input type="text" name="starting_pay" value="{{ $Employee->starting_pay_rate }}">-->
                                    <input type="text" name="starting_pay" value="{{ $Employee->career_starting_pay }}">
						    		<label class="error error1" for="starting_pay"></label>
					    		</figure>
					    		<figure>
						    		<label>Current Pay Rate (Yearly)<span class="required-field">*</span></label>
						    		<!--<input type="text" name="current_pay" value="{{ $Employee->current_pay_rate }}">-->
                                    <input type="text" name="current_pay" value="{{ $Employee->career_current_pay }}">
						    		<label class="error error1" for="current_pay"></label>
						    	</figure>
						    	<div class="radio-btun">
						    		<figure>	
							    		<label>Enrolled in Company's Health<br> Insurace Plan</label>
							    		<!--<input type="radio" value="Yes" name="insurance_plan" @if($Employee->insurance_plan == 'Yes') checked="" @endif ><span>Yes</span>
							    		<input type="radio" value="No" name="insurance_plan" @if($Employee->insurance_plan == 'No') checked="" @endif><span>No</span>-->
                                        <input type="radio" value="Yes" name="insurance_plan" @if($Employee->career_insurance_plan == 'Yes') checked="" @endif ><span>Yes</span>
							    		<input type="radio" value="No" name="insurance_plan" @if($Employee->career_insurance_plan == 'No') checked="" @endif><span>No</span>
						    		</figure>
						    	</div>
						    	<div class="radio-btun">
						    		<figure>	
							    		<label>Enrolled in Company's<span class="required-field">*</span><br> Retirement Plan</label>
							    		<!--<input type="radio" value="Yes" name="retirement_plan" @if($Employee->retirement_plan == 'Yes') checked="" @endif ><span>Yes</span>
							    		<input type="radio" value="No" name="retirement_plan" @if($Employee->retirement_plan == 'No') checked="" @endif ><span>No</span>-->
                                        <input type="radio" value="Yes" name="retirement_plan" @if($Employee->career_retirement_plan == 'Yes') checked="" @endif ><span>Yes</span>
							    		<input type="radio" value="No" name="retirement_plan" @if($Employee->career_retirement_plan == 'No') checked="" @endif ><span>No</span>
						    		</figure>
						    	</div>
				    			<figure>
						    		<label>Paid Vacation Per Year<span class="required-field">*</span></label>
						    		<!--<input type="text" name="paid_vacation" value="{{ $Employee->paid_vacation }}">-->
                                    <input type="text" name="paid_vacation" value="{{ $Employee->career_paid_vacation }}">
						    		<label class="error error1" for="paid_vacation"></label>
					    		</figure>
					    		<figure>
						    		<label>Paid Holidays Per Year<span class="required-field">*</span></label>
						    		<!--<input type="text" name="paid_holidays" value="{{ $Employee->paid_holiday }}">-->
                                    <input type="text" name="paid_holidays" value="{{ $Employee->career_paid_holiday }}">
						    		<label class="error error1" for="paid_holidays"></label>
						    	</figure>
						    	<figure>	
						    		<label>Allowed Unexcused Sick<span class="required-field">*</span> Leaves</label>
						    		<!--<input type="text" name="sick_leaves" value="{{ $Employee->allowed_sick_leaves }}">-->
                                    <input type="text" name="sick_leaves" value="{{ $Employee->career_allowed_sick_leaves }}">
						    		<label class="error error1" for="sick_leaves"></label>
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

		jQuery.validator.addMethod("descimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");
    	
		$("#editBenifits").validate({
			rules:{
				desired_pay:{required:true, number:true, descimalPlaces:true},
				starting_pay:{required:true, number:true, descimalPlaces:true},
				current_pay:{required:true, number:true, descimalPlaces:true},
				insurance_plan:{required:true},
				retirement_plan:{required:true},
				paid_vacation:{required:true, digits:true, maxlength:2},
				paid_holidays:{required:true, digits:true, maxlength:2},
				sick_leaves:{required:true, digits:true, maxlength:2},
			},
		});

	});
	 
</script>
 
@endsection
