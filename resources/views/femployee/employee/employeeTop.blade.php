		<div class="white-three-box-main">
			<div class="white-box-view-employee">
				<div class="white-box-view-employee-left">
					<p>Upcoming Performance Review</p>
					@php
					$hiring_date			= $Employee->hiring_date;
					$current_date			= date("Y-m-d");
					$employee_hiring_date	= date("d M Y",strtotime($hiring_date . " + 6 months"));

					while( strtotime($employee_hiring_date) < strtotime($current_date) )
					{
						$employee_hiring_date	= date("d M Y",strtotime($employee_hiring_date . " + 6 months"));
					}

					@endphp
					<b>{{ $employee_hiring_date }}</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="white-box-view-employee">
				<div class="white-box-view-employee-left">
					<p>Unplanned Call-ins Remaining</p>
					<b>0/6</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-frown-o" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="white-box-view-employee white-box-view-employee-mar">
				<div class="white-box-view-employee-left">
					<p>Paid Time Off Remaining</p>
					<b>8/{{ $Employee->career_paid_vacation }}</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-umbrella" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>