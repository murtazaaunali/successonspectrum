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
			.text-center
			{
				text-align:center !important;
			}
		 </style>

		<table align="center" class="main_logo">
			<tr><td><img src="{{ public_path('assets') }}/frontend/images/logo.jpg"></td></tr>
		</table>

		<h1 align="center">Admission Form</h1>
		<div class="no-break"></div>
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Choose Location</h2></th></tr>
			<tbody>
			<tr>
				<td><strong>Your interest:</strong><br />{{$adForm->chooselocation_interest}}</td>
			</tr>
			<tr>
				<td><strong>Desired Location:</strong><br />
					@if($adForm->chooselocation_location)
						<ul>
						@forelse (explode('|', $adForm->chooselocation_location) as $location)
						    <li>{{ $location }}</li>
						@empty
						    <li>No Location</li>
						@endforelse
						</ul>
					@endif
				</td>
			</tr>
			</tbody>
		</table>
		
		<div class="no-break"></div>
			
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Client Information</h2></th></tr>
			<tr>
				<td width="25%" valign="top"><strong>Today's Date:</strong><br />@if($adForm->client_todaydate ) {{ date('m/d/Y',strtotime($adForm->client_todaydate)) }} @endif</td>
				<td width="25%" valign="top"><strong>Child's Fullname:</strong><br />{{$adForm->client_childfullname}}</td>
				<td width="25%" valign="top"><strong>Child's Date of Birth:</strong><br /> @if($adForm->client_childdateofbirth ) {{ date('m/d/Y',strtotime($adForm->client_childdateofbirth)) }} @endif</td>
			</tr>
		</table>	
		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Mom's Name:</strong><br />{{$adForm->client_momsname}}</td>
				<td width="33.33%" valign="top"><strong>Mom's Email:</strong><br />{{$adForm->client_momsemail}}</td>
				<td width="33.33%" valign="top"><strong>Mom's Cell:</strong><br />{{$adForm->client_momscell}}</td>
			</tr>
		</table>
		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%" valign="top"><strong>Custodial Parent:</strong><br />{{$adForm->client_custodialparent}}</td>
				<td width="50%" valign="top"><strong>Custodial Parent's Address:</strong><br />{{$adForm->client_custodialparentsaddress}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Dad's Name:</strong><br />{{$adForm->client_dadsname}}</td>
				<td width="33.33%" valign="top"><strong>Dad's Email:</strong><br />{{$adForm->client_dadsemail}}</td>
				<td width="33.33%" valign="top"><strong>Dad's Cell:</strong><br />{{$adForm->client_dadscell}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="50%" valign="top"><strong>Emergency Contact Name:</strong><br />{{$adForm->client_emergencycontactname}}</td>
				<td width="50%" valign="top"><strong>Emergency Contact Phone:</strong><br />{{$adForm->client_emergencycontactphone}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<!--<td width="33.33%" valign="top"><strong>Insurance Company Name:</strong><br />{{$adForm->client_insurancecompanyname}}</td>-->
                <td width="33.33%" valign="top"><strong>Insurance Company Name:</strong><br />{{$adFormInsurancePolicy->client_insurancecompanyname}}</td>
				<td width="33.33%" valign="top"><strong>Insurance Company ID Card:</strong><br />
				<?php /*?>@if($adForm->client_insurancecompanyidcard)<?php */?>
                @if($adFormInsurancePolicyIDCard)
					@if($adFormInsurancePolicyIDCard->client_insurancecompanyidcard)
						<!--<img width="100" src="{{ storage_path($adForm->client_insurancecompanyidcard) }}" alt=""/>-->
						<!--<a href="{{ url($adForm->client_insurancecompanyidcard) }}" target="_blank" >{{ $idcard }}</a>-->
	                    <a href="{{ url($adFormInsurancePolicyIDCard->client_insurancecompanyidcard) }}" target="_blank" >{{ $idcard }}</a>
					@endif					
				@endif
				</td>
				<!--<td width="33.33%" valign="top"><strong>Member ID:</strong><br />{{$adForm->client_memberid}}</td>-->
                <td width="33.33%" valign="top"><strong>Member ID:</strong><br />{{$adFormInsurancePolicy->client_memberid}}</td>
			</tr>
		</table>


		<table class="main_tab_set" width="100%" >			
			<tr>
				<!--<td width="33.33%" valign="top"><strong>Group ID:</strong><br />{{$adForm->client_groupid}}</td>
				<td width="33.33%" valign="top"><strong>Policyholder’s Name (Usually a parent):</strong><br />{{ $adForm->client_policyholdersname }}</td>
				<td width="33.33%" valign="top"><strong>Policyholder’s Date of Birth:</strong><br />@if($adForm->client_policyholdersdateofbirth) {{ date('m/d/Y',strtotime($adForm->client_policyholdersdateofbirth)) }} @endif</td>-->
                <td width="33.33%" valign="top"><strong>Group ID:</strong><br />{{$adFormInsurancePolicy->client_groupid}}</td>
				<td width="33.33%" valign="top"><strong>Policyholder’s Name (Usually a parent):</strong><br />{{ $adFormInsurancePolicy->client_policyholdersname }}</td>
				<td width="33.33%" valign="top"><strong>Policyholder’s Date of Birth:</strong><br />@if($adFormInsurancePolicy->client_policyholdersdateofbirth) {{ date('m/d/Y',strtotime($adFormInsurancePolicy->client_policyholdersdateofbirth)) }} @endif</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td valign="top"><strong>Describe the age and symptoms that were first noticed:</strong><br /><br />{{$adForm->client_ageandsymtoms}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >
			<tr>
				<td width="40%" valign="top"><strong>Date of Autism Diagnosis:</strong><br />{{ date('m/d/Y',strtotime($adForm->client_dateofautism)) }}</td>
				<td width="60%" valign="top"><strong>Upload your child’s diagnostic report (must include the testing scores):</strong><br />
			    @php
			    	$docs = \App\Models\Franchise\Client_documents::where(array('client_id'=>$adForm->id, 'document'=>'Childs Dignostic'))->get();
			    	foreach($docs as $getDocs){
			    		$extension = pathinfo($getDocs->document_file,PATHINFO_EXTENSION);
			    		if($extension == 'pdf' || $extension == 'docx'){
							echo '<a href="'.url($getDocs->document_file).'" target="_blank">'.$getDocs->document_name.'</a><br />';
						}else{
							//echo '<img width="250" src="'.url($getDocs->document_file).'"><br />';
                            echo '<a href="'.url($getDocs->document_file).'" target="_blank">'.$getDocs->document_name.'</a><br />';
						}
					}
			    @endphp
			</td>
			</tr>
		</table>
				
		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Diagnosing Doctor:</strong><br />{{$adForm->client_diagnosingdoctor}}</td>
				<td width="33.33%" valign="top"><strong>Primary Diagnosis:</strong><br />{{ $adForm->client_primarydiagnosis }}</td>
				<td width="33.33%" valign="top"><strong>Secondary Diagnosis, if any:</strong><br />{{$adForm->client_secondarydiagnosis}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td valign="top"><strong>List Child’s Current Medications and Doses:</strong><br /><br />{{$adForm->client_childcurrentmedications}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td valign="top"><strong>List any allergies Or food restrictions:</strong><br /><br />{{$adForm->client_allergies}}</td>
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td valign="top"><strong>Has your Child ever received ABA before?:</strong><br />{{$adForm->client_aba}}</td>
			</tr>
		</table>

		@if($adForm->client_aba == 'Yes')
			@php $client_aba_facility = unserialize($adForm->client_aba_facilities); @endphp
			@foreach($client_aba_facility as $getData)
				<table class="main_tab_set" width="100%" >
					<tr>
						<td width="25%" valign="top"><strong>If yes, which facility?:</strong><br />{{ $getData['client_facility'] }}</td>
						<td width="25%" valign="top"><strong>What year did they start?:</strong><br /> @if( $getData['client_start'] ) {{ date('m/d/Y',strtotime($getData['client_start'])) }} @endif</td>
						<td width="25%" valign="top"><strong>What year did they finish?:</strong><br /> @if( $getData['client_end'] ) {{ date('m/d/Y',strtotime($getData['client_end'])) }} @endif</td>
						<td width="25%" valign="top"><strong>How many hours of ABA did they receive per week:</strong><br />{{ $getData['client_hours'] }}</td>
					</tr>
				</table>
			@endforeach
		@endif

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Is your child currently in Speech Therapy?:</strong><br />{{$adForm->client_speechtherapy}}</td>
				@if($adForm->client_speechtherapy == 'Yes')
				<td width="33.33%" valign="top"><strong>Institution:</strong><br />{{ $adForm->client_speechinstitution }}</td>
				<td width="33.33%" valign="top"><strong>Hours Per Week:</strong><br />{{$adForm->client_speechhoursweek}}</td>
				@endif
			</tr>
		</table>

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Is your child currently in Occupational Therapy?:</strong><br />{{$adForm->client_occupationaltherapy}}</td>
				@if($adForm->client_occupationaltherapy == 'Yes')
				<td width="33.33%" valign="top"><strong>Institution:</strong><br />{{ $adForm->client_occupationalinstitution }}</td>
				<td width="33.33%" valign="top"><strong>Hours Per Week:</strong><br />{{$adForm->client_occupationalhoursweek}}</td>
				@endif
			</tr>
		</table>		

		<table class="main_tab_set" width="100%" >			
			<tr>
				<td><strong>Does your child attend school?:</strong><br />{{$adForm->client_childattendschool}}</td>
			</tr>
		</table>
	
		<table class="main_tab_set" width="100%" >			
			<tr>
				<td width="33.33%" valign="top"><strong>Name of school:</strong><br />{{$adForm->client_schoolname}}</td>
				<td width="33.33%" valign="top"><strong>If so, are they in a special needs class?:</strong><br />{{$adForm->client_specialclass}}</td>
				<td width="33.33%" valign="top"><strong>Please Attach your Child's IEP:</strong><br />
			    @php 
			    	$docs = \App\Models\Franchise\Client_documents::where(array('client_id'=>$adForm->id, 'document'=>'Childs IEP'))->get();
			    	foreach($docs as $getDocs){
			    		$extension = pathinfo($getDocs->document_file,PATHINFO_EXTENSION);
			    		if($extension == 'pdf' || $extension == 'docx'){
							echo '<a href="'.url($getDocs->document_file).'" target="_blank">'.$getDocs->document_name.'</a><br />';
						}else{
							//echo '<img width="250" src="'.url($getDocs->document_file).'"><br />';
                            echo '<a href="'.url($getDocs->document_file).'" target="_blank">'.$getDocs->document_name.'</a><br />';
						}
					}
			    @endphp
				</td>
			</tr>
		</table>
        
		<div class="page-break"></div>
        
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>HIPAA Agreement Form</h2></th></tr>
			<tr>
				<td width="50%" valign="top"><strong>Child's Name:</strong><br />{{$adForm->hipaa_childsname}}</td>
				<td width="50%" valign="top"><strong>Parent's Name:</strong><br />{{$adForm->hipaa_parentsname}}</td>
			</tr>
            <tr>
				<td valign="top" colspan="2">
                	<h3>SOS is dedicated to maintaining the privacy of your individually identifiable health information (also called protected health information, or PHI). Below is our privacy policy:</h3>
                    <p><span>1.&nbsp;</span>SOS will not use or disclose your PHI for marketing or fundraising purposes; SOS will not sell your PHI to anyone for any reason.</p>
					<div class="clearfix"></div>
					<p><span>2.&nbsp;</span>SOS will only use your PHI in an appropriate manner for treatment.</p>
					<div class="clearfix"></div>
					<p><span>3.&nbsp;</span>SOS will only disclose PHI to the child&rsquo;s legal guardian. A legal guardian must give written authorization to allow us to share PHI with others.</p>
					<div class="clearfix"></div>
					<p><span>4.&nbsp;</span>SOS may disclose your PHI without your written permission when required By Law.  When disclosure is (a) required by federal, state, or local law judicial, board, or administrative proceedings; or, law enforcement; (b) compelled by a party to a proceeding before a court, arbitration panel or an administrative agency pursuant to its lawful authority; (c) required by a search warrant lawfully issued to a governmental law enforcement agency; or (d) compelled by the patient or the patient&rsquo;s representative pursuant to state or federal statutes or regulations, such as the Privacy Rule that requires this Notice.</p>
					<div class="clearfix"></div>
					<p><span>5.&nbsp;</span>SOS may disclose your PHI without your written permission for health oversight activities authorized by law including, investigations, inspections, audits, surveys, licensure and disciplinary actions; civil, administrative and criminal procedures or actions; or other activities necessary for the government to monitor government programs, compliance with civil rights laws and the health care system in general.</p>
					<div class="clearfix"></div>
					<p><span>6.&nbsp;</span>SOS may disclose your PHI without your written permission to avoid harm. When disclosure: (a) to law enforcement personnel or persons may be able to prevent or mitigate a serious threat to the health or safety of a person or the public; (b) is compelled or permitted by the fact that the Client is in such mental or emotional condition as to be dangerous to him or herself or the person or property of others, and if AST determines that disclosure is necessary to prevent the threatened danger; (c) is mandated by state child abuse and neglect reporting laws (for example, if we have a reasonable suspicion of child abuse or neglect); (d) is mandated by state elder/dependent abuse reporting law (for example, if we have a reasonable suspicion of elder abuse or dependent adult abuse); and (e) if disclosure is compelled or permitted by the fact that you or your child tells us of a serious/imminent threat of physical violence against a reasonably identifiable victim or victims.</p>
					<div class="clearfix"></div>
					<p><span>7.&nbsp;</span>SOS may disclose your PHI without your written permission  to company attorneys, accountants, consultants, and others to make sure that SOS is in compliance with applicable laws.</p>
					<div class="clearfix"></div>
					<p><span>8.&nbsp;</span>SOS may disclose your PHI without your written permission to your health insurance company to obtain benefit information, payment for treatment and services provided. </p>
					<div class="clearfix"></div>
					<p><span>9.&nbsp;</span>SOS may disclose your PHI without your written permission in the event of an emergency situation (such as a hospital visit).</p>
					<div class="clearfix"></div>
					<p><span>10.&nbsp;</span>SOS employees are not allowed to communicate by text message. The only HIPAA compliant methods of contact are phone calls, encrypted messaging, or person-to-person.</p>
					<div class="clearfix"></div>
					<p><span>11.&nbsp;</span>You have the right to access your PHI at anytime. SOS does not charge  fees to access your records.</p>
					<div class="clearfix"></div>
					<p><span>12.&nbsp;</span>You have the right to know who had access to your PHI within the last 6 years.</p>
					<div class="clearfix"></div>
					<p><span>13.&nbsp;</span>You have the right to limit our access to your health records.</p>
					<div class="clearfix"></div>
					<p><span>14.&nbsp;</span>You have the right to revoke access to your PHI that was previously given to us at any time.</p>
					<div class="clearfix"></div>
					<p><span>15.&nbsp;</span>SOS will notify you immediately if we become aware that an unauthorized person accessed your PHI.</p>
					<div class="clearfix"></div>
					<p><span>16.&nbsp;</span>You have the right to complain to the US Department of Health and Human Services if you feel that your rights have been violated.</p>
                    <div class="clearfix"></div>	
                </td>
			</tr>
            <tr>
				<td valign="top" colspan="2"><strong>SOS policy does not allow parents to take pictures/videos/audio of any clients during therapy hours:</strong><br /><br />{{$adForm->hipaa_sospolicy}}</td>
			</tr>
            <tr>
				<td valign="top" colspan="2"><strong>Inside our center, there are video cameras that record video/audio and display them in the parent viewing room. When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see your chilld or overhear their ongoing treatment. By signing this agreement, you give permission to SOS to capture and display images of your child:</strong><br /><br />{{$adForm->hipaa_insideourcenter}}</td>
			</tr>
            <tr>
				<td valign="top" colspan="2"><strong>When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see other clients or overhear their ongoing treatment. By signing this agreement, you agree to keep confidential all information obtained by your presence concerning other clients:</strong><br /><br />{{$adForm->hipaa_whenclients}}</td>
			</tr>
            <tr>
				<td valign="top" colspan="2">
                	<p class="text-center">We are required by law to maintain the confidentiality of health information that identifies clients.</p>
                	<p class="text-center">We also are required by law to provide this notice of our legal duties and the privacy practices that we maintain in our practice concerning our client&rsquo;s PHI.</p>
                </td>
			</tr>
            <tr>
				<td valign="top" colspan="2"><strong>I have read and understood Success On The Spectrum’s Privacy Policy.:</strong><br />
				@if($adForm->hipaa_whenclients)
					{{ 'Yes' }}
				@else
					{{ 'No' }}
				@endif
				</td>
			</tr>
            <tr>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->hipaa_date ) {{ date('m/d/Y',strtotime($adForm->hipaa_date)) }} @endif</td>
				<!--<td width="50%" valign="top"><strong>Signature:</strong><br />{{$adForm->hipaa_signature}}</td>-->
                <td width="50%" valign="top"><strong>Signature:</strong><br /><img src="{{$adForm->hipaa_signature}}" style="max-width:318px;"></td>
			</tr>
        </table>
        
		<div class="page-break"></div>
        
		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Payment Agreement</h2></th></tr>
			<tr>
				<td width="50%" valign="top"><strong>Child's Name:</strong><br />{{$adForm->payment_childsname}}</td>
				<td width="50%" valign="top"><strong>Parent's Name:</strong><br />{{$adForm->payment_parentsname}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<h3>AUTHORIZATION:</h3>
                    <p><span>&gt;&nbsp;</span>
					I authorize Success On The Spectrum to make medical reimbursement claims with my health insurance policy for services provided to my child.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Any pre-authorization obtained by Success On The Spectrum is not a guarantee of payment by my insurance.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>I understand and accept that I am ultimately financially responsible for all amounts not covered by my health insurance, including (but not limited to)  co-payments, deductible, co-insurance, and other fees.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Discounts for copays and deductible amounts are not allowed by law.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					I understand and agree that I am responsible for the payment of all charges incurred regardless of any insurance coverage or other plans available to me.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					I understand that Success On The Spectrum will bill me monthly for balances left unpaid by my health insurance. Invoices must be paid within 15 days of the date on the invoice. </p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					If any of my invoices remain unpaid for over 90 days, my child&rsquo;s services may be terminated.</p>
					<div class="clearfix"></div>
					<hr>
					<h3 class="head-pad">ADDITIONAL FEES: <label class="fees">(fees are subject to change)</label></h3>
					<p><span>&gt;&nbsp;</span>
					Annual registration fee (non-refundable)</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Late fee for every 15 days that invoice payments are late</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Fee for each returned check (such as NSF)</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Mileage fees ( for in-home and school shadowing services only)</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Nocall/noshow fee for unannounced cancellations</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Field trip fees</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Late pick-up fee for each 15 minutes after your scheduled session has ended</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Forgotten diaper fee</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Forgotten lunch fee if I do not supply my own to the center (parents will be called to give permission to SOS to supply food to the child)</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Replacement fees for SOS electronics when damaged by your child</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Processing fees for payments made online</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Any and all collections costs and/or attorney&rsquo;s fees if any delinquent balance is placed with an agency or attorney for collection, suit, or legal action. </p>
					<div class="clearfix"></div>
					<hr>
					<h3 class="head-pad">INVOICE DISPUTES:</h3>
					<p><span>&gt;&nbsp;</span>
					If I believe there is an error on my invoice, I must contact the billing department within 90 days of receipt of the relevant invoice in order to allow review and consideration.</p>
					<div class="clearfix"></div>
					<p><span>&gt;&nbsp;</span>
					Inquiries/Disputes regarding invoices over 90 days old will be deemed untimely and payment will be not be refunded.</p>
					<div class="clearfix"></div>	
                </td>
			</tr>
			<tr>
				<!--<td width="50%" valign="top"><strong>Parent's Signature:</strong><br />{{$adForm->payment_parentssignature}}</td>-->
                <td width="50%" valign="top"><strong>Parent's Signature:</strong><br /><img src="{{$adForm->payment_parentssignature}}" style="max-width:318px;"></td>
				<td width="50%" valign="top"><strong>Parent’s Social Security:</strong><br />{{$adForm->payment_parentssocialsecurity}}</td>
			</tr>
			<tr>
				<td width="50%" valign="top"><strong>Parent's Birthday:</strong><br />@if($adForm->payment_parentsbirthday ) {{ date('m/d/Y',strtotime($adForm->payment_parentsbirthday)) }} @endif</td>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->payment_parentsdate ) {{ date('m/d/Y',strtotime($adForm->payment_parentsdate)) }} @endif</td>
			</tr>
		</table>
        
        <div class="page-break"></div>

		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Informed Consent For Services</h2></th></tr>
			<tr>
				<td width="50%" valign="top"><strong>Child's Name:</strong><br />{{$adForm->informed_childsname}}</td>
				<td width="50%" valign="top"><strong>Parent's Name:</strong><br />{{$adForm->informed_parentsname}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<p>I hereby voluntarily apply for and consent to behavioral services by the staff of Success On The Spectrum, LLC. This consent applies to myself and the child named above. </p>
					<p>I understand that parental involvement and trainings are required. I understand that Success On Spectrum encourages both parents to attend the required meetings.</p>
					<p>I understand that my child&rsquo;s attendance is essential to the program and must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment.</p>
					<p>I understand that I may ask for a referral to another professional if I am not satisfied with the progress of my treatment. </p>
					<p>I understand that I have the right to refuse services at any time. I understand and agree that my continued participation implies voluntary informed consent. I also understand that Success On The Spectrum has the right to refuse services at any time.</p>
					<div class="clearfix"></div>	
                </td>
			</tr>
			<tr>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->informed_date ) {{ date('m/d/Y',strtotime($adForm->informed_date)) }} @endif</td>
				<!--<td width="50%" valign="top"><strong>Signature:</strong><br />{{$adForm->informed_signature}}</td>-->
                <td width="50%" valign="top"><strong>Signature:</strong><br /><img src="{{$adForm->informed_signature}}" style="max-width:318px;"></td>
			</tr>
		</table>
        
        <div class="page-break"></div>

		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Security System Waiver</h2></th></tr>
			<tr>
				<td width="50%" valign="top"><strong>Child's Name:</strong><br />{{$adForm->security_childsname}}</td>
				<td width="50%" valign="top"><strong>Parent's Name:</strong><br />{{$adForm->security_parentsname}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<p>SOS uses video/audio surveillance at every center. This feed is not broadcast on the internet and is  stored on a password protected hard drive within the center for approximately one month. These images/audio will not be used for marketing, advertising, or any public manner. These images/audio may be used for in-house (non-public) employee or parent training purposes. </p>
					<p>This hard drive typically  stores all recorded sessions for approximately one month before being written over. Parents may ask to view the video feed at any time. In the event of an unlikely negative incident, a copy of that session recording will be stored in the SOS Center for approximately 3 years.</p>
					<div class="clearfix"></div>	
                </td>
			</tr>
			<tr>
				<td valign="top" colspan="2"><strong>I grant Success On The Spectrum (SOS) non-revocable permission to capture and store my child’s image and audio in video surveillance, motion pictures, and recordings while in the SOS center:</strong><br /><br />{{$adForm->security_grantsuccess}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2"><strong>I acknowledge that SOS will own such images/audio and further grant SOS permission to store and use these images/audio. I further waive any right to inspect or approve the use of the image/audio by SOS prior to its use:</strong><br /><br />{{$adForm->security_acknowledge}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2"><strong>SOS policy does not allow parents to take pictures/videos/audio of any clients during therapy hours:</strong><br /><br />{{$adForm->security_sospolicy}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2"><strong>When clients/parents/visitors come into the center (or observe therapy outside of the center), it is possible that they see other clients or overhear their ongoing treatment. By signing this agreement, you agree to keep confidential all information obtained by your presence concerning other clients:</strong><br /><br />{{$adForm->security_whenclients}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<p>I forever release and hold the SOS harmless from any and all liability arising out of the use of the images/audio for training purposes, and waive any and all claims and causes of action relating to use of the images/audio, including without limitation, claims for invasion of privacy rights or publicity.</p>
					<div class="clearfix"></div>	
                </td>
			</tr>
			<tr>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->security_date ) {{ date('m/d/Y',strtotime($adForm->security_date)) }} @endif</td>
				<!--<td width="50%" valign="top"><strong>Signature:</strong><br />{{$adForm->security_signature}}</td>-->
                <td width="50%" valign="top"><strong>Signature:</strong><br /><img src="{{$adForm->security_signature}}" style="max-width:318px;"></td>
			</tr>
		</table>
        
        <div class="page-break"></div>

		<table class="main_tab_set" width="100%" >
			<tr><th><h2>Release Of Liability</h2></th></tr>
			<tr>
				<td width="50%"><strong>Child's Name:</strong><br />{{$adForm->release_childsname}}</td>
				<td width="50%"><strong>Parent's Name:</strong><br />{{$adForm->release_parentsname}}</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<h3>AUTHORIZATION</h3>
                    <p>Occasionally, Clients may bring personally owned devices (such as communication boards, iPads/tablets, iPods, specialized games, etc.) into the center. I understand that SOS is not responsible for any damage/loss/theft to my property.</p>
					<p>I understand that my child is never allowed to play with a SOS owned  iPad/tablet/electronics. I accept financial responsibility / liability for any damage done to SOS electronics by my child.</p>
					<hr>
					<h3>In-Home Therapy</h3>
					<p>Success On The Spectrum requires a parent/caregiver to be present during all in-home therapy at all times. SOS employees strive to avoid inappropriate situations. I understand that, if my child is not toilet-trained, I am responsible for changing diapers/wiping/bathing my child. I understand that I am personally responsible for cleaning messes made by my child during therapy sessions.
					<span class="release-text">I understand that Success On The Spectrum (SOS) employees may bring electronics, toys, books, or other equipment into my home for use during therapy sessions</span>.</p>
					<p>I understand that my child is not allowed to play with SOS owned property when sessions are not occurring. I understand that my child is never allowed to play with SOS owned tablets/electronics. I accept financial responsibility/liability for any damage done to SOS property by my child. I hereby release Success On The Spectrum from any liability/claims/demands related to any loss/damage/injury to any of my personally owned property that my child may cause during therapy sessions.</p>
					<div class="clearfix"></div>	
                </td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
                	<h3 class="text-center">I understand that I am financially responsible for damage caused by my child to SOS property or a SOS employee&rsquo;s property.</h3>
                	<h3 class="text-center">I understand that SOS is not responsible for any damage done by my child to my property.</h3>
                </td>
            </tr>    
			<tr>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->release_date ) {{ date('m/d/Y',strtotime($adForm->release_date)) }} @endif</td>
				<!--<td width="50%" valign="top"><strong>Signature:</strong><br />{{$adForm->release_signature}}</td>-->
                <td width="50%" valign="top"><strong>Signature:</strong><br /><img src="{{$adForm->release_signature}}" style="max-width:318px;"></td>
			</tr>
		</table>
        
        <div class="page-break"></div>	

		<table class="main_tab_set" width="100%">
			<tr><th><h2>Parent Handbook Agreement</h2></th></tr>
			<tr>
				<td width="50%" valign="top"><strong>Child's Name:</strong><br />{{$adForm->parent_childsname}}</td>
				<td width="50%" valign="top"><strong>Parent's Name:</strong><br />{{$adForm->parent_parentsname}}</td>
			</tr>
        	<tr>
                <td valign="top" width="50%">
                	<h3>IN-CENTER THERAPY SESSIONS</h3>
                    <h4>BEFORE YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Children should be dressed and fed prior to drop off at our center  (unless these skills are being addressed in the program)</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>SOS is not liable for children outside of the checked-in hours. Parents are responsible for children in the parking lot or anywhere outside of the SOS center.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Due to safety reasons, SOS does not provide any meals or snacks for the children. All students are expected to pack a lunch and re-usable water bottle. All SOS centers are nut free facilities. Parents are responsible for notifying the facility, in writing, of any allergies or other medical conditions upon enrollment or as the parents become aware of them.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Clients enrolled in SOS are not required to be toilet-trained, but parents are required to send in the appropriate diapering and/or toileting supplies that their child may need in their backpack. This includes diapers, wipes, creams, changes of clothing, and gloves to allow our staff of minimum of 3 changes per day.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Parents are responsible for supplying the child&rsquo;s medications, and must complete the medical administration form.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Children do not learn when they are unhappy, bored or stressed. It is our job to motivate your child to learn! Let us know what rewards your child is likely to enjoy. We request parents provide an assortment of their child&rsquo;s favorite items.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Animals/pets are not permitted in therapy areas or hallways without approval.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Attendance must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment. Extended vacations are not allowed, as it disrupts the progress of therapy.</p>
                    <div class="clearfix"></div>
                    <hr>
                </td>
                <td valign="top" width="50%">
                	<h3>IN-HOME THERAPY SESSIONS</h3>
                    <h4>BEFORE YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Children should be dressed and fed prior to the session  (unless these skills are being addressed in the program).</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Prepare an area in your home to be used for therapy. It must be a comfortable temperature, well lit, and relatively free of distractions.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Children do not learn when they are unhappy, bored or stressed. It is our job to motivate your child to learn! Let us know what rewards your child is likely to enjoy. We request parents provide an assortment of their child&rsquo;s favorite items.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>A parent or responsible adult must be present at all times during therapy sessions. SOS employees are not allowed to change diapers, undress, or bathe a child.  If needed, parents will also be the one to administer any first aid to your child.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>If a therapists arrives at your home and you are not present, they will wait 30 min before leaving. You will be charged a $50 noshow fee and applicable mileage fees.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Attendance must be maintained at a level of 85% of scheduled sessions each month, and over the duration of enrollment. Extended vacations are not allowed, as it disrupts the progress of therapy.</p>
                    <div class="clearfix"></div>
                    <hr>
                </td>
            </tr>
            <tr>
                <td valign="top" width="50%">
                	<h4>DURING YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Parent must complete the sign-in form at the beginning of each  session. Parents are responsible for ensuring accuracy of hours.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Therapists may use the first and last 15 minutes of the session for set-up and clean up.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Occasionally, clients may bring personally owned devices (such as communication boards, iPads, iPods, specialized games, etc.) into the center. Before any client-owned equipment/devices are brought on-site, a release of liability form must be completed by the parent. Parents are financially responsible for damage caused by your child to SOS property or a SOS employee’s property. SOS is not responsible for any damage done by your child to your property.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>You are welcome to view your child&rsquo;s session on our video security system from our Viewing Room. All non-client minors in our center (such as siblings) must be accompanied by an adult at all times.</p>
                    <div class="clearfix"></div>
                    <hr>
                </td>
                <td valign="top" width="50%">
                	<h4>DURING YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Parent must complete the sign-in form at the beginning of each  session. Parents are responsible for ensuring accuracy of hours.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Therapists may use the first and last 15 minutes of the session for set-up and clean up.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>SOS Therapists are not obligated to work with siblings. If a therapist feels a sibling can be used as a participant in a session, it is at their discretion.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Parents are financially responsible for damage caused by your child to SOS property or a SOS employee&rsquo;s property. SOS is not responsible for any damage done by your child to your property.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>If your child needs to be transported, it will be the responsibility of the parent or guardian to do this. SOS employees are not allowed to take a child in their automobile at any time.</p>
                    <div class="clearfix"></div>
                    <hr>	
                </td>
            </tr>
            <tr>
                <td valign="top" width="50%">
                	<h4>AFTER YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Parent must complete the sign-out form at the end of each session.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>SOS will charge a late pick-up fee for each 15 minutes after your scheduled session has ended.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Prior to  someone other than a parent picking up a child from our center, parents must fill out a form to authorize them to do so. SOS reserves the right to ask for their ID.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Parents will receive a Daily Report about the progress made within the session.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>SOS requires parents to participate in Caregiver Training. Parents will be given &ldquo;homework assignments&rdquo; and will be frequently contacted about these assignments.</p>
                    <div class="clearfix"></div>
                </td>
                <td valign="top" width="50%">
                	<h4>AFTER YOUR SESSION</h4>
                    <p><span>&gt;&nbsp;</span>Parent must complete the sign-out form at the end of each  session.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Parents will receive a Daily Report about the progress made within the session.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>Do not allow your child to play with SOS therapy materials and reinforcers outside of therapy time.</p>
                    <div class="clearfix"></div>
                    <p><span>&gt;&nbsp;</span>SOS requires parents to participate in Caregiver Training. Parents will be given &ldquo;homework assignments&rdquo; and will be frequently contacted about these assignments.</p>
                    <div class="clearfix"></div>	
                </td>
            </tr>    
			<tr>
				<td width="50%" valign="top"><strong>Date:</strong><br />@if($adForm->parent_date ) {{ date('m/d/Y',strtotime($adForm->parent_date)) }} @endif</td>
				<!--<td width="50%" valign="top"><strong>Signature:</strong><br />{{$adForm->parent_signature}}</td>-->
                <td width="50%" valign="top"><strong>Signature:</strong><br /><img src="{{$adForm->parent_signature}}" style="max-width:318px;"></td>
			</tr>
		</table>	

		<div class="no-break"></div>

    </body>
</html>
