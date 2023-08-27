@extends('admin.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<h6>{{ $Employee->fullname }}</h6>
			<p><a href="{{ url('admin/employees') }}">Employee</a> / <a href="{{ url('admin/employee/view/') }}/{{ $Employee->id }}">{{ $Employee->fullname }} </a> / Employee Demographic</p>
		</div>
		<div class="add-franchise-butn-main">
			<a href="{{ url('admin/employee/addperformance/'.$Employee->id) }}" class="btn dis-none-3"><i class="fa fa-plus" aria-hidden="true"></i>Add Performance Log</a>
		</div>
		<div class="add-franchise-butn-main">
			<a href="{{ url('admin/employee/addtasklist/'.$Employee->id) }}" class="btn dis-none-5"><i class="fa fa-plus" aria-hidden="true"></i>Add Task List</a>
		</div>
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('admin.employees.employeeTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			<ul class="nav nav-tabs EmployeeNavTabs">
			  <li class="padd-left-anchor @if(!Request::has('performance_log') && Request::get('tab') != 'performance_log' &&  !Request::has('trip_itenary') && !Request::get('tab') == 'trip_itenary' && !Request::get('tab') == 'tasklist' && !Request::get('tab') == 'timepunches')) active @endif">
			  <a data-toggle="tab" href="#">Employee Demographic</a></li>
			  <li class="trigger-5 "><a href="{{ url('admin/employee/viewtasklist/'.$Employee->id) }}" onclick="TasksList()">Task List</a></li>
			  <!--<li class="trigger  "><a href="{{ url('admin/employee/viewtripitinerary/'.$Employee->id) }}" onclick="TripItenary()">Trip Itinerary</a></li>
			  <li class="trigger "><a href="{{ url('admin/employee/viewtimepunches/'.$Employee->id) }}" onclick="TimePunches()">Time Punches</a></li>-->
			  <li class="trigger-1 "><a href="{{ url('admin/employee/viewperformancelog/'.$Employee->id) }}" onclick="PerformanceLog()">Performance Log</a></li>
			</ul>

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Employee's Demographic</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('admin/employee/edit/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<figure><h5>Status</h5>
				    		<h4 class="green-clr" @if($Employee->employee_status != 1) style="color: #fc6666 !important;" @endif>
				    		@if($Employee->employee_status == 1)
				    			Active
				    		@else
				    			Inactive	
				    		@endif	
				    		</h4>
				    		</figure>
				    		<figure><h5>Employee Name</h5><h4>{{ $Employee->fullname }}</h4></figure>
				    		<figure><h5>Employee Title</h5><h4>{{ $Employee->employee_title }}</h4></figure>
				    		<figure><h5>Employee Address</h5><h4>{{ $Employee->employee_address }}</h4></figure>
				    		<?php /*?><figure><h5>Hiring Date</h5><h4>{{ date('jS M Y',strtotime($Employee->hiring_date)) }}</h4></figure><?php */?>
                            <figure><h5>Hiring Date</h5><h4>{{ date('m/d/Y',strtotime($Employee->hiring_date)) }}</h4></figure>
				    		<figure><h5>Employee Type</h5><h4>{{ $Employee->employee_type }}</h4></figure>
				    		<?php /*?><figure><h5>Employee DOB</h5><h4>{{ date('jS M Y',strtotime($Employee->employee_dob)) }}</h4></figure><?php */?>
                            <figure><h5>Employee DOB</h5><h4>{{ date('m/d/Y',strtotime($Employee->employee_dob)) }}</h4></figure>
				    		<?php /*?><figure><h5>90 Days Probation Completion Date</h5><h4>{{ date('jS M Y',strtotime($Employee->ninty_days_probation_completion_date)) }}</h4></figure><?php */?>
                            <figure><h5><!--90 Days Probation Completion Date-->60 Days Probation Completion Date</h5><h4>{{ date('m/d/Y',strtotime($Employee->ninty_days_probation_completion_date)) }}</h4></figure>
				    		<figure><h5>Highest Degree Held</h5><h4>{{ $Employee->highest_degree_held }}</h4></figure>
				    		<figure><h5>Employee SS#</h5><h4>{{ $Employee->employee_ss }}</h4></figure>
				    		<figure><h5>Employee Email</h5><h4>{{ $Employee->email }}</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Emergency Contacts</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('admin/employee/addrelation/'.$Employee->id) }}" class="btn add-franchise-data-butn-1 butn-spacing-padd"><i class="fa fa-user-o" aria-hidden="true"></i>Add Contact</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<div class="blue-border-box-main">
				    			
				    			@if( !$Employee->employee_emergency_contact->isEmpty() )
				    				@php $count = 1; @endphp
					    			@foreach($Employee->employee_emergency_contact as $e_contact)
						    			<div class="blue-border-box blue-border-box-3 emergency_box">
							    			<a href="{{ url('admin/employee/editrelation/'.$e_contact->admin_employee_id.'/'.$e_contact->id) }}" class="owner_edit"><i class="fa fa-pencil"></i></a>
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
				    			<h3>Benefit Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('admin/employee/editbenifits/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Detail</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content view-tab-content-1">
				    		<figure><h5>Starting Pay Rate</h5><h4>@if($Employee->starting_pay_rate) ${{ $Employee->starting_pay_rate }}<!--/yr--> @endif</h4></figure>
				    		<figure><h5>Current Pay Rate</h5><h4>@if($Employee->current_pay_rate) ${{ $Employee->current_pay_rate }}<!--/yr--> @endif</h4></figure>
				    		<figure><h5>Enrolled in Company's Health Insurance Plan</h5><h4>@if($Employee->starting_pay_rate) {{ $Employee->insurance_plan }} @endif</h4></figure>
				    		<figure><h5>Enrolled in Company Retirement Plan</h5><h4>{{ $Employee->retirement_plan }}</h4></figure>
				    		<figure><h5>Paid Vacations Per Year</h5><h4>@if($Employee->starting_pay_rate) {{ $Employee->paid_vacation }} Days @endif</h4></figure>
				    		<figure><h5>Paid Holidays Per Year</h5><h4>@if($Employee->starting_pay_rate) {{ $Employee->paid_holiday }} Days </h4>@endif</figure>
				    		<figure class="border-bot-0"><h5>Allowed Unexcused Sick Leaves</h5><h4>@if($Employee->starting_pay_rate) {{ $Employee->allowed_sick_leaves }} Days @endif</h4></figure>
				    		<div class="padd-view-1"></div>
				    	</div>
				    	
				    	
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Performance Reviews</h3>
				    		</div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="alert alert-success hidden franchise-audit-response" style="line-height: initial;">Audit Conducted Successfully</div>
        					<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	<div class="super-admin-table-1 table-responsive">
                                <table class="table-striped FranchiseesListTableWidth FranchiseAudit">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Review Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
    								<tbody>
    								@if(!$p_reviews->isEmpty())
    								@php $count= 1; @endphp
    								@foreach($p_reviews as $p_review)

                                        @php
                                            $class = '';
                                            $class_highlight = "";
                                            $current_year = date("Y");
                                            
                                            if($p_review->created_at < $Employee->upcomming_performance && $p_review->status == 'Pending')
                                            {
                                            	$class_highlight = 'pending';
                                            	$class = 'red-clr';
                                            }
                                        @endphp

                                        <tr class="{{ $class_highlight }}" id="franchise-review-row{{ $p_review->id }}">
                                            <td class="{{ $class }}" width="50%">Performance Review {{ $count }}</td>
                                            <td class="{{ $class }}" width="30%">
                                            	{{ date('d/m/Y', strtotime($Employee->upcomming_performance)) }}
                                            </td>
                                            <td class="{{ $class }}" width="20%">
                                                <span class="pos-rel">
                                                    <select name="review_status{{ $p_review->id }}" id="review_status{{ $p_review->id }}" class="review_status" data-id="{{ $p_review->id }}">
                                                      <option value="">Status</option>
                                                      <option @if($p_review->status == 'Pending') selected="" @endif>Pending</option>
                                                      <option @if($p_review->status == 'Completed') selected="" @endif>Completed</option>
                                                    </select>
                                                </span>
                                            </td>
                                        </tr>
                                        
                                    @php $count++; @endphp    
                                    @endforeach
                                    
                                    @else
                                    	<tr><td colspan="3">No Performance Rewiew Found.</td></tr>
                                    @endif  
                                    </tbody>
                                </table>
                            </div>
				    		<div class="padd-view"></div>
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
			window.location.href = '{{ url("admin/employee/deletecontact") }}'+'/'+employee_id+'/'+contact_id;
		});
		
		//Print Report of time punches

		//Update Franchise Audit
		$('.review_status').change(function(){
			var status = $(this).val();
			var id = $(this).data('id');
			$.ajax({
				url:'{{ url("admin/employee/updatereview") }}',
				type:'POST',
				dataType:'json',
				data:{id: id, status: status, employee_id: '{{ $Employee->id }}', '_token':'{{ csrf_token() }}'},
				beforeSend: function( xhr ) {
					$(".franchise-audit-response").addClass('hidden');
				},
				success:function(response){
					console.log(response);
					if(typeof(response) == 'object'){
						if('success' in response){
							$(".franchise-audit-response").fadeIn();
							$(".franchise-audit-response").removeClass('hidden');
							$(".franchise-audit-response").fadeOut(2000);
							$("#franchise-audit-row"+id).removeAttr('class').addClass(status.toLowerCase());
							if(status.toLowerCase() == "pending")
							$("#franchise-audit-row"+id).find('td').removeClass('green-clr').addClass('red-clr');
							else
							$("#franchise-audit-row"+id).find('td').removeClass('red-clr').addClass('green-clr');
						}
					}
				},
			});
		});

	});
</script>


@endsection
