		<div class="white-three-box-main">
			<div class="white-box-view-employee">
				<div class="white-box-view-employee-left">
					<p>Upcoming Performance Review</p>
					@php
					/*$hiring_date			= $Employee->hiring_date;
					$current_date			= date("Y-m-d");
					$employee_hiring_date	= date("d M Y",strtotime($hiring_date . " + 6 months"));

					while( strtotime($employee_hiring_date) < strtotime($current_date) )
					{
						$employee_hiring_date	= date("d M Y",strtotime($employee_hiring_date . " + 6 months"));
					}*/
					
                    $upcomming_performance	= $Employee->upcomming_performance;
					@endphp
					<?php /*?><b>{{ $employee_hiring_date }}</b><?php */?>
                    <b>@if($upcomming_performance != "" && $upcomming_performance != '0000-00-00'){{ date('jS M Y',strtotime($upcomming_performance)) }} @else &nbsp; @endif</b>
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
					<b>0/@if($Employee->career_paid_vacation){{ $Employee->career_paid_vacation }}@else{{0}}@endif</b>
				</div>
				<div class="white-box-view-employee-right">
					<i class="fa fa-umbrella" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>