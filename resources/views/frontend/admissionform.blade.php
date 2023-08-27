@include('frontend.includes.header')

	<div id="rootwizard">
	<div class="container">
		<div class="addmi-head">
			<h2>ADMISSION FORM</h2>
			<a href="#" class="button-previous hidden"> <i class="fa fa-arrow-left" aria-hidden="true"></i>Go Back</a>
			<p><span class="index_count">1</span>/8</p>
		</div>
        <div class="clearfix"></div>

	<!--Steps html -->
	<form action="{{ url('admissionform/send') }}" method="post" id="admissionform" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		<div class="navbar">
		  <div class="navbar-inner">
			<ul>
			  	<li class="choose-tab"><a href="#tab1" data-toggle="tab">Choose <br/> Location</a></li>
				<li class="choose-tab"><a href="#tab2" data-toggle="tab">Client Information</a></li>
				<li class="choose-tab"><a href="#tab3" data-toggle="tab">HIPAA Agreement Form</a></li>
				<li class="choose-tab"><a href="#tab4" data-toggle="tab">Payment Agreement</a></li>
				<li class="choose-tab"><a href="#tab5" data-toggle="tab">Informed Consent For Services</a></li>
				<li class="choose-tab"><a href="#tab6" data-toggle="tab">Security System Waiver</a></li>
				<li class="choose-tab"><a href="#tab7" data-toggle="tab">Release of Liability</a></li>
				<li class="choose-tab"><a href="#tab8" data-toggle="tab">Parent Handbook Agreement</a></li>
			</ul>
		  </div>
		</div>
		
		<div class="tab-content">
		    <div class="tab-pane" id="tab1">
				<div class="intrest">
					<h3>Select your interest:<span class="required-field">*</span></h3>
					<!--<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="SOS Center Full-me (Mon - Fri 8:00am-4:00pm)" name="ff">  SOS Center Full-time (Mon - Fri 8:00am-4:00pm)</label>
					</div>
					<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="SOS Center Part-time" name="ff"> SOS Center Part-time</label>
					</div>
					<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="School Shadowing 8:00am-4:00pm (with school approval)" name="ff">  School Shadowing 8:00am-4:00pm (with school approval)</label>
					</div>
					<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)" name="ff"> In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)</label>
					</div>-->
                    <div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="Office" name="ff" checked="checked"> Office</label>
					</div>
					<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="Home" name="ff"> Home</label>
					</div>
					<div class="your-bord">
						<label><input type="radio" name="chooselocation_interest" value="School" name="ff"> School</label>
					</div>
					<label class="error" for="chooselocation_interest"></label>
					<div class="chech-loc">
						<h3>Desired Location:<span class="required-field">*</span></h3>
						<h4>Please select which location you would like this completed  form to be delivered to.</h4>
						<select name="chooselocation_location[]" class="form-control inp-hi select_location">
						<option value="" selected="selected">Select Desired Location</option>
						@if($franchises)
							@foreach($franchises as $franchise)
								<option data-franchise_id="{{ $franchise->id }}">{{ $franchise->location }}</option>
							@endforeach
						@endif
						</select>

						<div><label class="error" for="chooselocation_location[]"></label></div>
						<input type="hidden" name="franchise_id" value="" />
					</div>
				</div>		    
			</div><!--tab1-->
		    
		    <!-- /////////////////////////////////
		    	Client Information
		    ////////////////////////////////////-->
		    <div class="tab-pane" id="tab2">
				<div class="cleint-head">
					<h2>Client Information</h2>
				</div>
				<div class="cleint-form">
					<div class="row row-pad">
						<div class="col-md-3 col-sm-3">
			                <div class='input-group date'>
			                	<label>Today's Date</label>
			                    <input type='text' class="form-control inp-hi" readonly="" name="client_todaydate" value="{{ date('m/d/Y') }}">
			                    <br/><label class="error" for="client_todaydate"></label>
			                </div>
	            		</div>
						<div class="col-md-3 col-sm-3">
							<label>Child's First Name</label>
			                <input name="client_childfirstname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Child's Last Name</label>
			                <input name="client_childlastname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
			                <div class='input-group date' id='dateofbirth'>
			                	<label>Child's Date of Birth</label>
			                    <!--<input name="client_childdateofbirth" readonly="readonly" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" />-->
                                <input name="client_childdateofbirth" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br/><label class="error" for="client_childdateofbirth"></label>
			                </div>
						</div>
					</div>	
					<div class="row row-pad">
						<div class="col-md-12 col-sm-12 col-pad-lab">
							<label>Custodial Parent</label>
							<label class="txt-bold radio-inline"><input name="client_custodialparent" checked="" class="pad-r" type="radio" value="Both Parents are married">Both Parents are married</label>
							<label class="txt-bold radio-inline"><input name="client_custodialparent" class="pad-r" type="radio" value="Child lives with Dad">Child lives with Dad</label>
							<label class="txt-bold radio-inline"><input name="client_custodialparent" class="pad-r" type="radio" value="Child lives with Mom">Child lives with Mom</label>
							<br />
							<label class="error" for="client_custodialparent"></label>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-3 col-sm-3">
							<label>Mom's First Name</label>
			                <input name="client_momsfname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Mom's Last Name</label>
			                <input name="client_momslname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Mom's Email</label>
			                <input name="client_momsemail" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Mom's Cell</label>
			                <input name="client_momscell" type='text' class="form-control inp-hi usphone" placeholder="xxx-xxx-xxxx" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12">
							<label>Custodial Parent's Address</label>
			                <input name="client_custodialparentsaddress" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-3 col-sm-3">
							<label>Dad's First Name</label>
			                <input name="client_dadsfname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Dad's Last Name</label>
			                <input name="client_dadslname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Dad's Email</label>
			                <input name="client_dadsemail" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Dad's Cell</label>
			                <input name="client_dadscell" type='text' class="form-control inp-hi usphone" placeholder="xxx-xxx-xxxx"/>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Emergency Contact Name</label>
			                <input name="client_emergencycontactname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Emergency Contact Phone</label>
			                <input name="client_emergencycontactphone" type='text' class="form-control inp-hi usphone" placeholder="xxx-xxx-xxxx" />
						</div>
					</div>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Insurance Company Name</label>
			                <input name="client_insurancecompanyname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Insurance Company ID Card</label>
			                <input name="client_insurancecompanyidcard" type='file' class="clickme"/>
			                <div class="dash-bor"> + Attach</div>
			                <div class="file-upload">
		                		<div class="file-select-name noFile"></div> 
		            		</div>
		            		<label class="error" for="client_insurancecompanyidcard"></label>
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Member ID</label>
			                <input name="client_memberid" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Group ID</label>
			                <input name="client_groupid" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Policyholder's Name (Usually a parent)</label>
			                <input name="client_policyholdersname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
			                <div class='input-group date' id='datetimepicker3'>
			                	<label>Policyholder's Date of Birth</label>
			                    <!--<input name="client_policyholdersdateofbirth" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" />-->
                                <input name="client_policyholdersdateofbirth" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br /><label class="error" for="client_policyholdersdateofbirth"></label>
			                </div>
						</div>
					</div>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-12">
							<label>Describe the age and symptoms that were first noticed</label>
							<textarea name="client_ageandsymtoms" class="text-a"></textarea>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<div class='input-group date agreements_date2'>
							<label>Date of Autism Diagnosis</label>
			                <!--<input name="client_dateofautism" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>-->
                            <input name="client_dateofautism" type='text' class="form-control inp-hi" placeholder="mm/dd/yy"/>
			                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                <label class="error" for="client_dateofautism" ></label>
			                </div>
						</div>
						<div class="col-md-8 col-sm-8">
							<label>Upload your child's diagnostic report (must include the testing scores)&nbsp;<small>(Allowed file size 8 MB)</small></label>
			                <input name="client_childdiagnostic_report[]" type='file' class="clickme" id="mutliImages" multiple=""/>
			                <div class="dash-bor_multiple "> + Attach </div>
			                <div class="file-upload">
		                		<div class="file-select-name  noFile"></div> 
		            		</div>
		            		<label class="error" for="mutliImages"></label>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Diagnosing Doctor</label>
			                <input name="client_diagnosingdoctor" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Primary Diagnosis</label>
			                <input name="client_primarydiagnosis" type='text' class="form-control inp-hi" placeholder="F84.0 Autism Spectrum Disorder" />
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Secondary Diagnosis, if any</label>
			                <input name="client_secondarydiagnosis" type='text' class="form-control inp-hi" />
						</div>
					</div>	
					<div class="row row-pad">
						<div class="col-md-12">
							<label>List Child's Current Medications and Doses</label>
							<textarea name="client_childcurrentmedications" class="text-a"></textarea>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-12">
							<label>List any allergies Or food restrictions</label>
							<textarea name="client_allergies" class="text-a"></textarea>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-3 col-sm-5">
							<label>Has your Child ever received ABA before?</label>
							<label class="error" for="client_aba"></label>
						</div>
						<div class="col-md-3 col-sm-3">
							<label class="radio-inline txt-bold"><input name="client_aba" class="pad-r" type="radio" checked value="Yes">Yes</label>
							<label class="radio-inline txt-bold"><input name="client_aba" class="pad-r" type="radio" value="No">No</label>
						</div>
						
					</div>
					
					<div class="add_aba">
					<div class="row row-pad">
						<div class="col-md-4 col-sm-6">
							<label>If yes, which facility?</label>
			                <input name="aba[0][client_facility]" type='text' class="form-control inp-hi client_facility" />
						</div>
						<div class="col-md-2 col-sm-6">
			                <div class='input-group date startDate'>
			                	<label>What year did they start?</label>
			                    <input name="aba[0][client_start]" type='text' class="form-control inp-hi client_start" placeholder="mm/dd/yy" />
			                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                    <br /><label class="error" for="client_start"></label>
			                </div>
						</div>
						<div class="col-md-2 col-sm-6 pad-col">
			                <div class='input-group date endDate'>
								<label>What year did they finish?</label>
			                    <input name="aba[0][client_end]" type='text' class="form-control inp-hi client_end" placeholder="mm/dd/yy" />
			                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                    <br /><label class="error" for="client_end"></label>
			                </div>
						</div>
						<div class="col-md-4 col-sm-6">
							<label>How many hours of ABA did they receive per week</label>
			                <input name="aba[0][client_hours]" type='text' class="form-control inp-hi client_hours" />
						</div>
					</div>
					</div>
					
					
					<div class="row row-pad">
						<div class="col-md-12">
			                <div class="dash_bor_button"> + Add </div>
						</div>
					</div>
					
					<div class="row row-pad">
						<div class="col-md-5 col-sm-6">
							<div class="row pad-top">
								<div class="col-md-8 col-sm-8">
									<label>Is your child currently in Speech Therapy?</label>
									<label class="error" for="client_speechtherapy"></label>
								</div>
								<div class="col-md-4 col-sm-4">
									<label class="radio-inline txt-bold"><input name="client_speechtherapy" class="pad-r" checked type="radio" value="Yes">Yes</label>
									<label class="radio-inline txt-bold"><input name="client_speechtherapy" class="pad-r" type="radio" value="No">No</label>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-wid col-sm-3">
							<label>Institution</label>
			                <input name="client_speechinstitution" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-wid col-sm-3">
							<label>Hours Per Week</label>
			                <input name="client_speechhoursweek" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-5 col-sm-6">
							<div class="row pad-top">
								<div class="col-md-8 col-sm-8">
									<label>Is your child currently in Occupational Therapy?</label>
									<label class="error" for="client_occupationaltherapy"></label>
								</div>
								<div class="col-md-4 col-sm-4">
									<label class="radio-inline txt-bold"><input name="client_occupationaltherapy" checked class="pad-r" type="radio" value="Yes">Yes</label>
									<label class="radio-inline txt-bold"><input name="client_occupationaltherapy" class="pad-r" type="radio" value="No">No</label>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-wid col-sm-3">
							<label>Institution</label>
			                <input name="client_occupationalinstitution" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-3 col-wid col-sm-3">
							<label>Hours Per Week</label>
			                <input name="client_occupationalhoursweek" type='text' class="form-control inp-hi" />
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-5 col-sm-6">
							<div class="row pad-top">
								<div class="col-md-8 col-sm-8">
									<label>Does  your child attend school?</label>
									<label class="error" for="client_childattendschool"></label>
								</div>
								<div class="col-md-4 col-sm-4">
									<label class="radio-inline txt-bold"><input name="client_childattendschool" class="pad-r" type="radio" checked value="Yes">Yes</label>
									<label class="radio-inline txt-bold"><input name="client_childattendschool" class="pad-r" type="radio" value="No">No</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row row-pad">
						<div class="col-md-4 col-sm-4">
							<label>Name of school</label>
			                <input name="client_schoolname" type='text' class="form-control inp-hi" />
						</div>
						<div class="col-md-4 col-sm-4 special_classbox">
			                <label class="txt-bold">
				                If so, are they in a special needs class?
				                &nbsp;&nbsp;<input name="client_specialclass" type='radio' value="Yes" checked="" /> Yes
				                &nbsp;&nbsp;<input name="client_specialclass" type='radio' value="No"/> No
			                </label>
			                <label class="error" for="client_specialclass"></label>
						</div>
						<div class="col-md-4 col-sm-4">
							<label>Please Attach your Child's IEP&nbsp;<small>(Allowed file size 8 MB)</small></label>
			                <input name="client_childiep" type='file' class="clickme"/>
			                <div class="dash-bor2 IEP"> + Attach </div>
			                <div class="file-upload">
		                		<div class="file-select-name noFile"></div> 
		            		</div>
		            		<label class="error" for="client_childiep"></label>
						</div>
					</div>
				</div>
		    </div><!--tab2-->
		    
		    <!-- /////////////////////////////////
		    	HIPAA Agreement Form
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab3">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="hipaa_childsname" type='text' class="form-control inp-hi" />
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="hipaa_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="hipaa">
					<h2>SOS is dedicated to maintaining the privacy of your individually identifiable health information (also called protected health information, or PHI). Below is our privacy policy:</h2>
					<span>1.</span><p>SOS will not use or disclose your PHI for marketing or fundraising purposes; SOS will not sell your PHI to anyone for any reason.</p>
					<div class="clearfix"></div>
					<span>2.</span><p>SOS will only use your PHI in an appropriate manner for treatment.</p>
					<div class="clearfix"></div>
					<span>3.</span><p>SOS will only disclose PHI to the child&rsquo;s legal guardian. A legal guardian must give written authorization to allow us to share PHI with others.</p>
					<div class="clearfix"></div>
					<span>4.</span><p>SOS may disclose your PHI without your written permission when required By Law.  When disclosure is (a) required by federal, state, or local law judicial, board, or administrative proceedings; or, law enforcement; (b) compelled by a party to a proceeding before a court, arbitration panel or an administrative agency pursuant to its lawful authority; (c) required by a search warrant lawfully issued to a governmental law enforcement agency; or (d) compelled by the patient or the patient&rsquo;s representative pursuant to state or federal statutes or regulations, such as the Privacy Rule that requires this Notice.</p>
					<div class="clearfix"></div>
					<span>5.</span><p>SOS may disclose your PHI without your written permission for health oversight activities authorized by law including, investigations, inspections, audits, surveys, licensure and disciplinary actions; civil, administrative and criminal procedures or actions; or other activities necessary for the government to monitor government programs, compliance with civil rights laws and the health care system in general.</p>
					<div class="clearfix"></div>
					<span>6.</span><p>SOS may disclose your PHI without your written permission to avoid harm. When disclosure: (a) to law enforcement personnel or persons may be able to prevent or mitigate a serious threat to the health or safety of a person or the public; (b) is compelled or permitted by the fact that the Client is in such mental or emotional condition as to be dangerous to him or herself or the person or property of others, and if AST determines that disclosure is necessary to prevent the threatened danger; (c) is mandated by state child abuse and neglect reporting laws (for example, if we have a reasonable suspicion of child abuse or neglect); (d) is mandated by state elder/dependent abuse reporting law (for example, if we have a reasonable suspicion of elder abuse or dependent adult abuse); and (e) if disclosure is compelled or permitted by the fact that you or your child tells us of a serious/imminent threat of physical violence against a reasonably identifiable victim or victims.</p>
					<div class="clearfix"></div>
					<span>7.</span><p>SOS may disclose your PHI without your written permission  to company attorneys, accountants, consultants, and others to make sure that SOS is in compliance with applicable laws.</p>
					<div class="clearfix"></div>
					<span>8.</span><p>SOS may disclose your PHI without your written permission to your health insurance company to obtain benefit information, payment for treatment and services provided. </p>
					<div class="clearfix"></div>
					<span>9.</span><p>SOS may disclose your PHI without your written permission in the event of an emergency situation (such as a hospital visit).</p>
					<div class="clearfix"></div>
					<span>10.</span><p>SOS employees are not allowed to communicate by text message. The only HIPAA compliant methods of contact are phone calls, encrypted messaging, or person-to-person.</p>
					<div class="clearfix"></div>
					<span>11.</span><p>You have the right to access your PHI at anytime. SOS does not charge  fees to access your records.</p>
					<div class="clearfix"></div>
					<span>12.</span><p>You have the right to know who had access to your PHI within the last 6 years.</p>
					<div class="clearfix"></div>
					<span>13.</span><p>You have the right to limit our access to your health records.</p>
					<div class="clearfix"></div>
					<span>14.</span><p>You have the right to revoke access to your PHI that was previously given to us at any time.</p>
					<div class="clearfix"></div>
					<span>15.</span><p>SOS will notify you immediately if we become aware that an unauthorized person accessed your PHI.</p>
					<div class="clearfix"></div>
					<span>16.</span><p>You have the right to complain to the US Department of Health and Human Services if you feel that your rights have been violated.</p>
					<div class="clearfix"></div>
					<div class="bord"></div>
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<h4 class="pad-top">SOS policy does not allow parents to take pictures/videos/audio of any clients during therapy hours.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="hipaa_sospolicy" class="text-a"></textarea>
							<label>Initials</label>
							<br/><label class="error" for="hipaa_sospolicy"></label>
						</div>
					</div>
					<div class="bord"></div>
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<h4>Inside our center, there are video cameras that record video/audio and display them in the parent viewing room. When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see your chilld or overhear their ongoing treatment. By signing this agreement, you give permission to SOS to capture and display images of your child.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="hipaa_insideourcenter" class="text-a"></textarea>
							<label>Initials</label>
							<br/><label class="error" for="hipaa_insideourcenter"></label>
						</div>
					</div>
					<div class="bord"></div>
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<h4>When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see other clients or overhear their ongoing treatment. By signing this agreement, you agree to keep confidential all information obtained by your presence concerning other clients.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="hipaa_whenclients" class="text-a"></textarea>
							<label>Initials</label>
							<br/><label class="error" for="hipaa_whenclients"></label>
						</div>
					</div>
					<div class="bord"></div>
					<p class="text-center">We are required by law to maintain the confidentiality of health information that identifies clients.</p>
					<p class="text-center">We also are required by law to provide this notice of our legal duties and the privacy practices that we maintain in our practice concerning our client&rsquo;s PHI.</p>
					<div class="hipaa-check">
						<label><input name="hipaa_readprivacy" id="hipaa_readprivacy" type="checkbox" class="checkboxjq" value="1" />
						I have read and understood Success On The Spectrum's Privacy Policy.
						</label><br/>
						<label class="error" for="hipaa_readprivacy" style="font-size: 17px;font-family: Lato-Semibold;"></label>
					</div>
					
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                 <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="hipaa_date" type='text' readonly class="form-control inp-hi"  placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}"/>-->
                                <input name="hipaa_date" type='text' class="form-control inp-hi"  placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="hipaa_date"></label>
			                </div>
	            		</div>
						<div class="col-md-6 col-sm-6 text-center">
                            <!--<input name="hipaa_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="hipaa_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="hipaa_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="hipaa_signature">test</label>
						</div>
					</div>
				</div>
		    </div><!--tab3-->

		    <!-- /////////////////////////////////
		    	Payment Agreement
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab4">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="payment_childsname" type='text' class="form-control inp-hi"/>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="payment_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="payment">
					<h2>AUTHORIZATION:</h2>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					I authorize Success On The Spectrum to make medical reimbursement claims with my health insurance policy for services provided to my child.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Any pre-authorization obtained by Success On The Spectrum is not a guarantee of payment by my insurance.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>I understand and accept that I am ultimately financially responsible for all amounts not covered by my health insurance, including (but not limited to)  co-payments, deductible, co-insurance, and other fees.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Discounts for copays and deductible amounts are not allowed by law.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					I understand and agree that I am responsible for the payment of all charges incurred regardless of any insurance coverage or other plans available to me.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					I understand that Success On The Spectrum will bill me monthly for balances left unpaid by my health insurance. Invoices must be paid within 15 days of the date on the invoice. </p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					If any of my invoices remain unpaid for over 90 days, my child&rsquo;s services may be terminated.</p>
					<div class="clearfix"></div>
					<div class="bord"></div>
					<h2 class="head-pad">ADDITIONAL FEES: <label class="fees">(fees are subject to change)</label></h2>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Annual registration fee (non-refundable)</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Late fee for every 15 days that invoice payments are late</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Fee for each returned check (such as NSF)</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Mileage fees ( for in-home and school shadowing services only)</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Nocall/noshow fee for unannounced cancellations</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Field trip fees</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Late pick-up fee for each 15 minutes after your scheduled session has ended</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Forgotten diaper fee</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Forgotten lunch fee if I do not supply my own to the center (parents will be called to give permission to SOS to supply food to the child)</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Replacement fees for SOS electronics when damaged by your child</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Processing fees for payments made online</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Any and all collections costs and/or attorney&rsquo;s fees if any delinquent balance is placed with an agency or attorney for collection, suit, or legal action. </p>
					<div class="clearfix"></div>
					<div class="bord"></div>
					<h2 class="head-pad">INVOICE DISPUTES:</h2>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					If I believe there is an error on my invoice, I must contact the billing department within 90 days of receipt of the relevant invoice in order to allow review and consideration.</p>
					<div class="clearfix"></div>
					<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
					Inquiries/Disputes regarding invoices over 90 days old will be deemed untimely and payment will be not be refunded.</p>
					<div class="clearfix"></div>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <label>Parent's Signature</label>
			                <!--<input name="payment_parentssignature" type='text' class="form-control inp-hi" />-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="payment_parentssignature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="payment_parentssignature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
						</div>
						<div class="col-md-6 col-sm-6">
			                <label>Parent's Social Security</label>
			                <input name="payment_parentssocialsecurity" type='text' class="form-control inp-hi" placeholder="xxx-xx-xxxx" />
						</div>
					</div>	
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date' id='parent_birth'>
			                	<label>Parent's Birthday</label>
			                    <!--<input name="payment_parentsbirthday" readonly="" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">-->
                                <input name="payment_parentsbirthday" type='text' class="form-control inp-hi" placeholder="mm/dd/yy">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="payment_parentsbirthday"></label>
			                </div> 
						</div>
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="payment_parentsdate" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">-->
                                <input name="payment_parentsdate" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="payment_parentsdate"></label>
			                </div>
	            		</div>
					</div>
				</div>
		    </div><!--tab4-->

		    <!-- /////////////////////////////////
		    	Informed Consent For Services
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab5">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="informed_childsname" type='text' class="form-control inp-hi"/>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="informed_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="inform">
					<p>I hereby voluntarily apply for and consent to behavioral services by the staff of Success On The Spectrum, LLC. This consent applies to myself and the child named above. </p>
					<p>I understand that parental involvement and trainings are required. I understand that Success On Spectrum encourages both parents to attend the required meetings.</p>
					<p>I understand that my child&rsquo;s attendance is essential to the program and must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment.</p>
					<p>I understand that I may ask for a referral to another professional if I am not satisfied with the progress of my treatment. </p>
					<p>I understand that I have the right to refuse services at any time. I understand and agree that my continued participation implies voluntary informed consent. I also understand that Success On The Spectrum has the right to refuse services at any time.</p>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="informed_date" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">-->
                                <input name="informed_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="informed_date"></label>
			                </div>
	            		</div>
						<div class="col-md-6 col-sm-6 text-center">
			                <!--<input name="informed_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="informed_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="informed_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="informed_signature"></label>
						</div>
					</div>
				</div>
		    </div><!--tab5-->

		    <!-- /////////////////////////////////
		    	Security System
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab6">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="security_childsname" type='text' class="form-control inp-hi" />
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="security_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="inform">
					<p>SOS uses video/audio surveillance at every center. This feed is not broadcast on the internet and is  stored on a password protected hard drive within the center for approximately one month. These images/audio will not be used for marketing, advertising, or any public manner. These images/audio may be used for in-house (non-public) employee or parent training purposes. </p>
					<p>This hard drive typically  stores all recorded sessions for approximately one month before being written over. Parents may ask to view the video feed at any time. In the event of an unlikely negative incident, a copy of that session recording will be stored in the SOS Center for approximately 3 years.</p>
					<div class="bord"></div>
					<div class="row pad-02">
						<div class="col-md-9 col-sm-9">
							<h4>I grant Success On The Spectrum (SOS)  non-revocable permission to capture and store my child&rsquo;s image and audio in video surveillance, motion pictures, and recordings while in the SOS center.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="security_grantsuccess" class="text-a"></textarea>
							<label>Initials</label>
							<label class="error" for="security_grantsuccess"></label>
						</div>
					</div>
					<div class="row pad-02">
						<div class="col-md-9 col-sm-9">
							<h4>I acknowledge that SOS will own such images/audio and further grant SOS permission to store and use these images/audio. I further waive any right to inspect or approve the use of the image/audio by SOS prior to its use.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="security_acknowledge" class="text-a"></textarea>
							<label>Initials</label>
							<label class="error" for="security_acknowledge"></label>
						</div>
					</div>
					<div class="row pad-02">
						<div class="col-md-9 col-sm-9">
							<h4>SOS policy does not allow parents to take pictures/videos/audio of any clients during therapy hours.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="security_sospolicy" class="text-a"></textarea>
							<label>Initials</label>
							<label class="error" for="security_sospolicy"></label>
						</div>
					</div>
					<div class="row pad-02">
						<div class="col-md-9 col-sm-9">
							<h4>When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see other clients or overhear their ongoing treatment. By signing this agreement, you agree to keep confidential all information obtained by your presence concerning other clients.<span class="required-field">*</span></h4>
						</div>
						<div class="col-md-3 col-sm-3 text-center">
							<textarea name="security_whenclients" class="text-a"></textarea>
							<label>Initials</label>
							<label class="error" for="security_whenclients"></label>
						</div>
					</div>
					<p>I forever release and hold the SOS harmless from any and all liability arising out of the use of the images/audio for training purposes, and waive any and all claims and causes of action relating to use of the images/audio, including without limitation, claims for invasion of privacy rights or publicity.</p>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="security_date" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">-->
                                <input name="security_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="security_date"></label>
			                </div>
	            		</div>
						<div class="col-md-6 col-sm-6 text-center">
			                <!--<input name="security_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="security_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="security_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="security_signature"></label>
						</div>
					</div>
				</div>
		    </div><!--tab6-->

		    <!-- /////////////////////////////////
		    	Releas of liability
		    ////////////////////////////////////-->		    
			<div class="tab-pane" id="tab7">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="release_childsname" type='text' class="form-control inp-hi"/>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="release_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="release">
					<h2>AUTHORIZATION</h2>
					<p>Occasionally, Clients may bring personally owned devices (such as communication boards, iPads/tablets, iPods, specialized games, etc.) into the center. I understand that SOS is not responsible for any damage/loss/theft to my property.</p>
					<p>I understand that my child is never allowed to play with a SOS owned  iPad/tablet/electronics. I accept financial responsibility / liability for any damage done to SOS electronics by my child.</p>
					<div class="bord"></div>
					<h2>In-Home Therapy</h2>
					<p>Success On The Spectrum requires a parent/caregiver to be present during all in-home therapy at all times. SOS employees strive to avoid inappropriate situations. I understand that, if my child is not toilet-trained, I am responsible for changing diapers/wiping/bathing my child. I understand that I am personally responsible for cleaning messes made by my child during therapy sessions.
					<span class="release-text">I understand that Success On The Spectrum (SOS) employees may bring electronics, toys, books, or other equipment into my home for use during therapy sessions</span>.</p>
					<p>I understand that my child is not allowed to play with SOS owned property when sessions are not occurring. I understand that my child is never allowed to play with SOS owned tablets/electronics. I accept financial responsibility/liability for any damage done to SOS property by my child. I hereby release Success On The Spectrum from any liability/claims/demands related to any loss/damage/injury to any of my personally owned property that my child may cause during therapy sessions.</p>
					<div class="bord"></div>
					<h3 class="text-center">I understand that I am financially responsible for damage caused by my child to SOS property or a SOS employee&rsquo;s property.</h3>
					<h3 class="text-center">I understand that SOS is not responsible for any damage done by my child to my property.</h3>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="release_date" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">-->
                                <input name="release_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="release_date"></label>
			                </div>
	            		</div>
						<div class="col-md-6 col-sm-6 text-center">
			                <!--<input name="release_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="release_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="release_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="release_signature"></label>
						</div>
					</div>
				</div>
		    </div><!--tab7-->
		    
		    <!-- /////////////////////////////////
		    	Parent Handbook Agreement
		    ////////////////////////////////////-->		
			<div class="tab-pane" id="tab8">
				<div class="row row-pad">
					<div class="col-md-6 col-sm-6">
						<label>Child's Full Name</label>
		                <input name="parent_childsname" type='text' class="form-control inp-hi"/>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Parent's Full Name</label>
		                <input name="parent_parentsname" type='text' class="form-control inp-hi" />
					</div>
				</div>
				<div class="parent-page">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<h2>IN-CENTER THERAPY SESSIONS</h2>
							<h3>BEFORE YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Children should be dressed and fed prior to drop off at our center  (unless these skills are being addressed in the program)</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							SOS is not liable for children outside of the checked-in hours. Parents are responsible for children in the parking lot or anywhere outside of the SOS center.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Due to safety reasons, SOS does not provide any meals or snacks for the children. All students are expected to pack a lunch and re-usable water bottle. All SOS centers are nut free facilities. Parents are responsible for notifying the facility, in writing, of any allergies or other medical conditions upon enrollment or as the parents become aware of them.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Clients enrolled in SOS are not required to be toilet-trained, but parents are required to send in the appropriate diapering and/or toileting supplies that their child may need in their backpack. This includes diapers, wipes, creams, changes of clothing, and gloves to allow our staff of minimum of 3 changes per day.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parents are responsible for supplying the child&rsquo;s medications, and must complete the medical administration form.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Children do not learn when they are unhappy, bored or stressed. It is our job to motivate your child to learn! Let us know what rewards your child is likely to enjoy. We request parents provide an assortment of their child&rsquo;s favorite items.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Animals/pets are not permitted in therapy areas or hallways without approval.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Attendance must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment. Extended vacations are not allowed, as it disrupts the progress of therapy.</p>
							<div class="clearfix"></div>
							<div class="bord"></div>
							<h3>DURING YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parent must complete the sign-in form at the beginning of each  session. Parents are responsible for ensuring accuracy of hours.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>Therapists may use the first and last 15 minutes of the session for set-up and clean up.
							</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Occasionally, clients may bring personally owned devices (such as communication boards, iPads, iPods, specialized games, etc.) into the center. Before any client-owned equipment/devices are brought on-site, a release of liability form must be completed by the parent. Parents are financially responsible for damage caused by your child to SOS property or a SOS employee’s property. SOS is not responsible for any damage done by your child to your property.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							You are welcome to view your child&rsquo;s session on our video security system from our Viewing Room. All non-client minors in our center (such as siblings) must be accompanied by an adult at all times.</p>
							<div class="clearfix"></div>
							<div class="bord"></div>
							<h3>AFTER YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parent must complete the sign-out form at the end of each session.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							SOS will charge a late pick-up fee for each 15 minutes after your scheduled session has ended.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Prior to  someone other than a parent picking up a child from our center, parents must fill out a form to authorize them to do so. SOS reserves the right to ask for their ID.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parents will receive a Daily Report about the progress made within the session.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							SOS requires parents to participate in Caregiver Training. Parents will be given &ldquo;homework assignments&rdquo; and will be frequently contacted about these assignments.</p>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-6 col-sm-6">
							<h2>IN-HOME THERAPY SESSIONS</h2>
							<h3>BEFORE YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Children should be dressed and fed prior to the session  (unless these skills are being addressed in the program).</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Prepare an area in your home to be used for therapy. It must be a comfortable temperature, well lit, and relatively free of distractions.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Children do not learn when they are unhappy, bored or stressed. It is our job to motivate your child to learn! Let us know what rewards your child is likely to enjoy. We request parents provide an assortment of their child&rsquo;s favorite items.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							A parent or responsible adult must be present at all times during therapy sessions. SOS employees are not allowed to change diapers, undress, or bathe a child.  If needed, parents will also be the one to administer any first aid to your child.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							If a therapists arrives at your home and you are not present, they will wait 30 min before leaving. You will be charged a $50 noshow fee and applicable mileage fees.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Attendance must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment. Extended vacations are not allowed, as it disrupts the progress of therapy.</p>
							<div class="clearfix"></div>
							<div class="bord"></div>
							<h3>DURING YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parent must complete the sign-in form at the beginning of each  session. Parents are responsible for ensuring accuracy of hours.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Therapists may use the first and last 15 minutes of the session for set-up and clean up.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							SOS Therapists are not obligated to work with siblings. If a therapist feels a sibling can be used as a participant in a session, it is at their discretion.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parents are financially responsible for damage caused by your child to SOS property or a SOS employee&rsquo;s property. SOS is not responsible for any damage done by your child to your property.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							If your child needs to be transported, it will be the responsibility of the parent or guardian to do this. SOS employees are not allowed to take a child in their automobile at any time.</p>
							<div class="clearfix"></div>
							<div class="bord"></div>
							<h3>AFTER YOUR SESSION</h3>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parent must complete the sign-out form at the end of each  session.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Parents will receive a Daily Report about the progress made within the session.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							Do not allow your child to play with SOS therapy materials and reinforcers outside of therapy time.</p>
							<div class="clearfix"></div>
							<span><i class="fa fa-chevron-right" aria-hidden="true"></i></span><p>
							SOS requires parents to participate in Caregiver Training. Parents will be given &ldquo;homework assignments&rdquo; and will be frequently contacted about these assignments.</p>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="bord"></div>
					<div class="row row-pad">
						<div class="col-md-6 col-sm-6">
			                <div class='input-group date agreements_date'>
			                	<label>Date</label>
			                    <!--<input name="parent_date" readonly type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">-->
                                <input name="parent_date" type='text' class="form-control inp-hi" placeholder="mm/dd/yy" value="{{ date('m/d/Y') }}">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <br><label class="error" for="parent_date"></label>
			                </div>
	            		</div>
						<div class="col-md-6 col-sm-6 text-center">
			                <!--<input name="parent_signature" type='text' class="form-control inp-hi sig-bor" />-->
                            <label class="visible-xs">&nbsp;</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="parent_signature_pad">
                                        <a href="javascript:void(0);" data-action="clear" style="position:absolute;top:10px;right:25px;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <canvas style="height:180px;touch-action:none;border:1px solid #ccc;border-radius:4px;"></canvas>	
                                    </div>
                                </div>
                            </div>
                            <input name="parent_signature" type="text" class="form-control inp-hi" style="height:0px;padding:0px;border:0px"/>
			                <label>Signature<span class="required-field">*</span></label>
			                <br><label class="error" for="parent_signature"></label>
						</div>
					</div>
				</div>
		    </div><!--tab8-->
		        
				<ul class="pager wizard two-btn">
					<li class="previous pull-left"><button type='button' class='btn button-previous g-btn hidden' name='previous'><i class="fa fa-arrow-left" aria-hidden="true"></i>Back </button></li>
					<li class="next pull-right"><button type='button' class='btn button-next b-btn' name='next'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button></li>
					<li class="finish pull-right"><a href="javascript:;" class='btn b-btn'>Finish</a></li>
				</ul>
			
		</div>
	</form>
	<!--Steps html -->
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="hipaa_signature_pad_width"></div></div>
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="payment_parentssignature_pad_width"></div></div>
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="informed_signature_pad_width"></div></div>
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="security_signature_pad_width"></div></div>
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="release_signature_pad_width"></div></div>
    <div class="row hidden-xs"><div class="col-md-6 col-sm-6" id="parent_signature_pad_width"></div></div>
	</div>
	</div>

<script>
$(document).ready(function() {
		/////////////////////////
		// ALL VALIDATIONS HERE
		////////////////////////
		/*$('input[name=client_momscell]').samask("000-000-0000");
		$('input[name=client_dadscell]').samask("000-000-0000");
		$('input[name=payment_parentssocialsecurity]').samask("000-00-0000");
		$('input[name=client_emergencycontactphone]').samask("000-000-0000");*/
		$('input[name=client_momscell]').inputmask({"mask": "999-999-9999"});
		$('input[name=client_dadscell]').inputmask({"mask": "999-999-9999"});
		$('input[name=payment_parentssocialsecurity]').inputmask({"mask": "999-99-9999"});
		$('input[name=client_emergencycontactphone]').inputmask({"mask": "999-999-9999"});

		$.validator.addMethod("usphonenumb", function(value, element) {
    	        return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{3}?[\-]{1}?[0-9]{4}$/.test(value);
    	}, "Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)");

		$.validator.addMethod("validate_email", function(value, element) {
		    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
		        return true;
		    } else {
		        return false;
		    }
		}, "Please enter a valid Email.");
		
		$.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");

		$.validator.addMethod("alphanumeric_withspace", function(value, element) {
    	        return this.optional(element) || /^[a-z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	},"Special characters are not allowed.");

		$.validator.addMethod("alphanumeric_textarea", function(value, element) {
    	        return this.optional(element) || /^[a-z0-9\.\-,àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	},"Special characters are not allowed.");

		$.validator.addMethod("ssn", function(value, element) {
			return this.optional(element) || /^[0-9]{3}?[\-]{1}?[0-9]{2}?[\-]{1}?[0-9]{4}$/.test(value);
		}, "please enter valid ssn format number. (Eg: xxx-xx-xxxx)");
		
		$.validator.addMethod('filesize', function (value, element, param) {
			return this.optional(element) || (element.files[0].size <= param)
		}, 'File size must be less than {0}');
		
		//$('#admissionform')[0].reset();
		$('#admissionform').validate({
		  rules: {
		    //chooselocation_interest:{required:true,},
		    'chooselocation_location[]':{required:true,},
		    
		    //Clients
		    /*'client_todaydate':{required:true,date: true},
		    'client_childfirstname':{required:true, nameRegex: true},
		    'client_childlastname':{required:true, nameRegex: true},
		    'client_childdateofbirth':{required:true,date: true},
		    'client_custodialparent':{required:true},
		    'client_momsfname':{required:true, nameRegex: true},
		    'client_momslname':{required:true, nameRegex: true},
		    'client_momsemail':{required:true,validate_email:true},
		    'client_momscell':{required:true,phoneUS:true, usphonenumb:true},
		    'client_custodialparentsaddress':{required:true},
		    'client_dadsfname':{required:true, nameRegex: true},
		    'client_dadslname':{required:true, nameRegex: true},
		    'client_dadsemail':{required:true,validate_email:true},
		    'client_dadscell':{required:true,phoneUS:true, usphonenumb:true},
		    'client_emergencycontactname':{required:true, nameRegex: true},
		    'client_emergencycontactphone':{required:true,phoneUS:true, usphonenumb:true},
		    'client_insurancecompanyname':{nameRegex: true},
		    'client_policyholdersname':{nameRegex: true},
		    'client_ageandsymtoms':{required:true, alphanumeric_textarea:true},
		    'client_dateofautism':{required:true},
		    //'client_childdiagnostic_report[]':{required:true},
			'client_childdiagnostic_report[]':{required:true,extension: "doc,rtf,docx,pdf,jpg.jpeg,png,JPG.JPEG,PNG",filesize : 8388608},
		    'client_diagnosingdoctor':{required:true, nameRegex: true},
		    'client_primarydiagnosis':{required:true,},
		    'client_childcurrentmedications':{required:true, alphanumeric_textarea:true},
		    'client_allergies':{alphanumeric_textarea:true},
		    'client_aba':{required:true},
		    
		    'client_speechtherapy':{required:true,},
		    'client_speechinstitution':{ required: function(element) { if($("input[name='client_speechtherapy']:checked").val() == 'Yes') return true; } },		    
		    'client_speechhoursweek':{ required: function(element) { if($("input[name='client_speechtherapy']:checked").val() == 'Yes') return true; },
		    							number : function(element){ if($("input[name='client_speechtherapy']:checked").val() == 'Yes') return true; },
		    							max : function(element){ if($("input[name='client_speechtherapy']:checked").val() == 'Yes') return 90; } },
		    'client_occupationaltherapy':{required:true,},
		    'client_occupationalinstitution':{ required: function(element) { if($("input[name='client_occupationaltherapy']:checked").val() == 'Yes') return true; } },		    
		    'client_occupationalhoursweek':{ required: function(element) { if($("input[name='client_occupationaltherapy']:checked").val() == 'Yes') return true; },
		    							number : function(element){ if($("input[name='client_occupationaltherapy']:checked").val() == 'Yes') return true; } ,
		    							max : function(element){ if($("input[name='client_occupationaltherapy']:checked").val() == 'Yes') return 90; } },
		    'client_childattendschool':{required:true,},
		    'client_schoolname':{ required: function(element) { if($("input[name='client_childattendschool']:checked").val() == 'Yes') return true; },
		    					nameRegex : function(element){ if($("input[name='client_childattendschool']:checked").val() == 'Yes') return true; } },
		    'client_specialclass':{ required: function(element) { if($("input[name='client_childattendschool']:checked").val() == 'Yes') return true; },},		    
		    'client_childiep':{ required: function(element) { if($("input[name='client_childattendschool']:checked").val() == 'Yes') return true; },extension:function(element) { if($("input[name='client_childattendschool']:checked").val() == 'Yes') return "doc,rtf,docx,pdf,jpg.jpeg,png,JPG.JPEG,PNG"; } ,filesize : function(element) { if($("input[name='client_childattendschool']:checked").val() == 'Yes') return 8388608; } },		    
		    */
		    //HIPPA
		    /*'hipaa_childsname':{required:true, nameRegex: true},
		    'hipaa_parentsname':{required:true, nameRegex: true},
			*/
		    'hipaa_sospolicy':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'hipaa_insideourcenter':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'hipaa_whenclients':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'hipaa_signature':{required:true },
			
		    'hipaa_readprivacy':{required:true},
		    /*'hipaa_date':{required:true},
		    */
		    //Payment
		    'payment_parentssignature':{required:true},
		    /*'payment_childsname':{required:true, nameRegex: true},
		    'payment_parentsname':{required:true, nameRegex: true},
		    'payment_parentssocialsecurity':{required:true, ssn:true},
		    'payment_parentsbirthday':{required:true},
		    'payment_parentsdate':{required:true},*/
		    
		    //Informed
		    /*'informed_childsname':{required:true, nameRegex: true},
		    'informed_parentsname':{required:true, nameRegex: true},
		    'informed_date':{required:true},*/
		    'informed_signature':{required:true, },
		    
		    //Security
		    /*'security_childsname':{required:true, nameRegex: true},
		    'security_parentsname':{required:true, nameRegex: true},
		    'security_date':{required:true},
			*/
		    'security_grantsuccess':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'security_acknowledge':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'security_sospolicy':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'security_whenclients':{required:true, alphanumeric_textarea:true, maxlength:20},
		    'security_signature':{required:true, },
		    
		    //Release and Liability
		    /*'release_childsname':{required:true, nameRegex: true},
		    'release_parentsname':{required:true, nameRegex: true},
		    'release_date':{required:true},*/
		    'release_signature':{required:true, },
		    
		    //Parent Section
		    /*'parent_childsname':{required:true, nameRegex: true},
		    'parent_parentsname':{required:true, nameRegex: true},
		    'parent_date':{required:true},*/
		    'parent_signature':{required:true, },
		    
		  },
		  messages:{
		  	/*client_momscell:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
		  	client_dadscell:{phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)'},
		  	client_emergencycontactphone:{phoneUS:'Invalid format'},
		  	client_speechhoursweek:{max:'Please enter less than 90 hours'},
		  	client_occupationalhoursweek:{max:'Please enter less than 90 hours'},
		  	'client_childdiagnostic_report[]':{extension:'Please upload only doc ,pdf or image file only',filesize:' File size must be less than 8 MB '},
			'client_childiep':{extension:'Please upload only doc, pdf or image file only',filesize:' File size must be less than 8 MB '}*/
		  }	
		});
		$(".select_location").val($(".select_location option:first").val()).change();
		
		function ParentsRules(parentType){
			/*$('input[name=client_'+parentType+'fname], input[name=client_'+parentType+'lname]').each(function(){
				$(this).rules("add", { required:true, nameRegex: true })
			});
			$('input[name=client_'+parentType+'email]').rules("add", { required:true,validate_email:true }); 				 				
			$('input[name=client_'+parentType+'cell]').rules("add", { required:true,phoneUS:true, usphonenumb:true });*/			
		}
		
		function CustodialParentValidation(){
			var DadsName = $('input[name=client_dadsfname]').val()+' '+$('input[name=client_dadslname]').val();
			$('input[name=hipaa_parentsname],input[name=payment_parentsname],input[name=informed_parentsname],input[name=security_parentsname],input[name=release_parentsname],input[name=parent_parentsname] ').val(DadsName);

			if($('input[name=client_custodialparent]:checked').val() == 'Child lives with Dad'){
				$("input[name=client_momsfname], input[name=client_momslname], input[name=client_momsemail], input[name=client_momscell] ").each(function(){$(this).rules("remove");});	

				ParentsRules('dads');
								
			}else if($('input[name=client_custodialparent]:checked').val() == 'Child lives with Mom'){
				$("input[name=client_dadsfname], input[name=client_dadslname], input[name=client_dadsemail], input[name=client_dadscell] ").each(function(){$(this).rules("remove");});	
				
				ParentsRules('moms');
				
				var MomsName = $('input[name=client_momsfname]').val()+' '+$('input[name=client_momslname]').val();
				$('input[name=hipaa_parentsname],input[name=payment_parentsname],input[name=informed_parentsname],input[name=security_parentsname],input[name=release_parentsname],input[name=parent_parentsname] ').val(MomsName);

			}else{
				
				ParentsRules('dads');
				ParentsRules('moms');
			}
		}
		
		$('input[name="client_custodialparent"]').change(function(){
			CustodialParentValidation();
		});

		//CLIENT ABA VALIDATION
		$(".client_hours").each(function(){/*$(this).rules("add", {required:true,number:true, maxlength:5, })*/ });	
		$('input[name="client_aba"]').change(function(){
			if($('input[name=client_aba]:checked').val() == 'Yes'){
				$(".client_facility").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly');});	
				$(".client_start").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly'); });	
				$(".client_end").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly'); });	
				$(".client_hours").each(function(){
					/*$(this).rules("add", {
						required:true, number:true, max: 90, maxlength:5,
						messages:{
							max:'Please enter less than 90 hours'
						}
					}); */
					$(this).removeAttr('readonly'); 
				});	
				
				$('.dash_bor_button').show();
				
				$(".client_start").removeAttr('disabled');
				$(".client_end").removeAttr('disabled');
				$('.startDate,.endDate').find('span').css('pointer-events','auto');
			}else{
				$('.dash_bor_button').hide();
				$(".client_facility").each(function(){ $(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$(".client_start").each(function(){$(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$(".client_end").each(function(){$(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$(".client_hours").each(function(){$(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				
				$(".client_start").attr('disabled','true');
				$('.startDate,.endDate').find('span').css('pointer-events','none');
				$(".client_end").attr('disabled','true');
			}			
		});
		
		//SPEECH THERAPY VALIDATION
		$('input[name="client_speechtherapy"]').change(function(){
			if($('input[name=client_speechtherapy]:checked').val() == 'Yes'){
				$("input[name=client_speechinstitution]").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly');});	
				$("input[name=client_speechhoursweek]").each(function(){ /*$(this).rules("add", { required:true, number:true, max: 90, messages:{ max:'Please enter less than 90 hours' } }); */
					$(this).removeAttr('readonly'); 
					});	
			}else{
				$("input[name=client_speechinstitution]").each(function(){ $(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$("input[name=client_speechhoursweek]").each(function(){$(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
			}			
		});
		
		//Occupational Therapy VALIDATION
		$('input[name="client_occupationaltherapy"]').change(function(){
			if($('input[name=client_occupationaltherapy]:checked').val() == 'Yes'){
				$("input[name=client_occupationalinstitution]").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly');});	
				$("input[name=client_occupationalhoursweek]").each(function(){
					//$(this).rules("add", { required:true, number:true, max: 90, messages:{ max:'Please enter less than 90 hours' } }); 
					$(this).removeAttr('readonly'); 
				});	
			}else{
				$("input[name=client_occupationalinstitution]").each(function(){ $(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$("input[name=client_occupationalhoursweek]").each(function(){$(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
			}			
		});				
		
		//Does your child attend school VALIDATION
		$('input[name="client_childattendschool"]').change(function(){
			if($('input[name=client_childattendschool]:checked').val() == 'Yes'){
				$("input[name=client_schoolname]").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('readonly');});	
				$("input[name=client_specialclass]").each(function(){/*$(this).rules("add", {required:true,});*/ $(this).removeAttr('disabled');});	
				
			}else{
				$("input[name=client_schoolname]").each(function(){ $(this).rules("remove"); $(this).attr('readonly',''); $(this).val(''); });	
				$("input[name=client_specialclass]").each(function(){
					$(this).rules("remove"); 
					$(this).attr('disabled',true); 
					$(this).prop( "checked", false );;
				});	
			}	
		});	
		
		//Code for IEP image
		$('.IEP').on('click',function(){
			if($('input[name=client_childattendschool]:checked').val() == 'Yes'){
				$('input[name=client_childiep]').click();
	            $(this).parent('div').find('.clickme').bind('change', function () {
	                var filename = $(this).val();
	                if (/^\s*$/.test(filename)) {
	                    $(".file-upload").removeClass('active');
	                    $(this).parent('div').find(".noFile").text(""); 
	                }else {
		                $(".file-upload").addClass('active');
		                $(this).parent('div').find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
	              	}
	            });
			}else{
				return false;
			}
		});
		////////////////////////////
		// ALL VALIDATIONS END HERE
		////////////////////////////

		
		///////////////
		//Form Steps
		//////////////
	  	$('#rootwizard').bootstrapWizard({
	  		'nextSelector': '.button-next', 
	  		'previousSelector': '.button-previous',
			onTabClick: function(tab, navigation, index) {
				return false;
			},
			onTabShow: function(tab, navigation, index) {
				$('.index_count').html(index+1);
			},
			onNext: function(tab, navigation, index) {
				if(index == 1){
					$('.button-previous').removeClass('hidden');
				}
				if(index == 2){
					initSignaturePad("hipaa_signature");
				}
				if(index == 3){
					initSignaturePad("payment_parentssignature");
				}
				if(index == 4){
					initSignaturePad("informed_signature");
				}
				if(index == 5){
					initSignaturePad("security_signature");
				}
				if(index == 6){
					initSignaturePad("release_signature");
				}
				if(index == 7){
					initSignaturePad("parent_signature");
				}
				$(".client_hours").each(function(){/*$(this).rules("add", {required:true,number:true, maxlength:5,})*/ });
				if($('input[name=client_aba]:checked').val() == 'Yes'){
					/*$(".client_facility").each(function(){$(this).rules("add", {required:true,}) });	
					$(".client_start").each(function(){$(this).rules("add", {required:true,}) });	
					$(".client_end").each(function(){$(this).rules("add", {required:true,}) });*/	
					$(".client_hours").each(function(){
						/*$(this).rules("add", {
							required:true, number:true, max: 90, maxlength:5,
							messages:{
								max:'Please enter less than 90 hours'
							}
						}); */
						$(this).removeAttr('readonly'); 
					});	
				}else{
					$(".client_facility").each(function(){$(this).rules("remove");});	
					$(".client_start").each(function(){$(this).rules("remove") });	
					$(".client_end").each(function(){$(this).rules("remove") });	
				}
				
				if(index == 2){
					if($('input[name=client_aba]:checked').val() == 'Yes'){
						$(".client_hours").each(function(){
							/*$(this).rules("add", {
								required:true, number:true, max: 90,
								messages:{
									max:'Please enter less than 90 hours'
								}
							});*/ 
							$(this).removeAttr('readonly'); 
						});	
					}else{
						$(".client_hours").each(function(){$(this).rules("remove")});
					}
					
					CustodialParentValidation();
					//Getting Childs Name and fill in All steps
					var ChildsName = $('input[name=client_childfirstname]').val()+' '+$('input[name=client_childlastname]').val();
					$('input[name=hipaa_childsname],input[name=payment_childsname],input[name=informed_childsname],input[name=security_childsname],input[name=release_childsname],input[name=parent_childsname] ').val(ChildsName);
					
					
				}

	  			var $valid = $("#admissionform").valid();
				if(!$valid) {
	  				return false;
				}
				
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
			$('#admissionform').submit();
		});	
		
		///////////////
		//Form Steps end
		//////////////
		

});
	
$(document).ready(function(){
	
 	$('.datepicker').datetimepicker({
        today:1,
        autoclose: true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2
 	});

	//Start Date end Date code for daterange
	$(".startDate").datetimepicker({
        today:  1,
        autoclose: true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        minDate.setDate(minDate.getDate() + 1);
        $(this).parents('.row').find('.endDate').datetimepicker('setStartDate', minDate);
    });
    $(".endDate").datetimepicker({
        autoclose: true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2,
	    ignoreReadonly:true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        minDate.setDate(minDate.getDate() - 1);
        $(this).parents('.row').find('.startDate').datetimepicker('setEndDate', minDate);
    });

	//Date of birth condition for parents 
	$('#parent_birth, #datetimepicker3, #dateofbirth').datetimepicker({
		useCurrent: false,
		autoclose:true,
        format: 'mm/dd/yyyy',
	    maxView: 4,
	    minView: 2,   
	    endDate: new Date(),
    });  

	//Code for add ABA FIelds
	var count = 1;
	$('.dash_bor_button').click(function(){
		var html = '<div class="row row-pad">';
			html +=	'<div class="col-md-4 col-sm-6"><label>If yes, which facility?</label>';
			html +=	'<input name="aba['+count+'][client_facility]" type="text" class="form-control inp-hi client_facility" />';
			html +=	'</div>';

			html +=	'<div class="col-md-2 col-sm-6">'
		    html += '<div class="input-group date startDate" ><label>What year did they start?</label>';
		    html += '<input name="aba['+count+'][client_start]" type="text" class="form-control inp-hi client_start " placeholder="mm/dd/yy" />';
		    html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
		    html += '<br /><label class="error" for="client_start"></label></div></div>';
			
			html += '<div class="col-md-2 col-sm-6">';
		    html += '<div class="input-group date endDate"><label>What year did they finish?</label>';
		    html += '<input name="aba['+count+'][client_end]" type="text" class="form-control inp-hi client_end " placeholder="mm/dd/yy" />';
		    html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
		    html += '<br /><label class="error" for="client_end"></label></div></div>';
					
			html += '<div class="col-md-4 col-sm-6 aba_hours"><label>How many hours of ABA did they receive per week</label>';
		    html += '<input name="aba['+count+'][client_hours]" type="text" class="form-control inp-hi client_hours" /><i class="fa fa-times cut_aba"></i></div></div>';
		$('.add_aba').append(html);
		count++;

		//$(".client_hours").each(function(){$(this).rules("add", {required:true,number:true}) });	
		if($('input[name=client_aba]:checked').val() == 'Yes'){
			//$(".client_facility").each(function(){$(this).rules("add", {required:true,}) });	
			//$(".client_start").each(function(){$(this).rules("add", {required:true,}) });	
			//$(".client_end").each(function(){$(this).rules("add", {required:true,}) });
			//$(".client_hours").each(function(){$(this).rules("add", {required:true, maxlength:5, max: 90, messages:{max:'Please enter less than 90 hours'} }) });		
		}
		
		$(".startDate").datetimepicker({
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        minDate.setDate(minDate.getDate() + 1);
	        $(this).parents('.row').find('.endDate').datetimepicker('setStartDate', minDate);
	    });
	    $(".endDate").datetimepicker({
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    ignoreReadonly:true,    	
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        minDate.setDate(minDate.getDate() - 1);
	        $(this).parents('.row').find('.startDate').datetimepicker('setEndDate', minDate);
		});	         
	});
	
	$(document).on('click','.cut_aba',function(){
		$(this).parents('.row').remove();
	})

    $(document).on('click', '.startDate', function () {
        var $this = $(this);
		$this.datetimepicker({
			ignoreReadonly:true,
		});
    });

    $(document).on('click', '.endDate', function () {
        var $this = $(this);
	    $this.datetimepicker({
	    	ignoreReadonly:true,
	    }); 
    });

	//
	$('.agreements_date').datetimepicker({
        'autoclose': true,
        'format': 'mm/dd/yyyy',
	    'maxView': 4,
	    'minView': 2    	
	});	    
	$('.agreements_date').datetimepicker('setStartDate', new Date());

	//
	$('.agreements_date2').datetimepicker({
		'autoclose': true,
		'format': 'mm/dd/yyyy',
		'maxView': 4,
		'minView': 2
	});
	$('.agreements_date2').datetimepicker('setEndDate', new Date());


    var csrfToken = $('[name="_token"]').val();

    //setInterval(refreshToken, 1800000); // 1 hour 
	setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 
    function refreshToken(){
        //$.get('refresh-csrf').done(function(data){
		$.get('{{ url("refresh-csrf")}}').done(function(data){	
            $('[name="_token"]').val(data); // the new token
        });
    }
    //setInterval(refreshToken, 1800000);
	setInterval(refreshToken, 1000 * 60 * 1); // 15 minutes 
    
    //Frnachise id code
    $('.select_location').change(function(){
    	var franchise_id = $(this).find(':selected').data('franchise_id');	
    	$('input[name=franchise_id]').val(franchise_id);
    });
});

</script>

<script>
function initSignaturePad(signature)
{
	//Signature Pad
	var wrapper = document.getElementById(signature+"_pad");
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
			$('input[name="'+signature+'"]').val(data);
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
	var width = $("#"+signature+"_pad_width").width();
	if(width < 0)var width = parseFloat($( window ).width())-parseFloat(30);
	$("#"+signature+"_pad").find('canvas').css("width",width+"px").prop('width',width);
  
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
		$('input[name="'+signature+'"]').val("");
	});
	
	/*showPointsToggle.addEventListener('click', function(event) {
		signaturePad.showPointsToggle();
		showPointsToggle.classList.toggle('toggle');
	});*/
}
$(window).resize(function(){
	initSignaturePad("hipaa_signature");
	initSignaturePad("payment_parentssignature");
	initSignaturePad("informed_signature");
	initSignaturePad("security_signature");
	initSignaturePad("release_signature");
	initSignaturePad("parent_signature");
});
</script>
@include('frontend.includes.footer')