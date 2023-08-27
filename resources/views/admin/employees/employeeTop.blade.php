		<div class="white-three-box-main">
			<div class="white-box-view-employee" style="width:49%">
				<div class="white-box-view-employee-left">
					<p>Upcoming Performance Review</p>
					@php
					$hiring_date			= $Employee->hiring_date;
					$current_date			= date("Y-m-d");
					//$employee_hiring_date	= date("d M Y",strtotime($hiring_date . " + 6 months"));
                    $employee_hiring_date	= date("m/d/Y",strtotime($hiring_date . " + 6 months"));

					while( strtotime($employee_hiring_date) < strtotime($current_date) )
					{
						//$employee_hiring_date	= date("d M Y",strtotime($employee_hiring_date . " + 6 months"));
                        $employee_hiring_date	= date("m/d/Y",strtotime($employee_hiring_date . " + 6 months"));
					}

					@endphp
					<b>{{ $employee_hiring_date }}</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="white-box-view-employee" style="width:49%;margin-right:0">
				<div class="white-box-view-employee-left">
					<p>Unplanned Call-ins Remaining</p>
					<b>{{ $Employee->performance_logs_current_year_unplanned_call_in($Employee)->count() }}/{{ $Employee->allowed_sick_leaves }}</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-frown-o" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="white-box-view-employee white-box-view-employee-mar hidden">
				<div class="white-box-view-employee-left">
					<p>Paid Time Off Remaining</p>
					<!--<b>0/{{ $Employee->paid_vacation }}</b>-->
                    <b>{{ $Employee->performance_logs_planned_time_off->count() }}/{{ $Employee->paid_vacation }}</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-umbrella" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>