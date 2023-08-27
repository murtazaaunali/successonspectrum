@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client</a> / <a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }}</a> / Edit Insurance</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    	@if($type == 'primarypolicy')
			    	<form action="" method="post" id="editPrimaryPolicy">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Primary Policy</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main">
			    		<div class="super-admin-add-relation border-bot-0">
							<figure>
                                <label>Insurance Name<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancename" value="{{ $ClientInsurancePolicy->client_insurancename }}">
					    		<label class="error error1" for="client_insurancename"></label>
					    	</figure>
                            <figure>
                                <label>Insurance Company Name<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancecompanyname" value="{{ $ClientInsurancePolicy->client_insurancecompanyname }}">
					    		<label class="error error1" for="client_insurancecompanyname"></label>
					    	</figure>
                            <figure>
                                <label>Member ID<span class="required-field">*</span></label>
                                <input type="text" name="client_memberid" value="{{ $ClientInsurancePolicy->client_memberid }}">
					    		<label class="error error1" for="client_memberid"></label>
					    	</figure>
                            <figure>
                                <label>Group ID<span class="required-field">*</span></label>
                                <input type="text" name="client_groupid" value="{{ $ClientInsurancePolicy->client_groupid }}">
					    		<label class="error error1" for="client_groupid"></label>
					    	</figure>
                            <figure>
                                <label>Policyholder's Name (Usually a parent)<span class="required-field">*</span></label>
                                <input type="text" name="client_policyholdersname" value="{{ $ClientInsurancePolicy->client_policyholdersname }}">
					    		<label class="error error1" for="client_policyholdersname"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Policyholder's Date of Birth<span class="required-field">*</span></label>
                                <input type="text" name="client_policyholdersdateofbirth" value="@if($ClientInsurancePolicy->client_policyholdersdateofbirth != "" && $ClientInsurancePolicy->client_policyholdersdateofbirth != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicy->client_policyholdersdateofbirth)) }}@endif" id="client_policyholdersdateofbirth" placeholder="mm/dd/yy" class="client_policyholdersdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);" style="top:15px;"><i class="fa fa-calendar client_policyholdersdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_policyholdersdateofbirth"></label>
					    	</figure>
                            <figure>
                                <label>Client's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_childfullname" value="{{ $Client->client_childfullname }}">
					    		<label class="error error1" for="client_childfullname"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Client's DOB<span class="required-field">*</span></label>
                                <input type="text" name="client_childdateofbirth" value="@if($Client->client_childdateofbirth != "" && $Client->client_childdateofbirth != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_childdateofbirth)) }}@endif" id="client_childdateofbirth" placeholder="mm/dd/yy" class="client_childdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_childdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_childdateofbirth"></label>
					    	</figure>
                            <figure>
                                <label>Client's Address<span class="required-field">*</span></label>
                                <input type="text" name="client_custodialparentsaddress" value="{{ $Client->client_custodialparentsaddress }}">
					    		<label class="error error1" for="client_custodialparentsaddress"></label>
					    	</figure>
                            <figure class="hidden">
                                <label>Subscriber's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_subscribername" value="{{ $ClientInsurancePolicy->client_subscribername }}">
					    		<label class="error error1" for="client_subscribername"></label>
					    	</figure>
                            <figure class="pos-rel hidden">
					    		<label>Subscriber's DOB<span class="required-field">*</span></label>
                                <input type="text" name="client_subscriberdateofbirth" value="@if($ClientInsurancePolicy->client_subscriberdateofbirth != "" && $ClientInsurancePolicy->client_subscriberdateofbirth != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicy->client_subscriberdateofbirth)) }}@endif" id="client_subscriberdateofbirth" placeholder="mm/dd/yy" class="client_subscriberdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_subscriberdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_subscriberdateofbirth"></label>
					    	</figure>
			    		</div>	
			    	</div>
			    	</form>
                	@endif
                    
                    @if($type == 'benefits')
			    	<form action="" method="post" id="editBenefits">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Benefits</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure class="pos-rel">
					    		<label>Effective Date<span class="required-field">*</span></label>
                                <input type="text" name="client_benefiteffectivedate" value="@if($ClientInsurancePolicy->client_benefiteffectivedate != "" && $ClientInsurancePolicy->client_benefiteffectivedate != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicy->client_benefiteffectivedate)) }}@endif" id="client_benefiteffectivedate" placeholder="mm/dd/yy" class="client_benefiteffectivedate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefiteffectivedate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefiteffectivedate"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Expiration Date<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitexpirationdate" value="@if($ClientInsurancePolicy->client_benefitexpirationdate != "" && $ClientInsurancePolicy->client_benefitexpirationdate != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicy->client_benefitexpirationdate)) }}@endif" id="client_benefitexpirationdate" placeholder="mm/dd/yy" class="client_benefitexpirationdate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefitexpirationdate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefitexpirationdate"></label>
					    	</figure>
                            <figure>
                                <label>Copay<span class="required-field">*</span></label>

                                <select class="copay_type" name="copay_type">
                                	<option @if(strpos($ClientInsurancePolicy->client_benefitcopay,'$') !== false) selected="" @endif>$</option>
                                	<option @if(strpos($ClientInsurancePolicy->client_benefitcopay,'%') !== false) selected="" @endif>%</option>
                                </select>
                                <input type="text" name="client_benefitcopay" class="copay_input" value="{{ str_replace(array('$','%'),'', $ClientInsurancePolicy->client_benefitcopay) }}">
					    		<label class="error error1" for="client_benefitcopay"></label>
					    	</figure>
                            <figure>
                                <label>OOPM<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitoopm" value="{{ $ClientInsurancePolicy->client_benefitoopm }}">
					    		<label class="error error1" for="client_benefitoopm"></label>
					    	</figure>
                            <figure>
                                <label>Annual Max Benefit<span class="required-field">*</span></label>
                                <select class="benefit_type" name="benefit_type">
                                	<option @if(strpos($ClientInsurancePolicy->client_benefitannualbenefit,'$') !== false) selected="" @endif>$</option>
                                	<option @if(strpos($ClientInsurancePolicy->client_benefitannualbenefit,'%') !== false) selected="" @endif>%</option>
                                </select>
                                <input type="text" name="client_benefitannualbenefit" class="benefit_input" value="{{ str_replace(array('$','%'),'', $ClientInsurancePolicy->client_benefitannualbenefit) }}">
					    		<label class="error error1" for="client_benefitannualbenefit"></label>
					    	</figure>
                            <figure>
                                <label>Claim's Address<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitclaimaddress" value="{{ $ClientInsurancePolicy->client_benefitclaimaddress }}">
					    		<label class="error error1" for="client_benefitclaimaddress"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Date Verified<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitdateverified" value="@if($ClientInsurancePolicy->client_benefitdateverified != "" && $ClientInsurancePolicy->client_benefitdateverified != '0000-00-00'){{ date("m/d/Y",strtotime($ClientInsurancePolicy->client_benefitdateverified)) }}@endif" id="client_benefitdateverified" placeholder="mm/dd/yy" class="client_benefitdateverified">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefitdateverified" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefitdateverified"></label>
					    	</figure>
                            <figure>
                                <label>Insurance Employee<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitinsuranceemployee" value="{{ $ClientInsurancePolicy->client_benefitinsuranceemployee }}">
					    		<label class="error error1" for="client_benefitinsuranceemployee"></label>
					    	</figure>
                            <figure>	
					    		<label>Reference Number<span class="required-field">*</span></label>
                                <input type="phone" name="client_benefitreferencenumber" value="{{ $ClientInsurancePolicy->client_benefitreferencenumber }}" placeholder="xxx-xxx-xxxx">
					    		<label class="error error1" for="client_benefitreferencenumber"></label>
					    	</figure>
			    		</div>	
			    	</div>
			    	</form>
                	@endif
                    
                    @if($type == 'authorizations')
			    	<form action="" method="post" id="editAuthorizations">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Authorizations</h3>
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
                                <input type="text" name="client_authorizationsstartdate" value="@if($Client->client_authorizationsstartdate != "" && $Client->client_authorizationsstartdate != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_authorizationsstartdate)) }}@endif" id="client_authorizationsstartdate" placeholder="mm/dd/yy" class="client_authorizationsstartdate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsstartdate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationsstartdate"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>End Date<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationseenddate" value="@if($Client->client_authorizationseenddate != "" && $Client->client_authorizationseenddate != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_authorizationseenddate)) }}@endif" id="client_authorizationseenddate" placeholder="mm/dd/yy" class="client_authorizationseenddate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationseenddate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationseenddate"></label>
					    	</figure>
                            <figure>
                                <label>ABA<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsaba" value="{{ $Client->client_authorizationsaba }}">
					    		<label class="error error1" for="client_authorizationsaba"></label>
					    	</figure>
                            <figure>
                                <label>Supervision<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationssupervision" value="{{ $Client->client_authorizationssupervision }}">
					    		<label class="error error1" for="client_authorizationssupervision"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Parent Training<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsparenttraining" value="@if($Client->client_authorizationsparenttraining != "" && $Client->client_authorizationsparenttraining != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_authorizationsparenttraining)) }}@endif" id="client_authorizationsparenttraining" placeholder="mm/dd/yy" class="client_authorizationsparenttraining">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsparenttraining" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationsparenttraining"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Reassessment<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsreassessment" value="@if($Client->client_authorizationsreassessment != "" && $Client->client_authorizationsreassessment != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_authorizationsreassessment)) }}@endif" id="client_authorizationsreassessment" placeholder="mm/dd/yy" class="client_authorizationsreassessment">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsreassessment" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationsreassessment"></label>
					    	</figure>
			    		</div>	
			    	</div>
			    	</form>
                	@endif
			    </div>
			</div>
		</div>
		<!-- header-bottom-sec -->
	</div>	



<script type="text/javascript">
	$(function () {
		//$('#client_childdateofbirth').datetimepicker({
		$('.client_childdateofbirth').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_subscriberdateofbirth').datetimepicker({
		$('.client_subscriberdateofbirth').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_policyholdersdateofbirth').datetimepicker({
		$('.client_policyholdersdateofbirth').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_benefiteffectivedate').datetimepicker({
		$('.client_benefiteffectivedate').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_benefitexpirationdate').datetimepicker({
		$('.client_benefitexpirationdate').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_benefitdateverified').datetimepicker({
		$('.client_benefitdateverified').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
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
		//$('input[name=client_benefitreferencenumber]').samask("000-000-0000");
		
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

		$("#editPrimaryPolicy").validate({
			rules:{
				client_insurancecompanyname:{required:true,nameRegex:true},
				client_memberid:{required:true},
				client_groupid:{required:true},
				client_policyholdersname:{required:true},
				client_policyholdersdateofbirth:{required:true,date:true},
				client_childfullname:{required:true,nameRegex:true},
				client_childdateofbirth:{required:true,date:true},
				client_custodialparentsaddress:{required:true},
				/*client_subscribername:{required:true,nameRegex:true},
				client_subscriberdateofbirth:{required:true,date:true},*/
			},
		});
		
		$("#editBenefits").validate({
			rules:{
				client_benefiteffectivedate:{required:true,date:true},
				client_benefitexpirationdate:{required:true,date:true},
				client_benefitcopay:{required:true, descimalPlaces:true},
				client_benefitoopm:{required:true},
				client_benefitannualbenefit:{required:true, descimalPlaces:true},
				client_benefitclaimaddress:{required:true},
				client_benefitdateverified:{required:true,date:true},
				client_benefitinsuranceemployee:{required:true,nameRegex:true},
				client_benefitreferencenumber:{required:true, alphanumeric_withspace:true},
			},
		});
		
		$("#editAuthorizations").validate({
			rules:{
				client_authorizationsstartdate:{required:true,date:true},
				client_authorizationseenddate:{required:true,date:true},
				client_authorizationsaba:{required:true},
				client_authorizationssupervision:{required:true},
				client_authorizationsparenttraining:{required:true,date:true},
				client_authorizationsreassessment:{required:true,date:true},
			},
		});
	});

</script>
 
@endsection
