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

	

	
	<div class="clearfix"></div>
	
    <div class="add-franchise-super-main">
        @include('femployee.trip_itinerary.top')
        
        <div class="add-franchise-data-main-1 PerformanceNone">
            <ul class="nav nav-tabs">
                <li class=""><a href="{{ url('femployee/trip_itinerary') }}">Work Schdule</a></li>
                <li class=""><a href="#">Calendar</a></li>
                <li class=""><a href="{{ url('femployee/trip_itinerary/timepunches') }}">Time Punches</a></li>
            </ul>
            <div class="tab-content">
              
                <div id="Calendar" class="tab-pane fade in active">
                    <div class="TripItineraryMainDiv">
                        <div class="view-tab-content-head-main">
                            <div class="view-tab-content-head">
                                <h3>Event Calendar</h3>
                            </div>
                            <!--<div class="view-tab-content-butn">
                                <a href="{{ url('femployee/trip_itinerary/edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
                            </div>-->
                            <div class="clearfix"></div>
                        </div>
                        <br/>
                        <div class="row hidden">
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
                                        <a href="{{ url('femployee/trip_itinerary') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filters</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                        <div id='calendar2'></div>
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
	$(document).ready(function(){
		
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
@endsection
