@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client /</a><a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }} /</a>Edit Medical Information</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    	<form action="" method="post" id="editMedicalInformation">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Medical Information</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main">
			    		<div class="super-admin-add-relation border-bot-0">
				    		<figure>
                                <label class="vartical-top"><!--Describe the age and symptoms that were first noticed-->First Symptoms<span class="required-field">*</span></label>
                                <textarea type="text" name="client_ageandsymtoms" cols="40" rows="5">{{ $Client->client_ageandsymtoms }}</textarea>
					    		<label class="error error1" for="client_ageandsymtoms"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Date of Autism Diagnosis<span class="required-field">*</span></label>
                                <input type="text" name="client_dateofautism" value="@if($Client->client_dateofautism != "" && $Client->client_dateofautism != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_dateofautism)) }}@endif" id="client_dateofautism" placeholder="mm/dd/yy" class="client_dateofautism">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_dateofautism" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_dateofautism"></label>
					    	</figure>
                            <figure>
                                <label>Diagnosing Doctor<span class="required-field">*</span></label>
                                <input type="text" name="client_diagnosingdoctor" value="{{ $Client->client_diagnosingdoctor }}">
					    		<label class="error error1" for="client_diagnosingdoctor"></label>
					    	</figure>
					    	<figure>	
					    		<label>Primary Diagnosis<span class="required-field">*</span></label>
                                <input type="text" name="client_primarydiagnosis" value="{{ $Client->client_primarydiagnosis }}">
					    		<label class="error error1" for="client_primarydiagnosis"></label>
					    	</figure>
                            <figure>	
					    		<label>Secondary Diagnosis, if any</label>
                                <input type="text" name="client_secondarydiagnosis" value="{{ $Client->client_secondarydiagnosis }}">
					    		<label class="error error1" for="client_secondarydiagnosis"></label>
					    	</figure>
                            <figure>	
					    		<label class="vartical-top">List Child's Current Medications and Doses<span class="required-field">*</span></label>
                                <textarea type="text" name="client_childcurrentmedications" cols="40" rows="5">{{ $Client->client_childcurrentmedications }}</textarea>
					    		<label class="error error1" for="client_childcurrentmedications"></label>
					    	</figure>
                            <figure>	
					    		<label class="vartical-top">List any allergies Or food restrictions</label>
                                <textarea type="text" name="client_allergies" cols="40" rows="5">{{ $Client->client_allergies }}</textarea>
					    		<label class="error error1" for="client_allergies"></label>
					    	</figure>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Has your Child ever received ABA before?</label>
                                    <input type="radio" value="Yes" name="client_aba" @if($Client->client_aba == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="No" name="client_aba" @if($Client->client_aba == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="client-aba-fields-append w-100">
                            @php $facility_count = 0; @endphp
                            @if($Client->client_aba_facilities != "")
                            @php
                            $client_aba_facilities = unserialize($Client->client_aba_facilities);
                            @endphp
                            @foreach($client_aba_facilities as $key=>$client_aba_facility)
                            <div class="super-admin-add-relation client-aba-fields mar-top-20px w-100" style="border-bottom: 1px #e3e7ec solid">
                                @if($facility_count != 0)<i class="fa fa-times cut_relation cut-client-aba-fields"></i>@endif
                                <figure>	
                                    <label>If yes, which facility?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_facility]" value="{{ $client_aba_facility['client_facility'] }}" class="client_aba_facility">
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_facility]"></label>
                                </figure>
                                <figure class="pos-rel">
                                    <label>What year did they start?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_start]" value="@if($client_aba_facility['client_start'] != "" && $client_aba_facility['client_start'] != '0000-00-00'){{ date("m/d/Y",strtotime($client_aba_facility['client_start'])) }}@endif" placeholder="mm/dd/yy" class="client_aba_start">
                                    <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_start" aria-hidden="true"></i></a>
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_start]"></label>
                                </figure>
                                <figure class="pos-rel">
                                    <label>What year did they finish?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_end]" value="@if($client_aba_facility['client_end'] != "" && $client_aba_facility['client_end'] != '0000-00-00'){{ date("m/d/Y",strtotime($client_aba_facility['client_end'])) }}@endif" placeholder="mm/dd/yy" class="client_aba_end">
                                    <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_end" aria-hidden="true"></i></a>
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_end]"></label>
                                </figure>
                                <figure>	
                                    <label>How many hours of ABA did they receive per week<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_hours]" value="{{ $client_aba_facility['client_hours'] }}" class="client_aba_hours">
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_hours]"></label>
                                </figure>
                            </div>
                            <script>$(function(){loadClientABACalendersFields('{{ $facility_count }}');});</script>
                            @php $facility_count ++; @endphp
                            @endforeach
                            @else
                            <div class="super-admin-add-relation w-100">
                                <figure>	
                                    <label>If yes, which facility?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_facility]" class="client_aba_facility">
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_facility]"></label>
                                </figure>
                                <figure class="pos-rel">
                                    <label>What year did they start?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_start]" class="client_aba_start" placeholder="mm/dd/yy" >
                                    <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_start" aria-hidden="true"></i></a>
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_start]"></label>
                                </figure>
                                <figure class="pos-rel">
                                    <label>What year did they finish?<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_end]" class="client_aba_end" placeholder="mm/dd/yy" >
                                    <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_end" aria-hidden="true"></i></a>
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_end]"></label>
                                </figure>
                                <figure>	
                                    <label>How many hours of ABA did they receive per week<span class="required-field">*</span></label>
                                    <input type="text" name="client_aba_data[{{ $facility_count }}][client_hours]" class="client_aba_hours">
                                    <label class="error error1" for="client_aba_data[{{ $facility_count }}][client_hours]"></label>
                                </figure>
                            </div>
                            <script>$(function(){loadClientABACalendersFields('{{ $facility_count }}');});</script>
                            @php $facility_count ++; @endphp
                            @endif
                            </div>
                            <figure class="add-client-aba-fields-action-container">	
                                <label></label>
                                <input class="btn add-relation-dashed add-client-aba-fields @if($Client->client_aba == 'Yes') hidden @endif" type="button" value="+ Add">
                            </figure>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Is your child currently in Speech Therapy?</label>
                                    <input type="radio" value="Yes" name="client_speechtherapy" @if($Client->client_speechtherapy == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="No" name="client_speechtherapy" @if($Client->client_speechtherapy == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure>	
					    		<label>Institution<span class="required-field">*</span></label>
                                <input type="text" name="client_speechinstitution" value="{{ $Client->client_speechinstitution }}">
					    		<label class="error error1" for="client_speechinstitution"></label>
					    	</figure>
                            <figure>	
					    		<label>Hours Per Week<span class="required-field">*</span></label>
                                <input type="text" name="client_speechhoursweek" value="{{ $Client->client_speechhoursweek }}">
					    		<label class="error error1" for="client_speechhoursweek"></label>
					    	</figure>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Is your child currently in Occupational Therapy?</label>
                                    <input type="radio" value="Yes" name="client_occupationaltherapy" @if($Client->client_occupationaltherapy == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="No" name="client_occupationaltherapy" @if($Client->client_occupationaltherapy == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure>	
					    		<label>Institution<span class="required-field">*</span></label>
                                <input type="text" name="client_occupationalinstitution" value="{{ $Client->client_occupationalinstitution }}">
					    		<label class="error error1" for="client_occupationalinstitution"></label>
					    	</figure>
                            <figure>	
					    		<label>Hours Per Week<span class="required-field">*</span></label>
                                <input type="text" name="client_occupationalhoursweek" value="{{ $Client->client_occupationalhoursweek }}">
					    		<label class="error error1" for="client_occupationalhoursweek"></label>
					    	</figure>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Does your child attend school?</label>
                                    <input type="radio" value="Yes" name="client_childattendschool" @if($Client->client_childattendschool == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="No" name="client_childattendschool" @if($Client->client_childattendschool == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure>	
                                <label>Name of School<span class="required-field">*</span></label>
                                <input type="text" name="client_schoolname" value="{{ $Client->client_schoolname }}">
					    		<label class="error error1" for="client_schoolname"></label>
                            </figure>
                            <div class="radio-btun">
                                <figure>	
                                    <label>If so, are they in a special needs class?</label>
                                    <input type="radio" value="Yes" name="client_specialclass" @if($Client->client_specialclass == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="No" name="client_specialclass" @if($Client->client_specialclass == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="hidden">	
                                <label>Medication</label>
                                <input type="text" name="client_medicalmedication" value="{{ $Client->client_medicalmedication }}">
					    		<label class="error error1" for="client_medicalmedication"></label>
                            </figure>
                            <figure class="hidden">	
                                <label class="vartical-top">ABA History</label>
                                <textarea type="text" name="client_medicalabahistory" cols="40" rows="5">{{ $Client->client_medicalabahistory }}</textarea>
					    		<label class="error error1" for="client_medicalabahistory"></label>
                            </figure>
                            <figure class="pos-rel">
					    		<label>Last Vision Exam<span class="required-field">*</span></label>
                                <input type="text" name="client_medicallastvisionexam" value="@if($Client->client_medicallastvisionexam != "" && $Client->client_medicallastvisionexam != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_medicallastvisionexam)) }}@endif" id="client_medicallastvisionexam" placeholder="mm/dd/yy" class="client_medicallastvisionexam">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_medicallastvisionexam" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_medicallastvisionexam"></label>
					    	</figure>
                            <figure class="hidden">	
                                <label>How Many Hours of ABA Did They Receive Per Week</label>
                                <input type="text" name="client_medicalabahoursperweek" value="{{ $Client->client_medicalabahoursperweek }}">
					    		<label class="error error1" for="client_medicalabahoursperweek"></label>
                            </figure>
                            <figure class="hidden">	
                                <label>Tool Used</label>
                                <input type="text" name="client_medicaltoolused" value="{{ $Client->client_medicaltoolused }}">
					    		<label class="error error1" for="client_medicaltoolused"></label>
                            </figure>
                            <figure class="hidden">
                                <label>Phone Number</label>
                                <input type="phone" name="client_medicalphonenumber" value="{{ $Client->client_medicalphonenumber }}">
					    		<label class="error error1" for="client_medicalphonenumber"></label>
                            </figure>
                            <figure class="hidden">	
                                <label>Fax Number</label>
                                <input type="phone" name="client_medicalfaxnumber" value="{{ $Client->client_medicalfaxnumber }}">
					    		<label class="error error1" for="client_medicalfaxnumber"></label>
                            </figure>
                            <figure class="hidden">
                                <label>Address</label>
                                <input type="phone" name="client_medicaladdress" value="{{ $Client->client_medicaladdress }}">
					    		<label class="error error1" for="client_medicaladdress"></label>
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
		//$('#client_dateofautism').datetimepicker({
		$('.client_dateofautism').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
		
		//$('#client_medicallastvisionexam').datetimepicker({
		$('.client_medicallastvisionexam').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});
	});

	$(document).ready(function() {
		/*$('input[name=client_medicalfaxnumber]').samask("000-000-0000");
		$('input[name=client_medicalphonenumber]').samask("000-000-0000");*/
		$('input[name=client_medicalfaxnumber]').inputmask({"mask": "999-999-9999"});
		$('input[name=client_medicalphonenumber]').inputmask({"mask": "999-999-9999"});
		
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
		
		$("#editMedicalInformation").validate({
			rules:{
				client_ageandsymtoms:{required:true},
				client_dateofautism:{required:true,date:true},
				client_diagnosingdoctor:{required:true},
				client_primarydiagnosis:{required:true},
				
				client_childcurrentmedications:{required:true},
				//client_medicalphonenumber:{ phoneUS:true, usphonenumb:true},
				//client_medicalfaxnumber:{phoneUS:true, usphonenumb:true},

			},
			messages:{
			  //client_medicalphonenumber:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			  //client_medicalfaxnumber:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			}				
		});
		
		checkClientABARadioOption();
		$('input[name=client_aba]').click(function(){
			checkClientABARadioOption();
		});
		
		checkClientSpeechTherapyRadioOption();
		$('input[name=client_speechtherapy]').click(function(){
			checkClientSpeechTherapyRadioOption();
		});
		
		checkClientOccupationalTherapyRadioOption();
		$('input[name=client_occupationaltherapy]').click(function(){
			checkClientOccupationalTherapyRadioOption();
		});
		
		checkChildsAttendSchoolRadioOption();
		$('input[name=client_childattendschool]').click(function(){
			checkChildsAttendSchoolRadioOption();
		});
		
		//ADD EXPERIENCE/REFERENCE 
		var facility_count = '{{ $facility_count }}';
		$('.add-client-aba-fields').click(function(){
			var Html = '<div class="super-admin-add-relation client-aba-fields mar-top-20px w-100" style="border-bottom: 1px #e3e7ec solid">';
			Html +=	'<i class="fa fa-times cut_relation cut-client-aba-fields"></i>';
			Html +=	'<figure><label>If yes, which facility?<span class="required-field">*</span></label><input name="client_aba_data['+facility_count+'][client_facility]" type="text" class="client_aba_facility"><label class="error error1" for="client_aba_data['+facility_count+'][client_facility]"></label></figure>';
			Html +=	'<figure class="pos-rel"><label>What year did they start?<span class="required-field">*</span></label><input name="client_aba_data['+facility_count+'][client_start]" type="text" placeholder="mm/dd/yy" class="client_aba_start"><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_start" aria-hidden="true"></i></a><label class="error error1" for="client_aba_data['+facility_count+'][client_start]"></label></figure>';
			Html +=	'<figure class="pos-rel"><label>What year did they finish?<span class="required-field">*</span></label><input name="client_aba_data['+facility_count+'][client_end]" type="text" placeholder="mm/dd/yy" class="client_aba_end"><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_end" aria-hidden="true"></i></a><label class="error error1" for="client_aba_data['+facility_count+'][client_end]"></label></figure>';
			Html +=	'<figure><label>How many hours of ABA did they receive per week<span class="required-field">*</span></label><input name="client_aba_data['+facility_count+'][client_hours]" type="text" class="client_aba_hours"><label class="error error1" for="client_aba_data['+facility_count+'][client_hours]"></label></figure>';
			Html +=	'</div>	';
			$('.client-aba-fields-append').append(Html);
			//$('input[name="client_aba_data['+facility_count+'][client_start]"]').datetimepicker({
			$('.client_aba_start').datetimepicker({
				pickerPosition: 'top-left',
				format: 'mm/dd/yyyy',
				maxView: 4,
				minView: 2,
				autoclose: true,
			}).on('changeDate', function (selected) {
				var start_date = new Date(selected.date.valueOf());
				var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
				$('input[name="client_aba_data['+facility_count+'][client_end]"]').datetimepicker('setStartDate', setStartDate);
			});
			//$('input[name="client_aba_data['+facility_count+'][client_end]"]').datetimepicker({
			$('.client_aba_end').datetimepicker({	
				pickerPosition: 'top-left',
				format: 'mm/dd/yyyy',
				maxView: 4,
				minView: 2,
				autoclose: true,
			}).on('changeDate', function (selected) {
				var end_date = new Date(selected.date.valueOf());
				var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
				$('input[name="client_aba_data['+facility_count+'][client_start]"]').datetimepicker('setEndDate', setEndDate);
			});
			facility_count++;	
		});
		 
		$(document).on('click','.cut-client-aba-fields',function(){
			$(this).parent('.client-aba-fields').remove();
		});
	});
	
	function checkClientABARadioOption()
	{
		if($('input[name=client_aba]:checked').val() == "Yes")
		{
			$(".add-client-aba-fields").removeClass('hidden');
			$(".client_aba_facility").each(function(){$(this).rules("add", {required:true}); $(this).removeAttr('disabled');});
			$(".client_aba_start").each(function(){$(this).rules("add", {required:true,date:true});$(this).removeAttr('disabled'); });
			$(".client_aba_end").each(function(){$(this).rules("add", {required:true,date:true});$(this).removeAttr('disabled'); });
			$(".client_aba_hours").each(function(){$(this).rules("add", {required:true,number:true});$(this).removeAttr('disabled'); });
		}
		else
		{
			$(".add-client-aba-fields").addClass('hidden');
			$(".client_aba_facility").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); /*$(this).val('');*/ });
			$(".client_aba_start").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); /*$(this).val('');*/ });
			$(".client_aba_end").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); /*$(this).val('');*/ });
			$(".client_aba_hours").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); /*$(this).val('');*/ });
		}	
	}
	
	function checkClientSpeechTherapyRadioOption()
	{
		if($('input[name=client_speechtherapy]:checked').val() == "Yes")
		{
			$("input[name='client_speechinstitution']").each(function(){$(this).rules("add", {required:true}); $(this).removeAttr('disabled');});
			$("input[name='client_speechhoursweek']").each(function(){$(this).rules("add", {required:true,number:true});$(this).removeAttr('disabled'); });
		}
		else
		{
			$("input[name='client_speechinstitution']").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); $(this).val('{{ $Client->client_speechinstitution }}'); });
			$("input[name='client_speechhoursweek']").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); $(this).val('{{ $Client->client_speechhoursweek }}'); });
		}
	}
	
	function checkClientOccupationalTherapyRadioOption()
	{
		if($('input[name=client_occupationaltherapy]:checked').val() == "Yes")
		{
			$("input[name='client_occupationalinstitution']").each(function(){$(this).rules("add", {required:true}); $(this).removeAttr('disabled');});
			$("input[name='client_occupationalhoursweek']").each(function(){$(this).rules("add", {required:true,number:true});$(this).removeAttr('disabled'); });
		}
		else
		{
			$("input[name='client_occupationalinstitution']").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); $(this).val('{{ $Client->client_occupationalinstitution }}'); });
			$("input[name='client_occupationalhoursweek']").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); $(this).val('{{ $Client->client_occupationalhoursweek }}'); });
		}
	}
	
	function checkChildsAttendSchoolRadioOption()
	{
		if($('input[name=client_childattendschool]:checked').val() == "Yes")
		{
			$("input[name='client_schoolname']").each(function(){$(this).rules("add", {required:true,nameRegex:true});$(this).removeAttr('disabled'); });
		}
		else
		{
			$("input[name='client_schoolname']").each(function(){$(this).rules("remove"); $(this).attr('disabled',''); $(this).val('{{ $Client->client_schoolname }}'); });
		}
	}
	
	function loadClientABACalendersFields(count)
	{
		//$('input[name="client_aba_data['+count+'][client_start]"]').datetimepicker({
		$('.client_aba_start').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var start_date = new Date(selected.date.valueOf());
			var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
			$('input[name="client_aba_data['+count+'][client_end]"]').datetimepicker('setStartDate', setStartDate);
		});
		
		//$('input[name="client_aba_data['+count+'][client_end]"]').datetimepicker({
		$('.client_aba_end').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var end_date = new Date(selected.date.valueOf());
			var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
			$('input[name="client_aba_data['+count+'][client_start]"]').datetimepicker('setEndDate', setEndDate);
		});
	}

</script>
 
@endsection
