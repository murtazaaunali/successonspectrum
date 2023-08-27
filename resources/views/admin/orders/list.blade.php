@extends('admin.layout.main')

@section('content')
	<div class="main-deck-head main-deck-head-franchise Catalogue">
		<h4>{{$sub_title}}</h4>
		<p><a href="{{ url('admin/catalogue') }}">Catalog </a> / Orders</p>
	</div>
	<div class="clearfix"></div>

	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	@if ($errors->any())
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form method="GET" action="{{ route("admin.orders_list") }}" id="order_search">
		<div class="frnchise-select-main order_main">
			<div class="order-date">
				<label>Search by Order ID</label>
				<input type="text" name="order" placeholder="Order ID" @if(Request::has('order')) value="{{ Request::get('order') }}" @endif />
			</div>
			<div class="order-date">
				<label>Search by Franchise Name</label>
				<select name="franchise">
					<option value="">Select Franchise</option>
					@if($all_franchises->count())
						@foreach($all_franchises as $rec_franchise)
							<option value="{{ $rec_franchise->id }}" @if(Request::has('franchise')) @if(Request::get('franchise') == $rec_franchise->id) selected="" @endif @endif>{{ $rec_franchise->location  }}</option>
						@endforeach
					@endif
				</select>
			</div>
			<div class="order-date">
				<label>Search by Status</label>
				<select name="status">
					<option value="">Select Status</option>
					<option value="Pending" @if(Request::has('status')) @if(Request::get('status') == "Pending") selected="" @endif @endif>Pending</option>
					<option value="In Transit" @if(Request::has('status')) @if(Request::get('status') == "In Transit") selected="" @endif @endif>In Transit</option>
					<option value="Cancelled" @if(Request::has('status')) @if(Request::get('status') == "Cancelled") selected="" @endif @endif>Cancelled</option>
					<option value="Delivered" @if(Request::has('status')) @if(Request::get('status') == "Delivered") selected="" @endif @endif>Delivered</option>
				</select>
			</div>
			<div class="order-date">
				<label>Search by Date From</label>
				<input type="text" id="datefrom" name="start_date" placeholder="Date From" @if(Request::has('start_date')) value="{{ Request::get('start_date') }}" @endif class="datefrom"/>
				<a><i class="fa fa-calendar datefrom" aria-hidden="true"></i></a>
			</div>
			<div class="order-date">
				<label>Search by Date To</label>
				<input type="text" id="dateto" name="end_date" placeholder="Date To" @if(Request::has('end_date')) value="{{ Request::get('end_date') }}" @endif class="dateto"/>
				<a><i class="fa fa-calendar dateto" aria-hidden="true"></i></a>
			</div>

			<div class="fiter-butn-main">
				<button class="btn franchise-search-butn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
				<a href="{{ route('admin.orders_list')  }}@if(Request::has('page'))?page={{ Request::get('page')  }}@endif" class="btn francse-filter-butn  butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>


	<div class="upcoming-contact-expiration franchise-list-main">
		<h6>{{ $inner_title  }}</h6>
		<!--<div class="super-admin-table-2 table-responsive">-->
        <div class="super-admin-table-1 table-responsive">

			<table>
				<thead>
					<tr>
						<th>Order ID</th>
						<th>Location</th>
						<th>Status</th>
						<th>Date</th>
						<th>Total Amount</th>
						<th>Comment</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
					@if($orders->count())
						@foreach($orders as $order)
							<tr class="super-admin-table-row-back">
								<td>{{ $order->id }}</td>
								<td>@if(isset($order->order_franchise->location)) {{ $order->order_franchise->location  }} @else - @endif</td>
								<td @if($order->status == "Cancelled") style="color: #fa6961;" @elseif($order->status == "In Transit") style="color: #eca246;" @elseif($order->status == "Delivered") style="color: #5ddf9e;" @endif>{{ $order->status }}</td>
								<!--<td>{{ date("d M Y",strtotime($order->created_at)) }}</td>-->
                                <td>{{ date("m/d/Y",strtotime($order->created_at)) }}</td>
								<td>$ {{ $order->total_amount }}</td>
								<td>@if($order->comment) {{ substr($order->comment, 0, 20) .((strlen($order->comment) > 20) ? '...' : '')  }} @else - @endif</td>
								<td>
									<a href="{{ route('admin.view_order',['id'=>$order->id]) }}" class="grey-clr mar-right-5"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="{{ route('admin.edit_order',['id'=>$order->id]) }}" class="grey-clr"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</td>
							</tr>
						@endforeach
					@else
						<tr><td colspan="7">No Orders found.</td></tr>
					@endif
				</tbody>
			</table>
		</div>

		<div class="super-admin-table-bottom">
			<div class="super-admin-table-bottom-para">
				@if($orders->firstItem())
					<p>Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries</p>
				@else
					<p>Showing 0 Entries</p>
				@endif
			</div>
			<div class="super-admin-table-bottom-pagination">
				{!! $orders->appends(request()->query())->links() !!}
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

@endsection

@push('js')
<script type="text/javascript">
		$(".datefrom").datetimepicker({
		//$("#datefrom").datetimepicker({
			today:  1,
			autoclose: true,
			format: 'dd/mm/yyyy',
			maxView: 4,
			minView: 2,
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        $('#dateto').datetimepicker('setStartDate', minDate);
	    });
	    //$("#dateto").datetimepicker({
		$(".dateto").datetimepicker({	
	        autoclose: true,
	        format: 'dd/mm/yyyy',
		    maxView: 4,
		    minView: 2,  	
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        $('#datefrom').datetimepicker('setEndDate', minDate);
	    });
	    
		//Filters
		$("#order_search").on("submit",function(e){
		    e.preventDefault();
		    var url = $(this).attr("action");

		    var filter_order        = $('input[name=\'order\']').val();
		    var filter_franchise    = $('select[name=\'franchise\']').val();
		    var filter_status       = $('select[name=\'status\']').val();
		    var start_date          = $('input[name=\'start_date\']').val();
		    var end_date            = $('input[name=\'end_date\']').val();

		    if(filter_order == "" && filter_franchise == "" && filter_status == "" && start_date == "" && end_date == "")
		    {
		        alert("Please Select Filter Options");
		        return false;
		    }
		    else
		    {
		        url += '?';
		    }

		    if(filter_order != "")
		    {
		        url += 'order=' + encodeURIComponent(filter_order);
		    }

		    if(filter_franchise != "")
		    {
		        if(filter_order != "")
		            url += '&';
		        url += 'franchise=' + encodeURIComponent(filter_franchise);
		    }

		    if(filter_status != "")
		    {
		        if(filter_franchise != "" || filter_order != "")
		            url += '&';
		        url += 'status=' + encodeURIComponent(filter_status);
		    }

		    if(start_date != "")
		    {
		        if(filter_franchise != "" || filter_order != "" || filter_status != "")
		            url += '&';
		        url += 'start_date=' + encodeURIComponent(start_date);
		    }

		    if(end_date != "")
		    {
		        if(filter_franchise != "" || filter_order != "" || filter_status != "" || start_date != "")
		            url += '&';
		        url += 'end_date=' + encodeURIComponent(end_date);
		    }

		    window.location = url;
		})
	    
</script>
@endpush