@extends('franchise.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise"><h4>{{$sub_title}}</h4></div>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="addEmployee">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<div id="rootwizard">
		<div class="container tabs-wrap col-2">
			<div class="add-employee-tabs-main">
				<div class="navbar">
				  <div class="navbar-inner">

					<ul class="nav nav-tabs FranchiseSixTabs">
						<li class="active li-after-none"><a href="#tab1" data-toggle="tab">1. Employee's Demographic</a></li>
						<li><a href="#tab2" data-toggle="tab" >2. Emergency Contacts</a></li>
						<li><a href="#tab3" data-toggle="tab" >3. Benefit Information</a></li>
						<li><a href="#tab4" data-toggle="tab" >4. Set Schedule</a></li>
                        <li><a href="#tab5" data-toggle="tab" >5. ABA Experience/Reference</a></li>
						<li class="mar-right-zreo"><a href="#tab6" data-toggle="tab">6. Finish Form</a></li>
					</ul>

				  </div>
				</div>
			</div>	  

		
			<div class="tab-content TabsBorder EmployeeDemographicMain">
			    <!-- /////////////////////////////////
			    	1. Employee's Demographic
			    ////////////////////////////////////-->
                <div class="tab-pane active" id="tab1">

					<div class="add-employee-body-main">
						<div class="add-employee-head">
				    		<div class="view-tab-content-head">
				    			<h3>1. Employee's Demographic</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-user-o" aria-hidden="true"></i>Add Owner</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
					    <div class="super-admin-add-relation-main">
				    		<div class="super-admin-add-relation border-bot-0 spinner_main">
				    			<div class="spinner_inner">
				    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
				    				Checking email if exist.	
				    			</div>
				    			<figure>
						    		<label>Set Status</label>
						    		<select name="status">
						    			<option>Active</option>
						    			<option>Terminated</option>
						    			<option>Applicant</option>
						    			<option>Vacation</option>
						    		</select>
					    		</figure>
					    		<figure>
						    		<label>Employee Name<span class="required-field">*</span></label>
						    		<input type="text" name="employee_name" placeholder="Employee Name">
						    		<label class="error error1" for="employee_name"></label>
						    	</figure>
                                <figure class="pos-rel">
						    		<label>Employee DOB<span class="required-field">*</span></label>
						    		<input name="employee_dob" id="employee_dob" type='text' placeholder="mm/dd/yy" class="employee_dob_datepicker" />
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employee_dob_datepicker" aria-hidden="true"></i></a>
						    		<label class="error error1" for="employee_dob"></label>
					    		</figure>
                                <figure>	
						    		<label>Employee Address<span class="required-field">*</span></label>
						    		<input type="text" name="employee_address" placeholder="Employee Address">
						    		<label class="error1 error" for="employee_address"></label>
						    	</figure>
                                <figure>	
						    		<label class="hidden-xs">&nbsp;</label>
                                    <div class="input-group-row">
                                        <div class="input-group-col-4 input-group-col-first">
                                        	<input type="text" name="employee_city" placeholder="Employee City" >
                                        	<label class="error1 error" for="employee_city" style="left:0"></label>
                                        </div>
                                        <div class="input-group-col-4">
                                        	<input type="text" name="employee_state" placeholder="Employee State" >
                                        	<label class="error1 error" for="employee_state" style="left:0"></label>
                                        </div>
                                        <div class="input-group-col-4 input-group-col-last">
                                        	<input type="text" name="employee_zipcode" placeholder="Employee Zip" >
                                        	<label class="error1 error" for="employee_zipcode" style="left:0"></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
						    	</figure>
                                <figure>	
						    		<label>Employee SS#<span class="required-field">*</span></label>
						    		<input type="text" name="employee_ss" placeholder="Employee SS#">
						    		<label class="error error1" for="employee_ss"></label>
						    	</figure>
						    	<figure>	
						    		<label>Employee Email<span class="required-field">*</span></label>
						    		<input type="email" name="employee_email" placeholder="Employee Email">
						    		<label class="error error1" for="employee_email"></label>
						    	</figure>
                                <figure>	
						    		<label>Employee Phone<span class="required-field">*</span></label>
						    		<input type="text" name="employee_phone" placeholder="xxx-xxx-xxxx">
						    		<label class="error error1" for="employee_phone"></label>
						    	</figure>
                                <div class="radio-btun">
						    		<figure>	
							    		<label>Authorize To Work in The US</label>
							    		<input type="radio" value="Yes" name="work_authorised" checked><span>&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
							    		<input type="radio" value="No" name="work_authorised"><span>&nbsp;No</span>
						    		</figure>
						    	</div>
                                <div class="radio-btun">
						    		<figure>	
							    		<label>Capable Of Performing The Essential Functions Of The Job Which You Are Applying Without Any Accommodations?</label>
							    		<input type="radio" value="Yes" name="work_capable" checked class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
							    		<input type="radio" value="No" name="work_capable" class="vartical-top"><span class="vartical-top">&nbsp;No</span>
						    		</figure>
						    	</div>
                                <figure>	
						    		<label>If No, What Accommodations Do You Need?</label>
						    		<input type="text" name="work_nocapable" disabled="disabled" class="vartical-top">
						    		<label class="error1 error" for="work_nocapable"></label>
						    	</figure>
                                <div class="radio-btun">
						    		<figure>	
							    		<label>Are you able to lift 30 to 40 lbs? Able to do physical activities?</label>
							    		<input type="radio" value="Yes" name="work_liftlbs" checked class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
							    		<input type="radio" value="No" name="work_liftlbs" class="vartical-top"><span class="vartical-top">&nbsp;No</span>
						    		</figure>
						    	</div>
						    	<figure>	
						    		<label>Employment Type<!--<span class="required-field">*</span>--></label>
						    		<select name="employee_type">
						    			<option value="">Select Employment Type</option>
						    			<option>Full-Time</option>
						    			<option>Part-Time</option>
						    			<option>Contract</option>
						    			<!--<option>Others</option>-->
						    		</select>
						    		<label class="error error1" for="employee_type"></label>
						    	</figure>
                                <figure>	
						    		<!--<label>Employee Title<span class="required-field">*</span></label>-->
                                    <label>Desired Position<span class="required-field">*</span></label>
						    		<select name="employee_title">
						    			<option value="">Select Desired Position</option>
		                                <option>Billing</option>
		                                <option>Office Manager</option>
		                                <option>Receptionist</option>
		                                <option>BCBA</option>
		                                <option>BCBA Intern or BCaBA</option>
		                                <option>RBT Trainer</option>
		                                <option>Behavior Technician</option>						    		
                                    </select>
						    		<label class="error error1" for="employee_title"></label>
						    	</figure>
						    	<!--<figure>	
						    		<label>Employee Address<span class="required-field">*</span></label>
						    		<input type="text" name="employee_address" placeholder="Employee Address">
						    		<label class="error1 error" for="employee_address"></label>
						    	</figure>-->
				    			<figure class="pos-rel">
							    		<label>Hiring Date<span class="required-field">*</span></label>
							    		<input name="hiring_date" id="hiring_date" type='text' placeholder="mm/dd/yy" class="hiring_datepicker" />
					                    <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar hiring_datepicker" aria-hidden="true"></i></a>
							    		<label class="error error1" for="hiring_date"></label>
					    		</figure>
					    		<!--<figure>
						    		<label>Employee Type<span class="required-field">*</span></label>
						    		<input type="text" name="employee_type" placeholder="Employee Type" />
						    		<label class="error error1" for="employee_type"></label>
						    	</figure>-->
						    	<!--<figure class="pos-rel">
						    		<label>Employee DOB<span class="required-field">*</span></label>
						    		<input name="employee_dob" id="employee_dob" readonly="readonly" type='text' placeholder="mm/dd/yy" />
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar" aria-hidden="true"></i></a>
						    		<label class="error error1" for="employee_dob"></label>
					    		</figure>-->
						    	<figure class="pos-rel">	
						    		<label>90 Days Probation Completion Date<span class="required-field">*</span></label>
						    		<input type="text" class="datepicker" name="completion_date" id="completion_date" placeholder="90 Days Probation Completion Date" readonly="">
						    		<!--<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar cale-icon" aria-hidden="true"></i></a>-->
						    		<label class="error error1" for="completion_date"></label>
						    	</figure>
						    	<figure>	
						    		<label>Highest degree held<span class="required-field">*</span></label>
						    		<input type="text" name="highest_degree" placeholder="Highest degree held">
						    		<label class="error error1" for="highest_degree"></label>
						    	</figure>
						    	<!--<figure>	
						    		<label>Employee SS#<span class="required-field">*</span></label>
						    		<input type="text" name="employee_ss" placeholder="Employee SS#">
						    		<label class="error error1" for="employee_ss"></label>
						    	</figure>
						    	<figure>	
						    		<label>Employee Email<span class="required-field">*</span></label>
						    		<input type="email" name="employee_email" placeholder="Employee Email">
						    		<label class="error error1" for="employee_email"></label>
						    	</figure>-->
								<figure>	
						    		<label>Desired Location<span class="required-field">*</span></label>
                                    <select name="career_desired_location">
                                    <option value="">Select Desired Location</option>
                                    @if($franchises)
                						@foreach($franchises as $franchise)
                                            <option>{{ $franchise->location }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                    <label class="error error1" for="career_desired_location"></label>
						    	</figure>
                                <div class="radio-btun">
						    		<figure>	
							    		<label>Are you Registered by the BACB?</label>
							    		<input type="radio" value="Yes" name="career_bacb" checked class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
							    		<input type="radio" value="No" name="career_bacb" class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                        <label class="error error1" for="career_bacb"></label>
						    		</figure>
						    	</div>
                                <div class="radio-btun">
						    		<figure>	
							    		<label>Are You CPR Certified?</label>
							    		<input type="radio" value="Yes" name="career_cpr_certified" checked class="vartical-top"><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
							    		<input type="radio" value="No" name="career_cpr_certified" class="vartical-top"><span class="vartical-top">&nbsp;No</span>
                                        <label class="error error1" for="career_cpr_certified"></label>
						    		</figure>
						    	</div>
						    	<figure>	
						    		<label>Password<span class="required-field">*</span></label>
						    		<input type="password" name="password" id="password" placeholder="Password">
						    		<label for="password" class="error error1"></label>
						    	</figure>
						    	<figure>	
						    		<label>Confirm Password<span class="required-field">*</span></label>
						    		<input type="password" name="confirm_password" placeholder="Confirm Password">
						    		<label for="confirm_password" class="error error1"></label>
						    	</figure>
						    			
						    	<div class="franchise-data franchise-data-1 two-butn">
						    		<label></label>
									<ul class="pager wizard two-btn front">
										<li class="next pull-right"><button name="next" type='button' class='btn add-franchise-data-butn nxt-butn-ri8 button-next b-btn'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button></li>
									</ul>
						    	</div>
				    		</div>	
				    	</div>
					</div>
				    <!-- <a class="btn btn-primary continue btn add-franchise-data-butn nxt-butn-ri8">Next</a> -->				    
				    
			    </div><!--tab1-->
			    
			    <!-- /////////////////////////////////
			    	2. Emergency Contacts
			    ////////////////////////////////////-->
			    <div class="tab-pane" id="tab2">

				    <div class="back-gr-white">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>2. Emergency Contacts</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="super-admin-add-relation-main">
				    		<div class="emergency_append">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Relationship Type<span class="required-field">*</span></label>
						    		<input class="relation_type" type="text" name="emergency[0][relationship_type]" placeholder="Relationship Type">
						    		<label class="error1 error" for="emergency[0][relationship_type]"></label>
					    		</figure>
					    		<figure>
						    		<label>Full Name<span class="required-field">*</span></label>
						    		<input class="fullname" type="text" name="emergency[0][fullname]" placeholder="Full Name">
						    		<label class="error error1" for="emergency[0][fullname]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Phone Number<span class="required-field">*</span></label>
						    		<input class="phonenumber" type="text" name="emergency[0][phonenumber]" placeholder="xxx-xxx-xxxx">
						    		<label class="error1 error" for="emergency[0][phonenumber]"></label>
						    	</figure>
						    	<figure>	
						    		<label>Email Address<span class="required-field">*</span></label>
						    		<input class="email" type="email" name="emergency[0][email]" placeholder="Email Address">
						    		<label class="error error1" for="emergency[0][email]"></label>
						    	</figure>
						    </div>
						    </div>

							<div class="super-admin-add-relation">
						    	<figure>	
						    		<label></label>
						    		<input class="btn add-relation-dashed" type="button" value="+ Add Relationship">
						    	</figure>
						    	<div class="franchise-data franchise-data-1 two-butn">
						    	<label></label>
									<ul class="pager wizard two-btn front">
										<li class="previous pull-left"><button name="previous" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
										<li class="next pull-right"><button name="next" type='button' class='btn button-next add-franchise-data-butn nxt-butn-ri8 b-btn'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button></li>
									</ul>
								</div>
				    		</div>	
				    	</div>

				    </div>
				</div>

			    </div><!--tab2-->
			    
			    <!-- /////////////////////////////////
			    	3. Benefit Information
			    ////////////////////////////////////-->		    
				<div class="tab-pane" id="tab3">
				    <div class="back-gr-white">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>3. Benefit Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    	<div class="super-admin-add-relation-main">
				    		<div class="super-admin-add-relation">
				    			<figure>
						    		<label>Desired Pay<span class="required-field">*</span></label>
						    		<input type="text" name="desired_pay" placeholder="Desired Pay">
						    		<label class="error error1" for="desired_pay"></label>
					    		</figure>
                                <figure>
						    		<label>Starting Pay Rate (Yearly)<span class="required-field">*</span></label>
						    		<input type="text" name="starting_pay" placeholder="Starting Pay Rate (Yearly)">
						    		<label class="error error1" for="starting_pay"></label>
					    		</figure>
					    		<figure>
						    		<label>Current Pay Rate (Yearly)<span class="required-field">*</span></label>
						    		<input type="text" name="current_pay" placeholder="Current Pay Rate (Yearly)">
						    		<label class="error1 error" for="current_pay"></label>
						    	</figure>
						    	<div class="radio-btun">
						    		<figure>	
							    		<label>Enrolled In Company's Health<br> Insurance Plan</label>
							    		<input type="radio" value="Yes" name="insurance_plan" checked><span>Yes</span>
							    		<input type="radio" value="No" name="insurance_plan"><span>No</span>
						    		</figure>
						    	</div>
						    	<div class="radio-btun">
						    		<figure>	
							    		<label>Enrolled In Company<br> Retirement Plan</label>
							    		<input type="radio" value="Yes" name="retirement_plan" checked><span>Yes</span>
							    		<input type="radio" value="No" name="retirement_plan"><span>No</span>
						    		</figure>
						    	</div>
				    			<figure>
						    		<label>Paid Vacation Per Year<span class="required-field">*</span></label>
						    		<input type="text" name="paid_vacation" placeholder="Paid Vacation Per Year">
						    		<label class="error error1" for="paid_vacation"></label>
					    		</figure>
					    		<figure>
						    		<label>Paid Holidays Per Year<span class="required-field">*</span></label>
						    		<input type="text" name="paid_holidays" placeholder="Paid Holidays Per Year">
						    		<label class="error1 error" for="paid_holidays"></label>
						    	</figure>
						    	<figure>	
						    		<label>Allowed Unexcused Sick<span class="required-field">*</span> Leaves</label>
						    		<input type="text" name="sick_leaves" placeholder="Allowed Unexcused Sick Leaves">
						    		<label class="error error1" for="sick_leaves"></label>
						    	</figure>
						    	<div class="franchise-data franchise-data-1 two-butn">
						    	<label></label>
								<ul class="pager wizard two-btn front">
									<li class="previous pull-left"><button name="previous" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
									<li class="next pull-right"><button name="next" type='button' class='btn button-next add-franchise-data-butn nxt-butn-ri8 b-btn'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button></li>
								</ul>
						    </div>
				    		</div>	
				    	</div>
				    	
				    </div>
				</div>
				</div><!--tab3-->

			    <!-- /////////////////////////////////
			    	4. Set Schedule
			    ////////////////////////////////////-->		    
				<div class="tab-pane" id="tab4">

				    <div class="back-gr-white">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>4. Set Schedule</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="super-admin-add-relation-main">
				    		<div class="super-admin-add-relation BoxWidth2 SetScheduleDiv">
				    			<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Monday</label>
							    	</div>
							    	<div class="row time-input">
								    	<div class="col-sm-6">	
								    		<span>Time in</span>
								    		<input class="timepicker" name="monday_timein" id="start_M" type="text" placeholder="00.00 AM">
								    	</div>
								    	<div class="col-sm-6">		
								    		<span>Time Out</span>
								    		<input class="timepicker" name="monday_timeout" id="end_M" type="text" placeholder="00.00 PM">
							    		</div>
						    		</div>
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Tuesday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">
								    		<span>Time in</span>
								    		<input class="timepicker" name="tuesday_timein" id="start_T" type="text" placeholder="00.00 AM">
							    		</div>
							    		<div class="col-sm-6">
								    		<span>Time Out</span>
								    		<input class="timepicker" name="tuesday_timeout" id="end_T" type="text" placeholder="00.00 PM">
							    		</div>
						    		</div>
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Wednesday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">
								    		<span>Time in</span>
								    		<input class="timepicker" name="wednesday_timein" id="start_W" type="text" placeholder="00.00 AM">
							    		</div>
							    		<div class="col-sm-6">
								    		<span>Time Out</span>
								    		<input class="timepicker" name="wednesday_timeout" id="end_W" type="text" placeholder="00.00 PM">
							    		</div>
						    		</div>	
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Thursday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">	
								    		<span>Time in</span>
								    		<input class="timepicker" name="thursday_timein" id="start_TH" type="text" placeholder="00.00 AM">
								    	</div>
								    	<div class="col-sm-6">	
								    		<span>Time Out</span>
								    		<input class="timepicker" name="thursday_timeout" id="end_TH" type="text" placeholder="00.00 PM">
								    	</div>	
						    		</div>
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Friday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">	
								    		<span>Time in</span>
								    		<input class="timepicker" name="friday_timein" id="start_F" type="text" placeholder="00.00 AM">
								    	</div>
								    	<div class="col-sm-6">	
								    		<span>Time Out</span>
								    		<input class="timepicker" name="friday_timeout" id="end_F" type="text" placeholder="00.00 PM">
								    	</div>	
						    		</div>
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Saturday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">		
								    		<span>Time in</span>
								    		<input class="timepicker" name="saturday_timein" id="start_S" type="text" placeholder="00.00 AM">
								    	</div>
								    	<div class="col-sm-6">	
								    		<span>Time Out</span>
								    		<input class="timepicker" name="saturday_timeout" id="end_S" type="text" placeholder="00.00 PM">
								    	</div>	
						    		</div>
					    		</div>
					    		<div class="input-time-picker">
					    			<div class="main-lable">
							    		<label>Sunday</label>
							    	</div>
							    	<div class="row time-input">
							    		<div class="col-sm-6">	
								    		<span>Time in</span>
								    		<input class="timepicker" name="sunday_timein" id="start_SU" type="text" placeholder="00.00 AM">
								    	</div>
								    	<div class="col-sm-6">	
								    		<span>Time Out</span>
								    		<input class="timepicker" name="sunday_timeout" id="end_SU" type="text" placeholder="00.00 PM">
								    	</div>	
						    		</div>
					    		</div>
						    	<div class="franchise-data franchise-data-1 two-butn">
									<ul class="pager wizard two-btn front">
										<li class="previous pull-left"><button name="previous" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
										<li class="next pull-right"><button name="next" type='button' class='btn button-next add-franchise-data-butn nxt-butn-ri8 b-btn'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></</button></li>
									</ul>
						    	</div>
				    		</div>	
				    	</div>
				    </div>
				</div>

				</div><!--tab4-->
				
                <!-- /////////////////////////////////
			    	5. ABA Experience/Reference
			    ////////////////////////////////////-->	
                <div class="tab-pane" id="tab5">
					
                    <div class="back-gr-white">
                    <div class="view-tab-content-main">
						<div class="view-tab-content-head-main view-tab-content-head-main-3">
				    		<div class="view-tab-content-head">
				    			<h3>5. ABA Experience/Reference</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" class="btn add-franchise-data-butn-1 back-g"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
					    <div class="super-admin-add-relation-main">
                            <div class="experience_append">
                            <div class="super-admin-add-relation super-admin-add-experience">
				    			<figure class="pos-rel">
						    		<label>Employment Starting Date:</label>
						    		<input name="aba_experience_reference[0][employment_startingdate]" type='text' placeholder="mm/dd/yy" class="employment_startingdate" />
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employment_startingdate" aria-hidden="true"></i></a>
						    		<label class="error error1" for="aba_experience_reference[0][employment_startingdate]"></label>
					    		</figure>
                                <figure class="pos-rel">
						    		<label>Employment Ending Date:</label>
						    		<input name="aba_experience_reference[0][employment_endingdate]" type='text' placeholder="mm/dd/yy" class="employment_endingdate" />
						    		<a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employment_endingdate" aria-hidden="true"></i></a>
						    		<label class="error error1" for="aba_experience_reference[0][employment_endingdate]"></label>
					    		</figure>
					    		<figure>
						    		<label>Company Name</label>
						    		<input type="text" name="aba_experience_reference[0][companyname]" placeholder="Company Name">
						    		<label class="error error1" for="aba_experience_reference[0][companyname]"></label>
						    	</figure>
                                <figure>
						    		<label>Position Held</label>
						    		<input type="text" name="aba_experience_reference[0][positionheld]" placeholder="Position Held">
						    		<label class="error error1" for="aba_experience_reference[0][positionheld]"></label>
						    	</figure>
                                <figure>
						    		<label>Reason For Leaving</label>
						    		<input type="text" name="aba_experience_reference[0][reasonforleaving]" placeholder="Reason For Leaving">
						    		<label class="error error1" for="aba_experience_reference[0][reasonforleaving]"></label>
						    	</figure>
                                <figure>
						    		<label>Manager's Name</label>
						    		<input type="text" name="aba_experience_reference[0][managersname]" placeholder="Manager's Name">
						    		<label class="error error1" for="aba_experience_reference[0][managersname]"></label>
						    	</figure>
                                <figure>
						    		<label>Phone#</label>
						    		<input type="text" name="aba_experience_reference[0][phone]" placeholder="xxx-xxx-xxxx" class="aba_experience_reference_phone">
						    		<label class="error error1" for="aba_experience_reference[0][phone]"></label>
						    	</figure>
				    		</div>	
                            </div>
                            <div class="super-admin-add-relation">
                                <figure>	
                                    <label></label>
                                    <input class="btn add-experience-dashed" type="button" value="+ Add Experience">
                                </figure>
                                <div class="franchise-data franchise-data-1 two-butn">
                                    <label></label>
                                    <ul class="pager wizard two-btn front">
                                        <li class="previous pull-left"><button name="previous" type='button' class='btn button-previous snd-mes-butn-1 eye-butn back'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
                                        <li class="next pull-right"><button name='next' type='button' class='btn add-franchise-data-butn nxt-butn-ri8 button-next b-btn'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button></li>
                                    </ul>
                                </div>
                            </div>
				    	</div>
					</div>
			    	</div>
                    
			    </div><!--tab5-->

				<!-- /////////////////////////////////
			    	6. Finish Form
			    ////////////////////////////////////-->
                <div class="tab-pane" id="tab6">
				    <div class="back-gr-white">
				    	<div class="last-tab-data-main">
				    		<div class="last-tab-data">
				    			<h3>Congratulations!</h3>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				    			<a class="view_franchise btn" href="">To Employees Profile</a>
				    		</div>
				    	</div>
				    </div>					
				</div><!--tab5-->
			        
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
			date.setDate( date.getDate() + 90);
			var dateafter_90days = ("0" + (date.getMonth() + 1)).slice(-2) + "/" + ("0" + date.getDate() ).slice(-2) + "/" + date.getFullYear();
			$('#completion_date').val(dateafter_90days);
		});
		
		//$('input[name="aba_experience_reference[0][employment_startingdate]"]').datetimepicker({
		$('.employment_startingdate').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var start_date = new Date(selected.date.valueOf());
			var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
			$('input[name="aba_experience_reference[0][employment_endingdate]"]').datetimepicker('setStartDate', setStartDate);
		});
		
		//$('input[name="aba_experience_reference[0][employment_endingdate]"]').datetimepicker({
		$('.employment_endingdate').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var end_date = new Date(selected.date.valueOf());
			var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
			$('input[name="aba_experience_reference[0][employment_startingdate]"]').datetimepicker('setEndDate', setEndDate);
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
		    pickerPosition: 'top-left',
    	});

		function timeRange_back(startTime, endTime){
		  $(startTime).datetimepicker({
				minuteStep: 30,
				autoclose: true,
				minView: 0,
				maxView: 0,
				startView: 1,
				format: 'HH:ii P',
				showMeridian: 1,
				pickerPosition: 'bottom-left',
				hoursDisabled: '0,1,2,3,4,5,6,7',
			}).on('changeDate', function (selected) {
				var minTime = new Date(selected.date.valueOf());
				minTime.setMinutes(minTime.getMinutes() );
				$(endTime).datetimepicker('setStartDate', minTime);
				var Hours = minTime.getHours();
				var minutes = minTime.getMinutes();
				if(minutes >= 30){
					$(endTime).datetimepicker('setHoursDisabled', [Hours]);
				}else{
					if(Hours == 8){
						$(endTime).datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7]);
					}
					
				}
				
			});
	
			$(endTime).datetimepicker({
				minuteStep: 30,
				autoclose: true,
				minView: 0,
				maxView: 1,
				startView: 1,
				format: 'HH:ii P',
				showMeridian: 1, 
				pickerPosition: 'bottom-left',
				hoursDisabled: '0,1,2,3,4,5,6,7,8',	
			}).on('changeDate', function (selected) {
				var minTime = new Date(selected.date.valueOf());
				minTime.setMinutes(minTime.getMinutes());
				var Hours = minTime.getHours();
				var minutes = minTime.getMinutes();
				if(minutes < 30){
					$(startTime).datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7,Hours]);
					$(startTime).datetimepicker('setEndDate', minTime);
				}else{
					minTime.setMinutes(minTime.getMinutes() - 30);
					$(startTime).datetimepicker('setEndDate', minTime);
					$(startTime).datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7,8]);
				}
			}); 
		}
		function timeRange(startTime, endTime){
    	//START TIME
  	  	$(startTime).datetimepicker({
		  	//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 0,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1,
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
	  	}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes() );
	        $(endTime).datetimepicker('setStartDate', minTime);
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
	        if(minutes >= 55){
	        	$(endTime).datetimepicker('setHoursDisabled', [Hours]);
	        }else{
				$(endTime).datetimepicker('setHoursDisabled', []);
			}
		});
		
		//END TIME
		$(endTime).datetimepicker({
			//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 1,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1, 
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
		}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes());
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
        	
        	minTime.setMinutes(minTime.getMinutes() - 5);
        	$(startTime).datetimepicker('setEndDate', minTime);
	 	}); 
    }
	
		timeRange('#start_M', '#end_M');
		timeRange('#start_T', '#end_T');  
		timeRange('#start_W', '#end_W');  
		timeRange('#start_TH', '#end_TH');     	
		timeRange('#start_F', '#end_F');  
		timeRange('#start_S', '#end_S');  
		timeRange('#start_SU', '#end_SU');  
		
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
		/*$('input[name=employee_phone]').samask("000-000-0000");
		$('input[name="emergency[0][phonenumber]"]').samask("000-000-0000");
		$('input[name="aba_experience_reference[0][phone]"]').samask("000-000-0000");*/
		$('input[name=employee_phone]').inputmask({"mask": "999-999-9999"});
		$('input[name="emergency[0][phonenumber]"]').inputmask({"mask": "999-999-9999"});
		$('input[name="aba_experience_reference[0][phone]"]').inputmask({"mask": "999-999-9999"});

		jQuery.validator.addMethod("ssn", function(value, element) {
    	    return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{2}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please enter valid ssn format number. (Eg: xxx-xx-xxxx)");

		jQuery.validator.addMethod("descimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");

		jQuery.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

		$("#addEmployee").validate({
			rules:{
				/*employee_name:{required:true,nameRegex:true,},
				employee_title:{required:true},
				hiring_date:{required:true, date:true},
				hiring_date:{required:true},
				employee_dob:{required:true},
				employee_type:{required:true},
				completion_date:{required:true},
				highest_degree:{required:true},
				employee_ss:{required:true,ssn:true,},
				employee_email:{required:true, validate_email:true},
				employee_address:{required:true},
			    password:{required:true, minlength:6},
			    confirm_password:{equalTo: "#password"},*/
				employee_name:{required:true,nameRegex:true,},
				//employee_type:{required:true},
				employee_dob:{required:true},
				employee_address:{required:true},
				employee_city:{required:true},
				employee_state:{required:true},
				employee_zipcode:{required:true},
				employee_ss:{required:true},
				employee_email:{required:true, validate_email:true},
				employee_phone:{required:true, phoneUS:true, usphonenumb:true},
				employee_title:{required:true},
				hiring_date:{required:true, date:true},
				completion_date:{required:true},
				highest_degree:{required:true},
				career_desired_location:{required:true},
			    password:{required:true, minlength:6},
			    confirm_password:{equalTo: "#password"},
								
				//Benefit Information
				desired_pay:{required:true, number:true, descimalPlaces:true},
				starting_pay:{required:true, number:true, descimalPlaces:true},
				current_pay:{required:true, number:true, descimalPlaces:true},
				insurance_plan:{required:true},
				retirement_plan:{required:true},
				paid_vacation:{required:true, digits:true, maxlength:2},
				paid_holidays:{required:true, digits:true, maxlength:2},
				sick_leaves:{required:true, digits:true, maxlength:2},
				
				//Schedule
				'monday_timein':{ required: function(element) { if($("input[name='monday_timeout']").val() != '') return true; } },
				'monday_timeout':{ required: function(element) { if($("input[name='monday_timein']").val() != '') return true; } },
				'tuesday_timein':{ required: function(element) { if($("input[name='tuesday_timeout']").val() != '') return true; } },
				'tuesday_timeout':{ required: function(element) { if($("input[name='tuesday_timein']").val() != '') return true; } },
				'wednesday_timein':{ required: function(element) { if($("input[name='wednesday_timeout']").val() != '') return true; } },
				'wednesday_timeout':{ required: function(element) { if($("input[name='wednesday_timein']").val() != '') return true; } },
				'thursday_timein':{ required: function(element) { if($("input[name='thursday_timeout']").val() != '') return true; } },
				'thursday_timeout':{ required: function(element) { if($("input[name='thursday_timein']").val() != '') return true; } },
				'friday_timein':{ required: function(element) { if($("input[name='friday_timeout']").val() != '') return true; } },
				'friday_timeout':{ required: function(element) { if($("input[name='friday_timein']").val() != '') return true; } },
				'saturday_timein':{ required: function(element) { if($("input[name='saturday_timeout']").val() != '') return true; } },
				'saturday_timeout':{ required: function(element) { if($("input[name='saturday_timein']").val() != '') return true; } },
				'sunday_timein':{ required: function(element) { if($("input[name='sunday_timeout']").val() != '') return true; } },
				'sunday_timeout':{ required: function(element) { if($("input[name='sunday_timein']").val() != '') return true; } },
			},
		  messages:{
			confirm_password:{
				equalTo:'Please confirm your password'
			}
		  }			
		});
		
		///////////////////////
	  	//BOOTSTRAP WIZARD TABS
	  	///////////////////////
	  	$('#rootwizard').bootstrapWizard({
	  		'nextSelector': '.button-next', 
	  		'previousSelector': '.button-previous',
			onTabClick: function(tab, navigation, index) {
				return false;
			},
			onNext: function(tab, navigation, index) {
				
	  			//ADDING VALIDATION DAYNAMIC RULES
	  			if(index == 2){
				    
				    $(".relation_type").each(function(){$(this).rules("add", {required:true,nameRegex:true,}) });
				    $(".fullname").each(function(){$(this).rules("add", {required:true,nameRegex:true,}) });
				    $(".phonenumber").each(function(){
				    	$(this).rules("add", {
				    		required:true,
				    		phoneUS:true,
				    		usphonenumb:true,
				    		messages: {
				    			phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
				    		}
				    	}); 
				    });
				    $(".email").each(function(){
				    	$(this).rules("add", {
				    		required:true,
				    		validate_email:true,
				    	}); 
				    });
				    
					var $valid = $("#addEmployee").valid();					
		  			if(!$valid) {
		  				return false;
					}
				}
				
				if(index == 5){
				    
				    $(".aba_experience_reference_phone").each(function(){
				    	$(this).rules("add", {
				    		phoneUS:true,
				    		usphonenumb:true,
				    		messages: {
				    			phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
				    		}
				    	}); 
				    });
				    
					var $valid = $("#addEmployee").valid();					
		  			if(!$valid) {
		  				return false;
					}
				}
				
				///////////////////////////////////////////////
				//CHECKING IF EMPLOYEE EMAIL IS ALREADY EXITS//
				///////////////////////////////////////////////
				var $valid = $("#addEmployee").valid();
				if(index == 1){
					var employee_email = $('input[name=employee_email]').val();
					if(employee_email != '' && $valid){
						
						$.ajax({
							url:'{{ url("franchise/employee/emailexist") }}',
							type:'POST',
							dataType:'json',
							data:{email: employee_email, EmailField: 'personal_email', '_token':'{{ csrf_token() }}'},
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
				//CHECKING IF EMPLOYEE EMAIL IS ALREADY EXITS//
				///////////////////////////////////////////////
				//CONDITION END HERE
				
	  			if(!$valid) {
	  				return false;
				}else{
					//if(index == 4){
					if(index == 5){	
		  				var formData = $('#addEmployee').serialize();
						$.ajax({
							url:'{{ url("franchise/employee/add") }}',
							type:'POST',
							dataType:'json',
							data:formData,
							success:function(response){
								var url = '{{ url("franchise/employee/view/")}}';
								if(typeof(response) == 'object'){
									if('errors' in response){
										var Errors = '';
				                  		$.each(response.errors, function(key, value){
				                  			Errors += value+'\n';
				                  		});
				                  		//alert(Errors);	
										$('#rootwizard').bootstrapWizard('show',index - 1);
									}
									if('success' in response){
										$('.view_franchise').attr('href',url+'/'+response.employee_id);
										$('#rootwizard').bootstrapWizard('show',5);	
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
		///////////////////////
	  	//BOOTSTRAP WIZARD TABS
	  	///////////////////////
	  	
		//FORM SUBMIT WITH VALIDATION
		window.prettyPrint && prettyPrint();
		$('#rootwizard .finish').click(function () {
  			var $valid = $("#addEmployee").valid();
  			if(!$valid) {
  				return false;
  			}else{
				$('#addEmployee').submit();
			}
		});	

 
	 //ADD RELATION CODE 
	 var count = 1;
	 $('.add-relation-dashed').click(function(){
	 	var Html = '<div class="super-admin-add-relation mar-top-20px" style="border-bottom: 1px #e3e7ec solid">';
	    		Html +=	'<i class="fa fa-times cut_relation"></i>';
	    		Html +=	'<figure><label>Relationship Type<span class="required-field">*</span></label><input type="text" class="relation_type" placeholder="Relationship Type" name="emergency['+count+'][relationship_type]"><label class="error error1" for="emergency['+count+'][relationship_type]"></label></figure>';
		    	Html +=	'<figure><label>Full Name<span class="required-field">*</span></label><input class="fullname" placeholder="Full Name" type="text" name="emergency['+count+'][fullname]"><label class="error error1" for="emergency['+count+'][fullname]"></label></figure>';
			    Html +=	'<figure><label>Phone Number<span class="required-field">*</span></label><input class="phonenumber" placeholder="xxx-xxx-xxxx" type="text" name="emergency['+count+'][phonenumber]"><label class="error error1" for="emergency['+count+'][phonenumber]"></label></figure>';
			    Html +=	'<figure><label>Email Address<span class="required-field">*</span></label><input class="email" placeholder="Email Address" type="text" name="emergency['+count+'][email]"><label class="error error1" for="emergency['+count+'][email]"></label></figure>';
			Html +=	'</div>	';
	 	$('.emergency_append').append(Html);
	 	//$('input[name="emergency['+count+'][phonenumber]"]').samask("000-000-0000");
		$('input[name="emergency['+count+'][phonenumber]"]').inputmask({"mask": "999-999-9999"});
	 	count++;	
	 });
	 
	 //ADD EXPERIENCE/REFERENCE 
	 var experience_count = 1;
	 $('.add-experience-dashed').click(function(){
	 	var Html = '<div class="super-admin-add-relation super-admin-add-experience mar-top-20px" style="border-bottom: 1px #e3e7ec solid">';
	    		Html +=	'<i class="fa fa-times cut_experience"></i>';
	    		Html +=	'<figure class="pos-rel"><label>Employment Starting Date:</label><input name="aba_experience_reference['+experience_count+'][employment_startingdate]" type="text" placeholder="mm/dd/yy" class="employment_startingdate"><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employment_startingdate" aria-hidden="true"></i></a><label class="error error1" for="aba_experience_reference['+experience_count+'][employment_startingdate]"></label></figure>';
				Html +=	'<figure class="pos-rel"><label>Employment Ending Date:</label><input name="aba_experience_reference['+experience_count+'][employment_endingdate]" type="text" placeholder="mm/dd/yy" class="employment_endingdate"><a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar employment_endingdate" aria-hidden="true"></i></a><label class="error error1" for="aba_experience_reference['+experience_count+'][employment_endingdate]"></label></figure>';
				Html +=	'<figure><label>Company Name</label><input name="aba_experience_reference['+experience_count+'][companyname]" type="text" placeholder="Company Name"><label class="error error1" for="aba_experience_reference['+experience_count+'][companyname]"></label></figure>';
		    	Html +=	'<figure><label>Position Held</label><input name="aba_experience_reference['+experience_count+'][positionheld]" type="text" placeholder="Position Held"><label class="error error1" for="aba_experience_reference['+experience_count+'][positionheld]"></label></figure>';
				Html +=	'<figure><label>Reason For Leaving</label><input name="aba_experience_reference['+experience_count+'][reasonforleaving]" type="text" placeholder="Reason For Leaving"><label class="error error1" for="aba_experience_reference['+experience_count+'][reasonforleaving]"></label></figure>';
				Html +=	'<figure><label>Manager&rsquo;s Name</label><input name="aba_experience_reference['+experience_count+'][managersname]" type="text" placeholder="Manager&rsquo;s Name"><label class="error error1" for="aba_experience_reference['+experience_count+'][managersname]"></label></figure>';
				Html +=	'<figure><label>Phone#</label><input name="aba_experience_reference['+experience_count+'][phone]" type="text" placeholder="xxx-xxx-xxxx"><label class="error error1" for="aba_experience_reference['+experience_count+'][phone]"></label></figure>';
			Html +=	'</div>	';
	 	$('.experience_append').append(Html);
	 	//$('input[name="aba_experience_reference['+experience_count+'][phone]"]').samask("000-000-0000");
		$('input[name="aba_experience_reference['+experience_count+'][phone]"]').inputmask({"mask": "999-999-9999"});
		//$('input[name="aba_experience_reference['+experience_count+'][employment_startingdate]"]').datetimepicker({
		$('.employment_startingdate').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var start_date = new Date(selected.date.valueOf());
			var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
			$('input[name="aba_experience_reference['+experience_count+'][employment_endingdate]"]').datetimepicker('setStartDate', setStartDate);
		});
		//$('input[name="aba_experience_reference['+experience_count+'][employment_endingdate]"]').datetimepicker({
		$('.employment_endingdate').datetimepicker({	
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var end_date = new Date(selected.date.valueOf());
			var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
			$('input[name="aba_experience_reference['+experience_count+'][employment_startingdate]"]').datetimepicker('setEndDate', setEndDate);
		});
	 	experience_count++;	
	 });
	 
	 $(document).on('click','.cut_relation',function(){
	 	$(this).parent('.super-admin-add-relation').remove();
	 });
	 
	 $(document).on('click','.cut_experience',function(){
	 	$(this).parent('.super-admin-add-experience').remove();
	 });
	 
	 $('input[name="work_capable"]').change(function(){
		if($('input[name=work_capable]:checked').val() == 'No'){
			$("input[name=work_nocapable]").each(function(){$(this).rules("add", {required:true,}); $(this).removeAttr('disabled');});	
		}else{
			$("input[name=work_nocapable]").each(function(){ $(this).rules("remove"); $(this).attr('disabled',''); $(this).val(''); });	
		}			
	 });
 
});
</script>
 
@endsection
