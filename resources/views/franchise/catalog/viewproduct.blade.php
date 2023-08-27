@extends('franchise.layout.main')

@section('content')

		<!-- header-bottom-sec -->
		<div class="add-franchise-super-main CatalogueProductView">
			<div class="view-tab-control float-none">
				<div class="main-deck-head main-deck-head-franchise Catalogue">
					<h6>Catalog</h6>
					<p><a href="{{ url('franchise/catalogue') }}">Catalog </a> / Product / View</p>
				</div>
				
				<div class="add-franchise-butn-main add-product-butn-main MargTop8 MargBot10">
					<a href="{{ url('franchise/viewcart') }}" class="btn CartBadge"><i class="fa fa-shopping-cart" aria-hidden="true"></i>View Cart <span class="badge badge-light"></span></a>
				</div>
				<div class="clearfix"></div>
			</div>
			
			@if(Session::has('Success'))
				{!! session('Success') !!}
			@endif			
			
			<div class="upload-document-cargo-head add-product-view"> <h4>SOS Product Details</h4></div>
			<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload spinner_main">
			
    			<div class="spinner_inner" style="padding-top: 5%;">
    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
    				Adding to cart.	
    			</div>
    						
				<div class="row">
					<div id="product-main-image-column" class="col-sm-4">
                        <!--@if($product->image)
                            <img class="r-img" src="{{ url($product->image) }}">
                        @else
                            <img src="{{ asset('assets/images/product_placeholder.png') }}">
                        @endif-->
                        <div class="ThumbnailMargin">
                            <div id="product-main-image-cover" class="pImageCover">
                                @if($product->image)
                                    <img class="r-img img-responsive" src="{{ url($product->image) }}">
                                @else
                                    <img src="{{ asset('assets/images/product_placeholder.png') }}" class="img-responsive">
                                @endif
                            </div>
                            <div class="clearfix"></div> 
                        </div>   
                        <div class="clearfix"></div>						
						@if(!$product->gallery->isEmpty())
						<div class="owl-carousel product-slider">
							@if($product->image)
							    <div class="item">
							        <img class="thumb-img img-responsive" src="{{ url($product->image) }}" alt="photo by Barn Images">
							    </div>
							@endif
						    @foreach($product->gallery as $image)
						    <div class="item">
						        <img class="thumb-img img-responsive" src="{{ $image->image_path }}" alt="photo by Barn Images">
						    </div>
						    @endforeach
						</div>
						@endif
					</div>
					<div class="col-sm-8">
						<div class="t-shirt-description-main description-box-text">
							<h2>@if($product->product_category_id) {{ $product->product_category->category_name }} @endif</h2>
							<h3>{{ $product->product_name }}</h3>
							<h4>${{ $product->selling_price }}</h4>
							<p>{{ $product->product_description }}</p>
							<br>

							<div class="row">
								<div class="col-sm-8">
									
									<div class="row">
										<div class="col-sm-6">
											<label class="pull-left" style="width:30px;">QTY</label>
											<input type="number" class="pull-left" value="1" name="quantity" autocomplete="off" min="1" style="width:70px !important;" />
										</div>

										<div class="col-sm-6">
											@if(!$product->attributes->isEmpty())
                                            <label class="pull-left" style="width:60px;"><!--Size-->Attributes</label>
											<select name="size" style="width:70px; font-size: 12px; border-color: #d5d8dc; color: #949494">
											<option value="">Select</option>
												<!--@if(!$product->attributes->isEmpty())-->
													@foreach($product->attributes as $attr)
														<option>{{ $attr->attribute_description }} </option>
													@endforeach
												<!--@endif-->
											</select>
                                            @endif
										</div>
									</div>
									
									<a href="JavaScript:void(0);" data-product_id="{{ $product->id }}" class="btn franchise-search-butn add addCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart</a>
									
								</div>	
							</div>


						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		<!-- header-bottom-sec -->
	</div>
	
	
	 <div class="delete-popup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="myModal2" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content DeleteEmployeepopup">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Product Added Successfully Into The Cart.</h4>
	        </div>
	        <div class="modal-body">
	          
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>

 <div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal2-error" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title cart_error"></h4>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
      
    </div>
  </div>
</div>

	
@endsection

@push('js')
<script type="text/javascript">
    var owl = $('.product-slider');
	owl.owlCarousel({
    //loop: true,
    items: 3,
    nav:true,
    margin:10,
});
$('.thumb-img').click(function(){
	$('.r-img').attr('src',$(this).attr('src'));
});

@if(Session::has('products_count'))
	console.log(' {!! session("products_count") !!} ');
	$('.badge-light').html('{!! session("products_count") !!}');
@endif

//Product adding to cart
$('.addCart').click(function(){
	var product_id = '{{ $product->id }}';
	var quantity = $('input[name=quantity]').val();
	
	if(quantity <= 0){
		quantity = 1;
	}
	
	var $valid = true;
	//var $valid = $("#addEmployee").valid();
	if($valid){
		
		$.ajax({
			url:"{{ url('franchise/addcart') }}",
			method:'POST',
			data:{'product_id':product_id, 'quantity':quantity, '_token':'{{ csrf_token() }}'},
			beforeSend: function() {
				$('.spinner_inner').css('display','block');
			},
			success:function(response){
				$('.spinner_inner').css('display','none');
				if('message' in response  && response.message == 'success'){
					$('#myModal2').modal('show');
					$('#myModal2').on('shown.bs.modal', function (e) {
					  setTimeout(function(){ $('#myModal2').modal('hide'); }, 1000);
					});
					$('.badge-light').html(response.products.length);
				}

				if('message' in response  && response.message == 'error'){
					$('.cart_error').html(response.error_message);
					$('#myModal2-error').modal('show');
					setTimeout(function(){ $('#myModal2-error').modal('hide'); }, 2000);
				}

			}
		});		
	}

});	
	
$(document).ready(function(){
	$('.product-slider').each(function(index, element) {
		var item_obj = $(this).find('.item');
		item_obj.width(item_obj.width());
		item_obj.height(item_obj.width());
	});
	$("#product-main-image-cover").width($("#product-main-image-column").width());
	$("#product-main-image-cover").height($("#product-main-image-column").width());
	//$("#product-main-image-cover").find('img').css('max-width',$("#product-main-image-column").width()+'px');
})

$( window ).resize(function() {
	//alert("resize");
	$('.product-slider').each(function(index, element) {
		var item_obj = $(this).find('.item');
		item_obj.width(item_obj.width());
		item_obj.height(item_obj.width());
	});
	$("#product-main-image-cover").width($("#product-main-image-column").width());
	$("#product-main-image-cover").height($("#product-main-image-column").width());
	//$("#product-main-image-cover").find('img').css('max-width',$("#product-main-image-column").width()+'px');
});
</script>
@endpush