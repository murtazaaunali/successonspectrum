@extends('parent.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
			<p>Client / <span id="change-bread-crumb">Session Logs</span></p>
		</div>

		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('parent.client.clientTop')	

			<div class="tab-content">
				
				<div id="task-list" class="tab-pane fade in active">

                       <div class="view-tab-content-head-main view-tab-content-head-main-padd">
                            <div class="view-tab-content-head">
                                <h3>Sessions Logs</h3>
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
								<a href="#" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
							</div>
						</form>
					</div> 
                    <div class="EmployeeTrimitinerayViewTablePadd">
	                    <div class="super-admin-table-1 table-responsive">
							<table class="table-striped">
								<tr>
									<th>Date</th>
									<th>Days</th>
									<th>Location</th>
									<th>Time In</th>
									<th>Time Out</th>
									<th>Authorized Person</th>
								</tr>
	                            <tr>
	                                <td>01 Jan 2019</td>
	                                <td>Sunday</td>
	                                <td>-</td>
	                                <td>09:00 AM</td>
	                                <td>5:00 PM</td>
	                                <td>Martha Stewert, Mother</td>
	                            </tr>
	                            <tr>
	                                <td>01 Jan 2019</td>
	                                <td>Sunday</td>
	                                <td>-</td>
	                                <td>09:00 AM</td>
	                                <td>5:00 PM</td>
	                                <td>Martha Stewert, Mother</td>
	                            </tr>
	                            <tr>
	                                <td>01 Jan 2019</td>
	                                <td>Sunday</td>
	                                <td>-</td>
	                                <td>09:00 AM</td>
	                                <td>5:00 PM</td>
	                                <td>Martha Stewert, Mother</td>
	                            </tr>                            
							</table>
						</div>
					</div>
					
				</div>
		
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	

@endsection
