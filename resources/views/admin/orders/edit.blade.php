@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<h6>{{$sub_title}}</h6>
		<p>
			<a href="{{ route('admin.catalogue') }}">Catalog </a> / <a href="{{ route('admin.orders_list') }}">Orders</a>
			Order Details
		</p>
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

	<form method="POST" action="{{ route('admin.order_save') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="add-franchise-super-main">
			<div class="add-franchise-data-main-1 add-franchise-data-main-2">
				<div id="franchise-demography" class="tab-pane fade in active">
					<div class="view-tab-content-main">
						<div class="view-tab-content-head-main view-tab-content-head-main-3 add-owner-bar-main">
							<div class="view-tab-content-head add-owner-bar-head">
								<h3>{{ $inner_title }}</h3>
							</div>
							<div class="view-tab-content-butn">
								<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Update Order</button>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="super-admin-add-relation-main order-history">
							<h2>Order #{{ $order->id }} details</h2>
							<div class="view-tab-content mar0">
								<figure>
									<h5>Status</h5>
									<select class="DeliveredOption" name="status">
										<option value="">Select Status</option>
										<option value="Pending" @if($order->status == "Pending") selected="" @endif>Pending</option>
										<option value="In Transit" @if($order->status == "In Transit") selected="" @endif>In Transit</option>
										<option value="Cancelled" @if($order->status == "Cancelled") selected="" @endif>Cancelled</option>
										<option value="Delivered" @if($order->status == "Delivered") selected="" @endif>Delivered</option>
									</select>
									<input type="hidden" value="{{ $order->id }}" name="order_id" />
									<label class="clearfix"></label>
								</figure>

								<figure>
									<h5>Order Date</h5>
									<!--<h6>{{ date("jS M Y",strtotime($order->created_at)) }}</h6>-->
                                    <h6>{{ date("m/d/Y",strtotime($order->created_at)) }}</h6>
									<label class="clearfix"></label>
								</figure>

								<figure>
									<div class="row">
										<div class="col-sm-4">
											<h5>Item (s)</h5>
										</div>
										<div class="col-sm-8 order-view-item">
											@if($order->order_products)
												@foreach($order->order_products as $product)
													<div class="col-sm-8">
														<h6>{{$product->product_name}}</h6>
													</div>
													<div class="col-sm-4">
														<h6><span>x {{$product->quantity}}</span></h6>
													</div>
													<div class="clearfix"></div>
												@endforeach
											@endif
										</div>
									</div>
									<label class="clearfix"></label>
								</figure>

								<figure>
									<h5>Total Ammount</h5>
									<h6>${{ $order->total_amount }}</h6>
									<label class="clearfix"></label>
								</figure>

								@if($order->franchise_id)
									<figure>
										<h5>Franchise Name</h5>
										<h6>@if($order->order_franchise) {{ $order->order_franchise->location }} @endif</h6>
										<label class="clearfix"></label>
									</figure>

									<figure>
										<h5>Franchise Location</h5>
										<h6>@if($order->order_franchise) {{ $order->order_franchise->address }} @else &nbsp; @endif </h6>
										<label class="clearfix"></label>
									</figure>
								@endif
								<figure class="border-bot-0">
									<h5>Leave a Note</h5>
									<h6>
										<textarea class="TextareaWid" style="margin: 0px; width: 344px; height: 117px;" placeholder="Leave a Note" name="comment">{{ $order->comment }}</textarea>
									</h6>
									<label class="clearfix"></label>
								</figure>
								<div class="padd-view"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection