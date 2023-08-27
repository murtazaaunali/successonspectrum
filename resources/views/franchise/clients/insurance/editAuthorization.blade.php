@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client</a> / <a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }}</a> @if(!empty($ClientInsurancePolicy->client_insurancename))/ <a href="{{ url('franchise/client/viewinsurance/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}">{{ $ClientInsurancePolicy->client_insurancename }}</a> /@endif Edit Authorization</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    	<form action="" method="post" id="editAuthorization">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Authorization Details</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure class="pos-rel">
					    		<label>Start Date<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsstartdate" value="@if($ClientInsurancePolicyAuthorization->client_authorizationsstartdate != "" && $ClientInsurancePolicyAuthorization->client_authorizationsstartdate != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicyAuthorization->client_authorizationsstartdate)) }}@endif" id="client_authorizationsstartdate" placeholder="mm/dd/yy" class="client_authorizationsstartdate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsstartdate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationsstartdate"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>End Date<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationseenddate" value="@if($ClientInsurancePolicyAuthorization->client_authorizationseenddate != "" && $ClientInsurancePolicyAuthorization->client_authorizationseenddate != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicyAuthorization->client_authorizationseenddate)) }}@endif" id="client_authorizationseenddate" placeholder="mm/dd/yy" class="client_authorizationseenddate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationseenddate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationseenddate"></label>
					    	</figure>
                            <figure>
                                <label>ABA<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsaba" value="{{ $ClientInsurancePolicyAuthorization->client_authorizationsaba }}">
					    		<label class="error error1" for="client_authorizationsaba"></label>
					    	</figure>
                            <figure>
                                <label>Supervision<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationssupervision" value="{{ $ClientInsurancePolicyAuthorization->client_authorizationssupervision }}">
					    		<label class="error error1" for="client_authorizationssupervision"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Parent Training<span class="required-field">*</span></label>
                                <?php /*?><input type="text" name="client_authorizationsparenttraining" value="@if($ClientInsurancePolicyAuthorization->client_authorizationsparenttraining != "" && $ClientInsurancePolicyAuthorization->client_authorizationsparenttraining != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicyAuthorization->client_authorizationsparenttraining)) }}@endif" id="client_authorizationsparenttraining" placeholder="mm/dd/yy" class="client_authorizationsparenttraining"><?php */?>
                                <input type="text" name="client_authorizationsparenttraining" value="{{ $ClientInsurancePolicyAuthorization->client_authorizationsparenttraining }}" id="client_authorizationsparenttraining">
					    		<?php /*?><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsparenttraining" aria-hidden="true"></i></a><?php */?>
					    		<label class="error error1" for="client_authorizationsparenttraining"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Reassessment<span class="required-field">*</span></label>
                                <?php /*?><input type="text" name="client_authorizationsreassessment" value="@if($ClientInsurancePolicyAuthorization->client_authorizationsreassessment != "" && $ClientInsurancePolicyAuthorization->client_authorizationsreassessment != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicyAuthorization->client_authorizationsreassessment)) }}@endif" id="client_authorizationsreassessment" placeholder="mm/dd/yy" class="client_authorizationsreassessment"><?php */?>
                                <input type="text" name="client_authorizationsreassessment" value="{{ $ClientInsurancePolicyAuthorization->client_authorizationsreassessment }}" id="client_authorizationsreassessment">
					    		<?php /*?><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsreassessment" aria-hidden="true"></i></a><?php */?>
					    		<label class="error error1" for="client_authorizationsreassessment"></label>
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
	$(function () {
		//$('#client_authorizationsstartdate').datetimepicker({
		$('.client_authorizationsstartdate').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var start_date = new Date(selected.date.valueOf());
			var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
			$('#client_authorizationseenddate').datetimepicker('setStartDate', setStartDate);
		});
		
		//$('#client_authorizationseenddate').datetimepicker({
		$('.client_authorizationseenddate').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var end_date = new Date(selected.date.valueOf());
			var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
			$('#client_authorizationsstartdate').datetimepicker('setEndDate', setEndDate);
		});
		
		//$('#client_authorizationsparenttraining').datetimepicker({
		$('.client_authorizationsparenttraining').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_authorizationsreassessment').datetimepicker({
		$('.client_authorizationsreassessment').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
	});

	$(document).ready(function() {
		jQuery.validator.addMethod("validate_email", function(value, element) {
		    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
		        return true;
		    } else {
		        return false;
		    }
		}, "Please enter a valid Email.");
		
		//APLHA NUMERIC VALUES
		jQuery.validator.addMethod("alphanumeric_withspace", function(value, element) {
    	        return this.optional(element) || /^[a-z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	},"Only Alphanumeric charecters are allow.");

		jQuery.validator.addMethod("descimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");
    			
		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");

		jQuery.validator.addMethod("dolarPercent", function(value, element) {
    	        return this.optional(element) || /^[0-9$%.\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");

		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

		$("#editAuthorization").validate({
			rules:{
				client_authorizationsstartdate:{required:true,date:true},
				client_authorizationseenddate:{required:true,date:true},
				client_authorizationsaba:{required:true},
				client_authorizationssupervision:{required:true},
				/*client_authorizationsparenttraining:{required:true,date:true},
				client_authorizationsreassessment:{required:true,date:true},*/
				client_authorizationsparenttraining:{required:true},
				client_authorizationsreassessment:{required:true},
			},
		});
	});

</script>
 
@endsection
