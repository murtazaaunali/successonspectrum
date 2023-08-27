@extends('admin.layout.main')

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

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar2');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      schedulerLicenseKey: '0446301481-fcs-1560338019',
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'resourceTimeline' ],
      editable: false, // enable draggable events
      now:'{{ $date }}',
	  header: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth'
      },
      defaultView: 'dayGridMonth',
      events:@php echo str_replace(array("&lt;br /&gt;","<br>"),'\n',$events); @endphp,
	  eventClick: function(info) {

	    //CREATING DATE FORMATE
	    date = new Date(info.event.start);
	    date.setMonth(date.getMonth() + 1);
	    date = (date.getMonth() < 10 ? 0+""+date.getMonth() : date.getMonth() )+'/'+ date.getDate() +'/'+date.getFullYear()  ;
	    
	    //GET EVENT AND FRANCHISE ID
	    var ids = info.event.id.split("_");
	    
	    //GET START AND END TIME
	    var start = new Date(info.event.start);
	    var end = new Date(info.event.end);
		//alert("start="+start+"|end="+end+"|eventname="+info.event.groupId+"|date="+date+"|event_id="+ids[0]+"|admin_employee_id="+ids[1]);
	    
	    $("#editnewevent").find('input[name=eventname]').val(info.event.groupId);
	    $("#editnewevent").find('input[name=eventdate]').val(date);
	    $("#editnewevent").find('input[name=event_id]').val(ids[0]);
	    $("#editnewevent").find('input[name=admin_employee_id]').val(ids[1]);
	    //$("#editnewevent").find('input[name=starttime]').val(formatAMPM(start));
	    //$("#editnewevent").find('input[name=endtime]').val(formatAMPM(end));
	    
	    //UPDATING TIME IN TIMEPICKER
		//var StartTime = $("#editnewevent").find('input[name=starttime]');
	    //var EndTime = $("#editnewevent").find('input[name=endtime]');
		var StartTime = $("#edit_starttime");
	    var EndTime = $("#edit_endtime");
	    
	    /*$(StartTime).datetimepicker('setEndDate',end);
	    $(StartTime).datetimepicker('update', start);
	    
	    $(EndTime).datetimepicker('setStartDate', start);
	    $(EndTime).datetimepicker('update', end);*/

  	  	/*$(StartTime).datetimepicker({
		  	minuteStep: 30,
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
	        minTime.setMinutes(minTime.getMinutes() + 29 );
	        $(EndTime).datetimepicker('setStartDate', minTime);
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
	        if(minutes >= 30){
	        	$(EndTime).datetimepicker('setHoursDisabled', [Hours]);
	        }else{
				$(EndTime).datetimepicker('setHoursDisabled', [0]);
			}
		});
		
		//END TIME
		$(EndTime).datetimepicker({
			minuteStep: 30,
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
        	
        	minTime.setMinutes(minTime.getMinutes() - 30);
        	$(StartTime).datetimepicker('setEndDate', minTime);
	 	});*/
		timeRange(StartTime, EndTime);
		
		$("#editnewevent").find('input[name=starttime]').val(formatAMPM(start));
	    $("#editnewevent").find('input[name=endtime]').val(formatAMPM(end)); 
		
		$(StartTime).datetimepicker('setEndDate',end);
	    $(StartTime).datetimepicker('update', start);
	    
	    $(EndTime).datetimepicker('setStartDate', start);
	    $(EndTime).datetimepicker('update', end);
	    
	    $('#myModalEdit').modal('show');
	  },
    });

    calendar.render();
	
	//CONVERTING TIME FORMATE AM AND PM
	function formatAMPM(date) {
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;
		return strTime;
	}
  });

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
	min-height: 60px; 
	/*color: #3788d8;*/
  }
  .fc-content:before{
  	position: absolute;
  	right: 5px;
  	top: 2px;
  	/*color: #3788d8;*/
  	content: '\f044';
  	font-family: FontAwesome;
  }
  .fc-time{display: none;}
  .fc-content:hover{cursor: pointer;}
  .fc-today{background: none !important;}
  .fc-dayGridMonth-button{display: none;}
  .fc-event{/*background:none !important;*/}  
  .fc-button-primary{background: #4e98ca; border-color: #4e98ca;}
  .fc-button-primary:hover{background: #4e98ca; border-color: #4e98ca;}
</style>

@if(Request::has('year') || Request::has('monthh'))
<style>
	.fc-prev-button, .fc-next-button{display:none;}
</style>
@endif

	<div class="main-deck-head main-deck-head-franchise">
		<h4>Super Admin {{$sub_title}}</h4>
	</div>
    <div class="add-franchise-butn-main">
		<a href="javascript:void(0);" class="btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar" aria-hidden="true"></i>Add New Event</a>
	</div>
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
					<form action="{{ url('admin/trip_itinerary/add') }}" method="post" id="addnewevent">
						<input type="hidden" name="action" value="franchise_calendar"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="selectadmin" value="{{ Auth::user()->id }}"/>
						<div class="modal-body add-forgetten-modal-body">
							<?php /*?><select name="selectfranchise">
								<option value="">Select Franchise</option>
								@if($all_franchises->count())
									@foreach($all_franchises as $rec_franchise)
										<option value="{{ $rec_franchise->id }}">{{ $rec_franchise->location  }}</option>
									@endforeach
								@endif
							</select>
							@if($errors->has('selectfranchise'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('selectfranchise') }}</label>
                                </span>
							@endif<?php */?>

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
    
    <div class="poupup-main">
		<!-- Modal -->
		<div class="modal fade" id="myModalEdit" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content add-forgetten-modal-content EventModel">
					<div class="modal-header add-forgetten-modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Edit Event</h4>
					</div>
					<form action="{{ url('admin/trip_itinerary/update') }}" method="post" id="editnewevent">
						<input type="hidden" name="franchise_id" />
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
							
							<input name="starttime" type="text" placeholder="Start Time" id="edit_starttime" readonly />
							@if($errors->has('starttime'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('starttime') }}</label>
                                </span>
							@endif

							<input name="endtime" type="text" placeholder="End Time" id="edit_endtime" readonly />
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
							<input type="hidden" name="event_id" />
							<input class="btn add-franchise-data-butn-1" type="submit" value="Update Event">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	<div class="upcoming-contact-expiration franchise-list-main TripItineraryMainDiv">
		<h6>{{ $inner_title  }}</h6>

		<div class="view-tab-content-head-main">
    		<div class="view-tab-content-head">
    			<h3>Activity Calendar</h3>
    		</div>
    		<div class="view-tab-content-butn">
    			<!--<a href="{{ url('admin/trip_itinerary/edit/') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>-->&nbsp;
    		</div>
    		<div class="clearfix"></div>
    	</div>
    	
		<br/>
		<div class="row">
			<div class="col-sm-12">
				<form action="" method="get" id="trip_filters">
					<div class="super-admin-table-select col-sm-9">
						<input type="text" name="year" placeholder="Select Year" value="{{ Request::get('year') }}" class="datepicker_filter">
						<div class="super-admin-table-select-calender-icon TripItineraryViewCalendar">
							<i class="fa fa-calendar datepicker_filter" aria-hidden="true"></i>
						</div>
						
						<select name="month">
							<option value="">Select Month</option>
							@foreach($months as $key => $getMonth)
								<option @if(Request('monthh') == $key) selected @endif value="{{ $key }}">{{ $getMonth }}</option>
							@endforeach
						</select>
					</div>
					<div class="pull-right">
						<button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
						<a href="{{ url('admin/trip_itinerary') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filters</a>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>

		<div id='calendar2'></div>
	</div>

<script type="text/javascript">
	$(document).ready(function(){
		/*$('.datepicker').datetimepicker({
			pickerPosition: 'bottom-left',
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
        });*/
		$('.datepicker').datetimepicker({
			today:1,
			pickerPosition: 'bottom-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
			startDate: new Date(),
		});
		
		$('.datepicker_filter').datetimepicker({
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});
		
		/*$('#starttime').datetimepicker({
			minuteStep: 30,
			autoclose: true,
			minView: 0,
			maxView: 0,
			startView: 1,
			format: 'HH:ii P',
			showMeridian: 1,
			pickerPosition: 'bottom-left',
		});
	
		$('#endtime').datetimepicker({
			minuteStep: 30,
			autoclose: true,
			minView: 0,
			maxView: 1,
			startView: 1,
			format: 'HH:ii P',
			showMeridian: 1, 
			pickerPosition: 'bottom-left',
		});*/
		
		$('#addnewevent').validate({
			rules:{
				'selectadmin':{required:true},
				'eventdate':{required:true},
				'starttime':{required:true},
				'endtime':{required:true},
				'eventname':{required:true},
			}
		});
		
		$('#editnewevent').validate({
			rules:{
				'eventdate':{required:true},
				'starttime':{required:true},
				'endtime':{required:true},
				'eventname':{required:true},
			}
		});
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
@endsection
