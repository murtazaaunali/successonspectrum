@extends('admin.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<h6>{{ $Employee->fullname }}</h6>

			<p>Employee / {{ $Employee->fullname }} / <span id="change-bread-crumb">Employees Demographic</span></p>

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
			<ul class="nav nav-tabs">
			  <li class="padd-left-anchor @if(!Request::has('performance_log') && Request::get('tab') != 'performance_log' &&  !Request::has('trip_itenary') && !Request::get('tab') == 'trip_itenary' && !Request::get('tab') == 'tasklist' && !Request::get('tab') == 'timepunches')) active @endif">
			  <a data-toggle="tab" onclick="EmployeesDemographic()" href="#franchise-demography">Employee Demographic</a></li>
			  <li class="trigger-5 @if(Request::get('tab') == 'tasklist') active @endif "><a href="{{ url('admin/employee/viewtasklist/'.$Employee->id) }}" onclick="TasksList()">Task List</a></li>
			  <li class="trigger  @if(Request::has('trip_itenary') || Request::get('tab') == 'trip_itenary' ) active @endif"><a data-toggle="tab" href="#trip-itenary" onclick="TripItenary()">Trip Itinerary</a></li>
			  <li class="trigger @if( Request::get('tab') == 'timepunches') active @endif task-btn"><a data-toggle="tab" href="#time-punches" onclick="TimePunches()">Time Punches</a></li>
			  <li class="trigger-1 @if(Request::has('performance_log') || Request::get('tab') == 'performance_log') active @endif"><a data-toggle="tab" href="#performance-log" onclick="PerformanceLog()">Performance Log</a></li>
			</ul>

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in @if(!Request::has('performance_log') && Request::get('tab') != 'performance_log' && !Request::has('searchPerformance') && !Request::has('trip_itenary') && Request::get('tab') != 'trip_itenary' && Request::get('tab') != 'tasklist' && Request::get('tab') != 'timepunches') active @endif">
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
				    		<h4 class="green-clr">
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
				    		<figure><h5>Hiring Date</h5><h4>{{ date('jS M Y',strtotime($Employee->hiring_date)) }}</h4></figure>
				    		<figure><h5>Employee Type</h5><h4>{{ $Employee->employee_type }}</h4></figure>
				    		<figure><h5>Employee DOB</h5><h4>{{ date('jS M Y',strtotime($Employee->employee_dob)) }}</h4></figure>
				    		<figure><h5>90 Days Probation Completion Date</h5><h4>{{ date('jS M Y',strtotime($Employee->ninty_days_probation_completion_date)) }}</h4></figure>
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
				    			<a href="{{ url('admin/employee/addrelation/'.$Employee->id) }}" class="btn add-franchise-data-butn-1 butn-spacing-padd"><i class="fa fa-user-o" aria-hidden="true"></i>Add Relations</a>
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
							    			<figure class="border-bot-0"><h5>Email Address</h5><h4>{{ $e_contact->email }}</h4></figure>
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
				    		<figure><h5>Starting Pay Rate</h5><h4>${{ $Employee->starting_pay_rate }}/yr</h4></figure>
				    		<figure><h5>Current Pay Rate</h5><h4>${{ $Employee->current_pay_rate }}/yr</h4></figure>
				    		<figure><h5>Enrolled in company,s Health Insurance Plan</h5><h4>{{ $Employee->insurance_plan }}</h4></figure>
				    		<figure><h5>Enrolled in Company Retirement Plan</h5><h4>{{ $Employee->retirement_plan }}</h4></figure>
				    		<figure><h5>Paid Vacations Per Year</h5><h4>{{ $Employee->paid_vacation }} Days</h4></figure>
				    		<figure><h5>Paid Holidays Per Year</h5><h4>{{ $Employee->paid_holiday }} Days</h4></figure>
				    		<figure class="border-bot-0"><h5>Allowed Unexcussed Sick Leaves</h5><h4>{{ $Employee->allowed_sick_leaves }} Days</h4></figure>
				    		<div class="padd-view-1"></div>
				    	</div>
				    </div>
				</div>
				<div id="task-list" class="tab-pane fade @if(Request::get('tab') == 'tasklist') in active @endif">
					<div class="view-tab-content-head-main">
					    		<div class="view-tab-content-head">
					    			<h3>{{ $Employee->fullname }}'s Task List</h3>
					    		</div>
					    		<div class="view-tab-content-butn">
					    			<a href="{{ url('admin/employee/edittasklist/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Eidt Details</a>
					    		</div>
					    		<div class="clearfix"></div>
					    	</div>
				    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table view-employee-tabs-task-list-lines">
				    	<div class="employee-content-left add-franchise-lines-data Task_List_Main">
					      	@if(!$Employee->tasklist->isEmpty())
					      	<ul>
					      		@forelse($Employee->tasklist()->orderBy('sort','asc')->get() as $task)
					      		<li>
					      			@if($task->status == 'Complete')
					      				<span><i class="fa fa-check " aria-hidden="true"></i></span>
					      			@else
					      				<span><i class="fa fa-times icon-back" aria-hidden="true"></i></span>
					      			@endif
					      			<h1 class="task_description">{{ $task->task }}</h1>
					      			<div class="clearfix"></div>
					      		</li>
					      		@empty
					      			<li>No Tasks found.</li>
					      		@endforelse
					      	</ul>
					      	@endif
				      	</div>
				    </div>
				</div>
				<div id="trip-itenary" class="tab-pane fade @if(Request::has('trip_itenary') || Request::get('tab') == 'trip_itenary') in active @endif">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming">
                    @if(Request::has('trip_itenary'))
                        <form action="{{ url('admin/employee/tripitenaryupdate/'.$Employee->employee_schedules->id) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="admin_employee_id" value="{{ $Employee->id }}" />
                    @endif
                        <div class="view-tab-content-head-main view-tab-content-head-main-padd">
                            <div class="view-tab-content-head">
                                <h3>Work Schedule</h3>
                            </div>
                            <div class="view-tab-content-butn">
                                @if(Request::has('trip_itenary'))
                                    <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Save Changes</button>
                                @else
                                    <a href="{{ url('admin/employee/view/'.$Employee->id.'?trip_itenary=edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="super-admin-table-1 table-responsive padd-upcoming-2 table-width">
							<table class="table-striped">
								<tr>
									<th>Days</th>
									<th>Time in</th>
									<th>Time Out</th>
									<th class="super-admin-table-position super-admin-table-position-1">Total Hrs</th>
								</tr>
                                @foreach($Employee_schedule as $emmployee_sch)
                                    <tr>
                                        <td>{{ $emmployee_sch['day'] }}</td>
                                        <td>
                                            @if(Request::has('trip_itenary'))
                                                <input @if($emmployee_sch['time_in'] != "-") {{--value="{{ $emmployee_sch['time_in']  }}"--}} @endif name="{{ strtolower($emmployee_sch['day']) }}_time_in" id="{{ strtolower($emmployee_sch['day']) }}_time_in" type="text" placeholder="-"/>
                                            @else
                                                {{ $emmployee_sch['time_in'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(Request::has('trip_itenary'))
                                                <input @if($emmployee_sch['time_out'] != "-") {{--value="{{ $emmployee_sch['time_out']  }}"--}} @endif name="{{ strtolower($emmployee_sch['day']) }}_time_out" id="{{ strtolower($emmployee_sch['day']) }}_time_out" type="text" placeholder="-"/>
                                            @else
                                                {{ $emmployee_sch['time_out'] }}
                                            @endif
                                        </td>
                                        <td class="super-admin-table-position super-admin-table-position-1">{{ $emmployee_sch['total_hours'] }}</td>
                                    </tr>
                                @endforeach
							</table>
						</div>

						<div class="fourty-hours-main">
							<h6>Total Weekly Hours</h6> <b>{{$Employee_schedule_hours}} Hours/Week</b>
						</div>
						<div class="clearfix"></div>
                     @if(Request::has('trip_itenary'))
                        </form>
                     @endif
					</div>
				</div>
				<div id="time-punches" class="tab-pane fade @if( Request::get('tab') == 'timepunches') in active @endif">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-padd">
				    		<div class="view-tab-content-head">
				    			<h3>{{ $Employee->fullname }}'s Time Punches</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" data-target="#myModal-1" data-toggle="modal" class="btn btn-2"><i class="fa fa-print" aria-hidden="true"></i></a>
				    			<a href="javascript:;" class="btn btn-2"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>
				    			<a href="#" data-target="#myModal" data-toggle="modal" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Add Forgotten Time Punch</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
						<div class="super-admin-table-select padd-upcoming-1">
							<form action="" method="get" id="timepunch_filter">
								<select name="month" id="monthChange">
									<option value="">Select Month</option>
									@foreach($months as $key => $value)
										<option @if(Request('month') == $key) selected @endif value="{{ $key }}" >{{ $value }}</option>
									@endforeach
								</select>
								<select name="week" id="Weeks">
									
								</select>
								<input type="hidden" name="tab" value="timepunches"/>
								<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
								<a href="{{ url('admin/employee/view/'.$Employee->id.'?tab=timepunches') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
							</form>
						</div>
						<div class="super-admin-table-1 table-responsive padd-upcoming-2">
							<table class="table-striped TimePuncheTableWidth">
								<tr>
									<th>Date</th>
									<th>Days</th>
									<th>Time in</th>
									<th>Time Out</th>
									<th>Total Hrs</th>
									<th>Overtime Hr(s)</th>
									<th>PTO</th>
									<th>Remarks</th>
								</tr>

								@php 
								$total_hours = 0; 
								$TotalMinutes = 0; 
								$TotalOverTime = 0; 
								$TotalOverTimeMinutes = 0; 
								@endphp

								@if(!is_array($Employee_timepunches) && !$Employee_timepunches->isEmpty())
									
									@foreach($Employee_timepunches as $timepunch)
									
									<!-- ================================
									Calculating over time and total hours
									================================= -->
									@php
										if( strpos($timepunch->total_hrs, '.') !== false ){
											$hours = explode('.',$timepunch->total_hrs);
											$total_hours += $hours[0];
											$TotalMinutes += $hours[1];
										}else{
											$total_hours += $timepunch->total_hrs;
										}

										if( strpos($timepunch->overtime_hrs, '.') !== false ){
											$hours = explode('.',$timepunch->overtime_hrs);
											$TotalOverTime += $hours[0];
											$TotalOverTimeMinutes += $hours[1];
										}else{
											$TotalOverTime += $timepunch->overtime_hrs;
										}

							            $time_in        = ($timepunch->time_in) ? date("g:i A", strtotime($timepunch->time_in) ) : "-";
							            $time_out       = ($timepunch->time_out) ? date("g:i A", strtotime($timepunch->time_out) ) : "-";
							            $T_hours    = "-";

							            if($time_in != "" && $time_out != "")
							            {
							                $time1          = strtotime($time_in);
							                $time2          = strtotime($time_out);
							                $difference     = round(abs($time2 - $time1) / 3600,2);
							                $T_hours    = ($difference) ? $difference : "-";
							            }
										
									@endphp
										<tr>
											<td>{{ date('jS M Y', strtotime($timepunch->date)) }}</td>
											<td>{{ $timepunch->day }}</td>
											<td>{{ date('h:i A',strtotime($timepunch->time_in)) }}</td>
											<td>{{ date('h:i A',strtotime($timepunch->time_out)) }}</td>
											<td>{{ $T_hours }}</td>
											<td>{{ $timepunch->overtime_hrs }}</td>
											<td>{{ $timepunch->pto }}</td>
											<td>{{ $timepunch->remarks }}</td>
										</tr>
									@endforeach
								@else
									<tr><td colspan="8">No Time Punches found.</td></tr>
								@endif
								
								@php
									while($TotalMinutes >= 60){
										$TotalMinutes = $TotalMinutes - 60;
										$total_hours += 1;
									}
								@endphp
								
							</table>
						</div>
						<div class="fourty-hours-main-main">
							<div class="fourty-hours-main fourty-hours-main-1">
								<h6>Total</h6>
								<b>{{$Employee_schedule_hours}} Hours/Week</b>
							</div>
							<div class="fourty-hours-main fourty-hours-main-1 fourty-hours-main-2">
								<h6>Billable Hours</h6>
								<b>{{ $total_hours }} hours @if($TotalMinutes) {{ $TotalMinutes }} minutes @endif</b>
							</div>
							<div class="fourty-hours-main fourty-hours-main-1 fourty-hours-main-2">
								@php $overTime =  ($total_hours.'.'.$TotalMinutes) - $Employee_schedule_hours; @endphp
								@if($overTime > 0)
									<h6>Over Time</h6>
									<b>{{ $overTime }} hours</b>
								@endif
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div> 
				</div>
				<div id="performance-log" class="tab-pane fade @if(Request::has('performance_log') || Request::get('tab') == 'performance_log') in active @endif ">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming">
				    	
				    	<div class="view-tab-content-head-main view-tab-content-head-main-padd">
				    		<div class="view-tab-content-head">
				    			<h3>{{ $Employee->fullname }}'s Performance Log</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			@if(Request::has('performance_log'))
				    				<button type="button" class="btn add-franchise-data-butn-1 updatePer"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Save Changes</button>
				    			@else
				    				<a href="{{ url('admin/employee/view/'.$Employee->id.'?performance_log=edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    			@endif
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
						<div class="super-admin-table-select padd-upcoming-1">
							<form action="" method="get" id="performancelog_filter">
								<select name="month">
									<option value="">Select Month</option>
									@foreach($months as $key => $getMonth)
										<option @if(Request('month') == $key) selected @endif value="{{ $key }}">{{ $getMonth }}</option>
									@endforeach
								</select>
								<select name="event">
									<option value="">Select Event</option>
						    		@foreach($PerformanceLogEvents as $event)
						    			<option @if(Request('event') == $event) selected @endif >{{ $event }}</option>
						    		@endforeach
								</select>
								<button type="submit" class="btn add-franchise-data-butn-1" ><i class="fa fa-search" aria-hidden="true"></i> Search</button>
								<a href="{{ url('admin/employee/view/'.$Employee->id.'?tab=performance_log') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
							</form>
						</div>
						<div class="PerformanceLogTableWidth Edit-Performance super-admin-table-1 table-responsive padd-upcoming-2 super-admin-table-time-punches">
						<form action="{{ url('admin/employee/performanceupdate/'.$Employee->id) }}" method="post" id="editPerformance">
							<table class="table-striped">
								<tr>
									<th>Date</th>
									<th>Event</th>
									<th>Comment</th>
									<th>Description</th>
								</tr>
								@if(!$Employee_performance->isEmpty())
									@php $count = 0; @endphp
									@foreach($Employee_performance as $log)
										<tr>
											<td>{{ date('jS M Y', strtotime($log->date)) }}</td>
											<td>
												@if(Request::has('performance_log'))
													<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
													<input type="hidden" name="performance[{{ $count }}][date]" value="{{ $log->date }}"/>
													<input type="hidden" name="performance[{{ $count }}][employee_id]" value="{{ $Employee->id }}"/>
													<select name="performance[{{ $count }}][event]">

											    		@foreach($PerformanceLogEvents as $event)
											    			<option @if($log->event == $event) selected @endif >{{ $event }}</option>
											    		@endforeach

													</select>
												@else
													{{ $log->event }}
												@endif
											</td>
											<td>
												@if(Request::has('performance_log') == 'edit')
													<input type="text" readonly class="performance_input" name="performance[{{ $count }}][comment]" value="{{ $log->comment }}"/>
													<a class="BluePencile"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												@else
													{{ $log->comment }}
												@endif
											
											</td>
											<td class="super-admin-table-time-punches-td">
												@if(Request::has('performance_log') == 'edit')
													<input type="text" readonly class="performance_input" name="performance[{{ $count }}][description]" value="{{ $log->description }}"/>
													<a class="BluePencile"><i class="fa fa-pencil" aria-hidden="true"></i></a>
													<a href="#" class="red-clr delete_performance"><i class="fa fa-trash" aria-hidden="true"></i></a>
												@else
													{{ $log->description }}
												@endif
											</td>
										</tr>
										@php $count++; @endphp
									@endforeach
								@else
									<tr><td colspan="4">No Performance Log found.</td></tr>
								@endif

							</table>
						</form>
						</div>
						
					</div> 
				</div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	<div class="poupup-main">
	  <!-- Trigger the modal with a button -->


	   <!-- ============== Modal for performance log ================ -->
	  <div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Add a Forgotten Time Punch</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body pos-rel">
	          <form action="{{ url('admin/employee/addtimepunch/'.$Employee->id) }}" method="post" id="TimePunch">
		          <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          
		          <input type="text" placeholder="Date" name="date" class="TimePunchDate" autocomplete="off" readonly="">
		          <i class="fa fa-calendar pos-abs-popup-caleder" aria-hidden="true"></i>
		          <input type="text" placeholder="Time In" name="time_in" class="TimePunchTime" id="add_time_in" autocomplete="off">
		          <input type="text" placeholder="Time Out" name="time_out" class="TimePunchTime" id="add_time_out" autocomplete="off">
		          
		          <input class="btn add-franchise-data-butn-1" type="submit" value="Add Forgotten Time Punch">
	          </form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	  <!-- ============== Modal for performance log ================ -->
	  

	  <!-- ============== Modal for delete performance log ================ -->
		<div class="delete-popup-main">
		  <div class="modal fade" id="myModal2" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content DeleteEmployeepopup">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Delete Performance Log</h4>
		        </div>
		        <div class="modal-body">
		          <p>Are you sure you want to delete this log.</p>
		          <input class="btn popup-delete-butn" type="button" value="Delete">
		        </div>
		      </div>
		      
		    </div>
		  </div>	  
		 </div> 
	  <!-- ============== Modal for delete performance log ================ -->
	  
	</div>
	<div class="poupup-main">
	  <!-- Trigger the modal with a button -->
	  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

	  <!-- Modal -->
	  <div class="modal fade" id="myModal-1" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Print Report</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body">
	          	<form action="{{ url('admin/employee/printreport/'.$Employee->id) }}" method="post" id="printReport">
		          	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          	<div class="pop_position-rel">
		          	<input type="text" name="startReport" autocomplete="off" placeholder="Date (From)" id="startReport">
					<a><i class="fa fa-calendar" aria-hidden="true"></i></a>
					<label class="error" for="startReport"></label>
					</div>
		          	<div class="pop_position-rel">
		          	<input type="text" name="endReport" autocomplete="off" placeholder="Date (To)" id="endReport">
					<a><i class="fa fa-calendar" aria-hidden="true"></i></a>
					<label class="error" for="endReport"></label>
		          	</div>
		          	<input class="btn add-franchise-data-butn-1" type="submit" value="Print Report">
	          	</form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
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

		
		//Time picker
		$('.TimePunchDate').datetimepicker({
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
    	});	
		
		$('#TimePunch').validate({
			rules:{
				'date':{required:true},
				'time_in':{required:true},
				'time_out':{required:true},
			}
		});
		
		
		//Print Report of time punches
		
		$( function() {
			$("#startReport").datetimepicker({
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    }).on('changeDate', function (selected) {
		        var minDate = new Date(selected.date.valueOf());
		        minDate.setDate(minDate.getDate() + 1);
		        $(this).parents('.EventModel').find('#endReport').datetimepicker('setStartDate', minDate);
		    });
		    $("#endReport").datetimepicker({
		        autoclose: true,
		        format: 'mm/dd/yyyy',
			    maxView: 4,
			    minView: 2,  	
		    }).on('changeDate', function (selected) {
		        var minDate = new Date(selected.date.valueOf());
		        minDate.setDate(minDate.getDate() - 1);
		        $(this).parents('.EventModel').find('#startReport').datetimepicker('setEndDate', minDate);
		    });

		});

		$('#printReport').validate({
			rules:{
				'startReport':{required:true},
				'endReport':{required:true},
			}			
		});
		//Print Report of time punches
		
	});

	$(document).ready(function(e) {
		
		//Code for edit performance log
		$('.BluePencile').click(function(){
			var editInput = $(this).parent('td').find('.performance_input');
			if( editInput.attr('readonly') ){
				editInput.removeAttr('readonly');
			}else{
				editInput.attr('readonly','');
			}
		});
		
		// code for delete Performance
		var currentRow = '';
		$('.delete_performance').click(function(){
			currentRow = $(this);
			$('#myModal2').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			currentRow.parents('tr').remove();
			$('#myModal2').modal('hide');
		});
		
		//Submit update performance form 
		$('.updatePer').click(function(){
			$('#editPerformance').submit();
		});
		
		
		//get weeks of selected month
		function getWeeks(Month = 1){
			var Month = 1;
			if('{{ Request::has("month") }}'){
				Month = '{{ Request::get("month") }}';
			}
			$.ajax({
				url:'{{ url("admin/employee/getweeks/") }}',
				method:'Post',
				data:{'month':Month, '_token':'{{ csrf_token() }}'},
				success:function(response){
					//alert(response);
					if(!isNaN(response)){
						var html = '';
						html += '<option value="" >Select Week</option>';
						for(var i = 1; i <= response; i++){
							html += '<option '+ ('@php echo Request("week"); @endphp' == i ? 'selected' : "") +' value="'+i+'">Week '+i+'</option>';
						}
						$('#Weeks').html(html);
					}
				}
			});
		}
		getWeeks();

		$('#monthChange').change(function(){
			var Month = $(this).val();
			if(Month != ''){
				getWeeks(Month);
			}
		});
		
	});
    function timeRange(startTime, endTime){
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
	        	$(endTime).datetimepicker('setHoursDisabled', [0]);
		        minTime.setMinutes(minTime.getMinutes() + 29);
		        $(endTime).datetimepicker('setStartDate', minTime);
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
		    hoursDisabled: '0,1,2,3,4,5,6,7',	
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
	        	$(startTime).datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7]);
	        }
	 	}); 
    }
    //End time range

    timeRange('#add_time_in', '#add_time_out');

    @foreach($Employee_schedule as $emmployee_sch)
    	@if(Request::has('trip_itenary'))
    		timeRange('#{{ strtolower($emmployee_sch['day']) }}_time_in', '#{{ strtolower($emmployee_sch['day']) }}_time_out');
    		@if($emmployee_sch['time_in'] != "" && $emmployee_sch['time_in'] != "-")
    			
    			//TIME IN VARIABLE
    			settimein = new Date('{{ date('M d, Y H:i:s',strtotime($emmployee_sch['time_in']) )  }}');
    			//TIME OUT VARIABLE
    			settimeout = new Date('{{ date('M d, Y H:i:s',strtotime($emmployee_sch['time_out']) )  }}');
    			
    			var StartTime = '#{{ strtolower($emmployee_sch['day']) }}_time_in';
    			var EndTime = '#{{ strtolower($emmployee_sch['day']) }}_time_out';
    			
    			//Set End time of first field
    			setEndOfStartPicker = new Date('{{ date('M d, Y H:i:s',strtotime($emmployee_sch['time_out']) )  }}');
    			setEndOfStartPicker.setMinutes(setEndOfStartPicker.getMinutes() - 29);
	    		$(StartTime).datetimepicker('update', settimein);
    			$(StartTime).datetimepicker('setEndDate',setEndOfStartPicker);

	    		//Set Start time of second field
	    		setStartOfEndPicker = new Date('{{ date('M d, Y H:i:s',strtotime($emmployee_sch['time_in']) )  }}');
	    		setStartOfEndPicker.setMinutes(setStartOfEndPicker.getMinutes() + 30);
	    		$(EndTime).datetimepicker('update', settimeout);
	    		$(EndTime).datetimepicker('setStartDate', setStartOfEndPicker);

	    		$('#{{ strtolower($emmployee_sch['day']) }}_time_in').val('{{ date( "h:i A",strtotime($emmployee_sch['time_in']) ) }}');
	    		$('#{{ strtolower($emmployee_sch['day']) }}_time_out').val('{{ date( "h:i A",strtotime($emmployee_sch['time_out']) ) }}');
    		@endif
    		
    	@endif
    @endforeach

	//BUTTONS JS
    $(".trigger-1").click(function(e) {
        $(".dis-none-3").show();
        $(".dis-none-5").hide();
    });
    $(".trigger").click(function(e) {
        $(".dis-none-3").hide();
        $(".dis-none-5").hide();
    });
    $(".trigger-5").click(function(e) {
        $(".dis-none-3").hide();
        $(".dis-none-5").show();
    });
    
    if('{{ Request::get("tab") }}' == 'tasklist'){
    	$(".dis-none-5").show();
    }
    if('{{ Request::get("tab") }}' == 'performance_log'){
    	$(".dis-none-3").show();
    }

	//BREADCRUMBS CODE 
	function EmployeesDemographic() {
	    document.getElementById("change-bread-crumb").innerHTML = "Employees Demographic";
	}
	function TasksList() {
	    document.getElementById("change-bread-crumb").innerHTML = "Tasks List";
	}
	function TripItenary() {
	    document.getElementById("change-bread-crumb").innerHTML = "Trip Itenary";
	}
	function TimePunches() {
	    document.getElementById("change-bread-crumb").innerHTML = "Time Punches";
	}
	function PerformanceLog() {
	    document.getElementById("change-bread-crumb").innerHTML = "Performance Log";
	}
	
	
	//TIME PUNCHES FILTERS
	$("#timepunch_filter").on("submit",function(e){
	    e.preventDefault();
	    var url = $(this).attr("action");

	    var week        = $('#timepunch_filter select[name=\'week\']').val();
	    var month       = $('#timepunch_filter select[name=\'month\']').val();

	    if(week == "" || month == "")
	    {
	        alert("Please select both fields");
	        return false;
	    }
	    else
	    {
	        url += '?tab=timepunches&';
	    }

	    if(week != "")
	    {
	        url += 'week=' + encodeURIComponent(week);
	    }

	    if(month != "")
	    {
	        if(week != "")
	            url += '&';
	        url += 'month=' + encodeURIComponent(month);
	    }

	    window.location = url;
	});
	
	//PERFORMANCE FILTERS
	$("#performancelog_filter").on("submit",function(e){
	    e.preventDefault();
	    var url = $(this).attr("action");

	    var event        = $('#performancelog_filter select[name=\'event\']').val();
	    var month       = $('#performancelog_filter select[name=\'month\']').val();

	    if(event == "" && month == "")
	    {
	        alert("Please select both fields");
	        return false;
	    }
	    else
	    {
	        url += '?tab=performance_log&';
	    }

	    if(event != "")
	    {
	        url += 'event=' + encodeURIComponent(event);
	    }

	    if(month != "")
	    {
	        if(event != "")
	            url += '&';
	        url += 'month=' + encodeURIComponent(month);
	    }

	    window.location = url;
	})	
</script>


@endsection
