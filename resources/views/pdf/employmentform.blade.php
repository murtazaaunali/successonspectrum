<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admission Form</title>

    </head>
    <body>
        <style>
        body{
        	white-space: normal; 
        	font-family: 'Varela Round', sans-serif;
        	font-size: 12px;
        	}
		.no-break{
			page-break-inside: avoid;
		}
		.main_tab_set{
			 border-radius: 10px;
    		-moz-border-radius: 10px;
			}
		.main_tab_set tr td{
			
		    background: #eeeeee !important;
		    margin: 20px;
		    padding: 10px;
		    border-radius: 10px;
    		-moz-border-radius: 10px;
		 }
		 .main_tab_set{
			border-spacing: 12px;
			border-collapse: separate;
			page-break-inside: avoid;
		 	}
		 h2{
		 	padding-left: 0px;
		 	}
		 .main_tab_set th{
		 	text-align: left;
		 	padding-left: 10px;
		  }
		  img{
		  	text-align: center;
		  }
		  ul{
		  	padding: 15px;
		  }
		  .main_logo{
		  	text-align: center;
		  	}
		  .main_logo td{
		  	/*background: #000;*/
			background: #fff;
		  	width: 100%;
		  	text-align: center;
		  	}
			.page-break {
			    page-break-after: always;
			}		  			
		 </style>

		<table align="center" class="main_logo">
			<tr><td><img src="{{ public_path('assets') }}/frontend/images/logo.jpg"></td></tr>
		</table>

		<h1 align="center">EMPLOYMENT APPLICATION</h1>
		<div class="no-break"></div>
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>PERSONAL INFO</h2></th></tr>
			<tbody>
				<tr>
					<td width="33.33%" valign="top"><strong>Name:</strong><br />{{$empForm->personal_name}}</td>
					<td width="33.33%" valign="top"><strong>Phone#:</strong><br />{{$empForm->personal_phone}}</td>
					<td width="33.33%" valign="top"><strong>Email:</strong><br />{{$empForm->personal_email}}</td>
				</tr>
				<tr>
					<td width="33.33%" valign="top"><strong>City:</strong><br />{{$empForm->personal_city}}</td>
					<td width="33.33%" valign="top"><strong>State:</strong><br />{{$empForm->personal_state}}</td>
					<td width="33.33%" valign="top"><strong>Zipcode:</strong><br />{{$empForm->personal_zipcode}}</td>
				</tr>
				
			</tbody>
		</table>
		
		<table class="main_tab_set" width="100%" >
			<tr><td><strong>Address:</strong><br />{{$empForm->personal_address}}</td></tr>
		</table>
		
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>CAREER OPTIONS</h2></th></tr>
			<tbody>
				<tr>
					<td><strong>Desired Position:</strong><br />
						@if($empForm->career_desired_position)
							<ul>
							@forelse (explode(',', $empForm->career_desired_position) as $position)
							    <li>{{ $position }}</li>
							@empty
							    <li>No Location</li>
							@endforelse
							</ul>
						@endif
					</td>
				</tr>				
			</tbody>
		</table>	
		
		<table class="main_tab_set" width="100%" >
			<tr><td><strong>Desired Schedule:</strong><br />{{$empForm->career_desired_schedule}}</td></tr>
		</table>			

		
		<table class="main_tab_set" width="100%" >
			<tr><th><h3>Availability</h3></th></tr>
			@php 
				$times = array();
				$schedule = \App\Models\Franchise\Femployees_schedules::find($empForm->id);
				
				if($empForm->career_availability){
					$times = unserialize($empForm->career_availability);
				}
			@endphp
			
			@if($schedule)
				@if(!empty($emp_shedule))
					@foreach($emp_shedule as $day => $time)
						<tr>
							<td>{{ ucfirst($day) }}</td>
							<td>{{ date('h:i A', strtotime($schedule->{$day.'_time_in'}) ) }}</td>
							<td>{{ date('h:i A', strtotime($schedule->{$day.'_time_out'}) ) }}</td>
						</tr>
					@endforeach
				@endif
			
			@else
			<tr><td>No Availability</td></tr>	
			@endif
			
		</table>		

		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Desired Pay $:</strong><br />{{$empForm->career_desired_pay}}</td>
				<td><strong>Earliest Start Date:</strong><br />@if($empForm->career_earliest_startdate ) {{ date('m/d/Y',strtotime($empForm->career_earliest_startdate)) }} @endif</td>
			</tr>
		</table>


		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Are you Registered by the BACB?:</strong><br />{{$empForm->career_bacb}} @if($empForm->career_bacb == 'Yes') ({{ date('m/d/Y', strtotime($empForm->bacb_regist_date)) }}) @endif</td>
				<td><strong>Are You CPR Certified?:</strong><br />{{$empForm->career_cpr_certified}} @if($empForm->career_cpr_certified == 'Yes') ({{ date('m/d/Y', strtotime($empForm->cpr_regist_date)) }}) @endif</td>
			</tr>
		</table>
		
		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Highest Degree:</strong><br />{{$empForm->career_highest_degree}}</td>
			</tr>
		</table>


		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Desired Location:</strong><br />
					@if($empForm->career_desired_location)
						<ul>
						@forelse (explode('|', $empForm->career_desired_location) as $location)
						    <li>{{ $location }}</li>
						@empty
						    <li>No Location</li>
						@endforelse
						</ul>
					@endif
				</td>
			</tr>
		</table>		
		<div class="page-break"></div>
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>WORK ELIGIBILITY</h2></th></tr>
			<tr>
				<td><strong>Are you under 18 years of age?:</strong><br />{{$empForm->work_underage}}</td>
			</tr>
		</table>	

		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Are you authorized to work in the United States?:</strong><br />{{$empForm->work_authorised}}</td>
			</tr>
		</table>	

		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Are you capable of performing the essential functions of the job which you are applying without any accommodations?:</strong><br />{{$empForm->work_nocapable}}</td>
			</tr>
		</table>
		
		<table class="main_tab_set" width="100%" >
			<tr>
				<td><strong>Are you able to lift 30 to 40 lbs? Able to do physical activities?:</strong><br />{{$empForm->work_liftlbs}}</td>
			</tr>
		</table>
		
		<div class="page-break"></div>
		<table class="main_tab_set"  width="100%" >
			<tr><th><h2>ABA EXPERIENCE AND REFERENCES</h2></th></tr>
		</table>
		<table class="main_tab_set" width="100%" >
			
			<tr>
				<td width="33.33%"><strong>Employment Starting Date:</strong><br /> @if($empForm->aba_employment_startingdate) {{ date('m/d/Y',strtotime($empForm->aba_employment_startingdate)) }} @endif</td>
				<td width="33.33%"><strong>Employment Ending Date:</strong><br /> @if($empForm->aba_employment_endingdate ) {{ date('m/d/Y',strtotime($empForm->aba_employment_endingdate)) }} @endif</td>
				<td width="33.33%"><strong>Company Name:</strong><br />{{$empForm->aba_companyname}}</td>
			</tr>
		</table>				
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Position Held:</strong><br />{{$empForm->aba_positionheld}}</td>
				<td width="50%"><strong>Reason for Leaving:</strong><br />{{$empForm->aba_reasonforleaving}}</td>
			</tr>
		</table>
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Manager's Name:</strong><br />{{$empForm->aba_managersname}}</td>
				<td width="50%"><strong>Phone#:</strong><br />{{$empForm->aba_phone}}</td>
			</tr>
		</table>
		<hr />
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="33.33%"><strong>Employment Starting Date:</strong><br /> @if($empForm->aba_employment_startingdate2 ) {{ date('m/d/Y',strtotime($empForm->aba_employment_startingdate2)) }} @endif</td>
				<td width="33.33%"><strong>Employment Ending Date:</strong><br />@if($empForm->aba_employment_endingdate2 ) {{ date('m/d/Y',strtotime($empForm->aba_employment_endingdate2)) }} @endif</td>
				<td width="33.33%"><strong>Company Name:</strong><br />{{$empForm->aba_companyname2}}</td>
			</tr>
		</table>				
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Position Held:</strong><br />{{$empForm->aba_positionheld2}}</td>
				<td width="50%"><strong>Reason for Leaving:</strong><br />{{$empForm->aba_reasonforleaving2}}</td>
			</tr>
		</table>
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Manager's Name:</strong><br />{{$empForm->aba_managersname2}}</td>
				<td width="50%"><strong>Phone#:</strong><br />{{$empForm->aba_phone2}}</td>
			</tr>
		</table>
		<hr />
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="33.33%"><strong>Employment Starting Date:</strong><br />@if($empForm->aba_employment_startingdate3 ) {{ date('m/d/Y',strtotime($empForm->aba_employment_startingdate3)) }} @endif</td>
				<td width="33.33%"><strong>Employment Ending Date:</strong><br />@if($empForm->aba_employment_endingdate3 ) {{ date('m/d/Y',strtotime($empForm->aba_employment_endingdate3)) }} @endif</td>
				<td width="33.33%"><strong>Company Name:</strong><br />{{$empForm->aba_companyname3}}</td>
			</tr>
		</table>				
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Position Held:</strong><br />{{$empForm->aba_positionheld3}}</td>
				<td width="50%"><strong>Reason for Leaving:</strong><br />{{$empForm->aba_reasonforleaving3}}</td>
			</tr>
		</table>
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%"><strong>Manager's Name:</strong><br />{{$empForm->aba_managersname3}}</td>
				<td width="50%"><strong>Phone#:</strong><br />{{$empForm->aba_phone3}}</td>
			</tr>
		</table>

		<div class="page-break"></div>
		<table class="main_tab_set"  width="100%" >
			<tr><th><h2>PLEASE READ CAREFULLY BEFORE SIGNING APPLICATION</h2></th></tr>
		</table>
		
        <table class="main_tab_set" width="100%" >
        	<tr>
        		<td>
	        		<p>
	        			I have submitted the attached form to the company for the purpose of obtaining employment. I acknowledge that the use of this form, and my filling it  out, does not indicate that any positions are open, nor does it obligate Success On The Spectrum to further process my application.
	        		</p>
	        		<p>
	        			My signature below attests to the fact that the information that I have provided on my application, resume, given verbally, or provided in any other 
	        			materials, is true and complete to the best of my knowledge and also constitutes authority to verify any and all information submitted on this application. 
	        			I understand that any misrepresentation or omission of any fact in my application, resume or any other materials, or during any interviews, can be 
	        			justification for refusal of employment, or, if employed, termination from Success On The Spectrum’s employ.
	        		</p>

	        		<p>
	        			I also affirm that I have not signed any kind of restrictive document creating any obligation to any former employer that would restrict my acceptance of 
	    				employment with Success On The Spectrum in the position I am seeking. I understand that this application is not an employment contract for any specific 
	    				length of time between Success On The Spectrum and me, and that in the event I am hired, my employment will be “at will” and either Success On The 
	    				Spectrum or I can terminate my employment with or without cause and with or without notice at any time. Nothing contained in any handbook, manual, 
	    				policy and the like, distributed by Success On The Spectrum to its employees is intended to or can create an employment contract, an offer of 
	    				employment or any obligation on Success On The Spectrum’s part. Success On The Spectrum may, at its sole discretion, hold in abeyance or revoke, 
	    				amend or modify, abridge or change any benefit, policy practice, condition or process affecting its Employees.
	        		</p>

	        		<p>
	        			<strong>References:</strong> I hereby authorize Success On The Spectrum and its agents to make such investigations and inquiries into my employment and educational
	    				history and other related matters as may be necessary in arriving at an employment decision. I hereby release employers, schools, and other persons from 
	    				all liability in responding to inquiries connected with my application and I specifically authorize the release of information by any schools, businesses,
	    				individuals, services or other entities listed by me in this form. Furthermore, I authorize Success On The Spectrum and its agents to release any reference
	    				information to clients who request such information for purposes of evaluating my credentials and qualifications.
	        		</p>

	        		<p>
	    				<strong>Temporary/Contract Employment:</strong> If employed as a temporary or contract employee, I understand that I may be an employee of Success On The 
	    				Spectrum and not of any client. If employed, I further understand that my employment is not guaranteed for any specific time and may be terminated at 
	    				any time for any reason. I further understand that a contract will exist between Success On The Spectrum and each client to whom I may be assigned 
	    				which will require the client to pay a fee to Success On The Spectrum in the event that I accept direct employment with the client, I agree to notify 
	    				Success On The Spectrum immediately should I be offered direct employment by a client (or by referral of the client to any subsidiary or affiliated
	    				company), either for a permanent, temporary (including assignments through another agency), or consulting positions during my assignment or after my 
	    				assignment has ended.
	        		</p>
        		</td>
        	</tr>
        	<tr>
        		<td>
        			<p>
        				Success On The Spectrum is an equal opportunity employer and does not discriminate against any applicant or employee because of race, color, religion,
        				sex, national origin, disability, age, or military or veteran status in accordance with federal law. In addition, Success On The Spectrum complies with
        				applicable state and local laws governing nondiscrimination in employment in every jurisdiction in which it maintains facilities. Success On The Spectrum
        				also provides reasonable accommodation to qualified individuals with disabilities in accordance with applicable laws.
        			</p>
        		</td>
        	</tr>
        	
		</table>        			
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="33.33%" valign="top"><strong>Applicant Printed Name:</strong><br />{{$empForm->careully_applicantpname}}</td>
				<td width="33.33%" valign="top"><strong>Date:</strong><br />@if($empForm->careully_date ) {{ date('m/d/Y',strtotime($empForm->careully_date)) }} @endif</td>
				<!--<td width="33.33%"><strong>Signature:</strong><br />{{$empForm->careully_signature}}</td>-->
                <td width="33.33%"><strong>Signature:</strong><br /><img src="{{$empForm->careully_signature}}" style="max-width:198px;"></td>
			</tr>
		</table>

		<div class="no-break"></div>

    </body>
</html>
