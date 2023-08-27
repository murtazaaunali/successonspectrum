<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Admission Form</title>
</head>

<body>

<style>
.table
{
	width:100%;
	border-spacing: 0;
	text-align:left;
	border-collapse: collapse;
}
.table > tr
{
	display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}
.table-bordered
{
	border: 1px solid #DDDDDD;
}
.table > thead > tr > th
{
	padding:8px;
    border-top: 0;
	vertical-align: middle;
	border-bottom-width: 2px;
    background-color: #f7f7f7;
    border-bottom: 2px solid #ddd;
}
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td
{
	padding:8px;
	border-bottom: 0 !important;
	vertical-align: middle;
	border: 1px solid #DDDDDD;*
}	
</style>
	
	<p>WELCOME TO SUCCESS OF SPECTRUM!</p>
	
	<p style="color:#555">{{-- {!! $messages !!} --}}</p>


	<table width="100%" border="1" class="table table-bordered">
		<tr>
			<th colspan="3" align="center">Order #{{ $order->id }}</th>
		</tr>
		<tr>
			<td>Order Date</td>
			<td colspan="2">{{ date("jS M Y",strtotime($order->created_at)) }}</td>
		</tr>	
		<tr>
				<td rowspan="{{ count($order->order_products) }}">Items</td>
				@if($order->order_products)
				@php $count = 1; @endphp
					@foreach($order->order_products as $product)
					
					@if($count > 1)
						</tr><tr>
					@endif
						<td>{{$product->product_name}}</td>
						<td>x {{$product->quantity}}</td>
						@php $count++; @endphp
					@endforeach
				@endif				
			
		</tr>
		<tr>
			<td>Total Ammount</td>
			<td colspan="2">${{ $order->total_amount }}</td>
		</tr>
	</table>

	<p style="color:#555">Visit: <a href="{{-- $link --}}">http://sosapp.accunity.com</a></p>
</body>
</html>