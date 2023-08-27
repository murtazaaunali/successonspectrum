@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise"><h4>{{$sub_title}}</h4></div>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="addFranchise">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<div id="rootwizard">
		<div class="container tabs-wrap col-2">
			<div class="add-employee-tabs-main add-franchise-tabs-main Marg-Bot-14">
				<div class="navbar">
				  <div class="navbar-inner">
					<ul class="nav nav-tabs">
					  	<li class="active li-after-none"><a href="#tab1" data-toggle="tab">1. Franchise Demographic</a></li>
						<li ><a href="#tab2" data-toggle="tab">2. Contract & Fee</a></li>
						<li class="third-tab"><a href="#tab3" data-toggle="tab">3. Create Franchise<!-- Franchise Owner Details--></a></li>
						<li class="mar-right-zreo"><a href="#tab4" data-toggle="tab" class="hidden">4. Create Franchise</a></li>
					</ul>
				  </div>
				</div>
			</div>	  

		
			<div class="tab-content TabsBorder FranchiseDemographicMain">
			    <div class="tab-pane active" id="tab1">

					<div class="add-employee-body-main">
						<div class="view-tab-content-head-main add-employee-head">
				    		<div class="view-tab-content-head">
				    			<h3>1. Franchise Demographic</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-user-o" aria-hidden="true"></i>Add Owner</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
					    <div class="add-employee-data padd-left-0">
					    <div class="super-admin-add-relation-main add-franchise-tabs-data-main padd-0">
				    		<div class="super-admin-add-relation border-bot-0 spinner_main">
				    			<div class="spinner_inner">
				    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
				    				Checking email if exist.	
				    			</div>

				    			<figure>
						    		<label>Franchise Status</label>
						    		<select name="status">
						    			<option value="Active">Active</option>
						    			<option value="Terminated">Terminated</option>
						    			<option value="Expired">Expired</option>
                                        <option value="Potential">Potential</option>
						    		</select>
					    		</figure>
					    		{{--<figure class="pos-rel">
						    		<label>Franchise Activation Date</label>
						    		<input class="datepicker" readonly="" id="franchise_activation_date" name="franchise_activation_date" autocomplete="off" type="text" required placeholder="mm/dd/yy">
						    		<i class="fa fa-calendar pos-abs-cal" aria-hidden="true"></i>
						    		<label for="franchise_activation_date" class="error error1"></label>
						    	</figure>
						    	<figure>	
						    		<label>Franchise Name</label>
						    		<input type="text" name="franchise_name" required placeholder="Franchise Name">
						    		<label for="franchise_name" class="error error1"></label>
						    	</figure>--}}
						    	<figure>	
						    		<label>Franchise Location</label>
						    		<input type="text" name="location" required placeholder="Franchise Location">
						    		<label for="location" class="error error1"></label>
						    	</figure>
						    	<figure>	
						    		<label>Franchise Address</label>
						    		<input type="text" name="address" required placeholder="Franchise Address">
						    		<label for="address" class="error error1"></label>
						    	</figure>
				    			<figure>
						    		<label>City</label>
						    		<input type="text" placeholder="City" name="city">
						    		<label for="city" class="error error1"></label>
						    	</figure>
						    	<figure>
						    		<label>State</label>	
						    		@if($states)	
						    			<select name="state">
						    				<option value="">Select State</option>
							    			@foreach($states as $state)
							    				<option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
							    			@endforeach
						    			</select>
						    		@endif
						    		<label for="state" class="error error1"></label>
					    		</figure>
						    	<figure>
						    		<label>Zip</label>	
						    		<input type="text" placeholder="Zip" name="zipcode">
						    		<label for="zipcode" class="error error1"></label>
						    	</figure>
					    		<figure>
						    		<label>Franchise Phone Number</label>
						    		<input type="text" name="phonenumber" placeholder="xxx-xxx-xxxx">
						    		<label for="phonenumber" class="error error1"></label>
						    	</figure>
								<figure>
									<label>Franchise Fax Number</label>
									<input type="text" name="faxnumber" placeholder="xxx-xxx-xxxx">
									<label for="faxnumber" class="error error1"></label>
								</figure>
						    	<figure>	
						    		<label>Franchise Email Address</label>
						    		<input type="text" name="email" placeholder="Franchise Email Address">
						    		<label for="email" class="error error1"></label>
						    	</figure>
						    	<figure style="display:none">	
						    		<label>Password</label>
						    		<input type="password" name="password" id="password" placeholder="Password" value="123456">
						    		<label for="password" class="error error1"></label>
						    	</figure>
						    	<figure style="display:none">	
						    		<label>Confirm Password</label>
						    		<input type="password" name="confirm_password" placeholder="Confirm Password" value="123456">
						    		<label for="confirm_password" class="error error1"></label>
						    	</figure>						    	

						    	{{--<figure>
						    		<label>Client Address</label>
						    		<input type="text" name="client_address" placeholder="Client Address">
						    		<label for="client_address" class="error error1"></label>
						    	</figure>
						    	<figure>	
						    		<label>City</label>
						    		<input type="text" placeholder="City" name="client_city">
						    		<label for="client_city" class="error error1"></label>
						    	</figure>
						    	<figure>
						    		<label>Zip</label>
						    		<input type="text" placeholder="Zip" name="client_zipcode">
						    		<label class="error error1" for="client_zipcode"></label>
						    	</figure>
						    	<figure>
						    		<label>State</label>	
						    		@if($states)	
						    			<select name="client_state">
						    				<option value="">Select State</option>
							    			@foreach($states as $state)
							    				<option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
							    			@endforeach
						    			</select>
						    		@endif
						    		<label for="client_state" class="error error1"></label>	
						    	</figure>--}}
				    		</div>	
				    	</div>
						    <div class="franchise-data-1 franchise-tabs-data-1">
						    	<label></label>
								<ul class="pager wizard two-btn front">
									<li class="next pull-right"><button name="" type='button' class='btn add-franchise-data-butn nxt-butn-ri8 button-next b-btn' name='next'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></</button></li>
								</ul>
						    </div>
					    </div>
					</div>

			    </div><!--tab1-->
			    
			    <!-- /////////////////////////////////
			    	Contract & Fee
			    ////////////////////////////////////-->
			    <div class="tab-pane" id="tab2">

					<div class="back-gr-white">
					    <div class="view-tab-content-main">
					    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
					    		<div class="view-tab-content-head">
					    			<h3>2. Contract & Fee</h3>
					    		</div>
					    		<div class="view-tab-content-butn">
					    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
					    		</div>
					    		<div class="clearfix"></div>
					    	</div>
					    	<div class="super-admin-add-relation-main">
					    		<div class="super-admin-add-relation border-bot-0">
					    			<figure class="pos-rel">
							    		<label>Date FDD Was Signed</label>
							    		<input class="datepicker fdd_signed_datepicker" type="text" autocomplete="off" id="fdd_signed_date" name="fdd_signed_date" required="" placeholder="mm/dd/yy">
							    		<i class="fa fa-calendar pos-abs-cal fdd_signed_datepicker" aria-hidden="true"></i>
							    		<label class="error error1" for="fdd_signed_date"></label>
							    	</figure>
						    		<figure class="pos-rel">
							    		<label>Date of FDD Expiration</label>
							    		<input class="datepicker fdd_expiration_datepicker" type="text" autocomplete="off" id="fdd_expiration_date" name="fdd_expiration_date" required="" placeholder="mm/dd/yy">
							    		<i class="fa fa-calendar pos-abs-cal fdd_expiration_datepicker" aria-hidden="true"></i>
							    		<label class="error1 error" for="fdd_expiration_date"></label>
							    	</figure>
							    	<figure class="pos-rel hidden">
							    		<label>Contract Duration<br> Start Date</label>
							    		<input id="startDate" autocomplete="off" type="text" placeholder="Strat Date" name="contract_start" class="contract_start_datepicker">
							    		<i class="fa fa-calendar pos-abs-cal cal-icon contract_start_datepicker" aria-hidden="true"></i>
							    		<label class="error error1" for="startDate"></label>
							    	</figure>
							    	<figure class="pos-rel hidden">
							    		<label>Contract Duration<br> Expiration Date</label>	
							    		<input id="endDate" autocomplete="off" type="text" placeholder="Expiration Date" name="contract_end" class="contract_end_datepicker">
							    		<i class="fa fa-calendar pos-abs-cal cal-icon contract_end_datepicker" aria-hidden="true"></i>
							    		<label class="error1 error" for="endDate"></label>
							    	</figure>
							    	<figure class="pos-rel">
							    		<label>Fee Due Date</label>
							    		<input type="text" name="feedue_date" id="feedue_date" min="1" max="30">
							    	</figure>
					    			<figure>
							    		<label>Initial Franchise Fee <br>(one time fee)</label>
							    		<input type="text" name="initialfranchise_fee" placeholder="$0.00">
							    		<label class="error error1" for="initialfranchise_fee"></label>
						    		</figure>
						    		{{--<figure>
							    		<label>Monthly Royalty Fee <br>(once a month for 5 years)</label>
							    		<input type="text" name="monthly_royalty_fee" placeholder="$0.00">
							    		<label class="error error1" for="monthly_royalty_fee"></label>
							    	</figure>--}}
                                    <figure class="lin-higt-maintan">	
                                        <label class="w-100">Monthly Royalty Fees (once a month for 5 year)</label>
                                        <div class="clearfix"></div>
                                    </figure>
                                    <figure>	
                                        <label style="font-weight:500">For first year</label>
                                        <input name="monthly_royalty_fee" type="text" value="$0.00">
                                        <label class="error error1" for="monthly_royalty_fee"></label>
                                    </figure>
                                    <figure>
                                        <label style="font-weight:500">For second year</label>
                                        <input name="monthly_royalty_fee_second_year" type="text" value="$0.00">
                                        <label class="error error1" for="monthly_royalty_fee_second_year"></label>
                                    </figure>
                                    <figure style="border-bottom: 1px #eee solid;">
                                        <label style="font-weight:500">For subsequent years</label>
                                        <input name="monthly_royalty_fee_subsequent_years" type="text" value="$0.00">
                                        <label class="error error1" for="monthly_royalty_fee_subsequent_years"></label>
                                        <div class="clearfix">&nbsp;</div>
                                    </figure>
							    	<figure >	
							    		<label>Monthly System Advertising Fee <br>(once a month for 5 year)</label>
							    		<input type="text" name="monthly_advertising_fee" placeholder="$0.00">
							    		<label class="error error1" for="monthly_advertising_fee"></label>
							    	</figure>
							    	<figure>	
							    		<label>Renewal Fee <br>(Due upon expiration of the FDD contract)</label>
							    		<input type="text" name="renewal_fee" placeholder="$0.00">
							    		<label class="error error1" for="renewal_fee"></label>
							    	</figure>
							    	<div class="franchise-data franchise-data-1 two-butn">
							    	<label></label>
									<ul class="pager wizard two-btn front">
										<li class="previous pull-left"><button name="" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back' name='previous'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
										<li class="next pull-right"><button name="" type='button' class='btn button-next add-franchise-data-butn nxt-butn-ri8 b-btn' name='next'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></</button></li>
									</ul>

							    </div>
					    		</div>	
					    	</div>
					    </div>
					</div>

			    </div><!--tab2-->
			    
			    <!-- /////////////////////////////////
			    	3. Franchise Owner Details
			    ////////////////////////////////////-->		    
				<div class="tab-pane" id="tab3">

					<div class="back-gr-white">
					    <div class="view-tab-content-main">
					    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
					    		<div class="view-tab-content-head">
					    			<h3>3. Franchise Owner Details</h3>
					    		</div>
					    		<div class="view-tab-content-butn">
					    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
					    		</div>
					    		<div class="clearfix"></div>
					    	</div>
					    	<div class="super-admin-add-relation-main">
					    		<div class="super-admin-add-relation">
					    			<figure>
							    		<label>Full Name</label>
							    		<input type="text" name="owner_name" placeholder="Full Name">
							    		<label class="error error1" for="owner_name"></label>
						    		</figure>
						    		<figure>
							    		<label>Email Address</label>
							    		<input type="text" name="owner_email" placeholder="Email Address">
							    		<label class="error error1" for="owner_email"></label>
							    	</figure>
					    			<figure>
							    		<label>Contact Number</label>
							    		<input type="text" name="owner_contact" id="owner_contact" placeholder="xxx-xxx-xxxx">
							    		<label class="error1 error" for="owner_contact"></label>
						    		</figure>
							    	<div class="franchise-data franchise-data-1 two-butn">
							    	<label></label>
									<ul class="pager wizard two-btn front">
										<li class="previous pull-left"><button name="" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back' name='previous'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
										<li class="next pull-right"><button name="" type='button' class='btn button-next add-franchise-data-butn nxt-butn-ri8 b-btn' name='next'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></</button></li>
									</ul>
							    </div>
					    		</div>	
					    	</div>
					    </div>
					</div>

				</div><!--tab3-->

			    <!-- /////////////////////////////////
			    	Congratulations!
			    ////////////////////////////////////-->		    
				<div class="tab-pane" id="tab4">
					<div class="back-gr-white back-gr-white-thanks">
				    	<div class="last-tab-data-main">
				    		<div class="last-tab-data">
				    			<h3>Congratulations!</h3>
				    			<p>The franchise has been successfully created.</p>
				    			<a href="" class="btn view_franchise">View Franchise</a>
				    		</div>
				    	</div>
				    </div>
				</div><!--tab4-->
			        
			</div>

		</div>
	</div><!--rootwizard-->	
	</form>
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
          <input class="btn " type="button" data-dismiss="modal" value="Close">
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
	$( function() {
	$('.continue').click(function(){
	  $('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
	$('.back').click(function(){
	  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});

	$(document).ready(function() {
		//$("#fdd_signed_date").datetimepicker({
		$(".fdd_signed_datepicker").datetimepicker({
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'bottom-left',
	    });
	    
	    //$("#fdd_expiration_date").datetimepicker({
		$(".fdd_expiration_datepicker").datetimepicker({
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'bottom-left',  	
	    });

		//Phone number validation
		/*$('input[name=phonenumber]').samask("000-000-0000");
		$('input[name=faxnumber]').samask("000-000-0000");
		$('input[name=owner_contact]').samask("000-000-0000");*/
		$('input[name="phonenumber"]').inputmask({"mask": "999-999-9999"});
		$('input[name="faxnumber"]').inputmask({"mask": "999-999-9999"});
		$('input[name="owner_contact"]').inputmask({"mask": "999-999-9999"});
		
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

		jQuery.validator.addMethod("descimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");
		
		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");
		
		jQuery.validator.addMethod("lettersonly", function(value, element) {
		  return this.optional(element) || /^[a-z\ \s]+$/i.test(value);
		}, "Letters only please");     	

		/*$( "#addFranchise" ).validate({
		  rules: {
		    //franchise_name:{required:true,nameRegex:true,},
		    state:{required:true,},
		    address:{required:true,},
		    zipcode:{required:true, number:true},
		    city:{required:true, lettersonly:true},
		    password:{required:true, minlength:6},
		    confirm_password:{equalTo: "#password"},
		    email:{
		    	required:true,
		    	validate_email: true
		    },
		    phonenumber:{
		    	required:true,
		    	phoneUS:true,
		    	usphonenumb:true
		    },
			faxnumber:{
		    	//required:true,
		    	phoneUS:true,
		    	usphonenumb:true
		    },
		    location:{required:true,},
		    //client_address:{required:true,},
		    //client_city:{required:true,},
		    //client_state:{required:true,},
		    //client_zipcode:{required:true, number:true},
			feedue_date:{required:true, digits:true},
			//initialfranchise_fee:{required:true, number:true, descimalPlaces:true},
		    initialfranchise_fee:{required:true},
			//contract_start:{required:true, date:true},
		    //contract_end:{required:true, date:true},
		    //monthly_royalty_fee:{required:true, number:true, descimalPlaces:true},
		    //monthly_advertising_fee:{required:true, number:true, descimalPlaces:true},
		    //renewal_fee:{required:true, number:true, descimalPlaces:true},
			monthly_royalty_fee:{required:true},
		    monthly_advertising_fee:{required:true},
		    renewal_fee:{required:true},
		    owner_name:{required:true,nameRegex:true},
		    owner_email:{required:true,validate_email:true},
		    //franchise_activation_date:{required:true, date:true},
		    fdd_signed_date:{required:true, date:true},
		    fdd_expiration_date:{required:true, date:true},
		    owner_contact: {
		      required: true,
		      phoneUS: true,
		      usphonenumb: true
		    },
		  },
		  messages:{
		  	owner_contact:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			},
		  	phonenumber:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			},
			faxnumber:{
				phoneUS:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
				usphonenumb:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
			},
			confirm_password:{
				equalTo:'Please confirm your password'
			}
		  }
		});*/
		var status_condition = function()
		{
			return ($('select[name="status"]').val() == "Validation");
		}
		$( "#addFranchise" ).validate({
		  rules: {
		    state:{required:status_condition},
		    address:{required:status_condition},
		    zipcode:{required:status_condition, number:status_condition},
		    city:{required:status_condition, lettersonly:status_condition},
		    password:{required:status_condition, minlength:6},
		    confirm_password:{equalTo: "#password"},
		    email:{
		    	required:status_condition,
		    	validate_email: status_condition
		    },
		    phonenumber:{
		    	required:status_condition,
		    	phoneUS:status_condition,
		    	usphonenumb:status_condition
		    },
			faxnumber:{
		    	//required:true,
		    	phoneUS:status_condition,
		    	usphonenumb:status_condition
		    },
		    location:{required:true},
		    //client_address:{required:true,},
		    //client_city:{required:true,},
		    //client_state:{required:true,},
		    //client_zipcode:{required:true, number:true},
			feedue_date:{required:status_condition, digits:status_condition},
			//initialfranchise_fee:{required:true, number:true, descimalPlaces:true},
		    initialfranchise_fee:{required:status_condition},
			//contract_start:{required:true, date:true},
		    //contract_end:{required:true, date:true},
		    //monthly_royalty_fee:{required:true, number:true, descimalPlaces:true},
		    //monthly_advertising_fee:{required:true, number:true, descimalPlaces:true},
		    //renewal_fee:{required:true, number:true, descimalPlaces:true},
			monthly_royalty_fee:{required:status_condition},
		    monthly_advertising_fee:{required:status_condition},
		    renewal_fee:{required:status_condition},
		    owner_name:{required:status_condition,nameRegex:status_condition},
		    owner_email:{required:status_condition,validate_email:status_condition},
		    //franchise_activation_date:{required:true, date:true},
		    fdd_signed_date:{required:status_condition, date:status_condition},
		    fdd_expiration_date:{required:status_condition, date:status_condition},
		    owner_contact: {
		      required: status_condition,
		      phoneUS: status_condition,
		      usphonenumb: status_condition
		    },
		  },
		  messages:{
		  	owner_contact:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			},
		  	phonenumber:{
				phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
			},
			faxnumber:{
				phoneUS:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
				usphonenumb:'Please Enter a Valid Fax Number. (Eg: xxx-xxx-xxxx)',
			},
			confirm_password:{
				equalTo:'Please confirm your password'
			}
		  }
		});
	  	
	  	$('#rootwizard').bootstrapWizard({
	  		'nextSelector': '.button-next', 
	  		'previousSelector': '.button-previous',
			onTabClick: function(tab, navigation, index) {
				return false;
			},
			onNext: function(tab, navigation, index) {
	  			var $valid = $("#addFranchise").valid();
	  			if(!$valid) {
	  				return false;
				}else{

					///////////////////////////////////////////////
					//CHECKING IF FRANCHISE EMAIL IS ALREADY EXITS//
					///////////////////////////////////////////////
					var $valid = $("#addFranchise").valid();
					if(index == 1){
						var f_email = $('input[name=email]').val();
						if(f_email != '' && $valid){
							
							$.ajax({
								url:'{{ url("admin/franchise/emailexist") }}',
								type:'POST',
								dataType:'json',
								data:{email: f_email, '_token':'{{ csrf_token() }}'},
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
											$('#rootwizard').bootstrapWizard('show',1);	
										}
									}
									
								},
							});	
							return false;
						}
					}
					///////////////////////////////////////////////
					//CHECKING IF FRANCHISE EMAIL IS ALREADY EXITS//
					///////////////////////////////////////////////

					if(index == 3){
		  				var formData = $('#addFranchise').serialize();
						var conditionCheck = true;
						$.ajax({
							url:'{{ url("admin/franchise/add") }}',
							type:'POST',
							dataType:'json',
							data:formData,
							success:function(response){
								
								var url = '{{ url("admin/franchise/view/")}}';
								if(typeof(response) == 'object'){
									if('errors' in response){
										var Errors = '';
				                  		$.each(response.errors, function(key, value){
				                  			Errors += value+'\n';
				                  		});
				                  		alert(Errors);	
										$('#rootwizard').bootstrapWizard('show',index - 1);
									}
									if('success' in response){
										$('.view_franchise').attr('href',url+'/'+response.franchise_id);
										$('#rootwizard').bootstrapWizard('show',3);	
										$('.third-tab').addClass('active');
									}
								}
								
							},
				            error: function (request, status, error) {
				                json = $.parseJSON(request.responseText);
				                var Error = '';
				                $.each(json.errors, function(key, value){
				                    Error += value+'\n';
				                });
				                if(Error){
									alert(Error);
								}
				                
				            }							
							
						}); //End ajax here 
						return false
					}
				}		

	  			$(window).scrollTop($('#rootwizard').offset().top);
            },
			onPrevious: function(tab, navigation, index) {
	  			$(window).scrollTop($('#rootwizard').offset().top);
            },

	  	});
	  	//
	  	
		window.prettyPrint && prettyPrint();
		$('#rootwizard .finish').click(function () {
  			var $valid = $("#addFranchise").valid();
  			if(!$valid) {
  				return false;
  			}else{
				$('#addFranchise').submit();
			}
		});	
  	//$("#startDate").datetimepicker({
	$(".contract_start_datepicker").datetimepicker({	
        today:  1,
        autoclose: true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2,
	    pickerPosition: 'bottom-left',
	}).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        minDate.setMonth(minDate.getMonth() + 12);
        $(this).parents('.super-admin-add-relation').find('#endDate').datetimepicker('setStartDate', minDate);
	});
	//$("#endDate").datetimepicker({
    $(".contract_end_datepicker").datetimepicker({
	    autoclose: true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2,
	    pickerPosition: 'bottom-left',  	
	}).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        minDate.setMonth(minDate.getMonth() - 12);
        $(this).parents('.super-admin-add-relation').find('#startDate').datetimepicker('setEndDate', minDate);
	 });

	});	
});
</script>
 
@endsection
