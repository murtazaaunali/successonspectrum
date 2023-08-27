@extends('admin.layout.main')

@section('content')

		<!-- header-bottom-sec -->
		<div class="add-franchise-super-main CatalogueProductView">
			<div class="view-tab-control float-none">
				<h6>Corporate Catalogue</h6>
				<p><a href="{{ url('admin/catalogue') }}">Corporate Catalogue </a> / Product / View</p>
			</div>
			
			@if(Session::has('Success'))
				{!! session('Success') !!}
			@endif			
			
			<div class="upload-document-cargo-head add-product-view"> <h4>Product View</h4></div>
			<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload">
				<div class="row">
					<div id="product-main-image-column" class="col-sm-4 text-center">
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
                                <!--<div class="item">
							        <div class="ThumbnailMargin">
                            			<div class="pImageCover" style="margin:0px;margin-bottom: 12px;">
                                    		<img class="thumb-img" src="{{ url($product->image) }}">
							    		</div>
                                    </div>
                                </div>-->
							@endif
						    @foreach($product->gallery as $image)
						    <div class="item">
						        <img class="thumb-img img-responsive" src="{{ $image->image_path }}" alt="photo by Barn Images">
                                <!--<div class="ThumbnailMargin">
                                    <div class="pImageCover" style="margin:0px;margin-bottom: 12px;">
                                        <img class="thumb-img" src="{{ $image->image_path }}">
                                    </div>
                                </div>-->
						    </div>
						    @endforeach
						    {{--<div class="item">
						        <img class="thumb-img" src="https://unsplash.imgix.net/photo-1426200830301-372615e4ac54?fit=crop&fm=jpg&h=1080&q=75&w=1900" alt="photo by Barn Images">
						    </div>
						    <div class="item">
						        <img class="thumb-img"  src="https://ununsplash.imgix.net/photo-1423753623104-718aaace6772?fit=crop&fm=jpg&h=1080&q=75&w=1900" alt="photo by Joshua Earle">
						    </div>
						    <div class="item">
						        <img class="thumb-img"  src="https://ununsplash.imgix.net/photo-1421098518790-5a14be02b243?fit=crop&fm=jpg&h=1080&q=75&w=1900" alt="photo by Alexander Dimitrov">
						    </div>
						    <div class="item">
						        <img class="thumb-img"  src="https://unsplash.imgix.net/photo-1423439793616-f2aa4356b37e?fit=crop&fm=jpg&h=1080&q=75&w=1900" alt="photo by Wojciech Szaturski">
						    </div>--}}
						</div>
						@endif
                        <div class="clearfix hidden-lg">&nbsp;</div>
					</div>
					<div class="col-sm-8">
						<div class="t-shirt-description-main description-box-text">
							<h2>@if($product->product_category_id) {{ $product->product_category->category_name }} @endif</h2>
							<h3>{{ $product->product_name }}</h3>
							<h4>${{ $product->selling_price }}</h4>
							<p>{{ $product->product_description }}</p>
							<figure>
								Stock / Attributes
                                <!--Stock : <span @if($product->stock_status == "In Stock") style="color: #5ddf9e;" @else class="red-clr" @endif>{{ $product->stock_status  }}</span>-->
							</figure>
                            
							@if(!$product->attributes->isEmpty())
                            <!--<figure>
						    	Attributes-->
								@foreach($product->attributes as $attr)
									<p><label>{{ $attr->attribute_description }}</label></p>
								@endforeach
                            <!--</figure>    -->
							@endif
                            
							<!--<p><label>Medium</label> <span>96/100</span></p>
							<p><label>Large</label> <span>44/100</span></p>-->
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		<!-- header-bottom-sec -->
	</div>

<div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Product?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this product.?</p>
          <input class="btn popup-delete-butn" type="button" value="Delete">
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