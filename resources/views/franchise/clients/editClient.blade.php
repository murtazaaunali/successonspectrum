@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client </a> / <a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }} /</a>Profile Edit</p>

		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>
		
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    	<form action="" method="post" id="editClient">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Client's Information</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1" id="save-client-information"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main spinner_main">
		    			<div class="spinner_inner" style="padding-top: 15% !important;">
		    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
		    				Checking email if exist.	
		    			</div>

			    		<div class="super-admin-add-relation border-bot-0">
			    			<figure>
					    		<label>Set Status</label>
					    		<select name="client_status">
                                    <!--<option @if($Client->client_status == 'Active') selected="" @endif>Active</option>
					    			<option @if($Client->client_status == 'Terminated') selected="" @endif >Terminated</option>
					    			<option @if($Client->client_status == 'Applicant') selected="" @endif >Applicant</option>-->
                                    <option value="Active" @if($Client->client_status == 'Active') selected="" @endif>Active</option>
                                    <option value="Terminated" @if($Client->client_status == 'Terminated') selected="" @endif >Inactive</option>
					    			<option value="Applicant" @if($Client->client_status == 'Applicant') selected="" @endif >Waiting List</option>
					    		</select>
				    		</figure>
				    		<figure>
                                <label>Client's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_childfullname" value="{{ $Client->client_childfullname }}">
					    		<label class="error error1" for="client_childfullname"></label>
					    	</figure>
							<figure class="pos-rel">
					    		<label>Child's Date of Birth<span class="required-field">*</span></label>
                                <input type="text" name="client_childdateofbirth" value="@if($Client->client_childdateofbirth != "" && $Client->client_childdateofbirth != '0000-00-00'){{ date("m/d/Y",strtotime($Client->client_childdateofbirth)) }}@endif" id="client_childdateofbirth" placeholder="mm/dd/yy" class="client_childdateofbirth">
					    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_childdateofbirth" aria-hidden="true"></i></a>
					    		<label class="error error1" for="client_childdateofbirth"></label>
					    	</figure>
                            <figure>	
					    		<label>Custodial Parent</label>
                                <!--<input type="text" name="client_custodialparent" value="{{ $Client->client_custodialparent }}">-->
								<label class="txt-bold radio-inline"><input name="client_custodialparent" @if($Client->client_custodialparent == 'Both Parents are married') checked="" @endif class="pad-r w-auto" type="radio" value="Both Parents are married">Both Parents are married</label>
                                <label>&nbsp;</label>
								<label class="txt-bold radio-inline"><input name="client_custodialparent" @if($Client->client_custodialparent == 'Child lives with Dad') checked="" @endif class="pad-r w-auto" type="radio" value="Child lives with Dad">Child lives with Dad</label>
                                <label>&nbsp;</label>
								<label class="txt-bold radio-inline"><input name="client_custodialparent" @if($Client->client_custodialparent == 'Child lives with Mom') checked="" @endif class="pad-r w-auto" type="radio" value="Child lives with Mom">Child lives with Mom</label>
					    	</figure>
                            <figure>	
					    		<label>Location of Services<span class="required-field">*</span></label>
								<!--<label class="txt-bold radio-inline w-auto"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'SOS Center Full-me (Mon - Fri 8:00am-4:00pm)') checked="" @endif class="pad-r w-auto" type="radio" value="SOS Center Full-me (Mon - Fri 8:00am-4:00pm)">SOS Center Full-me (Mon - Fri 8:00am-4:00pm)</label>
                                <label>&nbsp;</label>
								<label class="txt-bold radio-inline"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'SOS Center Part-time') checked="" @endif class="pad-r w-auto" type="radio" value="SOS Center Part-time">SOS Center Part-time</label>
                                <label>&nbsp;</label>
								<label class="txt-bold radio-inline w-50"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'School Shadowing 8:00am-4:00pm (with school approval)') checked="" @endif class="pad-r w-auto" type="radio" value="School Shadowing 8:00am-4:00pm (with school approval)">School Shadowing 8:00am-4:00pm (with school approval)</label>
                                <label>&nbsp;</label>
								<label class="txt-bold radio-inline w-50"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)') checked="" @endif class="pad-r w-auto" type="radio" value="In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)">In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)</label>-->
                                <label class="txt-bold radio-inline"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'Office') checked="" @endif class="pad-r w-auto" type="radio" value="Office">Office</label>
                                <label>&nbsp;</label>
                                <label class="txt-bold radio-inline"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'Home') checked="" @endif class="pad-r w-auto" type="radio" value="Home">Home</label>
                                <label>&nbsp;</label>
                                <label class="txt-bold radio-inline"><input name="chooselocation_interest" @if($Client->chooselocation_interest == 'School') checked="" @endif class="pad-r w-auto" type="radio" value="School">School</label>
                                <label class="error error1" for="chooselocation_interest"></label>
					    	</figure>
					    	<figure>	
					    		<label>Child's School<span class="required-field">*</span></label>
                                <input type="text" name="client_schoolname" value="{{ $Client->client_schoolname }}">
					    		<label class="error error1" for="client_schoolname"></label>
					    	</figure>
                            <?php /*?><figure>	
					    		<label>Crew<span class="required-field">*</span></label>
                                <select name="client_crew">
                                	@if(!$crews->isEmpty())
                                		<option value="">Select</option>
                                		@foreach($crews as $getCrew)
                                			<option value="{{ $getCrew->id }}" @if($getCrew->id == $Client->client_crew) selected @endif >{{ $getCrew->personal_name }}</option>
                                		@endforeach
                                	@endif
                                </select>
                                <br/>
                                <label class="error error1" for="client_crew"></label>
					    	</figure><?php */?>
                            <figure>	
                                <label>Crew<span class="required-field">*</span></label>
                                <select name="client_crew">
                                    <option value="">Select</option>
                                    <option @if($Client->client_crew == 'Ocean') selected @endif>Ocean</option>
                                    <option @if($Client->client_crew == 'Voyager') selected @endif>Voyager</option>
                                    <option @if($Client->client_crew == 'Sailor') selected @endif>Sailor</option>
                                </select>
                                <label class="error error1" for="client_crew"></label>
                            </figure>
                            <figure>	
					    		<label>Mom's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_momsname" value="{{ $Client->client_momsname }}">
					    		<label class="error error1" for="client_momsname"></label>
					    	</figure>
                            <figure>	
					    		<label>Mom's Email<span class="required-field">*</span></label>
                                <input type="email" name="client_momsemail" value="{{ $Client->client_momsemail }}">
					    		<label class="error error1" for="client_momsemail"></label>
					    	</figure>
                            <figure>	
					    		<label>Mom's Cell<span class="required-field">*</span></label>
                                <input type="phone" name="client_momscell" value="{{ $Client->client_momscell }}" placeholder="xxx-xxx-xxxx">
					    		<label class="error error1" for="client_momscell"></label>
					    	</figure>
                            <figure class="hidden">	
					    		<label>Custodial Parent's Address<span class="required-field">*</span></label>
                                <input type="text" name="client_custodialparentsaddress" value="{{ $Client->client_custodialparentsaddress }}">
					    		<label class="error error1" for="client_custodialparentsaddress"></label>
					    	</figure>
                            <figure>	
					    		<label>Dad's Name<span class="required-field">*</span></label>
                                <input type="text" name="client_dadsname" value="{{ $Client->client_dadsname }}">
					    		<label class="error error1" for="client_dadsname"></label>
					    	</figure>
                            <figure>	
					    		<label>Dad's Email<span class="required-field">*</span></label>
                                <input type="email" name="client_dadsemail" value="{{ $Client->client_dadsemail }}">
					    		<label class="error error1" for="client_dadsemail"></label>
					    	</figure>
                            <figure>	
					    		<label>Dad's Cell<span class="required-field">*</span></label>
                                <input type="phone" name="client_dadscell" value="{{ $Client->client_dadscell }}" placeholder="xxx-xxx-xxxx">
					    		<label class="error error1" for="client_dadscell"></label>
					    	</figure>
                            <figure>	
                                <label>Emergency Contact Name<span class="required-field">*</span></label>
                                <input type="text" name="client_emergencycontactname" value="{{ $Client->client_emergencycontactname }}">
					    		<label class="error error1" for="client_emergencycontactname"></label>
                            </figure>
                            <figure>	
                                <label>Emergency Contact Phone<span class="required-field">*</span></label>
                                <input type="phone" name="client_emergencycontactphone" value="{{ $Client->client_emergencycontactphone }}" placeholder="xxx-xxx-xxxx">
					    		<label class="error error1" for="client_emergencycontactphone"></label>
                            </figure>
                            <!--<figure>	
                                <label>Login Email<span class="required-field">*</span></label>
                                <input type="email" name="client_email" value="{{ $Client->email }}" autocomplete="off">
					    		<label class="error error1" for="client_email"></label>
                            </figure>
                            <figure>	
                                <label>Login Password</label>
                                <input type="password" name="client_password" id="client_password" value="">
					    		<label class="error error1" for="client_password"></label>
                            </figure>
                            <figure>	
                                <label>Login Confirm Password</label>
                                <input type="password" name="client_confirm_password" id="client_confirm_password" value="">
					    		<label class="error error1" for="client_confirm_password"></label>
                            </figure>-->
			    		</div>	
			    	</div>
			    </form>


			    <!-- LOGIN DETAILS FORM --> 
			    <form action="{{ url('franchise/client/invite/'.$Client->id) }}"  method="post" id="invite_form" autocomplete="off">
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
	                            <input type="email" autocomplete="off" name="login_email" id="login_email" value="{{ $Client->email }}">
	                            <label class="error error1" for="login_email"></label>
	                        </figure>
	                        <figure>	
	                            <label>Password</label>
	                            <input type="password" autocomplete="off" name="client_password" id="client_password" value="">
	                            <label class="error error1" for="emp_password"></label>
	                        </figure>
	                        <figure>	
	                            <label>Confirm Password</label>
	                            <input type="password" name="client_confirm_password" id="client_confirm_password" value="">
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
      <div class="modal fade" id="checkClientEmailExistsModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Email Already Exist!</h4>
            </div>
            <div class="modal-body">
              <input class="btn " type="button" data-dismiss="modal" value="Close">
            </div>
          </div>
          
        </div>
      </div>
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
	});

	$(document).ready(function() {
		/*$('input[name=client_momscell]').samask("000-000-0000");
		$('input[name=client_dadscell]').samask("000-000-0000");
		$('input[name=client_emergencycontactphone]').samask("000-000-0000");*/
		$('input[name=client_momscell]').inputmask({"mask": "999-999-9999"});
		$('input[name=client_dadscell]').inputmask({"mask": "999-999-9999"});
		$('input[name=client_emergencycontactphone]').inputmask({"mask": "999-999-9999"});

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

		$('#invite_form').validate({
			rules:{
				login_email:{required:true, validate_email:true},
				client_password:{required:true,minlength:6},
				client_confirm_password:{equalTo: "#client_password"},				
			}
		});

		$("#editClient").validate({
			rules:{
				client_childfullname:{required:true,nameRegex:true},
				client_childdateofbirth:{required:true,date:true},
				chooselocation_interest:{required:true},
				client_schoolname:{required:true},
				client_crew:{required:true},
				client_momsname:{required:true,nameRegex:true,},
				client_momsemail:{required:true, validate_email:true},
				client_momscell:{required:true, phoneUS:true, usphonenumb:true},
				//client_custodialparentsaddress:{required:true},
				client_dadsname:{required:true,nameRegex:true,},
				client_dadsemail:{required:true, validate_email:true},
				client_dadscell:{required:true, phoneUS:true, usphonenumb:true},
				client_emergencycontactname:{required:true,nameRegex:true,},
				client_emergencycontactphone:{required:true, phoneUS:true, usphonenumb:true},
				/*client_email:{required:true,email:true},
				client_password:{minlength:6},
				client_confirm_password:{equalTo: "#client_password"},*/
			},
			  messages:{
			  	client_momscell:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			  	client_dadscell:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
			  	client_emergencycontactphone:{phoneUS:'Invalid format'},
			  }			
		});
		
		///////////////////////////////////////////////
		//CHECKING IF CLIENT EMAIL IS ALREADY EXITS//
		///////////////////////////////////////////////
		$('.invite_btn').click(function () {
			var $valid = $("#invite_form").valid();
			var client_email = $('input[name=login_email]').val();
			var client_id = '{{ $Client->id }}';
			if(client_email != '' && $valid){
				$.ajax({
					url:'{{ url("franchise/client/emailexist") }}',
					type:'POST',
					dataType:'json',
					data:{email: client_email, 'client_id':client_id, '_token':'{{ csrf_token() }}'},
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
								$('#checkClientEmailExistsModal').modal('show');
							}
							
							if('success' in response){
								$('#invite_form').submit();
							}
						}
						
					},
				});	
				return false;
			}
		});

	});

</script>
 
@endsection
