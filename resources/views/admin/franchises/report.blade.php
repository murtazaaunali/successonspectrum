<html>
	<head>
		<title> Franchise Payment Report </title>
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.css') }}" />
	</head>
	
	<body>
<div class="container">
		<div class="form-group" style="margin-top: 10px;">
			<button class="btn btn-primary" onClick="printDiv();"><i class="fa fa-print"></i> Print</button>
			<a href="{{ url('admin/franchise/viewpayment/'.$franchise_id) }}" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i> Back</a>
			<div class="clearfix"></div>
		</div>
	<div id="DivIdToPrint">
		<table width="100%" border="1" class="table table-bordered">
			<tr>
				<th>Invoice Name</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Month</th>
				<th>Late Fee</th>
				<th>Comment</th>
				<th>Payment Recived</th>
				<th>Actions</th>
			</tr>
			@if(!$report->isEmpty())
				
				@foreach($report as $payment)
					<tr>
						<td>{{ $payment->invoice_name }}</td>
						<td>${{ $payment->amount }}@if($payment->invoice_name != 'Initial Franchise Fee' && $payment->invoice_name != 'Renewal Fee')/mo @endif </td>
						<td>{{ $payment->status }}</td>
						<td>{{ $payment->month }}</td>
						<td>@if($payment->late_fee) ${{ $payment->late_fee }} @endif</td>
						<td>{{ $payment->comment }}</td>
						<?php /*?><td>@if($payment->payment_recieved_on != '') {{ date('dS M Y',strtotime($payment->payment_recieved_on)) }} @endif</td><?php */?>
                        <td>@if($payment->payment_recieved_on != '') {{ date('m/d/Y',strtotime($payment->payment_recieved_on)) }} @endif</td>
						<td>{{ $payment->action }}</td>
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