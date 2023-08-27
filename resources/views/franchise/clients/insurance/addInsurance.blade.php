@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client</a> / <a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }}</a> / Add Insurance</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    	<form action="{{ url('franchise/client/storeinsurance/'.$Client->id) }}" method="post" id="addInsurancePolicy" enctype="multipart/form-data">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Insurance Details</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Insurance</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main" style="padding-bottom:0px;">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure>
                                <label>Insurance Name<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancename" value="">
					    		<label class="error error1" for="client_insurancename"></label>
					    	</figure>
                            <figure>
                                <label>Insurance Payer Id<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancepayerid" value="" maxlength="8">
					    		<label class="error error1" for="client_insurancepayerid"></label>
					    	</figure>
                            <figure class="hidden">
                                <label>Insurance Company Name<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancecompanyname" value="">
					    		<label class="error error1" for="client_insurancecompanyname"></label>
					    	</figure>
                            <figure>
                                <label>Insurance Phone Number<span class="required-field">*</span></label>
                                <input type="text" name="client_insurancephone_number" value="">
					    		<label class="error error1" for="client_insurancephone_number"></label>
					    	</figure>
                            <figure>
                            	<label>Insurance Company ID Card<span class="required-field">*</span></label>
                                <div class="upload-box-main upload_client_insurancecompanyidcard" style="width:65%; padding: 25px 20px;float:right">
                                    <div class="drop">
                                        <div class="cont">
                                            <div class="upload-icon">
                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                            </div>
                                            <div class="upload-para">
                                                <p>click here to upload Insurance ID<span class="required-field">*</span></p>
                                            </div>
                                            <input id="client_insurancecompanyidcard" name="client_insurancecompanyidcard" type="file" accept="image/*" />
                                            <div class="file-upload">
                                                <div class="file-select-name noFile"></div> 
                                            </div>
                                        </div>
                                        <label class="error" for="client_insurancecompanyidcard"></label>
                                    </div>
                                </div>
                                <div class="hidden">
                                	<input id="client_insurancecompanyidcard" name="client_insurancecompanyidcard" type="file" accept="image/*" />
                            	</div>
                            </figure>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <figure>
                                <label>Member ID<span class="required-field">*</span></label>
                                <input type="text" name="client_memberid" value="">
					    		<label class="error error1" for="client_memberid"></label>
					    	</figure>
                            <figure>
                                <label>Group ID<span class="required-field">*</span></label>
                                <input type="text" name="client_groupid" value="">
					    		<label class="error error1" for="client_groupid"></label>
					    	</figure>
                            <figure>
                                <label>Policyholder's Name (Usually a parent)<span class="required-field">*</span></label>
                                <input type="text" name="client_policyholdersname" value="">
					    		<label class="error error1" for="client_policyholdersname"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Policyholder's Date of Birth<span class="required-field">*</span></label>
                                <input type="text" name="client_policyholdersdateofbirth" value="" id="client_policyholdersdateofbirth" placeholder="mm/dd/yy" class="client_policyholdersdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);" style="top:15px;"><i class="fa fa-calendar client_policyholdersdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_policyholdersdateofbirth"></label>
					    	</figure>
                            <figure class="hidden">
                                <label>Subscriber's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_subscribername" value="">
					    		<label class="error error1" for="client_subscribername"></label>
					    	</figure>
                            <figure class="pos-rel hidden">
					    		<label>Subscriber's DOB<span class="required-field">*</span></label>
                                <input type="text" name="client_subscriberdateofbirth" value="" id="client_subscriberdateofbirth" placeholder="mm/dd/yy" class="client_subscriberdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_subscriberdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_subscriberdateofbirth"></label>
					    	</figure>
			    		</div>
			    	</div>
                    
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3" >
			    		<div class="view-tab-content-head">
			    			<h3>Benefits</h3>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main" style="padding-bottom:0px;">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure class="pos-rel">
					    		<label>Effective Date<span class="required-field">*</span></label>
                                <input type="text" name="client_benefiteffectivedate" value="" id="client_benefiteffectivedate" placeholder="mm/dd/yy" class="client_benefiteffectivedate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefiteffectivedate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefiteffectivedate"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Expiration Date<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitexpirationdate" value="" id="client_benefitexpirationdate" placeholder="mm/dd/yy" class="client_benefitexpirationdate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefitexpirationdate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefitexpirationdate"></label>
					    	</figure>
                            <figure>
                                <label>Copay<span class="required-field">*</span></label>

                                <select class="copay_type" name="copay_type">
                                	<option>$</option>
                                	<option>%</option>
                                </select>
                                <input type="text" name="client_benefitcopay" class="copay_input" value="">
					    		<label class="error error1" for="client_benefitcopay"></label>
					    	</figure>
                            <figure>
                                <label>OOPM<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitoopm" value="">
					    		<label class="error error1" for="client_benefitoopm"></label>
					    	</figure>
                            <figure>
                                <label>Annual Max Benefit<span class="required-field">*</span></label>
                                <select class="benefit_type" name="benefit_type">
                                	<option>$</option>
                                	<option>%</option>
                                </select>
                                <input type="text" name="client_benefitannualbenefit" class="benefit_input" value="">
					    		<label class="error error1" for="client_benefitannualbenefit"></label>
					    	</figure>
                            <figure>
                                <label>Claim's Address<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitclaimaddress" value="">
					    		<label class="error error1" for="client_benefitclaimaddress"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Date Verified<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitdateverified" value="" id="client_benefitdateverified" placeholder="mm/dd/yy" class="client_benefitdateverified">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_benefitdateverified" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_benefitdateverified"></label>
					    	</figure>
                            <figure>
                                <label>Insurance Employee<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitinsuranceemployee" value="">
					    		<label class="error error1" for="client_benefitinsuranceemployee"></label>
					    	</figure>
                            <figure>	
					    		<label>Reference Number<span class="required-field">*</span></label>
                                <input type="text" name="client_benefitreferencenumber" value="">
					    		<label class="error error1" for="client_benefitreferencenumber"></label>
					    	</figure>
			    		</div>	
			    	</div>
                    
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Authorizations</h3>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main" style="padding-bottom:0px;">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure class="pos-rel">
					    		<label>Start Date<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsstartdate" value="" id="client_authorizationsstartdate" placeholder="mm/dd/yy" class="client_authorizationsstartdate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsstartdate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationsstartdate"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>End Date<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationseenddate" value="" id="client_authorizationseenddate" placeholder="mm/dd/yy" class="client_authorizationseenddate">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationseenddate" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_authorizationseenddate"></label>
					    	</figure>
                            <figure>
                                <label>ABA<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationsaba" value="">
					    		<label class="error error1" for="client_authorizationsaba"></label>
					    	</figure>
                            <figure>
                                <label>Supervision<span class="required-field">*</span></label>
                                <input type="text" name="client_authorizationssupervision" value="">
					    		<label class="error error1" for="client_authorizationssupervision"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Parent Training<span class="required-field">*</span></label>
                                <?php /*?><input type="text" name="client_authorizationsparenttraining" value="" id="client_authorizationsparenttraining" placeholder="mm/dd/yy" class="client_authorizationsparenttraining"><?php */?>
                                <input type="text" name="client_authorizationsparenttraining" value="" id="client_authorizationsparenttraining">
					    		<?php /*?><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_authorizationsparenttraining" aria-hidden="true"></i></a><?php */?>
					    		<label class="error error1" for="client_authorizationsparenttraining"></label>
					    	</figure>
                            <figure class="pos-rel">
					    		<label>Reassessment<span class="required-field">*</span></label>
                                <?php /*?><input type="text" name="client_authorizationsreassessment" value="" id="client_authorizationsreassessment" placeholder="mm/dd/yy" class="client_authorizationsreassessment"><?php */?>
                                <input type="text" name="client_authorizationsreassessment" value="" id="client_authorizationsreassessment">
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
		/*$('#client_subscriberdateofbirth').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});*/
		
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
		
		$('input[name=client_insurancephone_number]').inputmask({"mask": "999-999-9999"});
		
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

		$("#addInsurancePolicy").validate({
			rules:{
				client_insurancename:{required:true,nameRegex:true},
				client_insurancepayerid:{required:true,number:true},
				//client_insurancecompanyname:{required:true,nameRegex:true},
				client_insurancephone_number:{required:true,phoneUS:true, usphonenumb:true},
				client_memberid:{required:true},
				client_groupid:{required:true},
				client_policyholdersname:{required:true},
				client_policyholdersdateofbirth:{required:true,date:true},
				/*client_subscribername:{required:true,nameRegex:true},
				client_subscriberdateofbirth:{required:true,date:true},*/
				client_benefiteffectivedate:{required:true,date:true},
				client_benefitexpirationdate:{required:true,date:true},
				client_benefitcopay:{required:true, descimalPlaces:true},
				client_benefitoopm:{required:true},
				client_benefitannualbenefit:{required:true, descimalPlaces:true},
				client_benefitclaimaddress:{required:true},
				client_benefitdateverified:{required:true,date:true},
				client_benefitinsuranceemployee:{required:true,nameRegex:true},
				client_benefitreferencenumber:{required:true, alphanumeric_withspace:true},
				client_authorizationsstartdate:{required:true,date:true},
				client_authorizationseenddate:{required:true,date:true},
				client_authorizationsaba:{required:true},
				client_authorizationssupervision:{required:true},
				/*client_authorizationsparenttraining:{required:true,date:true},
				client_authorizationsreassessment:{required:true,date:true},*/
				client_authorizationsparenttraining:{required:true},
				client_authorizationsreassessment:{required:true},
			},
			messages:{
			  client_insurancephone_number:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			}	
		});
		
		$('.upload_client_insurancecompanyidcard').click(function () {
		  $('input[name="client_insurancecompanyidcard"]').click();
		});
		
		function handleFileSelect(evt) {
		  var files = evt.target.files;
		  for (var i = 0, f; f = files[i]; i++) {
	
			var filename = $(this).val();
					if (/^\s*$/.test(filename)) {
						$(".file-upload").removeClass('active');
						$(this).parent('div').find(".noFile").text(""); 
					}
					else {
						$(".file-upload").addClass('active');
						$(this).parent('div').find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
					}
	
			var reader = new FileReader();
			reader.onload = (function(theFile) {
			  return function(e) {
			  };
			})(f);
			reader.readAsDataURL(f);
		  }
		}
		$('input[name="client_insurancecompanyidcard"]').change(handleFileSelect);
	});

</script>
 
@endsection
