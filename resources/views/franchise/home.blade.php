@extends('franchise.layout.main')

@section('content')
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif

	    <div class="main-deck-head">
	        <h4>{{$sub_title}}</h4>
	    </div>
		<!--<div class="main-deck-card-main FranchiseMainDeckMain">-->
        <div class="main-deck-card-main">
			<div class="main-deck-card main-deck-card-1">
				<div class="main-deck-card-text">
					<p>Active Employees</p>
					<b class="block-1">{{ $active_employees }}</b>
					<span>Employees on Vacation:</span>
					<b>{{ $emp_vacation }}</b><br /><br /><br />
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-1">
					<!--<i class="fa fa-building" aria-hidden="true"></i>-->
                    <i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="main-deck-card main-deck-card-2">
				<div class="main-deck-card-text">
					<p>Active Clients</p>
					<b class="block-1">{{ $active_clients }}</b>
					<!--<span>Waiting List:</span>
					<b>{{ $applicant_Clients }}</b>-->
                    <span>Ocean Waiting List:</span>
					<b>{{ $Total_Ocean_Clients }}</b><br />
                    <span>Voyager Waiting List:</span>
					<b>{{ $Total_Voyager_Clients }}</b><br />
                    <span>Sailor Waiting List:</span>
					<b>{{ $Total_Sailor_Clients }}</b>
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-2">
					<!--<i class="fa fa-times" aria-hidden="true"></i>-->
                    <i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="main-deck-card main-deck-card-4 hidden">
				@php 
                if(!empty($monthly_royalty_fee))
                {
                    if(empty($monthly_royalty_fee->payment_recieved_on))
                    {
                        $last_royalty_submission_fee = date('jS M Y',strtotime($monthly_royalty_fee->created_at."+1 months"));
                        $upcoming_royalty_submission_fee = date('jS M Y',strtotime($monthly_royalty_fee->created_at."+1 months"));
                    }
                    else
                    {
                        $last_royalty_submission_fee = date('jS M Y',strtotime($monthly_royalty_fee->payment_recieved_on));
                        $upcoming_royalty_submission_fee = date('jS M Y',strtotime($monthly_royalty_fee->payment_recieved_on."+1 months"));
                    }
                }
                
                if(!empty($monthly_system_advertising_fee))
                {
                    if(empty($monthly_system_advertising_fee->payment_recieved_on))
                    {
                        $last_system_advertising_submission_fee = date('jS M Y',strtotime($monthly_system_advertising_fee->created_at));
                        $upcoming_system_advertising_submission_fee = date('jS M Y',strtotime($monthly_system_advertising_fee->created_at."+1 months"));
                    }
                    else
                    {
                        $last_system_advertising_submission_fee = date('jS M Y',strtotime($monthly_system_advertising_fee->payment_recieved_on));
                        $upcoming_system_advertising_submission_fee = date('jS M Y',strtotime($monthly_system_advertising_fee->payment_recieved_on."+1 months"));
                    }   
                }             
                @endphp
                <div class="main-deck-card-text">
					<p>Upcoming Royalty Fee</p>
					@php 
						$day = '1st'; 
						$due_date = $Franchise->franchise_fees->fee_due_date;
						$due_date = $due_date.date('-m-Y');
						$royalty = date('jS M Y',strtotime($due_date.'+1 months'));
					@endphp
                    <b class="block-1">{{-- $upcoming_royalty_submission_fee --}} {{$day.date(' M Y',strtotime('+ 1 months')) }}</b>
					<span>Last Date of Submission: </span>
                    <b>{{-- $last_royalty_submission_fee --}} {{ $royalty }}</b>
				</div>
                
				<div class="main-deck-card-icon main-deck-card-icon-4">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="main-deck-card main-deck-card-5 hidden">
				<div class="main-deck-card-text">
					<p>Upcoming System Advertisment Fee</p>
                    <b class="block-1">{{-- $upcoming_system_advertising_submission_fee --}} {{$day.date(' M Y',strtotime('+ 1 months')) }}</b>
					<span>Last Date of Submission</span>
                    <b>{{-- $last_system_advertising_submission_fee --}} {{ $royalty }}</b>
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-5">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
            <div class="main-deck-card main-deck-card-3">
				<div class="main-deck-card-text">
					<p>Ocean Scheduled Hours</p>
                    <b class="block-1">0</b><br /><br /><br />
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-5">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
            <div class="main-deck-card main-deck-card-4">
				<div class="main-deck-card-text">
					<p>Voyager Scheduled Hours</p>
                    <b class="block-1">0</b><br /><br /><br />
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-5">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
            <div class="main-deck-card main-deck-card-5">
				<div class="main-deck-card-text">
					<p>Sailor Scheduled Hours</p>
                    <b class="block-1">0</b><br /><br /><br />
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-5">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="upcoming-contact-expiration MargBot10">
			<h6>Members Activity</h6>
			<!--<div id="chartContainer" style="height: 370px; width: 100%; margin: 0px auto;"></div>-->
			<div id="chart1" style="margin-top:20px; margin:auto; width:100%; height:300px;"></div>
			
			<div class="infoMain">
				<div id="clients"><div class="client_square"></div><b>Clients:</b> 0</div>
				<div id="employees"><div class="employee_square"></div><b>Employee:</b> 0</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 MainDeckLeftColPadd">
					<div class="upcoming-contact-expiration">
						<h6>Clients</h6>
						<!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
						<div class="super-admin-table-1 table-responsive MainDackTableWidth">
							<table class="table-striped">
								<tr>
									<th>Name</th>
									<th>Auth Exp</th>
									<th>Asses Exp</th>
									<th>Crew</th>
								</tr>
								@if(!$DashClients->isEmpty())
									@foreach($DashClients as $client)
									<tr>
										<td>{{ $client->client_childfullname }}</td>
										<td>@if($client->client_authorizationseenddate != "" && $client->client_authorizationseenddate != '0000-00-00') {{ date('jS M Y',strtotime($client->client_authorizationseenddate)) }} @endif</td>
										<td>@if($client->client_authorizationsreassessment != "" && $client->client_authorizationsreassessment != '0000-00-00') {{ date('jS M Y',strtotime($client->client_authorizationsreassessment)) }} @endif</td>
										<td>@if($client->client_crew) @if($client->ClientCrew) {{ $client->ClientCrew->crew_type }} @endif @else - @endif</td>
									</tr>
									@endforeach
								@else
									<tr><td colspan="2">No record found.</td></tr>
								@endif
								
							</table>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-para">
				            	@if($DashClients->firstItem())
				                <p>Showing {{ $DashClients->firstItem() }} to {{ $DashClients->lastItem() }} of {{ $DashClients->total() }} entries</p>
				                @else
				                <p>Showing 0 Entries</p>
				                @endif
							</div>
							<div class="super-admin-table-bottom-pagination">
								{!! $DashClients->appends(request()->query())->links() !!}
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="col-md-6 MainDeckRightColPadd">
					<div class="upcoming-contact-expiration">
						<h6>Employees</h6>
						<!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
						<div class="super-admin-table-1 table-responsive MainDackTableWidth">
							<table class="table-striped">
								<tr>
									<th>Name</th>
									<th>BACB Exp</th>
									<th>CPR Exp</th>
									<th>Perform Review</th>
									<th>Crew</th>
								</tr>
								
								@if(!$DashEmployees->isEmpty())
									@foreach($DashEmployees as $emp)
									<tr>
										<td>{{ $emp->personal_name }}</td>
										<td>@if($emp->bacb_regist_date) {{ date('d/m/Y', strtotime($emp->bacb_regist_date)) }} @else - @endif</td>
										<td>@if($emp->cpr_regist_date) {{ date('d/m/Y', strtotime($emp->cpr_regist_date.'+1 year')) }} @else - @endif</td>
										<td>{{ date('d/m/Y', strtotime($emp->upcomming_performance)) }}</td>
										<td>@if($emp->crew_type) {{ $emp->crew_type }} @else - @endif</td>
									</tr>								
									@endforeach
								@else
									<tr><td colspan="3">No record found.</td></tr>
								@endif
								
							</table>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-para">
				            	@if($DashEmployees->firstItem())
				                <p>Showing {{ $DashEmployees->firstItem() }} to {{ $DashEmployees->lastItem() }} of {{ $DashEmployees->total() }} entries</p>
				                @else
				                <p>Showing 0 Entries</p>
				                @endif
							</div>
							<div class="super-admin-table-bottom-pagination">
								{!! $DashEmployees->appends(request()->query())->links() !!}
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>



<script type="text/javascript" src="{{ asset('assets/js/canvas.js') }}"></script>
    <link class="include" rel="stylesheet" type="text/css" href="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.css" />

<script>
$(document).ready(function() {
	var current_date = new Date();
	var months_name = new Array("January","February","March","April","May","June","Jully","August","September","October","November","December");
	//Creating Employees Json Object	
	var employees = @php echo $employees; @endphp;
	var Emp = new Array();
	$.each(employees,function(key,val){
		var date = new Date(val.x);
		Emp.push({'x':new Date(val.x), 'y':val.y});
		//Emp.push({'x':date.getDate(), 'y':val.y});
	});
	console.log(Emp);

	//Creating Clients Json Object	
	/*var clients = @php echo $clients; @endphp;
	var Cli = new Array();
	$.each(clients,function(key,val){
		var date = new Date(val.x);
		Cli.push({'x':new Date(val.x), 'y':val.y});
		//Cli.push({'x':date.getDate(), 'y':val.y});
	});

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
			title: months_name[current_date.getMonth()]+" "+current_date.getFullYear(),
			//margin:5,
			interval: 1,
			includeZero: false,
			valueFormatString:  "DD"
		},
		axisY: {
			title: "",
			titleFontColor: "#4F81BC",
			lineColor: "#4F81BC",
			labelFontColor: "#4F81BC",
			tickColor: "#4F81BC",
			includeZero: false,
			interval: 1
		},

		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [{
			//type: "spline",
			type: "column",
			name: "Employees",
			//axisYType: "secondary",//extra line
			showInLegend: true,
			xValueFormatString: "DD MMM YYYY",
			//yValueFormatString: "#,##0.#",
			dataPoints: Emp,
		},
		{
			//type: "spline",
			type: "column",
			name: "Clients",
			//axisYType: "secondary",
			showInLegend: true,

			xValueFormatString: "DD MMM YYYY",
			//yValueFormatString: "#,##0.#",
			dataPoints: Cli,
		}]
	};

	$("#chartContainer").CanvasJSChart(options);
	function toggleDataSeries(e) {
		if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		} else {
			e.dataSeries.visible = true;
		}
		e.chart.render();
	}*/
	
});

</script>

<script class="code" type="text/javascript">
$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var GraphData = @php echo $GraphData; @endphp;
		//GETTING DAYS
		var days = new Array();
		$.each(GraphData.days,function(key,val){
			days.push(val);
		});

		//GETTING EMPLOYEE
		var Employees = new Array();
		$.each(GraphData.employees,function(key,val){
			Employees.push(val);
		});
		
		//GETTING Clients
		var Clients = new Array();
		$.each(GraphData.clients,function(key,val){
			Clients.push(val);
		});


        var clients = Clients;
        var employees = Employees;
        var ticks = days;
         
        plot1 = $.jqplot('chart1', [clients, employees], {
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
     
        $('#chart1').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
            	
				var value = data.toString().split(',');
            	if(seriesIndex == 1){
					$('#employees').html('<div class="employee_square"></div><b>Employees:</b> '+value[1]);
				}else{
					$('#clients').html('<div class="client_square"></div><b>Clients:</b> '+value[1]);
				}
            }
        );


        $('#chart1').bind('jqplotDataUnhighlight', 
            function (ev) {
            	$('#employees').html('<div class="employee_square"></div><b>Employees:</b> '+0);
                $('#clients').html('<div class="client_square"></div><b>Clients:</b> '+0);
            }
        );
    });
</script>

<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.js"></script>
<!-- Additional plugins go here -->

<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.barRenderer.min.js"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	
@endsection

