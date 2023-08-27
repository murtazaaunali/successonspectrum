@extends('franchise.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
			<p>Client / {{ $Client->client_childfullname }} / <span id="change-bread-crumb">Schedule</span></p>
		</div>

		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('franchise.clients.clientTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('franchise.clients.clientTabMenu')
            
			<div class="tab-content">
				
				<div id="trip-itenary" class="tab-pane fade in active">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming">
                    @if(Request::has('trip_itenary'))
                        <form action="@if(isset($Client->employee_schedules->id)){{ url('franchise/client/tripitenaryupdate/'.$Client->employee_schedules->id) }}@else {{ url('franchise/client/tripitenaryupdate/-1') }} @endif" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="client_id" value="{{ $Client->id }}" />
                    @endif
                        <div class="view-tab-content-head-main view-tab-content-head-main-padd">
                            <div class="view-tab-content-head">
                                <h3>Work Schedule</h3>
                            </div>
                            <div class="view-tab-content-butn">
                                @if(Request::has('trip_itenary'))
                                    <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Save Changes</button>
                                @else
                                    <a href="{{ url('franchise/client/viewtripitinerary/'.$Client->id.'?trip_itenary=edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="ClientTrimitinerayViewTablePadd EmployeeTrimitinerayViewTablePadd">
	                        <div class="super-admin-table-1 table-responsive table-width">
								<table class="table-striped">
									<tr>
										<th>Days</th>
										<th>Time in</th>
										<!--<th>Time Out</th>-->
										<th class="super-admin-table-position super-admin-table-position-1">Time Out</th>
                                        <!--<th class="super-admin-table-position super-admin-table-position-1">Total Hrs</th>-->
									</tr>
	                                @foreach($Client_schedule as $client_sch)
	                                    <tr>
	                                        <td>{{ $client_sch['day'] }}</td>
	                                        <td>
	                                            @if(Request::has('trip_itenary'))
	                                                <input autocomplete="off" name="{{ strtolower($client_sch['day']) }}_time_in" id="{{ strtolower($client_sch['day']) }}_time_in" type="text" placeholder="-"/>
	                                            @else
	                                                {{ $client_sch['time_in'] }}
	                                            @endif
	                                        </td>
	                                        <!--<td>-->
                                            <td class="super-admin-table-position super-admin-table-position-1">
	                                            @if(Request::has('trip_itenary'))
	                                                <input autocomplete="off" name="{{ strtolower($client_sch['day']) }}_time_out" id="{{ strtolower($client_sch['day']) }}_time_out" type="text" placeholder="-"/>
	                                            @else
	                                                {{ $client_sch['time_out'] }}
	                                            @endif
	                                        </td>
	                                        <!--<td class="super-admin-table-position super-admin-table-position-1">{{ $client_sch['total_hours'] }}</td>-->
	                                    </tr>
	                                @endforeach
								</table>
							</div>
							<!--<div class="fourty-hours-main">
								<h6>Total Weekly Hours</h6> <b>{{$Client_schedule_hours}} Hours/Week</b>
							</div>-->
                            <div class="clearfix"></div>
						</div>

						<div class="clearfix"></div>
                     @if(Request::has('trip_itenary'))
                        </form>
                     @endif
					</div>
				</div>
		
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	

	
<script type="text/javascript">

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
    //End time range

    timeRange('#add_time_in', '#add_time_out');

    @foreach($Client_schedule as $client_sch)
    	@if(Request::has('trip_itenary'))
    		timeRange('#{{ strtolower($client_sch['day']) }}_time_in', '#{{ strtolower($client_sch['day']) }}_time_out');
    		@if($client_sch['time_in'] != "" && $client_sch['time_in'] != "-")
    			
    			//TIME IN VARIABLE
    			settimein = new Date('{{ date('M d, Y H:i:s',strtotime($client_sch['time_in']) )  }}');
    			//TIME OUT VARIABLE
    			settimeout = new Date('{{ date('M d, Y H:i:s',strtotime($client_sch['time_out']) )  }}');
    			
    			var StartTime = '#{{ strtolower($client_sch['day']) }}_time_in';
    			var EndTime = '#{{ strtolower($client_sch['day']) }}_time_out';
    			
    			//Set End time of first field
    			setEndOfStartPicker = new Date('{{ date('M d, Y H:i:s',strtotime($client_sch['time_out']) )  }}');
    			setEndOfStartPicker.setMinutes(setEndOfStartPicker.getMinutes() - 29);
	    		$(StartTime).datetimepicker('update', settimein);
    			$(StartTime).datetimepicker('setEndDate',setEndOfStartPicker);

	    		//Set Start time of second field
	    		setStartOfEndPicker = new Date('{{ date('M d, Y H:i:s',strtotime($client_sch['time_in']) )  }}');
	    		setStartOfEndPicker.setMinutes(setStartOfEndPicker.getMinutes() + 30);
	    		$(EndTime).datetimepicker('update', settimeout);
	    		$(EndTime).datetimepicker('setStartDate', setStartOfEndPicker);

	    		$('#{{ strtolower($client_sch['day']) }}_time_in').val('{{ date( "h:i A",strtotime($client_sch['time_in']) ) }}');
	    		$('#{{ strtolower($client_sch['day']) }}_time_out').val('{{ date( "h:i A",strtotime($client_sch['time_out']) ) }}');
    		@endif
    		
    	@endif
    @endforeach
	
</script>


@endsection
