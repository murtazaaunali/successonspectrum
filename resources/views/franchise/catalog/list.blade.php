@extends('franchise.layout.main')

@section('content')
	<div class="main-deck-head main-deck-head-franchise">
		<h4>{{$sub_title}}</h4>
	</div>

	<div class="clearfix"></div>

	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif

	@if(Session::has('Error'))
		{!! session('Error') !!}
	@endif
	
	<div class="franchise-list-main">
		<h6>{{ $inner_title }}</h6>
		<div class="super-admin-table-2 table-responsive">
			<table>
				<tr>
					<th class="width15">Item</th>
					<th>Qty</th>
					<th class="super-admin-table-position-1">Amount</th>
				</tr>

				@php $total = 0; @endphp				
				@if(!empty($products))
				<form id="cart" method="post" action="{{ url('franchise/updatecart') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					@foreach($products as $product)
					<tr>
						<td>{{ $product['name'] }}</td>
						<td width="10%"><input type="number" min="0" name="quantity[{{ $product['product_id']}}]" class="form-control quantity" value="{{ $product['quantity'] }}" /></td>
						<td class="text-right super-admin-table-position-1">${{ $product['selling_price'] }}</td>
					</tr>
					@php $total = $total + $product['selling_price']; @endphp
					@endforeach
				</form>
				@else
					<tr><td colspan="3">Empty Cart.</td></tr>
				@endif
			</table>
			
			
			<br /><br />
			
			<div class="col-sm-4 text-right col-sm-offset-8">

				<strong class="pull-left">Tax</strong>
				<strong class="pull-right">@if(session('tax') > 0) ${{ number_format((float) session('tax'), 2, '.', '') }} @else 0 @endif</strong>
				<div class="clearfix"></div>
				<hr />

				<strong class="pull-left">Total</strong>
				<strong class="pull-right">${{ number_format((float)$total + session('tax'), 2, '.', '') }}</strong>
				<div class="clearfix"></div>
				<hr />
				<form method="post" action="{{ url('franchise/checkout') }}">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<br />
					<button type="submit" class="btn add-franchise-data-butn"><i class="fa fa-shopping-cart"></i> Checkout</button>
				</form>
			</div>
			
		</div>
	</div>

	


<script type="text/javascript">
	$('.quantity').change(function(){
		$('#cart').submit();
	});
	/*jQuery.validator.setDefaults({
	  debug: true,
	  success: "valid"
	});
	$( "#cart" ).validate({
		rules:{
			'quantity[]':{min:1}
		}
	});
	
    $(".quantity").each(function(){
    	$(this).rules("add", {
    		min:1
    		messages: {
    			phoneUS:'Please Enter a Valid Phone Number. (Eg: xxx-xxx-xxxx)',
    		}
    	}); 
    });*/
	
</script>

@endsection

@push('js')
@endpush