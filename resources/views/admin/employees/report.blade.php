<html>
	<head>
		<title> Employee Punch Report </title>
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.css') }}" />
	</head>
	
<body>

<div class="container">
		<div class="form-group" style="margin-top: 10px;">
			<button class="btn btn-primary" onClick="printDiv();"><i class="fa fa-print"></i> Print</button>
			<a href="{{ url('admin/employee/viewtimepunches/'.$employee_id.'?tab=timepunches') }}" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i> Back</a>
			<div class="clearfix"></div>
		</div>
	<div id="DivIdToPrint">
		<table width="100%" border="1" class="table table-bordered">
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
			@if(!$report->isEmpty())
				
				@foreach($report as $timepunch)
					<tr>
						<!--<td>{{ date('dS M Y', strtotime($timepunch->date)) }}</td>-->
                        <td>{{ date('m/d/Y', strtotime($timepunch->date)) }}</td>
						<td>{{ $timepunch->day }}</td>
						<td>{{ date('h:i A',strtotime($timepunch->time_in)) }}</td>
						<td>{{ date('h:i A',strtotime($timepunch->time_out)) }}</td>
						<td>{{ $timepunch->total_hrs }}</td>
						<td>{{ $timepunch->overtime_hrs }}</td>
						<td>{{ $timepunch->pto }}</td>
						<td>{{ $timepunch->remarks }}</td>
					</tr>
				@endforeach
			@else
				<tr><td colspan="8">No Payment Records Found.</td></tr>	
			@endif
			
		</table>
	</div>
</div>

<script type="text/javascript">
	function printDiv(){
		var divToPrint=document.getElementById('DivIdToPrint');
		var newWin=window.open('','Print-Window');
		newWin.document.open();
		newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
		newWin.document.close();
		setTimeout(function(){newWin.close();},10);
	}	
</script>
	</body>
</html>