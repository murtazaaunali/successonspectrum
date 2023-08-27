@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-franchise-super-main add-employee-tabs-main-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
        <h6>{{$sub_title}}</h6></div>
        <div class="clearfix"></div>
			<p>{{ $Franchise->name }} / 
				@if($Franchise->state != "")
				{{ $Franchise->getState->state_name }}
				@else
				 - 
				@endif			
			 / <span id="change-bread-crumb">Franchisee Demographic</span></p>
    </div>

	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">

	<form method="post" id="editFranchise">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="active padd-left-anchor Task-List-1"><a data-toggle="tab" href="#fees">Franchisee Demographic</a></li>
				</ul>
			</div>
			<div class="view-tab-control-butn-main">
				<button type="submit" id="saveChanges" class="btn add-franchise-data-butn-1 pos-rel-sav-butn"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button> 
			</div>
			<div class="clearfix"></div>
		</div>


		<div class="add-employee-body-main">
		    <div class="add-employee-data padd-left-0">
		    <div class="super-admin-add-relation-main add-franchise-tabs-data-main padd-0 FranchiseFieldsCalenders">
	    		<div class="super-admin-add-relation border-bot-0">
	    			<figure>
			    		<label>Franchise Status</label>
			    		<select name="status">
			    			<option @if($Franchise->status == 'Active') selected="" @endif">Active</option>
			    			<option @if($Franchise->status == 'Terminated') selected="" @endif">Terminated</option>
			    			<option @if($Franchise->status == 'Expired') selected="" @endif">Expired</option>
                            <option @if($Franchise->status == 'Potential') selected="" @endif">Potential</option>
			    		</select>
		    		</figure>
					{{--<figure class="pos-rel">
                        <label>Franchise Activation Date<!--<span class="required-field">*</span>--></label>
                        <input class="datepicker" name="franchise_activation_date" id="franchise_activation_date" type="text" required value="{{ date('m/d/Y',strtotime($Franchise->franchise_activation_date)) }}" readonly="">
                        <i class="fa fa-calendar pos-abs-cal" aria-hidden="true"></i>
                        @if ($errors->has('franchise_activation_date'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('franchise_activation_date') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="franchise_activation_date"></label>
                    </figure>
                    <figure>
                        <label>Franchise Name<!--<span class="required-field">*</span>--></label>
                        <input type="text" name="franchise_name" value="{{ $Franchise->name }}">
                        @if ($errors->has('franchise_name'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('franchise_name') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="franchise_name"></label>
                    </figure>--}}
			    	<figure>	
			    		<label>Franchise Location<span class="required-field">*</span></label>
			    		<input type="text" name="location" required value="{{ $Franchise->location }}">
                        @if ($errors->has('location'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('location') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="location"></label>
			    	</figure>
			    	<figure>	
			    		<label>Franchise Address<!--<span class="required-field">*</span>--></label>
			    		<input type="text" name="address" value="{{ $Franchise->address }}">
                        @if ($errors->has('address'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="address"></label>
			    	</figure>
	    			<figure>
			    		<label>City<!--<span class="required-field">*</span>--></label>
			    		<input type="text" name="city" value="{{ $Franchise->city }}">
                        @if ($errors->has('city'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="city"></label>
			    	</figure>
			    	<figure>
			    		<label>Zip<!--<span class="required-field">*</span>--></label>	
			    		<input type="text" name="zipcode" value="{{ $Franchise->zipcode }}">
                        @if ($errors->has('zipcode'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('zipcode') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="zipcode"></label>
                    </figure>
                    <figure>
                    	<label>State<!--<span class="required-field">*</span>--></label>    
			    		@if($states)	
			    			<select name="state">
			    				<option value="">Select State</option>
				    			@foreach($states as $state)
				    				<option @if($Franchise->state == $state['id']) selected @endif value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
				    			@endforeach
			    			</select>
			    		@endif	
                        @if ($errors->has('state'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('state') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="state"></label>
		    		</figure>
		    		<figure>
			    		<label>Franchise Phone Number<!--<span class="required-field">*</span>--></label>
			    		<input type="text" name="phonenumber" value="{{ $Franchise->phone }}" placeholder="xxx-xxx-xxxx">
                        @if ($errors->has('phonenumber'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('phonenumber') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="phonenumber"></label>
			    	</figure>

					<figure>
						<label>Franchise Fax Number</label>
						<input type="text" name="faxnumber" value="{{ $Franchise->fax }}" placeholder="xxx-xxx-xxxx">
						@if ($errors->has('faxnumber'))
							<span class="help-block error">
                                <strong style="color:red">{{ $errors->first('faxnumber') }}</strong>
                            </span>
						@endif
						<label class="error error1" for="faxnumber"></label>
					</figure>
			    	<figure>	
			    		<label>Franchise Email Address<!--<span class="required-field">*</span>--></label>
			    		<input type="text" name="email" value="{{ $Franchise->email }}">
                        @if ($errors->has('email'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <label class="error error1" for="email"></label>
			    	</figure>
	    			<figure class="pos-rel">
			    		<label>Date FDD Was Signed<!--<span class="required-field">*</span>--></label>
			    		<!--<input class="datepicker fdd_signed_datepicker" type="text" autocomplete="off" id="fdd_signed_date" value="{{ date('m/d/Y',strtotime($Franchise->fdd_signed_date )) }}" name="fdd_signed_date" required="" placeholder="mm/dd/yy" readonly="readonly">-->
                        <input class="fdd_signed_datepicker" type="text" autocomplete="off" id="fdd_signed_date" value="@if($Franchise->fdd_signed_date != "" && $Franchise->fdd_signed_date != '0000-00-00'){{ date('m/d/Y',strtotime($Franchise->fdd_signed_date )) }}@endif" name="fdd_signed_date" placeholder="mm/dd/yy">
			    		<!--<i class="fa fa-calendar pos-abs-cal fdd_signed_datepicker" aria-hidden="true"></i>-->
                        @if ($errors->has('fdd_signed_date'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('fdd_signed_date') }}</strong>
                            </span>
                        @endif
			    		<label class="error error1" for="fdd_signed_date"></label>
			    	</figure>
		    		<figure class="pos-rel">
			    		<label>Date of FDD Expiration<!--<span class="required-field">*</span>--></label>
			    		<input class="datepicker fdd_expiration_datepicker" type="text" autocomplete="off" id="fdd_expiration_date" value="@if($Franchise->fdd_expiration_date != "" && $Franchise->fdd_expiration_date != '0000-00-00'){{ date('m/d/Y',strtotime($Franchise->fdd_expiration_date )) }}@endif" name="fdd_expiration_date" placeholder="mm/dd/yy">
			    		<i class="fa fa-calendar pos-abs-cal fdd_expiration_datepicker" aria-hidden="true"></i>
                        @if ($errors->has('fdd_expiration_date'))
                            <span class="help-block error">
                                <strong style="color:red">{{ $errors->first('fdd_expiration_date') }}</strong>
                            </span>
                        @endif
			    		<label class="error1 error" for="fdd_expiration_date"></label>
			    	</figure>
			    	
	    		</div>	
	    	</div>
		    </div>
		    
		    
		</div>
	</form>

    <form action="{{ url('admin/franchise/invite/'.$Franchise->id.'/'.$Owner->id) }}"  method="post" id="invite_form" autocomplete="off" style="display:none !important;">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    	<div class="view-tab-content-head-main">
    		<div class="view-tab-content-head">
    			<h3>Send Credentials To Owner</h3>
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
                    <input type="email" autocomplete="off" name="login_email" id="login_email" value="{{ $Owner->email }}">
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
	$(document).ready(function() {
		//Phone number validation
		//$('input[name=phonenumber]').samask("000-000-0000");
		//$('input[name=faxnumber]').samask("000-000-0000");
		$('input[name="phonenumber"]').inputmask({"mask": "999-999-9999"});
		$('input[name="faxnumber"]').inputmask({"mask": "999-999-9999"});

		jQuery.validator.addMethod("validate_email", function(value, element) {

		    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
		        return true;
		    } else {
		        return false;
		    }
		}, "Please enter a valid Email.");
		
		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");
		
		jQuery.validator.addMethod("lettersonly", function(value, element) {
		  return this.optional(element) || /^[a-z\ \s]+$/i.test(value);
		}, "Letters only please");     	

		$( "#editFranchise" ).validate({
		  rules: {
		    //franchise_name:{required:true,nameRegex:true,},
		    /*state:{required:true,},
		    location:{required:true,},
		    address:{required:true,},
		    city:{required:true,lettersonly:true},
		    zipcode:{required:true,},
		    email:{
		    	required:true,
		    	validate_email: true,
		    },
		    phonenumber:{
		    	required:true,
		    	phoneUS:true,
		    	usphonenumb:true,
		    },
		    faxnumber:{
		    	//required:true,
		    	phoneUS:true,
		    	usphonenumb:true
		    },*/
		    location:{required:true,},
		  },
		  messages:{
		  	/*phonenumber:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			},
		  	faxnumber:{
				phoneUS:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
				usphonenumb:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
			},*/
		  }
		});

		$('#invite_form').validate({
			rules:{
				login_email:{required:true, validate_email:true},
				emp_password:{required:true,minlength:6},
				emp_confirm_password:{equalTo: "#emp_password"},				
			}
		});

		//$("#fdd_signed_date").datetimepicker({
		$(".fdd_signed_datepicker").datetimepicker({	
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'top-left',
	    });
	    
	    //$("#fdd_expiration_date").datetimepicker({
	    $(".fdd_expiration_datepicker").datetimepicker({
		    autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'top-left',  	
	    });


		//Function for exist email
		$('#saveChanges').click(function(){
			var $valid = $('#editFranchise').valid();
			if(!$valid) {
				return false;
			}else{
				var franchise_id = '{{ $Franchise->id }}';
				var employee_email = $('input[name=email]').val();
				if(employee_email != '' && $valid)
				{
					$.ajax({
						url:'{{ url("admin/franchise/emailexisteditfranchise") }}',
						type:'POST',
						dataType:'json',
						data:{email: employee_email, franchise_id: franchise_id, '_token':'{{ csrf_token() }}'},
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
									$('#editFranchise').submit();	
								}
							}
							
						},
					});
					return false;
				}
			}
		});

		//Function for exist email
		$('.invite_btn').click(function(){
			var $valid = $('#invite_form').valid();
			if(!$valid) {
				return false;
			}else{
				var employee_id = '{{ $Owner->id }}';
				var employee_email = $('input[name=login_email]').val();
				if(employee_email != '' && $valid)
				{
					$.ajax({
						url:'{{ url("admin/franchise/ownerexist") }}',
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
									$('#invite_form').submit();	
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
