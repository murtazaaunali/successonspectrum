@extends('franchise.layout.main')

@section('content')
<div class="add-franchise-super-main">
    <!--<h6>{{ $Employee->fullname}}</h6>
    <p><a href="#">Employee /</a><a href="#">{{ $Employee->fullname }} /</a>Profile Edit</p>-->
    <h6>{{ $Employee->personal_name}}</h6>
    <p><a href="#">Employee /</a><a href="#">{{ $Employee->personal_name }} /</a>Profile Edit</p>

	<div class="text-left">
	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	</div>	

    <div class="add-franchise-data-main-1 add-franchise-data-main-2">
        <div id="franchise-demography" class="tab-pane fade in active">
            <div class="view-tab-content-main">
            
                <form action="{{ url('franchise/employee/edit/'.$Employee->id) }}" method="post" id="editEmployee">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <div class="view-tab-content-head-main view-tab-content-head-main-3">
                    <div class="view-tab-content-head">
                        <h3>Employee's Demographic</h3>
                    </div>
                    <div class="view-tab-content-butn">
                        <!--<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>-->
                        <button type="button" class="btn add-franchise-data-butn-1" id="saveEmployee"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="super-admin-add-relation-main" style="padding-bottom: 40px;">
                    <div class="super-admin-add-relation border-bot-0">
                        <figure>
                            <label>Set Status</label>
                            <select name="status">
                                <option @if($Employee->personal_status == 'Active') selected="" @endif >Active</option>
                                <option @if($Employee->personal_status == 'Terminated') selected="" @endif >Terminated</option>
                                <option @if($Employee->personal_status == 'Applicant') selected="" @endif >Applicant</option>
                                <option @if($Employee->personal_status == 'Vacation') selected="" @endif >Vacation</option>
                            </select>
                        </figure>
                        <figure>
                            <label>Employee Name<span class="required-field">*</span></label>
                            <input type="text" name="employee_fullname" value="{{ $Employee->personal_name }}">
                            @if($errors->has('personal_name'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('personal_name') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="employee_fullname"></label>
                        </figure>
                        <figure class="pos-rel">
                            <label>Employee DOB<span class="required-field">*</span></label>
                            <input type="text" name="employee_dob" autocomplete="off" id="employee_dob" placeholder="mm/dd/yy" value="@if($Employee->personal_dob != "" && $Employee->personal_dob != '0000-00-00'){{ date('m/d/Y',strtotime($Employee->personal_dob)) }}@endif" class="employee_dob_datepicker">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employee_dob_datepicker" aria-hidden="true"></i></a>
                            <label class="error error1" for="employee_dob"></label>
                        </figure>
                        <figure>	
                            <label>Employee Address<span class="required-field">*</span></label>

                            <input type="text" name="employee_address" value="{{ $Employee->personal_address }}">
                            <label class="error error1" for="employee_address"></label>
                        </figure>
                        <figure>	
                            <label class="hidden-xs">&nbsp;</label>
                            <div class="input-group-row">
                                <div class="input-group-col-4 input-group-col-first">
                                    <input type="text" name="employee_city" value="{{ $Employee->personal_city }}" >
                                    <label class="error1 error" for="employee_city" style="left:0"></label>
                                </div>
                                <div class="input-group-col-4">
                                    <input type="text" name="employee_state" value="{{ $Employee->personal_state }}" >
                                    <label class="error1 error" for="employee_state" style="left:0"></label>
                                </div>
                                <div class="input-group-col-4 input-group-col-last">
                                    <input type="text" name="employee_zipcode" value="{{ $Employee->personal_zipcode }}" >
                                    <label class="error1 error" for="employee_zipcode" style="left:0"></label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </figure>
                        <figure>	
                            <label>Employee SS#<span class="required-field">*</span></label>
                            <input type="text" name="employee_ss" value="{{ $Employee->personal_ss }}">
                            <label class="error error1" for="employee_ss"></label>
                        </figure>
                        <figure>	
                            <label>Employee Email<span class="required-field">*</span></label>
                            <input type="email" name="employee_email" value="{{ $Employee->personal_email }}">
                            <label class="error error1" for="employee_email"></label>
                        </figure>
                        <figure>	
                            <label>Employee Phone<span class="required-field">*</span></label>
                            <input type="text" name="employee_phone" value="{{ $Employee->personal_phone }}">
                            <label class="error error1" for="employee_phone"></label>
                        </figure>
                        <figure>	
                            <label>Crew Type<span class="required-field">*</span></label>
                            <select name="crew_type">
                            	<option value="">Select</option>
                            	<option @if($Employee->crew_type == 'Ocean') selected @endif>Ocean</option>
                            	<option @if($Employee->crew_type == 'Voyager') selected @endif>Voyager</option>
                                <option @if($Employee->crew_type == 'Sailor') selected @endif>Sailor</option>
                            </select>
                            <label class="error error1" for="crew_type"></label>
                        </figure>
                        <div class="radio-btun">
                            <figure>	
                                <label>Authorize To Work in The US</label>
                                <input type="radio" value="Yes" name="work_authorised" @if($Employee->work_authorised == 'Yes') checked @endif><span>&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" name="work_authorised" @if($Employee->work_authorised == 'No') checked @endif><span>&nbsp;No</span>
                            </figure>
                        </div>
                        <div class="radio-btun">
                            <figure>	
                                <label>Capable Of Performing The Essential Functions Of The Job Which You Are Applying Without Any Accommodations?</label>
                                <input type="radio" value="Yes" name="work_capable" @if($Employee->work_capable == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" name="work_capable" @if($Employee->work_capable == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                            </figure>
                        </div>
                        <figure>	
                            <label>If No, What Accommodations Do You Need?</label>
                            <input type="text" name="work_nocapable" @if($Employee->work_capable == 'Yes') disabled="disabled"  @endif value="{{ $Employee->work_nocapable }}" class="vartical-top">
                            <label class="error1 error" for="work_nocapable"></label>
                        </figure>
                        <div class="radio-btun">
                            <figure>	
                                <label>Are you able to lift 30 to 40 lbs? Able to do physical activities?</label>
                                <input type="radio" value="Yes" name="work_liftlbs" @if($Employee->work_liftlbs == 'Yes') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" name="work_liftlbs" @if($Employee->work_liftlbs == 'No') checked @endif class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                            </figure>
                        </div>
                        <figure>	
                            <label>Employment Type</label>
                            <select name="employee_type">
                                <option value="">Select Employment Type</option>
                                <option @if($Employee->career_desired_schedule == 'Full-Time') selected="" @endif>Full-Time</option>
                                <option @if($Employee->career_desired_schedule == 'Part-Time') selected="" @endif>Part-Time</option>
                                <option @if($Employee->career_desired_schedule == 'Contract') selected="" @endif>Contract</option>
                            </select>
                            <label class="error error1" for="employee_type"></label>
                        </figure>
                        <figure>	
                            <label>Desired Position<span class="required-field">*</span></label>
                            <select name="desired_title[]" multiple="" style="min-height: 150px;">
                            	@php
                            		$position = explode(',',$Employee->career_desired_position); 
                            		$dPositions = array('Billing', 'Office Manager', 'Receptionist', 'BCBA', 'BCBA Intern or BCaBA', 'RBT Trainer', 'Behavior Technician');
                            	@endphp
                            	
                            	<option value="">Select Desired Position</option>
                            	@foreach($dPositions as $getPos)
                            		<option @if(in_array($getPos, $position)) selected="" @endif >{{ $getPos }}</option>
                            	@endforeach
                                
                            </select>
                            <label class="error error1" for="desired_title"></label>
                        </figure>
                        <figure>	
                            <label>Assigned Position<span class="required-field">*</span></label>
                            <select name="employee_title">
                                <option value="">Select Desired Position</option>
                                <option @if($Employee->assigned_position == 'Billing') selected="" @endif >Billing</option>
                                <option @if($Employee->assigned_position == 'Office Manager') selected="" @endif >Office Manager</option>
                                <option @if($Employee->assigned_position == 'Receptionist') selected="" @endif >Receptionist</option>
                                <option @if($Employee->assigned_position == 'BCBA') selected="" @endif >BCBA</option>
                                <option @if($Employee->assigned_position == 'BCBA Intern or BCaBA') selected="" @endif >BCBA Intern or BCaBA</option>
                                <option @if($Employee->assigned_position == 'RBT Trainer') selected="" @endif >RBT Trainer</option>
                                <option @if($Employee->assigned_position == 'Behavior Technician') selected="" @endif >Behavior Technician</option>
                                <!--<option @if($Employee->career_desired_position == 'RBT') selected="" @endif>RBT</option>
                                <option @if($Employee->career_desired_position == 'Uncertified') selected="" @endif>Uncertified</option>
                                <option @if($Employee->career_desired_position == 'Technician') selected="" @endif>Technician</option>-->
                            </select>
                            <label class="error error1" for="employee_title"></label>
                        </figure>
                        <figure class="pos-rel">
                            <label>Hiring Date<span class="required-field">*</span></label>
                            <input type="text" name="hiring_date" autocomplete="off" id="hiring_date" value="@if($Employee->career_earliest_startdate != "" && $Employee->career_earliest_startdate != '0000-00-00'){{ date('m/d/Y',strtotime($Employee->career_earliest_startdate)) }}@endif" placeholder="mm/dd/yy" class="hiring_datepicker">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar hiring_datepicker" aria-hidden="true"></i></a>
                            <label class="error error1" for="hiring_date"></label>
                        </figure>

                        <figure class="pos-rel">	
                            <label><!--90 Days Probation Completion Date-->60 Days Probation Completion Date<span class="required-field">*</span></label>
                            <input type="text" name="completion_date" autocomplete="off" id="completion_date" value="@if($Employee->career_probation_completion_date != "" && $Employee->career_probation_completion_date != '0000-00-00'){{ date('m/d/Y',strtotime($Employee->career_probation_completion_date)) }}@endif" placeholder="mm/dd/yy" readonly="">
                            <!--<a class="employe-edit-cal-pos-abs" href="javascript:void(0);" style="top: 16px;"><i class="fa fa-calendar" aria-hidden="true"></i></a>-->
                            <label class="error error1" for="completion_date"></label>
                        </figure>
                        <figure>	
                            <label>Highest degree held<span class="required-field">*</span></label>
                            <input type="text" name="highest_degree_held" value="{{ $Employee->career_highest_degree }}">
                            <label class="error error1" for="highest_degree_held"></label>
                        </figure>

                        <figure>	
                            <label>Desired Location<span class="required-field">*</span></label>
                            <select name="career_desired_location">
                            <option value="">Select Desired Location</option>
                            @if($franchises)
                                @foreach($franchises as $franchise)
                                    <option @if($Employee->career_desired_location == $franchise->location) selected="" @endif>{{ $franchise->location }}</option>
                                @endforeach
                            @endif
                            </select>
                            <label class="error error1" for="career_desired_location"></label>
                        </figure>
                        <div class="radio-btun">
                            <figure>	
                                <label>Are you Registered by the BACB?</label>
                                <input type="radio" value="Yes" class="BACB vartical-top" name="career_bacb" @if($Employee->career_bacb == 'Yes') checked @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" class="BACB vartical-top" name="career_bacb" @if($Employee->career_bacb == 'No') checked @endif><span class="vartical-top">&nbsp;No</span>
                                <label class="error error1" for="career_bacb"></label>
                            </figure>
                        </div>
                        <figure class="pos-rel bacb_cover">
                            <label>BCBA Registration Date<span class="required-field">*</span></label>
                            <input type="text" name="bacb_regist_date" autocomplete="off" id="bacb_regist_date" placeholder="mm/dd/yy" value="@if($Employee->bacb_regist_date != "" && $Employee->bacb_regist_date != '0000-00-00'){{ date('m/d/Y',strtotime($Employee->bacb_regist_date)) }}@endif" class="bacb_regist_datepicker">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar bacb_regist_datepicker" aria-hidden="true"></i></a>
                            <label class="error error1" for="bacb_regist_date"></label>
                        </figure>
                        <div class="radio-btun">
                            <figure>	
                                <label>Are You CPR Certified?</label>
                                <input type="radio" value="Yes" class="CPR vartical-top" name="career_cpr_certified" @if($Employee->career_cpr_certified == 'Yes') checked @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" class="CPR vartical-top" name="career_cpr_certified" @if($Employee->career_cpr_certified == 'No') checked @endif><span class="vartical-top">&nbsp;No</span>
                                <label class="error error1" for="career_cpr_certified"></label>
                            </figure>
                        </div>
                        <figure class="pos-rel cpr_cover">
                            <label>CPR Registration Date<span class="required-field">*</span></label>
                            <input type="text" name="cpr_regist_date" autocomplete="off" id="cpr_regist_date" placeholder="mm/dd/yy" value="@if($Employee->cpr_regist_date != "" && $Employee->cpr_regist_date != '0000-00-00'){{ date('m/d/Y',strtotime($Employee->cpr_regist_date)) }}@endif" class="cpr_regist_datepicker">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar cpr_regist_datepicker" aria-hidden="true"></i></a>
                            <label class="error error1" for="cpr_regist_date"></label>
                        </figure>

                    </div>	
                </div>
            </form>
            
		    <form action="{{ url('franchise/employee/invite/'.$Employee->id) }}"  method="post" id="invite_form" autocomplete="off">
		    	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		    	<div class="view-tab-content-head-main">
		    		<div class="view-tab-content-head">
		    			<h3>Invite Email</h3>
		    		</div>
		    		<div class="view-tab-content-butn">
		    			<button type="button" class="btn add-franchise-data-butn-1 butn-spacing-padd invite_btn"><i class="fa fa-user-o" aria-hidden="true"></i>Invite Email</button>
		    		</div>
		    		<div class="clearfix"></div>
		    	</div>            

                <div class="super-admin-add-relation-main" style="padding-bottom: 40px;">
                    <div class="super-admin-add-relation border-bot-0">
                        <figure>	
                            <label>Email</label>
                            <input type="email" autocomplete="off" name="login_email" id="login_email" value="{{ $Employee->personal_email }}">
                            <label class="error error1" for="login_email"></label>
                        </figure>
                        <figure>	
                            <label>Password</label>
                            <input type="password" autocomplete="off" name="emp_password" id="emp_password" value="">
                            <label class="error error1" for="emp_password"></label>
                        </figure>
                        <figure>	
                            <label>Confirm Password</label>
                            <input type="password" name="emp_confirm_password" id="emp_confirm_password" value="">
                            <label class="error error1" for="emp_confirm_password"></label>
                        </figure>
                    </div>
                </div>    

		    </form>
		    	
            </div>
            
            
        </div>
    </div>
    <!-- header-bottom-sec -->
</div>	

<div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Email Already Exist!</h4>
        </div>
        <div class="modal-body">
          <!--<p>Are you sure you want to delete this user permanently ? All data of the existing user will be lost. This action cannot be undone</p>-->
          <input class="btn " type="button" data-dismiss="modal" value="Close">
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
	$(function () {
		/*$('#completion_date').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		});*/

		//$('#hiring_date').datetimepicker({
		$('.hiring_datepicker').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var date = new Date(selected.date.valueOf());
			//date.setDate( date.getDate() + 90);
			date.setDate( date.getDate() + 60);
			var dateafter_90days = ("0" + (date.getMonth() + 1)).slice(-2) + "/" + ("0" + date.getDate() ).slice(-2) + "/" + date.getFullYear();
			$('#completion_date').val(dateafter_90days);
		});
	});

	$('.continue').click(function(){
	  $('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
	$('.back').click(function(){
	  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});

	$(document).ready(function() {
		//$('#employee_dob').datetimepicker({
		$('.employee_dob_datepicker').datetimepicker({
			useCurrent: false,
			autoclose:true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,   
		    endDate: new Date(),
    	});

		//$('#bacb_regist_date, #cpr_regist_date').datetimepicker({
		$('.bacb_regist_datepicker, .cpr_regist_datepicker').datetimepicker({
			useCurrent: false,
			autoclose:true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,   
		    endDate: new Date(),
    	});

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

		/*$('input[name=employee_ss]').samask("000-00-0000");
		$('input[name=employee_phone]').samask("000-000-0000");*/
		$('input[name=employee_ss]').inputmask({"mask": "999-99-9999"});
		$('input[name=employee_phone]').inputmask({"mask": "999-999-9999"});

		jQuery.validator.addMethod("ssn", function(value, element) {
			return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{2}?[\-]{1}?[0-9]{4}$/.test(value);
		}, "please enter valid ssn format number. (Eg: xxx-xx-xxxx)");
		
		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

		$("#editEmployee").validate({
			rules:{
				employee_fullname:{required:true,nameRegex:true,},
				employee_dob:{required:true},
				employee_address:{required:true},
				employee_city:{required:true},
				employee_state:{required:true},
				employee_zipcode:{required:true},
				employee_ss:{required:true, ssn:true},
				employee_email:{required:true, validate_email:true},
				employee_phone:{required:true, phoneUS:true, usphonenumb:true},
				crew_type:{required:true},
				employee_type:{required:true},
				employee_title:{required:true},
				hiring_date:{required:true, date:true},
				completion_date:{required:true},
				highest_degree_held:{required:true},
				career_desired_location:{required:true},
				bacb_regist_date:{required:true},
				cpr_regist_date:{required:true},
			},
			messages:{
			  employee_phone:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			}				
		});


		$('#invite_form').validate({
			rules:{
				login_email:{required:true, validate_email:true},
				emp_password:{required:true,minlength:6},
				emp_confirm_password:{equalTo: "#emp_password"},				
			}
		});
		
		$('input[name="work_capable"]').change(function(){
			if($('input[name=work_capable]:checked').val() == 'No'){
				$("input[name=work_nocapable]").each(function(){$(this).rules("add", {required:true,}); $(this).removeAttr('disabled');$(this).val('{{ $Employee->work_nocapable }}');});	
			}else{
				$("input[name=work_nocapable]").each(function(){ $(this).rules("remove"); $(this).attr('disabled',''); $(this).val(''); });	
			}			
		 });
		
		
		//Function for exist email
		function valideEmail(FormName, EmailField, SearchEmailField){
			var $valid = $(FormName).valid();
  			if(!$valid) {
  				return false;
  			}else{
				var employee_id = '{{ $Employee->id }}';
				var employee_email = $('input[name='+EmailField+']').val();
				if(employee_email != '' && $valid)
				{
					$.ajax({
						url:'{{ url("franchise/employee/emailexistinvite") }}',
						type:'POST',
						dataType:'json',
						data:{email: employee_email, EmailField: SearchEmailField, employee_id: employee_id, '_token':'{{ csrf_token() }}'},
						beforeSend: function() {
							$('.spinner_inner').css('display','block');
						},
						success:function(response){
							$('.spinner_inner').css('display','none');
							if(typeof(response) == 'object'){
								
								if('errors' in response){
									var Errors = '';
									$.each(response.errors, function(key, value){
										Errors += value+'\n';
									});
									//alert(Errors);	
									$('#myModal2').modal('show');
								}
								
								if('success' in response){
									$(FormName).submit();	
								}
							}
							
						},
					});
					return false;
				}
			}
		}
		 
		 $('#editEmployee #saveEmployee').click(function () {
			valideEmail('#editEmployee', 'employee_email', 'personal_email');
		 });

		 $('.invite_btn').click(function () {
			valideEmail('#invite_form', 'login_email', 'personal_email');
		 });

		function BACB(Curr){
			//alert($(Curr).val());
			if($(Curr).val() == 'Yes'){
				$('.bacb_cover').show();
				$('input[name=bacb_regist_date]').rules("add", {required:true});
			}else{
				$('.bacb_cover').hide();
				$('input[name=bacb_regist_date]').rules("remove");
			}			
		}
		
		function CPR(Curr){
			if($(Curr).val() == 'Yes'){
				$('.cpr_cover').show();
				$('input[name=cpr_regist_date]').rules("add", {required:true});
			}else{
				$('.cpr_cover').hide();
				$('input[name=cpr_regist_date]').rules("remove");
			}			
		}


		$('.BACB').on('change',function(){
			BACB($(this));
		});
		$('.CPR').change(function(){
			CPR($(this));
		});
		
		BACB('.BACB:checked');
		CPR('.CPR:checked');
	});

</script>
 
@endsection
