@extends('femployee.layout.main')

@section('content')

<link href='{{ asset("assets") }}/packages/core/main.css' rel='stylesheet' />
<link href='{{ asset("assets") }}/packages/daygrid/main.css' rel='stylesheet' />
<link href='{{ asset("assets") }}/packages/timegrid/main.css' rel='stylesheet' />
<link href='{{ asset("assets") }}/packages/list/main.css' rel='stylesheet' />
<link href='{{ asset("assets") }}/packages/timeline/main.css' rel='stylesheet' />
<link href='{{ asset("assets") }}/packages/resource-timeline/main.css' rel='stylesheet' />

<script src='{{ asset("assets") }}/packages/core/main.js'></script>
<script src='{{ asset("assets") }}/packages/interaction/main.js'></script>
<script src='{{ asset("assets") }}/packages/daygrid/main.js'></script>
<script src='{{ asset("assets") }}/packages/timegrid/main.js'></script>
<script src='{{ asset("assets") }}/packages/timeline/main.js'></script>
<script src='{{ asset("assets") }}/packages/list/main.js'></script>
<script src='{{ asset("assets") }}/packages/resource-common/main.js'></script>
<script src='{{ asset("assets") }}/packages/resource-timeline/main.js'></script>
<script>
  
  function loadEventCalendar()
  {
	  document.getElementById('calendar2').innerHTML = "";
	  var calendarEl = document.getElementById('calendar2');
	  var calendar = new FullCalendar.Calendar(calendarEl, {
		schedulerLicenseKey: '0446301481-fcs-1560338019',
		now:'{{ $date }}',
		plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'resourceTimeline' ],
		editable: false, // enable draggable events
		header: {
		  left: 'prev,next',
		  center: 'title',
		  right: 'dayGridMonth'
		},
		defaultView: 'dayGridMonth',
		events:@php echo str_replace(array("&lt;br /&gt;","<br>"),'\n',$events); @endphp,
	  });
	  calendar.render();
  }

</script>
<style>
  #calendar2 {
    max-width: 900px;
    margin: 50px auto;
  }
  .fc-content{
  	white-space: normal !important; 
  	position: relative;
  	padding: 5px 1px;
  }
  .fc-today{background: none !important;}
  .fc-dayGridMonth-button{display: none;}
  .fc-button-primary{background: #4e98ca; border-color: #4e98ca;}
  .fc-button-primary:hover{background: #4e98ca; border-color: #4e98ca;}
</style>

@if(Request::has('year') || Request::has('monthh'))
<style>
	.fc-prev-button, .fc-next-button{display:none;}
</style>
@endif

	<div class="poupup-main">
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content add-forgetten-modal-content EventModel">
					<div class="modal-header add-forgetten-modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add New Event</h4>
					</div>
					<form action="{{ url('femployee/trip_itinerary/add') }}" method="post" id="addnewevent">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
						<div class="modal-body add-forgetten-modal-body">

							<div class="pop_position-rel">
								<input name="eventdate" type="text" placeholder="Date" class="datepicker">
								<a href="javascript:void(0);"><i class="fa fa-calendar datepicker" aria-hidden="true"></i></a>
							</div>
							@if($errors->has('eventdate'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('eventdate') }}</label>
                                </span>
							@endif
							
							<input name="starttime" type="text" placeholder="Start Time" id="starttime" autocomplete="off"/>
							@if($errors->has('starttime'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('starttime') }}</label>
                                </span>
							@endif

							<input name="endtime" type="text" placeholder="End Time" id="endtime" autocomplete="off"/>
							@if($errors->has('endtime'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('endtime') }}</label>
                                </span>
							@endif

							<input name="eventname" type="text" placeholder="Event Name" />
							@if($errors->has('eventname'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('eventname') }}</label>
                                </span>
							@endif
							<input class="btn add-franchise-data-butn-1" type="submit" value="Add New Event">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
	  <!-- ============== Modal for ForgottenTimePunchPopup ================ -->
    <!--<div class="poupup-main">
	  <div class="modal fade ForgottenTimePunchPopup" id="myModal-1" role="dialog">
	    <div class="modal-dialog">
	    
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Add a Forgotten Time Punch</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body pos-rel">
	          <form action="{{ url('femployee/trip_itinerary/addtimepunch/'.$Femployee->id) }}" method="post" id="TimePunch">
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
	</div>-->
	  <!-- ============== Modal for ForgottenTimePunchPopup ================ -->
	  
	  <!-- ============== Modal for Session ================ -->
    <div class="poupup-main">
	  <div class="modal fade ForgottenTimePunchPopup" id="request_session" role="dialog">
	    <div class="modal-dialog">
	    
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Saturday Session</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body pos-rel">
	          <form action="#" method="post">
		          <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          
		          <input type="text" placeholder="Date" name="date" class="TimePunchDate" autocomplete="off">
		          <i class="fa fa-calendar pos-abs-popup-caleder TimePunchDate" aria-hidden="true"></i>
		          <input type="text" placeholder="Time In" name="time_in" class="TimePunchTime" id="add_time_in" autocomplete="off">
		          <textarea name="Message" class="TimePunchTime" placeholder="Message" rows="5"></textarea>
		          
		          <input class="btn add-franchise-data-butn-1" type="submit" value="Request">
	          </form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>
	  <!-- ============== Modal for Session ================ -->	  
	
	<div class="poupup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="myModal-2" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Print Report</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body">
	          	<form action="{{ url('femployee/trip_itinerary/printreport/'.$Femployee->id) }}" method="post" id="printReport">
		          	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          	<div class="pop_position-rel">
		          	<input type="text" name="startReport" autocomplete="off" placeholder="Date (From)" id="startReport" class="startReport">
					<a><i class="fa fa-calendar startReport" aria-hidden="true"></i></a>
					<label class="error" for="startReport"></label>
					</div>
		          	<div class="pop_position-rel">
		          	<input type="text" name="endReport" autocomplete="off" placeholder="Date (To)" id="endReport" class="endReport">
					<a><i class="fa fa-calendar endReport" aria-hidden="true"></i></a>
					<label class="error" for="endReport"></label>
		          	</div>
		          	<input class="btn add-franchise-data-butn-1" type="submit" value="Print Report">
	          	</form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>
    
    <div class="poupup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="view-hourslog-graph" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Hours Log</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body">
	          	<div id="hours-log-chart-container" style="height: 400px; width: 100%; margin: 0px auto;"></div>
                <div class="clearfix"></div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="clearfix"></div>
	
    <div class="add-franchise-super-main">
        <div class="main-deck-head main-deck-head-franchise">
            <h4>{{$sub_title}}</h4>
            <p>{{ $sub_title }} / <span id="change-bread-crumb">Events </span></p>
        </div>
        <!--<div class="add-franchise-butn-main">
            <a href="javascript:void(0);" class="btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar" aria-hidden="true"></i>Add New Event</a>
        </div>-->
        <div class="clearfix"></div>
    
        @if(Session::has('Success'))
            {!! session('Success') !!}
        @endif
        
        <div class="add-franchise-data-main-1 PerformanceNone">
            <ul class="nav nav-tabs">
                <li class="@if(!Request::get('tab') && Request::get('tab') == '')active @endif"><a data-toggle="tab" href="#Work_Schdule">Work Schdule</a></li>
                <li><a data-toggle="tab" href="#Calendar">Calendar</a></li>
                <li class="@if(Request::get('tab') == 'timepunches') active @endif"><a data-toggle="tab" href="#Time_Punches">Time Punches</a></li>
            </ul>
            <div class="tab-content">
                <div id="Work_Schdule" class="tab-pane fade @if(!Request::get('tab') && Request::get('tab') == '')in active @endif">
                    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming">
                    @if(Request::has('trip_itenary'))
                    @php
                    	$schedule_id = -1; 
                    	if($Femployee->employee_schedules){
							$schedule_id = $Femployee->employee_schedules->id;
						}
                    @endphp
                        <form action="{{ url('femployee/tripitenaryupdate/'.$schedule_id) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="admin_employee_id" value="{{ $Femployee->id }}" />
                    @endif
                        <div class="view-tab-content-head-main view-tab-content-head-main-padd">
                            <div class="view-tab-content-head">
                                <h3>Work Schedule</h3>
                            </div>
                            <div class="view-tab-content-butn">
                                @if(Request::has('trip_itenary'))
                                    <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Save Changes</button>
                                @else
                                    <a href="{{ url('femployee/viewtripitinerary/'.$Femployee->id.'?trip_itenary=edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
                                    <button class="btn add-franchise-data-butn-1" data-toggle="modal" data-target="#request_session"><i class="fa fa-user" aria-hidden="true"></i>Request Saturday Session</button>
                                @endif
    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="EmployeeTrimitinerayViewTablePadd">
                            <div class="super-admin-table-1 table-responsive table-width">
                                <table class="table-striped">
                                    <tr>
                                        <th>Days</th>
                                        <th>Time in</th>
                                        <th>Time Out</th>
                                        <th class="super-admin-table-position super-admin-table-position-1">Total Hrs</th>
                                    </tr>
                                    @foreach($Femployee_schedule as $emmployee_sch)
                                        <tr>
                                            <td>{{ $emmployee_sch['day'] }}</td>
                                            <td>
                                                @if(Request::has('trip_itenary'))
                                                    <input autocomplete="off" name="{{ strtolower($emmployee_sch['day']) }}_time_in" id="{{ strtolower($emmployee_sch['day']) }}_time_in" type="text" placeholder="-"/>
                                                @else
                                                    {{ $emmployee_sch['time_in'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(Request::has('trip_itenary'))
                                                    <input autocomplete="off" name="{{ strtolower($emmployee_sch['day']) }}_time_out" id="{{ strtolower($emmployee_sch['day']) }}_time_out" type="text" placeholder="-"/>
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
                                <h6>Total Weekly Hours</h6> <b>{{$Femployee_schedule_hours}} Hours/Week</b>
                            </div>
                        </div>
    
                        <div class="clearfix"></div>
                     @if(Request::has('trip_itenary'))
                        </form>
                     @endif
                    </div>
                    
                </div>
                <div id="Calendar" class="tab-pane fade">
                    <div class="TripItineraryMainDiv">
                        <div class="view-tab-content-head-main">
                            <div class="view-tab-content-head">
                                <h3>Event Calendar</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br/>
                        <div class="row hidden">
                            <div class="col-sm-12">
                                <form action="" method="get" id="trip_filters">
                                    <div class="super-admin-table-select col-sm-9">
                                        <input type="text" name="year" placeholder="Select Year" value="{{ Request::get('year') }}" class="datepicker_filter" readonly="">
                                        <div class="super-admin-table-select-calender-icon TripItineraryViewCalendar">
                                            <i class="fa fa-calendar datepicker_filter" aria-hidden="true"></i>
                                        </div>
                                        
                                        <label>Month</label>
                                        <select name="month">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $getMonth)
                                                <option @if(Request('monthh') == $key) selected @endif value="{{ $key }}">{{ $getMonth }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                        <a href="{{ url('femployee/trip_itinerary') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filters</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                        <div id='calendar2'></div>
                    </div>    
                </div>
                <div id="Time_Punches" class="tab-pane fade @if(Request::get('tab') == 'timepunches') in active @endif">
                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                        <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming EmployeeTimepunchesMainDiv">
                            <div class="view-tab-content-head-main view-tab-content-head-main-padd">
                                <div class="view-tab-content-head">
                                    <h3>Time Punches</h3>
                                </div>
                                <div class="view-tab-content-butn">
                                    <a href="#" data-target="#myModal-2" data-toggle="modal" class="btn btn-2"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    <a href="#" data-target="#view-hourslog-graph" data-toggle="modal"  class="btn btn-2"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>
                                    <!--<a href="#" data-target="#myModal-1" data-toggle="modal" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Add Forgotten Time Punch</a>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="super-admin-table-select padd-upcoming-1">
                                <form action="" method="get" id="timepunch_filter">
                                    <label>Month</label>
                                    <select name="month" id="monthChange">
                                        <option value="">Select Month</option>
                                        @foreach($months as $key => $value)
                                            <option @if(Request('month') == $key) selected @endif value="{{ $key }}" >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <label>Week</label>
                                    <select name="week" id="Weeks">
                                        
                                    </select>
                                    <input type="hidden" name="tab" value="timepunches"/>
                                    <div class="ButtonsPullRightRisponsive">
                                        <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>

                                        <a href="{{ url('femployee/trip_itinerary') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
                                    </div>
                                </form>
                            </div>
                            <div class="super-admin-table-1 padd-upcoming-2">
                                <div class="table-responsive">
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
    
                                        @if(!is_array($Femployee_timepunches) && !$Femployee_timepunches->isEmpty())
                                            
                                            @foreach($Femployee_timepunches as $timepunch)
                                            
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
                                    <b>{{$Femployee_schedule_hours}} Hours/Week</b>
                                </div>
                                <div class="fourty-hours-main fourty-hours-main-1 fourty-hours-main-2">
                                    <h6>Billable Hours</h6>
                                    @if($total_hours)
                                        <b> @if($total_hours > 1) {{ $total_hours }} hours @else {{ $total_hours }} hour @endif @if($TotalMinutes) {{ $TotalMinutes }} minutes @endif</b>
                                    @else
                                        <b>{{ $total_hours }} hour</b>
                                    @endif
                                </div>
                                <div class="fourty-hours-main fourty-hours-main-1 fourty-hours-main-2">
                                    @php $overTime =  ($total_hours.'.'.$TotalMinutes) - $Femployee_schedule_hours; @endphp
                                    @if($overTime > 0)
                                        <h6>Over Time</h6>
                                        <b>{{ $overTime }} hours</b>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.datepicker_filter').datetimepicker({
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});

		$('.datepicker').datetimepicker({
			pickerPosition: 'bottom-left',
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
        });
		
		loadEventCalendar();
	});

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
    
    timeRange('#starttime', '#endtime');
	timeRange('#add_time_in', '#add_time_out');
	
	@foreach($Femployee_schedule as $emmployee_sch)
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
	
	$(document).ready(function(){
		
		//Time picker
		$('.TimePunchDate').datetimepicker({
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
			endDate: new Date(),
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
			//$("#startReport").datetimepicker({
			$(".startReport").datetimepicker({	
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
		    //$("#endReport").datetimepicker({
			$(".endReport").datetimepicker({	
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
		
		//get weeks of selected month
		//function getWeeks(Month = 1){
		function getWeeks(Month = ""){
			/*var Month = 1;
			if('{{ Request::has("month") }}'){
				Month = '{{ Request::get("month") }}';
			}*/
			if(Month == "")
			{
				if('{{ Request::has("month") }}'){
					var Month = '{{ Request::get("month") }}';
				}
			}
			$.ajax({
				url:'{{ url("femployee/trip_itinerary/getweeks/") }}',
				method:'Post',
				data:{'month':Month, '_token':'{{ csrf_token() }}'},
				success:function(response){
					//alert(response);
					if(!isNaN(response)){
						var html = '';
						html += '<option value="" >Select Week</option>';
						/*for(var i = 1; i <= response; i++){
							html += '<option '+ ('@php echo Request("week"); @endphp' == i ? 'selected' : "") +' value="'+i+'">Week '+i+'</option>';
						}*/
						if(Month != "")
						{
							for(var i = 1; i <= response; i++){
								html += '<option '+ ('@php echo Request("week"); @endphp' == i ? 'selected' : "") +' value="'+i+'">Week '+i+'</option>';
							}
						}
						$('#Weeks').html(html);
					}
				}
			});
		}
		//getWeeks();
		getWeeks("");

		$('#monthChange').change(function(){
			var Month = $(this).val();
			if(Month != ''){
				getWeeks(Month);
			}
		});
		
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			  // TODO: check href of e.target to detect your tab
			  if($(this).attr("href") == "#Calendar")loadEventCalendar();
		}) 
		
	});


//Filters
$("#trip_filters").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var year        = $('input[name=\'year\']').val();
    var month       = $('select[name=\'month\']').val();

    if(year == "" || month == "")
    {
        alert("Please select both fields");
        return false;
    }
    else
    {
        url += '?';
    }

    if(year != "")
    {
        url += 'year=' + encodeURIComponent(year);
    }

    if(month != "")
    {
        if(year != "")
            url += '&';
        url += 'monthh=' + encodeURIComponent(month);
    }

    window.location = url;
})
</script>

@if(Auth::guard('femployee')->check())
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endif

<script>
window.onload = function () {
//Creating Hours Log Json Object
var HoursLog = [];
//var HoursLog = new Array();
var hours_logs = @php echo $hours_logs; @endphp;	
$.each(hours_logs,function(key,val){
	//console.log(key);
	HoursLog.push({'x':new Date(val.x), 'y':Number(val.y)});
});
console.log(HoursLog);
var options = {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: ""
	},
	subtitles: [{
		text: ""
	}],
	axisX: {
		title: "Dates"
	},
	axisY: {
		title: "Hours",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC",
		includeZero: false,
		//interval: 1
	},
	axisY2: {
		title: "",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E",
		includeZero: false
	},
	toolTip: {
		shared: true
	},
	data: [
	{
		type: "column",
		//name: "Hours Log",
		//axisYType: "secondary",
		//showInLegend: true,
		xValueFormatString: "DD MMM YYYY",
		yValueFormatString: "Hours #,##0.#",
		dataPoints: HoursLog
	}]
};
$("#hours-log-chart-container").CanvasJSChart(options);
}
</script>			
@endsection
