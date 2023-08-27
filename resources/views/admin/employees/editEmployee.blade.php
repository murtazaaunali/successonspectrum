@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{ $Employee->fullname }}</h6>
		<p><a href="{{ url('admin/employees') }}">Employee</a> / <a href="{{ url('admin/employee/view/') }}/{{ $Employee->id }}">{{ $Employee->fullname }} </a> / Performance Log Add</p>

		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif

		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    	<form action="" method="post" id="editEmployee">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Employee's Demographic</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<!--<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>-->
                            <button type="button" class="btn add-franchise-data-butn-1 edit_employee"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main" style="padding-bottom: 50px;">
			    		<div class="super-admin-add-relation border-bot-0">
			    			<figure>
					    		<label>Set Status</label>
					    		<select name="status">
					    			<option value="1" @if($Employee->employee_status == 1) selected="" @endif >Active</option>
					    			<option value="0" @if($Employee->employee_status == 0) selected= @endif >Inactive</option>
					    		</select>
				    		</figure>
				    		<figure>
					    		<label>Employee Fullname<span class="required-field">*</span></label>
					    		<input type="text" name="employee_fullname" value="{{ $Employee->fullname }}">
					    		@if($errors->has('fullname'))
		                            <span class="help-block error">
		                                <strong style="color:red">{{ $errors->first('fullname') }}</strong>
		                            </span>
					    		@endif
					    		<label class="error error1" for="employee_fullname"></label>
					    	</figure>

					    	<figure>	
					    		<label>Employee Title<span class="required-field">*</span></label>
					    		<select name="employee_title">
					    			<option value="">Select Employee Title</option>
					    			<option @if($Employee->employee_title == 'Director of Administration') selected="" @endif >Director of Administration</option>
					    			<option @if($Employee->employee_title == 'Human Resources') selected="" @endif>Human Resources</option>
					    			<option @if($Employee->employee_title == 'Director of Operations') selected="" @endif>Director of Operations</option>
					    			<option @if($Employee->employee_title == 'SOS Distribution') selected="" @endif>SOS Distribution</option>
					    		</select>
					    		<label class="error error1" for="employee_title"></label>
					    	</figure>
					    	<figure>	
					    		<label>Employee Address<span class="required-field">*</span></label>
					    		<input type="text" name="employee_address" value="{{ $Employee->employee_address }}">
					    		<label class="error error1" for="employee_address"></label>
					    	</figure>
			    			<figure class="pos-rel">
					    		<label>Hiring Date<span class="required-field">*</span></label>
					    		<input type="text" name="hiring_date" id="hiring_date" class="hiring_datepicker" value="{{ date('m/d/Y',strtotime($Employee->hiring_date)) }}" placeholder="mm/dd/yy" >
					    		<a class="employe-edit-cal-pos-abs hiring_datepicker" href="javascript:void(0);"><i class="fa fa-calendar" aria-hidden="true"></i></a>
					    		<label class="error error1" for="hiring_date"></label>
				    		</figure>
				    		<figure>
					    		<label>Employee Type<span class="required-field">*</span></label>
					    		<input type="text" name="employee_type" value="{{ $Employee->employee_type }}"/>
					    		<label class="error error1" for="employee_type"></label>
					    	</figure>
					    	<figure class="pos-rel">
					    		<label>Employee DOB<span class="required-field">*</span></label>
					    		<input type="text" name="employee_dob" id="employee_dob" value="{{ date("m/d/Y",strtotime($Employee->employee_dob)) }}" placeholder="mm/dd/yy" class="employee_dob_datepicker">
					    		<a class="employe-edit-cal-pos-abs employee_dob_datepicker" href="javascript:void(0);"><i class="fa fa-calendar" aria-hidden="true"></i></a>
					    		<label class="error error1" for="employee_dob"></label>
					    	</figure>
					    	<figure class="pos-rel">	
					    		<label><!--90 Days Probation Completion-->60 Days Probation Completion<span class="required-field">*</span> Date</label>
					    		<input type="text" name="completion_date" id="completion_date" value="{{ date('m/d/Y', strtotime($Employee->ninty_days_probation_completion_date)) }}" readonly="readonly">
					    		<!--<a class="employe-edit-cal-pos-abs" href="javascript:void(0);" style="top: 16px;"><i class="fa fa-calendar" aria-hidden="true"></i></a>-->
					    		<label class="error error1" for="completion_date"></label>
					    	</figure>
					    	<figure>	
					    		<label>Highest degree held<span class="required-field">*</span></label>
					    		<input type="text" name="highest_degree_held" value="{{ $Employee->highest_degree_held }}">
					    		<label class="error error1" for="highest_degree_held"></label>
					    	</figure>
					    	<figure>	
					    		<label>Employee SS#<span class="required-field">*</span></label>
					    		<input type="text" name="employee_ss" value="{{ $Employee->employee_ss }}">
					    		<label class="error error1" for="employee_ss"></label>
					    	</figure>
					    	<!--<figure>	
					    		<label>Employee Email<span class="required-field">*</span></label>
					    		<input type="text" name="employee_email" value="{{ $Employee->email }}">
					    		<label class="error error1" for="employee_email"></label>
					    	</figure>-->
                            <figure>	
					    		<label>Employee Email<span class="required-field">*</span></label>
					    		<input type="text" name="login_email" value="{{ $Employee->email }}">
					    		<label class="error error1" for="login_email"></label>
					    	</figure>
			    		</div>	
			    	</div>
			    </form>
			    

			    <form action="{{ url('admin/employee/invite/'.$Employee->id) }}"  method="post" id="invite_form" autocomplete="off" class="hidden">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
			    	<div class="view-tab-content-head-main">
			    		<div class="view-tab-content-head">
			    			<h3>Invite Email</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="button" class="btn add-franchise-data-butn-1 butn-spacing-padd invite_btn"><i class="fa fa-user-o" aria-hidden="true"></i>Send Credentials</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>            

	                <div class="super-admin-add-relation-main" style="padding-bottom: 40px;">
	                    <div class="super-admin-add-relation border-bot-0">
	                        <figure>	
	                            <label>Email</label>
	                            <input type="email" autocomplete="off" name="login_email" id="login_email" value="{{ $Employee->email }}">
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

		//$('input[name=employee_ss]').samask("000-00-0000");

		jQuery.validator.addMethod("ssn", function(value, element) {
			return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{2}?[\-]{1}?[0-9]{4}$/.test(value);
		}, "please enter valid ssn format number. (Eg: xxx-xx-xxxx)");

		$("#editEmployee").validate({
			rules:{
				employee_firstname:{required:true,nameRegex:true,},
				employee_lastname:{required:true,nameRegex:true,},
				employee_title:{required:true},
				hiring_date:{required:true, date:true},
				employee_type:{required:true},
				employee_dob:{required:true},
				completion_date:{required:true},
				highest_degree_held:{required:true},
				employee_ss:{required:true, ssn:true},
				//employee_email:{required:true, validate_email:true},
				login_email:{required:true, validate_email:true},
			},
			
		});

		$('#invite_form').validate({
			rules:{
				login_email:{required:true, validate_email:true},
				emp_password:{required:true,minlength:6},
				emp_confirm_password:{equalTo: "#emp_password"},				
			}
		});
		
		$('.edit_employee').click(function(){
			var $valid = $('#editEmployee').valid();
			if(!$valid) {
				return false;
			}else{
				var employee_id = '{{ $Employee->id }}';
				var employee_email = $('input[name=login_email]').val();
				if(employee_email != '' && $valid)
				{
					$.ajax({
						url:'{{ url("admin/employee/emailexist") }}',
						type:'POST',
						dataType:'json',
						data:{email: employee_email, employee_id: employee_id, '_token':'{{ csrf_token() }}'},
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
									$(editEmployee).submit();	
								}
							}
							
						},
					});
					return false;
				}
			}
		});
		
		$('.invite_btn').click(function(){
			var $valid = $('#invite_form').valid();
			if(!$valid) {
				return false;
			}else{
				var employee_id = '{{ $Employee->id }}';
				var employee_email = $('input[name=login_email]').val();
				if(employee_email != '' && $valid)
				{
					$.ajax({
						url:'{{ url("admin/employee/emailexist") }}',
						type:'POST',
						dataType:'json',
						data:{email: employee_email, employee_id: employee_id, '_token':'{{ csrf_token() }}'},
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
									$(invite_form).submit();	
								}
							}
							
						},
					});
					return false;
				}
			}
		});

	});

</script>
 
@endsection
