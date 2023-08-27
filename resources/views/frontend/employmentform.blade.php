@include('frontend.includes.header')

<div class="container">

	<!--Steps html -->
	<form action="{{ url('employmentform/send') }}" method="post" id="employmentform" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<div id="rootwizard">
		<div class="addmi-head wid_main">
			<h2>EMPLOYMENT APPLICATION</h2>
			<a href="#" class="button-previous hidden"> <i class="fa fa-arrow-left" aria-hidden="true"></i>Go Back</a>
			<p><span class="index_count">1</span>/5</p>
			<div class="clearfix"></div>
			<div class="navbar">
			  <div class="navbar-inner">
				<ul>
				  	<li class="choose-tab"><a href="#tab1" data-toggle="tab">Personal <span>Info</span></a></li>
					<li class="choose-tab"><a href="#tab2" data-toggle="tab">Career <span>Options</span></a></li>
					<li class="choose-tab"><a href="#tab3" data-toggle="tab">Work <span>Eligibility</span></a></li>
					<li class="choose-tab"><a href="#tab4" data-toggle="tab">ABA Experience <span>and References</span></a></li>
					<li class="choose-tab"><a href="#tab5" data-toggle="tab">Carefully Signing <span>Application</span></a></li>
				</ul>
			  </div>
			</div>

		</div>
		
		<div class="tab-content">
		    <div class="tab-pane" id="tab1">
				<div class="EMP_INFO">
					<h2>PERSONAL INFO</h2>
				</div>
				<div class="personal-info spinner_main">
				<div class="spinner_inner">
    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
    				Checking email if exist.	
    			</div>
				
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Name<span class="required-field">*</span></label>
			                <input name="personal_name" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Phone#</label>
			                <input name="personal_phone" type='text' class="form-control inp-hi" placeholder="xxx-xxx-xxxx"/>
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Email</label>
			                <input name="personal_email" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>City</label>
			                <input name="personal_city" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-4 col-sm-4">
							<label>State</label>
			                <input name="personal_state" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Zip Code</label>
			                <input name="personal_zipcode" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12">
							<label>Address</label>
			                <textarea name="personal_address" class="text-a"></textarea>
						</div>
					</div>
				</div>					    
			</div><!--tab1-->
		    
		    <!-- /////////////////////////////////
		    	CAREER OPTIONS
		    ////////////////////////////////////-->
		    <div class="tab-pane" id="tab2">
				<div class="EMP_INFO">
					<h2>CAREER OPTIONS</h2>
				</div>
				<div class="career">
					<h3>Desired Position:</h3>
					<div class="desire">
						<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="Billing" type="checkbox" id="checkbox" />
	    					<label class="round-checkbox" for="checkbox"></label>Billing</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="Office Manager" type="checkbox" id="checkbox1" />
	    					<label class="round-checkbox" for="checkbox1"></label>Office Manager</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="Receptionist" type="checkbox" id="checkbox2" />
	    					<label class="round-checkbox" for="checkbox2"></label>Receptionist</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="BCBA" type="checkbox" id="checkbox3" />
	    					<label class="round-checkbox" for="checkbox3"></label>BCBA</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="BCBA Intern or BCaBA" type="checkbox" id="checkbox4" />
	    					<label class="round-checkbox" for="checkbox4"></label>BCBA Intern or BCaBA</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="RBT Trainer" type="checkbox" id="checkbox5" />
	    					<label class="round-checkbox" for="checkbox5"></label>RBT Trainer</label>
	  					</div>
	  					<div class="round">
	    					<label class="lab-round"> <input name="career_desired_position[]" value="Behavior Technician" type="checkbox" id="checkbox6" />
	    					<label class="round-checkbox" for="checkbox6"></label>Behavior Technician</label>
	  					</div>
	  					<label class="error" for="career_desired_position[]"></label>
					</div>
					<h3>Desired Schedule:</h3>
					<div class="desire">
					    <label class="lab-round padi-right">
					    	<input name="career_desired_schedule" type="radio" value="Full-Time" name="optradio">Full-Time
					    </label>
					    <label class="lab-round padi-right">
					      	<input name="career_desired_schedule" type="radio" value="Part-Time" name="optradio" checked>Part-Time
					    </label>
					    <label class="lab-round padi-right">
					      	<input name="career_desired_schedule" type="radio" value="Contract" name="optradio">Contract
					    </label>
					</div>
					<h3>Availability:</h3>
					<p>*Note: Please check all that apply</p>
					<div class="avail">
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Monday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round" for="checkbox-M"> <input name="career_availability[monday]" class="career_availability career_avail" value="8:00am-4:00pm" type="radio" id="checkbox-M"/>
	    							<span class="round-radio"></span>8:00am-4:00pm</label>
	    							
	  							</div>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[monday]" class="career_availability career_avail" value="4:30pm-6:30pm" type="radio" id="checkbox_M1" />
	    							<span class="round-radio"></span>4:30pm-6:30pm</label>
	  							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Tuesday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[tuesday]" class="career_availability career_avail" value="8:00am-4:00pm" type="radio" id="checkbox-T" />
	    							<span class="round-radio" ></span>8:00am-4:00pm</label>
	  							</div>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[tuesday]" class="career_availability career_avail" value="4:30pm-6:30pm" type="radio" id="checkbox_T1" />
	    							<span class="round-radio" ></span>4:30pm-6:30pm</label>
	  							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Wednesday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[wednesday]" class="career_availability career_avail" value="8:00am-4:00pm" type="radio" id="checkbox-W" />
	    							<label class="round-radio" ></label>8:00am-4:00pm</label>
	  							</div>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[wednesday]" class="career_availability career_avail" value="4:30pm-6:30pm" type="radio" id="checkbox_W1"/>
	    							<span class="round-radio" ></span>4:30pm-6:30pm</label>
	  							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Thursday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[thursday]" class="career_availability career_avail" value="8:00am-4:00pm" type="radio" id="checkbox-TH"/>
	    							<span class="round-radio" ></span>8:00am-4:00pm</label>
	  							</div>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[thursday]" class="career_availability career_avail" value="4:30pm-6:30pm" type="radio" id="checkbox_TH1" />
	    							<span class="round-radio" ></span>4:30pm-6:30pm</label>
	  							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Friday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[friday]" class="career_availability career_avail" value="8:00am-4:00pm" type="radio" id="checkbox-F" />
	    							<span class="round-radio"></span>8:00am-4:00pm</label>
	  							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4 col-wid-1">
								<label>Saturday</label>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6">
								<div class="round">
	    							<label class="lab-round"> <input name="career_availability[saturday]" class="career_availability career_avail" value="9:00am-1:00pm" type="radio" id="checkbox-S"/>
	    							<span class="round-radio"></span>9:00am-1:00pm</label>
	  							</div>
							</div>
						</div>
					</div>
					<div class="earlier">
						<div class="row row-pad">
							<div class="col-md-6 col-sm-6">
								<label>Desired Pay $ </label>
				                <input name="career_desired_pay" type='text' class="form-control inp-hi" />
							</div>
							<div class="col-md-6 col-sm-6">
				                <div class='input-group date earliest_date'>
				                	<label>Earliest Start Date</label>
				                    <!--<input name="career_earliest_startdate" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">-->
                                    <input name="career_earliest_startdate" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                    <br><label class="error" for="career_earliest_startdate"></label>
				                </div>
		            		</div>
						</div>
						<div class="row row-pad">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-7">
										<label>Are you Registered by the BACB?</label>
									</div>
									<div class="col-sm-5">
										<label class="radio-inline txt-bold"><input name="career_bacb" class="pad-r BACB" type="radio" value="Yes" checked>Yes</label>
										<label class="radio-inline txt-bold"><input name="career_bacb" class="pad-r BACB" type="radio" value="No">No</label>
									</div>
								</div>

								<div class="row bacb_cover">
									<div class="col-sm-7">
										<label>BACB Registration Date</label>
									</div>
									<div class="col-sm-5">
										<div class='input-group date bacb_date'>
											<!--<input name="bacb_regist_date" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">-->
                                            <input name="bacb_regist_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">
						                    <span class="input-group-addon" style="top:6px !important;">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
											<br><label class="error" for="bacb_regist_date"></label>
										</div>	
									</div>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-7">
										<label>Are You CPR Certified?</label>
									</div>
									<div class="col-sm-5">
										<label class="radio-inline txt-bold"><input name="career_cpr_certified" checked="" class="pad-r CPR" type="radio" value="Yes">Yes</label>
										<label class="radio-inline txt-bold"><input name="career_cpr_certified" class="pad-r CPR" type="radio" value="No">No</label>
									</div>
								</div>

								<div class="row cpr_cover">
									<div class="col-sm-7">
										<label>CPR Registration Date</label>
									</div>
									<div class="col-sm-5">
										<div class='input-group date cpr_date'>
											<!--<input name="cpr_regist_date" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">-->
                                            <input name="cpr_regist_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">
						                    <span class="input-group-addon" style="top:6px !important;">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
											<br><label class="error" for="cpr_regist_date"></label>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12">
							<label>Highest Degree</label>
			                <input name="career_highest_degree" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="intrest">
						<div class="chech-loc">
							<label><h3>Desired Location:<span class="required-field">*</span></h3></label>
							<!--<div class="your-bord">
								<label><input name="career_desired_location[]" type="checkbox" class="checkboxjq" value="MEDICAL CENTER HOUSTON 5751 Blythewood St #500 Houston, TX 77021 MedCenterHouston@SuccessOnTheSpectrum.com" />  MEDICAL CENTER HOUSTON <p>5751 Blythewood St #500 Houston, TX 77021</p> <span class="cl-txt">MedCenterHouston@SuccessOnTheSpectrum.com</span></label>
							</div>
							<div class="your-bord">
								<label><input name="career_desired_location[]" type="checkbox" class="checkboxjq" value="SOUTHWEST HOUSTON 9894 Bissonnet St #500 Houston, TX 77036 SWHouston@SuccessOnTheSpectrum.com" /> SOUTHWEST HOUSTON <p>9894 Bissonnet St #500 Houston, TX 77036</p> <span class="cl-txt">SWHouston@SuccessOnTheSpectrum.com</span></label>
							</div>
							<div class="your-bord">
								<label><input name="career_desired_location[]" type="checkbox" class="checkboxjq" value="SUGARLAND 1803 Richmond Parkway #600, Richmond TX 77469 Sugarland@SuccessOnTheSpectrum.com" /> SUGARLAND <p>1803 Richmond Parkway #600, Richmond TX 77469 </p><span class="cl-txt">Sugarland@SuccessOnTheSpectrum.com</span></label>
							</div>
							<div class="your-bord">
								<label><input name="career_desired_location[]" type="checkbox" class="checkboxjq" value="PASADENA 3919 Woodlawn Ave, Ste B, Pasadena TX 77504 Pasadena@SuccessOnTheSpectrum.com" /> PASADENA <p>3919 Woodlawn Ave, Ste B, Pasadena TX 77504</p> <span class="cl-txt">Pasadena@SuccessOnTheSpectrum.com</span></label>
							</div>-->
                            <select name="career_desired_location[]" class="form-control inp-hi select_location">
                            <option value="">Select Desired Location</option>
                            @if($franchises)
                                @foreach($franchises as $franchise)
                                    <option data-franchise_id="{{ $franchise->id }}">{{ $franchise->location }}</option>
                                @endforeach
                            @endif
                            </select>
							<br><label class="error" for="career_desired_location[]"></label>
                            <input type="hidden" name="franchise_id" value="" />
						</div>
					</div>
				</div>		

		    </div><!--tab2-->
		    
		    <!-- /////////////////////////////////
		    	WORK ELIGIBILITY
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab3">
				<div class="EMP_INFO">
					<h2>WORK ELIGIBILITY</h2>
				</div>
				<div class="work-e">
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12">
							<label>Are you under 18 years of age?</label>
							<label class="radio-inline txt-bold"><input name="work_underage" class="pad-r" type="radio" value="Yes" checked>Yes</label>
							<label class="radio-inline txt-bold"><input name="work_underage" class="pad-r" type="radio" value="No" >No</label>
							<br><label class="error" for="work_underage"></label>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12">
							<label>Are you authorized to work in the United States?</label>
							<label class="radio-inline txt-bold"><input name="work_authorised" class="pad-r" type="radio" value="Yes" checked>Yes</label>
							<label class="radio-inline txt-bold"><input name="work_authorised" class="pad-r" type="radio" value="No" >No</label>
							<p>All offers of employment are subject to verification of the applicant&rsquo;s identity and employment authorization, and it will be necessary for you to submit such documents as are required by law to verify your identification and employment authorization.</p>
							<br><label class="error" for="work_authorised"></label>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12">
							<label>Are you capable of performing the essential functions of the job which you are applying without any accommodations?</label>
							<label class="radio-inline txt-bold"><input name="work_capable" class="pad-r" type="radio" value="Yes" checked>Yes</label>
							<label class="radio-inline txt-bold"><input name="work_capable" class="pad-r" type="radio" value="No" >No</label>
							<br><label class="error" for="work_capable"></label>
							
							<span>If no, what accommodations do you need?</span>
							<input name="work_nocapable" type='text' readonly="" class="form-control inp-hi" />
							<br><label class="error" for="work_nocapable"></label>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12">
							<label>Are you able to lift 30 to 40 lbs? Able to do physical activities?</label>
							<label class="radio-inline txt-bold"><input name="work_liftlbs" class="pad-r" type="radio" value="Yes" checked>Yes</label>
							<label class="radio-inline txt-bold"><input name="work_liftlbs" class="pad-r" type="radio" value="No" >No</label>
							<span>(sit, stand, bend down for a long period of time)</span>
							<br><label class="error" for="work_liftlbs"></label>
						</div>
					</div>
				</div>				
		    </div><!--tab3-->

		    <!-- /////////////////////////////////
		    	ABA EXPERIENCE AND REFERENCES
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab4">
				<div class="EMP_INFO">
					<h2>ABA EXPERIENCE AND REFERENCES</h2>
				</div>
				<div class="aba">
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id="startDate">
			                	<label for="abc">Employment Starting Date:</label>
			                    <!--<input name="aba_employment_startingdate" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_startingdate" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_startingdate"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id="endDate">
			                	<label for="abc">Employment Ending Date:</label>
			                    <!--<input name="aba_employment_endingdate" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_endingdate" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_endingdate"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
							<label>Company Name</label>
			                <input name="aba_companyname" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Position Held</label>
			                <input name="aba_positionheld" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Reason for Leaving</label>
			                <input name="aba_reasonforleaving" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Manager&rsquo;s Name</label>
			                <input name="aba_managersname" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Phone#</label>
			                <input name="aba_phone" type='text' class="form-control inp-hi" placeholder="xxx-xxx-xxxx"/>
						</div>
					</div>
					<div class="bord-form"></div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id="startDate1">
			                	<label>Employment Starting Date:</label>
			                    <!--<input name="aba_employment_startingdate2" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_startingdate2" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_startingdate2"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id='endDate1'>
			                	<label>Employment Ending Date:</label>
			                    <!--<input name="aba_employment_endingdate2" type='text' readonly="" class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_endingdate2" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_endingdate2"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
							<label>Company Name</label>
			                <input name="aba_companyname2" type='text' class="form-control inp-hi"/>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Position Held</label>
			                <input name="aba_positionheld2" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Reason for Leaving</label>
			                <input name="aba_reasonforleaving2" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Manager&rsquo;s Name</label>
			                <input name="aba_managersname2" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Phone#</label>
			                <input name="aba_phone2" type='text' class="form-control inp-hi" placeholder="xxx-xxx-xxxx"/>
						</div>
					</div>
					<div class="bord-form"></div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id='startDate2'>
			                	<label>Employment Starting Date:</label>
			                    <!--<input name="aba_employment_startingdate3" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_startingdate3" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_startingdate3"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id='endDate2'>
			                	<label>Employment Ending Date:</label>
			                    <!--<input name="aba_employment_endingdate3" type='text' readonly="" class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                                <input name="aba_employment_endingdate3" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="aba_employment_endingdate3"></label>
			                </div>
	            		</div>
	            		<div class="col-md-4 col-sm-4">
							<label>Company Name</label>
			                <input name="aba_companyname3" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Position Held</label>
			                <input name="aba_positionheld3" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Reason for Leaving</label>
			                <input name="aba_reasonforleaving3" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
							<label>Manager&rsquo;s Name</label>
			                <input name="aba_managersname3" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Phone#</label>
			                <input name="aba_phone3" type='text' class="form-control inp-hi" placeholder="xxx-xxx-xxxx"/>
						</div>
					</div>
					<div class="bord-form"></div>
				</div>				
		    </div><!--tab4-->

		    <!-- /////////////////////////////////
		    	PLEASE READ CAREFULLY BEFORE SIGNING APPLICATION
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab5">
				<div class="EMP_INFO">
					<h2>PLEASE READ CAREFULLY BEFORE SIGNING APPLICATION</h2>
				</div>
				<div class="carefully">
					<p>I have submitted the attached form to the company for the purpose of obtaining employment. I acknowledge that the use of this form, and my filling it out, does not indicate that any positions are open, nor does it obligate Success On The Spectrum to further process my application.</p>
					<p>My signature below attests to the fact that the information that I have provided on my application, resume, given verbally, or provided in any other materials, is true and complete to the best of my knowledge and also constitutes authority to verify any and all information submitted on this application. I understand that any misrepresentation or omission of any fact in my application, resume or any other materials, or during any interviews, can be justification for refusal of employment, or, if employed, termination from Success On The Spectrum&rsquo;s employ.</p>
					<p>I also affirm that I have not signed any kind of restrictive document creating any obligation to any former employer that would restrict my acceptance of employment with Success On The Spectrum in the position I am seeking. I understand that this application is not an employment contract for any specific length of time between Success On The Spectrum and me, and that in the event I am hired, my employment will be “at will” and either Success On The Spectrum or I can terminate my employment with or without cause and with or without notice at any time. Nothing contained in any handbook, manual, policy and the like, distributed by Success On The Spectrum to its employees is intended to or can create an employment contract, an offer of
					employment or any obligation on Success On The Spectrum&rsquo;s part. Success On The Spectrum may, at its sole discretion, hold in abeyance or revoke, amend or modify, abridge or change any benefit, policy practice, condition or process affecting its Employees.</p>
					<p><span>References:</span> I hereby authorize Success On The Spectrum and its agents to make such investigations and inquiries into my employment and educational history and other related matters as may be necessary in arriving at an employment decision. I hereby release employers, schools, and other persons from all liability in responding to inquiries connected with my application and I specifically authorize the release of information by any schools, businesses, individuals, services or other entities listed by me in this form. Furthermore, I authorize Success On The Spectrum and its agents to release any reference information to clients who request such information for purposes of evaluating my credentials and qualifications.</p>
					<p><span>Temporary/Contract Employment:</span> If employed as a temporary or contract employee, I understand that I may be an employee of Success On The Spectrum and not of any client. If employed, I further understand that my employment is not guaranteed for any specific time and may be terminated
					at any time for any reason. I further understand that a contract will exist between Success On The Spectrum and each client to whom I may be assigned which will require the client to pay a fee to Success On The Spectrum in the event that I accept direct employment with the client, I agree to notify Success On The Spectrum immediately should I be offered direct employment by a client (or by referral of the client to any subsidiary or affiliated company), either for a permanent, temporary (including assignments through another agency), or consulting positions during my assignment or after my assignment has ended.</p>
					<div class="para-bord">
						<p>Success On The Spectrum is an equal opportunity employer and does not discriminate against any applicant or employee because of race, color, religion, sex, national origin, disability, age, or military or veteran status in accordance with federal law. In addition, Success On The Spectrum complies with applicable state and local laws governing nondiscrimination in employment in every jurisdiction in which it maintains facilities. Success On The Spectrum also provides reasonable accommodation to qualified individuals with disabilities in accordance with applicable laws.</p>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Applicant Printed Name</label>
			                <input name="careully_applicantpname" type='text' class="form-control inp-hi"/>
						</div>
						<div class="col-md-4 col-sm-4">
			                <!--<div class='input-group date careully_date'>
			                	<label>Date</label>
			                    <input name="careully_date" type='text' readonly="" class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="careully_date"></label>
			                </div>-->
                            <label>Date</label>
                            <input name="careully_date" type='text' readonly="" class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
                            <br><label class="error" for="careully_date"></label>
	            		</div>
						<div class="col-md-4 col-sm-4 text-center">
			                <!--<input name="careully_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="careully_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                                <!--<div class="col-md-6 col-sm-6 text-left"><a href="javascript:void(0);" data-action="clear">Clear</a></div>
                                <div class="col-md-6 col-sm-6 text-right"><a href="javascript:void(0);" data-action="save">Save</a></div>-->
                            </div>
                            <input name="careully_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="careully_signature"></label>
						</div>
					</div>
				</div>				
		    </div><!--tab5-->
		        
			<ul class="pager wizard two-btn">
				<li class="previous pull-left"><button type='button' class='btn button-previous g-btn hidden' name='previous'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button></li>
				<li class="next pull-right"><button type='button' class='btn button-next b-btn' name='next'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></</button></li>
				<li class="finish pull-right"><a href="javascript:void(0);" class='btn b-btn'>Finish</a></li>
			</ul>
			
		</div>
	</div>
	</form>
	<!--Steps html -->
    
    <div class="row hidden-xs"><div class="col-md-4 col-sm-4" id="employmentform_signature_pad_width"></div></div>
	
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

<script>
$(document).ready(function() {

	//Phone number validation
	/*$('input[name=personal_phone]').samask("000-000-0000");
	$('input[name=aba_phone]').samask("000-000-0000");
	$('input[name=aba_phone2]').samask("000-000-0000");
	$('input[name=aba_phone3]').samask("000-000-0000");*/
	$('input[name=personal_phone]').inputmask({"mask": "999-999-9999"});
	$('input[name=aba_phone]').inputmask({"mask": "999-999-9999"});
	$('input[name=aba_phone2]').inputmask({"mask": "999-999-9999"});
	$('input[name=aba_phone3]').inputmask({"mask": "999-999-9999"});
	
	$.validator.addMethod("validate_email", function(value, element) {

		if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
			return true;
		} else {
			return false;
		}
	}, "Please enter a valid Email.");

	$.validator.addMethod("nameRegex", function(value, element) {
			return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
	}, "Special characters and numbers are not allowed.");
	
	$.validator.addMethod("alphanumeric_textarea", function(value, element) {
			return this.optional(element) || /^[a-z0-9\.\-,àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
	},"Special characters are not allowed.");

	$.validator.addMethod("descimalPlaces", function(value, element) {
			return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
	},"Only 2 decimal places are allowed.");

	$.validator.addMethod("usphonenumb", function(value, element) {
			return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

	$('#employmentform').validate({
	  rules: {
		
		//Parent Section
		'personal_name':{required:true, nameRegex:true},
		/*'personal_phone':{required:true, phoneUS:true, usphonenumb:true},
		'personal_email':{required:true,validate_email:true,},
		'personal_city':{required:true},
		'personal_state':{required:true},
		'personal_zipcode':{required:true},
		'personal_address':{required:true, alphanumeric_textarea:true},*/
		
		//Career
		/*'career_desired_position[]':{required:true},
		'career_desired_schedule':{required:true},
		'career_desired_pay':{required:true,number:true, descimalPlaces: true},
		'career_earliest_startdate':{required:true, date: true},
		'career_bacb':{required:true},
		'bacb_regist_date':{required:true},
		'career_cpr_certified':{required:true},
		'cpr_regist_date':{required:true},
		'career_highest_degree':{required:true, },*/
		'career_desired_location[]':{required:true},
		
		//WORK ELIGIBILITY
		/*'work_underage':{required:true},
		'work_authorised':{required:true},
		'work_capable':{required:true},
		'work_nocapable':{ required: function(element) { if($("input[name='work_capable']:checked").val() == 'No') return true; } },
		'work_liftlbs':{required:true},*/
		
		//ABA EXPERIENCE AND REFERENCES

		/*'aba_companyname':{nameRegex:true},
		'aba_positionheld':{nameRegex:true},
		'aba_reasonforleaving':{alphanumeric_textarea:true},
		'aba_managersname':{ nameRegex:true},
		'aba_phone':{ phoneUS:true, usphonenumb:true},
		
		'aba_phone2':{ phoneUS:true,usphonenumb:true},
		'aba_companyname2':{nameRegex:true},
		'aba_positionheld2':{nameRegex:true},
		'aba_reasonforleaving2':{alphanumeric_textarea:true},
		'aba_managersname2':{ nameRegex:true},
		
		'aba_phone3':{ phoneUS:true, usphonenumb:true},
		'aba_companyname3':{nameRegex:true},
		'aba_positionheld3':{nameRegex:true},
		'aba_reasonforleaving3':{alphanumeric_textarea:true},
		'aba_managersname3':{ nameRegex:true},*/
		
		//PLEASE READ CAREFULLY BEFORE SIGNING APPLICATION
		/*'careully_applicantpname':{required:true, nameRegex:true},
		'careully_date':{required:true, date: true},*/
		'careully_signature':{required:true},
		
	  },
	  messages:{
		/*personal_phone:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
		aba_phone:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
		aba_phone2:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
		aba_phone3:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},*/
	  }	
	});

	/////////////////////////
	// EMPLOYMENT VALIDATIONS
	/////////////////////////
	$('#rootwizard').bootstrapWizard({
		'nextSelector': '.button-next', 
		'previousSelector': '.button-previous',
		onTabShow: function(tab, navigation, index) {
			$('.index_count').html(index+1);
		},
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onNext: function(tab, navigation, index) {
			if(index == 1){
				$('.button-previous').removeClass('hidden');
			}
			
			if(index == 4){
				initSignaturePad();
			}
			
			var $valid = $("#employmentform").valid();
			
			if(!$valid) {
				return false;
			}

			///////////////////////////////////////////////
			//CHECKING IF EMPLOYEE EMAIL IS ALREADY EXITS//
			///////////////////////////////////////////////
			if(index == 1){
				var employee_email = $('input[name=personal_email]').val();
				if(employee_email != '' && $valid){
					
					$.ajax({
						url:'{{ url("emailexist") }}',
						type:'POST',
						dataType:'json',
						data:{email: employee_email, '_token':'{{ csrf_token() }}'},
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
			
			$(window).scrollTop($('#rootwizard').offset().top);
		},
		onPrevious: function(tab, navigation, index) {
			if(index == 0){
				$('.button-previous').addClass('hidden');
			}
			$(window).scrollTop($('#rootwizard').offset().top);
		},

	});
	
	
	window.prettyPrint && prettyPrint();
	$('#rootwizard .finish').click(function () {
		$('#employmentform').submit();
	});	
 
	/////////////////////////
	//Date ranger validations
	/////////////////////////
	$("#startDate").datetimepicker({
		today: 1,autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2,
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() + 1);
		$('#endDate').datetimepicker('setStartDate', minDate);
	});
	$("#endDate").datetimepicker({
		autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2,
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() - 1);
		$('#startDate').datetimepicker('setEndDate', minDate);
	}); 

	$("#startDate1").datetimepicker({
		today: 1,autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() + 1);
		$('#endDate1').datetimepicker('setStartDate', minDate);
	});
	$("#endDate1").datetimepicker({
		autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2  
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() - 1);
		$('#startDate1').datetimepicker('setEndDate', minDate);
	}); 

	$("#startDate2").datetimepicker({
		today: 1,autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() + 1);
		$('#endDate2').datetimepicker('setStartDate', minDate);
	});
	$("#endDate2").datetimepicker({
		autoclose: true,format: 'mm/dd/yyyy',maxView: 4,minView: 2  
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		minDate.setDate(minDate.getDate() - 1);
		$('#startDate2').datetimepicker('setEndDate', minDate);
	}); 
	
	//Earliest Start date
	$('.earliest_date, .careully_date').datetimepicker({
		'autoclose': true,
		'format': 'mm/dd/yyyy',
		'maxView': 4,
		'minView': 2    	
	});	    
	$('.earliest_date, .careully_date').datetimepicker('setStartDate', new Date());	

	$('.bacb_date, .cpr_date').datetimepicker({
		'autoclose': true,
		'format': 'mm/dd/yyyy',
		'maxView': 4,
		'minView': 2,
		'endDate': new Date(),
	});	    
	//$('.bacb_date, .cpr_date').datetimepicker('setStartDate', new Date());	
	/////////////////////////
	//Date ranger validations
	/////////////////////////


	//Token refresh for expiration
	var csrfToken = $('[name="_token"]').val();

	setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 
	function refreshToken(){
		$.get('{{ url("refresh-csrf")}}').done(function(data){	
			$('[name="_token"]').val(data); // the new token
		});
	}
	setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 


	//
	$('input[name="work_capable"]').change(function(){
		if($('input[name=work_capable]:checked').val() == 'No'){
			$("input[name=work_nocapable]").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly');});	
		}else{
			$("input[name=work_nocapable]").each(function(){ $(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
		}			
	});
	
	 //Frnachise id code
	$('.select_location').change(function(){
		var franchise_id = $(this).find(':selected').data('franchise_id');	
		$('input[name=franchise_id]').val(franchise_id);
	});
	
	$('.career_availability').click(function(){
		var lab_round = $(this);
		//alert(lab_round.attr('id'));
		if(lab_round.hasClass('career_availability')){
			lab_round.prop("checked", true);
			lab_round.removeClass('career_availability')
			//lab_round.removeClass('career_avail')
		}else{
			//alert('uncheck');
			lab_round.prop("checked", false);
			lab_round.addClass('career_availability')
			//lab_round.addClass('career_avail')
		}
	});
	
	$('.lab-round').click(function(){
		var curr = $(this);
		$('.career_avail').each(function(){
			if(!$(this).is('checked')){
				$(this).addClass('career_availability');
			}
		});
		if($(curr).find('.career_avail').is(':checked')){
			$(curr).find('.career_avail').removeClass('career_availability');
		}
		
	});
	
	
});	

$('.BACB').change(function(){
	if($(this).val() == 'Yes'){
		$('.bacb_cover').show();
		//$('input[name=bacb_regist_date]').rules("add", {required:true});
	}else{
		$('.bacb_cover').hide();
		$('input[name=bacb_regist_date]').rules("remove");
	}
});
$('.CPR').change(function(){
	if($(this).val() == 'Yes'){
		$('.cpr_cover').show();
		//$('input[name=cpr_regist_date]').rules("add", {required:true});
	}else{
		$('.cpr_cover').hide();
		$('input[name=cpr_regist_date]').rules("remove");
	}
});
</script>

</script>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="{{ asset('assets/js/signature_pad.min.js') }}"></script>-->
<script>
function initSignaturePad()
{
	//Signature Pad
	var wrapper = document.getElementById("careully_signature_pad");
	var canvas = wrapper.querySelector("canvas");
	//var saveButton = wrapper.querySelector(" [data-action=save] ");
	var clearButton = wrapper.querySelector(" [data-action=clear] ");
	
	var signaturePad = new SignaturePad(canvas, {
		penColor: 'rgb(0, 0, 0)',
		backgroundColor: 'rgba(255, 255, 255, 0)',
		/*velocityFilterWeight: .7,
		minWidth: 0.5,
		maxWidth: 2.5,
		throttle: 16, // max x milli seconds on event update, OBS! this introduces lag for event update*/
		minWidth: 0.5,
    	maxWidth: 2.5,
		minPointDistance: 0,
		onEnd:function(callback)
		{
			var data = signaturePad.toDataURL('image/png');
			$('input[name="careully_signature"]').val(data);
		}
	});
	
	// When zoomed out to less than 100%, for some very strange reason,
	// some browsers report devicePixelRatio as less than 1
	// and only part of the canvas is cleared then.
	var ratio =  Math.max(window.devicePixelRatio || 1, 1);
  
	// This part causes the canvas to be cleared
	//canvas.width = canvas.offsetWidth * ratio;
	//canvas.height = canvas.offsetHeight * ratio;
	canvas.getContext("2d").scale(ratio, ratio);
	var width = $("#employmentform_signature_pad_width").width();
	if(width < 0)var width = parseFloat($( window ).width())-parseFloat(30);
	$("#careully_signature_pad").find('canvas').css("width",width+"px").prop('width',width);
  
	// This library does not listen for canvas changes, so after the canvas is automatically
	// cleared by the browser, SignaturePad#isEmpty might still return false, even though the
	// canvas looks empty, because the internal data of this library wasn't cleared. To make sure
	// that the state of this library is consistent with visual state of the canvas, you
	// have to clear it manually.
	//signaturePad.clear();
	
	/*saveButton.addEventListener('click', function(event) {
		var data = signaturePad.toDataURL('image/png');
		//window.open(data);
		$('input[name="careully_signature"]').val(data);
	});*/
	
	clearButton.addEventListener('click', function(event) {
		signaturePad.clear();
		$('input[name="careully_signature"]').val("");
	});
	
	/*showPointsToggle.addEventListener('click', function(event) {
		signaturePad.showPointsToggle();
		showPointsToggle.classList.toggle('toggle');
	});*/
}
$(window).resize(function(){
  initSignaturePad();
});
</script>
@include('frontend.includes.footer')