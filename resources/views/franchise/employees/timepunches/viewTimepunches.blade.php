@extends('franchise.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<!--<h6>{{ $Employee->fullname }}</h6>
			<p>Employee / {{ $Employee->fullname }} / <span id="change-bread-crumb">Time Punches</span></p>-->
            <h6>{{ $Employee->personal_name }}</h6>
			<p>Employee / {{ $Employee->personal_name }} / <span id="change-bread-crumb">Time Punches</span></p>
		</div>
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('franchise.employees.employeeTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			<ul class="nav nav-tabs">
			  <li class="padd-left-anchor"><a href="{{ url('franchise/employee/view/'.$Employee->id) }}">Employee Demographic</a></li>
			  <li class="trigger-5"><a href="{{ url('franchise/employee/viewtasklist/'.$Employee->id) }}">Task List</a></li>
			  <li class="trigger "><a href="{{ url('franchise/employee/viewtripitinerary/'.$Employee->id) }}" >Trip Itinerary</a></li>
			  <li class="trigger task-btn active"><a href="#">Time Punches</a></li>
			  <li class="trigger-1"><a href="{{ url('franchise/employee/viewperformancelog/'.$Employee->id) }}">Performance Log</a></li>
			</ul>

			<div class="tab-content">
				
				<div id="time-punches" class="tab-pane fade  in active ">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming EmployeeTimepunchesMainDiv">
				    	<div class="view-tab-content-head-main view-tab-content-head-main-padd">
				    		<div class="view-tab-content-head">
				    			<!--<h3>{{ $Employee->fullname }}'s Time Punches</h3>-->
                                <h3>{{ $Employee->personal_name }}'s Time Punches</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="#" data-target="#myModal-1" data-toggle="modal" class="btn btn-2"><i class="fa fa-print" aria-hidden="true"></i></a>
				    			<a href="#" data-target="#view-hourslog-graph" data-toggle="modal"  class="btn btn-2"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>
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
								<div class="ButtonsPullRightRisponsive">
									<button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
									<a href="{{ url('franchise/employee/viewtimepunches/'.$Employee->id) }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
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
								@if($total_hours)
									<b> @if($total_hours > 1) {{ $total_hours }} hours @else {{ $total_hours }} hour @endif @if($TotalMinutes) {{ $TotalMinutes }} minutes @endif</b>
								@else
									<b>{{ $total_hours }} hour</b>
								@endif
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
						</div>
						<div class="clearfix"></div>
					</div> 
				</div>
				
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	<div class="poupup-main">
	  <!-- Trigger the modal with a button -->


	   <!-- ============== Modal for performance log ================ -->
	  <div class="modal fade ForgottenTimePunchPopup" id="myModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Add a Forgotten Time Punch</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body pos-rel">
	          <form action="{{ url('franchise/employee/addtimepunch/'.$Employee->id) }}" method="post" id="TimePunch">
		          <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          
		          <input type="text" placeholder="Date" name="date" class="TimePunchDate" autocomplete="off">
		          <i class="fa fa-calendar pos-abs-popup-caleder TimePunchDate" aria-hidden="true"></i>
		          <input type="text" placeholder="Time In" name="time_in" class="TimePunchTime" id="add_time_in" autocomplete="off">
		          <input type="text" placeholder="Time Out" name="time_out" class="TimePunchTime" id="add_time_out" autocomplete="off">
		          
		          <input class="btn add-franchise-data-butn-1" type="submit" value="Add Forgotten Time Punch">
	          </form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	  <!-- ============== Modal for performance log ================ -->
	</div>
	<div class="poupup-main">
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
	          	<form action="{{ url('franchise/employee/printreport/'.$Employee->id) }}" method="post" id="printReport">
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
                <div id="graph-hours-count"><div class="hours_square"></div><b>Hours:</b> 0</div>
                <div class="clearfix"></div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	
<script type="text/javascript">
	$('document').ready(function(){
		
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
				url:'{{ url("franchise/employee/getweeks/") }}',
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
		
	});

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

</script>

@if(Auth::guard('franchise')->check())
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endif

<script>
window.onload = function () {
	
//Creating Hours Log Json Object
var HoursLog = [];
//var HoursLog = new Array();
var hours_logs = @php echo $hours_logs; @endphp;	
$.each(hours_logs,function(key,val){
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
//$("#hours-log-chart-container").CanvasJSChart(options);
}
</script>

<!-- JQPlot plugin files -->
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.css" />
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.barRenderer.min.js"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<!-- JQPlot plugin files -->

<script class="code" type="text/javascript">
$('#view-hourslog-graph').on('shown.bs.modal', function (e) {
    //alert('modal shown');
	$.jqplot.config.enablePlugins = true;
	var GraphData = @php echo $hours_logs; @endphp;
	//GETTING DATES
	var Dates = new Array();
	$.each(GraphData,function(key,val){
		var date = new Date(val.x);
		var date = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear();Dates.push(date);
	});
	console.log(Dates);

	//GETTING HOURS
	var Hours = new Array();
	$.each(GraphData,function(key,val){
		Hours.push(Number(val.y));
	});
	console.log(Hours);
	
	var hours = Hours;
	var ticks = Dates;
	 
	plot1 = $.jqplot('hours-log-chart-container', [hours], {
		// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
		animate: !$.jqplot.use_excanvas,
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		//highlighter: { show: false }
	});
 
	$('#hours-log-chart-container').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			var value = data.toString().split(',');
			$('#graph-hours-count').html('<div class="hours_square"></div><b>Hours:</b> '+value[1]);
		}
	);

	$('#hours-log-chart-container').bind('jqplotDataUnhighlight', 
		function (ev) {
			$('#graph-hours-count').html('<div class="hours_square"></div><b>Hours:</b> '+0);
		}
	);
});
</script>
@endsection
