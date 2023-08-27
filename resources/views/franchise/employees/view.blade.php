@extends('franchise.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<!--<h6>{{ $Employee->fullname }}</h6>-->
            <h6>{{ $Employee->personal_name }}</h6>

			<!--<p>Employee / {{ $Employee->fullname }} / <span id="change-bread-crumb">Employees Demographic</span></p>-->
            <p>Employee / {{ $Employee->personal_name }} / <span id="change-bread-crumb">Employees Demographic</span></p>

		</div>
		<div class="add-franchise-butn-main">
			<a href="{{ url('franchise/employee/addperformance/'.$Employee->id) }}" class="btn dis-none-3"><i class="fa fa-plus" aria-hidden="true"></i>Add Performance Log</a>
		</div>
		<div class="add-franchise-butn-main">
			<a href="{{ url('franchise/employee/addtasklist/'.$Employee->id) }}" class="btn dis-none-5"><i class="fa fa-plus" aria-hidden="true"></i>Add Task List</a>
		</div>
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('franchise.employees.employeeTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			<ul class="nav nav-tabs EmployeeNavTabs">
			  <li class="padd-left-anchor @if(!Request::has('performance_log') && Request::get('tab') != 'performance_log' &&  !Request::has('trip_itenary') && !Request::get('tab') == 'trip_itenary' && !Request::get('tab') == 'tasklist' && !Request::get('tab') == 'timepunches')) active @endif">
			  <a data-toggle="tab" href="#">Employee Demographic</a></li>
			  <li class="trigger-5 "><a href="{{ url('franchise/employee/viewtasklist/'.$Employee->id) }}" onclick="TasksList()">Task List</a></li>
			  <li class="trigger  "><a href="{{ url('franchise/employee/viewtripitinerary/'.$Employee->id) }}" onclick="TripItenary()">Trip Itinerary</a></li>
			  <li class="trigger "><a href="{{ url('franchise/employee/viewtimepunches/'.$Employee->id) }}" onclick="TimePunches()">Time Punches</a></li>
			  <li class="trigger-1 "><a href="{{ url('franchise/employee/viewperformancelog/'.$Employee->id) }}" onclick="PerformanceLog()">Performance Log</a></li>
			</ul>

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Employee's Demographic</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/employee/edit/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            <figure><h5>Status</h5>
				    		<h4 class="green-clr" @if($Employee->personal_status == 'Terminated') style="color: #fc6666 !important;" @endif>{{ $Employee->personal_status }}</h4>
				    		</figure>
				    		<figure><h5>Employee Name</h5>						@if($Employee->personal_name) 	<h4>{{ $Employee->personal_name }}</h4> @endif</figure>
                            <figure><h5>Employee DOB</h5>						@if($Employee->personal_dob) <h4>{{ date('jS M Y',strtotime($Employee->personal_dob)) }}</h4> @endif</figure>
				    		<figure><h5>Employee Address</h5>					@if($Employee->personal_address) <h4>{{ $Employee->personal_address }}, {{ $Employee->personal_city }}, {{ $Employee->personal_state }}, {{ $Employee->personal_zipcode }}</h4> @endif</figure>
                            <figure><h5>Employee SS#</h5>						@if($Employee->personal_ss) <h4>{{ $Employee->personal_ss }}</h4> @endif</figure>
				    		<figure><h5>Employee Email</h5>						@if($Employee->personal_email) <h4>{{ $Employee->personal_email }}</h4> @endif</figure>
                            <figure><h5>Employee Phone</h5>						@if($Employee->personal_phone) <h4>{{ $Employee->personal_phone }}</h4> @endif</figure>
                            <figure><h5>Crew Type</h5>							@if($Employee->crew_type) <h4>{{ $Employee->crew_type }}</h4> @endif</figure>
                            <figure><h5>Authorize To Work in The US</h5>		@if($Employee->work_authorised) <h4>{{ $Employee->work_authorised }}</h4> @endif</figure>
                            
                            <figure><h5>Capable Of Performing The Essential Functions Of The Job Which You Are Applying Without Any Accommodations?</h5>@if($Employee->work_capable) <h4>{{ $Employee->work_capable }}</h4> @endif</figure>
                            @if($Employee->work_capable == 'No')
                            <figure><h5>If No, What Accommodations Do You Need?</h5><h4>{{ $Employee->work_nocapable }}</h4></figure>
                            @endif
                            <figure><h5>Are you able to lift 30 to 40 lbs? Able to do physical activities?</h5>@if($Employee->work_liftlbs) <h4>{{ $Employee->work_liftlbs }}</h4> @endif</figure>
                            <figure><h5>Employment Type</h5>					@if($Employee->career_desired_schedule) <h4>{{ $Employee->career_desired_schedule }}</h4> @endif</figure>
                            <figure><h5>Desired Position</h5>					@if($Employee->career_desired_position) <h4>{{ str_replace(',',', ',$Employee->career_desired_position) }}</h4> @endif</figure>
                            <figure><h5>Assigned Position</h5>					@if($Employee->assigned_position) <h4>{{ $Employee->assigned_position }}</h4> @endif</figure>
				    		<figure><h5>Hiring Date</h5>						@if($Employee->career_earliest_startdate) <h4>{{ date('jS M Y',strtotime($Employee->career_earliest_startdate)) }}</h4> @endif</figure>
				    		<figure><h5>90 Days Probation Completion Date</h5>	@if($Employee->career_probation_completion_date) <h4>{{ date('jS M Y',strtotime($Employee->career_probation_completion_date)) }}</h4> @endif</figure>
				    		<figure><h5>Highest Degree Held</h5>				@if($Employee->career_highest_degree) <h4>{{ $Employee->career_highest_degree }}</h4> @endif</figure>
                            <figure><h5>Desired Location</h5>					@if($Employee->career_desired_location) <h4>{{ $Employee->career_desired_location }}</h4> @endif</figure>
                            <figure><h5>Are you Registered by the BACB?</h5>	@if($Employee->career_bacb) <h4>{{ $Employee->career_bacb }}</h4> @endif</figure>
                            @if($Employee->career_bacb == 'Yes')
                            <figure><h5>BACB Registration Date</h5>				@if($Employee->bacb_regist_date) <h4>{{ date('jS M Y',strtotime($Employee->bacb_regist_date)) }}</h4> @endif</figure>
                            @endif
                            <figure><h5>Are You CPR Certified?</h5>				@if($Employee->career_cpr_certified) <h4>{{ $Employee->career_cpr_certified }}</h4> @endif</figure>
                            @if($Employee->career_cpr_certified == 'Yes')
                            <figure><h5>CPR Registration Date</h5>				@if($Employee->cpr_regist_date) <h4>{{ date('jS M Y',strtotime($Employee->cpr_regist_date)) }}</h4> @endif</figure>
                            @endif
				    		
				    		<div class="padd-view"></div>
				    	</div>
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Emergency Contacts</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/employee/addrelation/'.$Employee->id) }}" class="btn add-franchise-data-butn-1 butn-spacing-padd"><i class="fa fa-user-o" aria-hidden="true"></i>Add Contact</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<div class="blue-border-box-main">
				    			
				    			@if( !$Employee->employee_emergency_contact->isEmpty() )
				    				@php $count = 1; @endphp
					    			@foreach($Employee->employee_emergency_contact as $e_contact)
						    			<div class="blue-border-box blue-border-box-3 emergency_box">
							    			<a href="{{ url('franchise/employee/editrelation/'.$e_contact->admin_employee_id.'/'.$e_contact->id) }}" class="owner_edit"><i class="fa fa-pencil"></i></a>
							    			<a href="javascript:;" data-contact_id="{{ $e_contact->id }}" data-employee_id="{{ $e_contact->admin_employee_id }}" class="owner_delete"><i class="fa fa-trash"></i></a>
							    			<figure><h5>Relationship {{ $count }}</h5><h4>{{ $e_contact->relationship }}</h4></figure>
							    			<figure><h5>Full Name</h5><h4>{{ $e_contact->fullname }}</h4></figure>
							    			<figure><h5>Phone Number</h5><h4>{{ $e_contact->phone_number }}</h4></figure>
							    			<figure class="border-bot-0"><h5>Email Address</h5><h4>{{ substr($e_contact->email, 0, 20) .((strlen($e_contact->email) > 20) ? '...' : '') }}</h4></figure>
							    			
							    		</div>
							    	@php $count++; @endphp	
						    		@endforeach
					    		@endif
					    		<div class="clearfix"></div>
				    		</div>
				    		<div class="padd-view-1"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Certifications</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/employee/addcertification/'.$Employee->id) }}" class="btn add-franchise-data-butn-1 butn-spacing-padd"><i class="fa fa-user-o" aria-hidden="true"></i>Add Certification</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<div class="blue-border-box-main">
				    			
				    			@if( !$Employee->employee_certifications->isEmpty() )
				    				@php $count = 1; @endphp
					    			@foreach($Employee->employee_certifications as $e_certification)
						    			<div class="blue-border-box blue-border-box-3 certification_box">
							    			<a href="{{ url('franchise/employee/editcertification/'.$e_certification->admin_employee_id.'/'.$e_certification->id) }}" class="certification_edit"><i class="fa fa-pencil"></i></a>
							    			<a href="javascript:;" data-certification_id="{{ $e_certification->id }}" data-employee_id="{{ $e_certification->admin_employee_id }}" class="certification_delete"><i class="fa fa-trash"></i></a>
							    			<figure><h5>Certification Name <!--{{ $count }}--></h5><h4>{{ $e_certification->certification_name }}</h4></figure>
							    			<figure class="border-bot-0"><h5>Expiration Date</h5><h4>{{ date('jS M Y',strtotime($e_certification->expiration_date)) }}</h4></figure>
							    			
							    		</div>
							    	@php $count++; @endphp	
						    		@endforeach
					    		@endif
					    		<div class="clearfix"></div>
				    		</div>
				    		<div class="padd-view-1"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Login Credentials</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/employee/addcredential/'.$Employee->id) }}" class="btn add-franchise-data-butn-1 butn-spacing-padd"><i class="fa fa-user-o" aria-hidden="true"></i>Add Credential</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<div class="blue-border-box-main">
				    			
				    			@if( !$Employee->employee_login_credentials->isEmpty() )
				    				@php $count = 1; @endphp
					    			@foreach($Employee->employee_login_credentials as $e_credential)
						    			<div class="blue-border-box blue-border-box-3 credential_box">
							    			<a href="{{ url('franchise/employee/editcredential/'.$e_credential->admin_employee_id.'/'.$e_credential->id) }}" class="credential_edit"><i class="fa fa-pencil"></i></a>
							    			<a href="javascript:;" data-credential_id="{{ $e_credential->id }}" data-employee_id="{{ $e_credential->admin_employee_id }}" class="credential_delete"><i class="fa fa-trash"></i></a>
							    			<figure><h5>App Name <!--{{ $count }}--></h5><h4>{{ $e_credential->app_name }}</h4></figure>
							    			<figure><h5>URL</h5><h4>{{ $e_credential->url }}</h4></figure>
							    			<figure><h5>Username</h5><h4>{{ $e_credential->username }}</h4></figure>
							    			<figure class="border-bot-0"><h5>Password</h5><h4>{{ $e_credential->password }}</h4></figure>
							    			
							    		</div>
							    	@php $count++; @endphp	
						    		@endforeach
					    		@endif
					    		<div class="clearfix"></div>
				    		</div>
				    		<div class="padd-view-1"></div>
				    	</div>
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Benefit Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/employee/editbenifits/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Detail</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content view-tab-content-1">
                            <figure><h5>Desired Pay</h5> 									@if($Employee->career_desired_pay) <h4>${{ $Employee->career_desired_pay }}/yr</h4> @endif</figure>
                            <figure><h5>Starting Pay Rate</h5> 								@if($Employee->career_starting_pay) <h4>${{ $Employee->career_starting_pay }}/yr</h4> @endif</figure>
				    		<figure><h5>Current Pay Rate</h5> 								@if($Employee->career_current_pay) <h4>${{ $Employee->career_current_pay }}/yr</h4> @endif</figure>
				    		<figure><h5>Enrolled in Company's Health Insurance Plan</h5>	@if($Employee->career_insurance_plan)<h4>{{ $Employee->career_insurance_plan }}</h4> @endif</figure>
				    		<figure><h5>Enrolled in Company Retirement Plan</h5> 			@if($Employee->career_retirement_plan) <h4>{{ $Employee->career_retirement_plan }}</h4> @endif</figure>
				    		<figure><h5>Paid Vacations Per Year</h5> 						@if($Employee->career_paid_vacation) <h4>{{ $Employee->career_paid_vacation }} Days</h4> @endif</figure>
				    		<figure><h5>Paid Holidays Per Year</h5> 						@if($Employee->career_paid_holiday) <h4>{{ $Employee->career_paid_holiday }} Days</h4> @endif</figure>
				    		<figure class="border-bot-0"><h5>Allowed Unexcused Sick Leaves</h5> @if($Employee->career_allowed_sick_leaves) <h4>{{ $Employee->career_allowed_sick_leaves }} Days</h4>@endif</figure>
				    		<div class="padd-view-1"></div>
				    	</div>
				    </div>
				</div>

			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>


	
<div class="delete-popup-main">
  <div class="modal fade" id="myModal-22" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Emergency Contact?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this contact ? This action cannot be undo</p>
          <input class="btn popup-delete-butn" type="button" value="Delete Contact">
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="delete-popup-main">
  <div class="modal fade" id="myModal-Certification" role="dialog">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Certification?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this certification ? This action cannot be undo</p>
          <input class="btn popup-certification-delete-butn" type="button" value="Delete Certification">
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="delete-popup-main">
  <div class="modal fade" id="myModal-Credential" role="dialog">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Credential?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this credential ? This action cannot be undo</p>
          <input class="btn popup-credential-delete-butn" type="button" value="Delete Credential">
        </div>
      </div>
      
    </div>
  </div>
</div>
	
<script type="text/javascript">
	$('document').ready(function(){
		
		//code for delete contact
		var employee_id = '';
		var contact_id = '';
		$('.owner_delete').click(function(){
			employee_id 	= $(this).data('employee_id');
			contact_id 		= $(this).data('contact_id');
			$('#myModal-22').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/employee/deletecontact") }}'+'/'+employee_id+'/'+contact_id;
		});
		
		//code for delete certification
		var employee_id = '';
		var certification_id = '';
		$('.certification_delete').click(function(){
			employee_id 	= $(this).data('employee_id');
			certification_id 		= $(this).data('certification_id');
			$('#myModal-Certification').modal('show');
		});
		
		$('.popup-certification-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/employee/deletecertification") }}'+'/'+employee_id+'/'+certification_id;
		});
		
		//code for delete credential
		var employee_id = '';
		var credential_id = '';
		$('.credential_delete').click(function(){
			employee_id 	= $(this).data('employee_id');
			credential_id 		= $(this).data('credential_id');
			$('#myModal-Credential').modal('show');
		});
		
		$('.popup-credential-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/employee/deletecredential") }}'+'/'+employee_id+'/'+credential_id;
		});
		
		//Print Report of time punches
	});
</script>


@endsection
