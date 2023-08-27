@extends('franchise.layout.main')

@section('content')
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
		<div class="main-head-franchise">
			<div class="main-deck-head main-deck-head-franchise Catalogue">
				<h4>Catalog</h4>
			</div>
			<div class="add-franchise-butn-main add-product-butn-main MargTop8 MargBot10">
				<a href="{{ url('franchise/viewcart') }}" class="btn CartBadge"><i class="fa fa-shopping-cart" aria-hidden="true"></i>View Cart <span class="badge badge-light"></span></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="super-admin-catalogue-main">
			<div class="super-cargo-tabs-main">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#">SOS Products</a></li>
				</ul>
			</div>
			<div class="super-admin-cargo-tab-content">
				<div class="tab-content">
					<div id="" class="tab-pane fade in active spinner_main">

		    			<div class="spinner_inner" style="padding-top: 5%;">
		    				<i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />
		    				Adding to cart.	
		    			</div>
						
						<div class="container">
							@if(!$products->isEmpty())
							<div class="row PaddBot70">
								@php $rowCount = 1; @endphp
								@foreach($products as $product)
								<div class="col-md-2 product-list-image-column">
									<div class="CatalogueProductBox">
										<!--<img src="{{ $product->image }}">-->
                                        <div class="ThumbnailMargin" style="float:none;margin:0px;">
                                        	<div class="pImageCover product-list-image-cover" style="float:none;margin:0px;">
                                            	<img src="{{ $product->image }}">
                                            </div>
                                        </div>
										<div class="CatalogueProductName text-center">
                                        	{{ $product->product_name }}	
                                        </div>
                                        <div class="CatalogueProductHoverBtn">
											<a href="{{ url('franchise/catalog/viewproduct/'.$product->id) }}" class="btn franchise-search-butn"><i class="fa fa-list" aria-hidden="true"></i> View Details</a>
											<a href="JavaScript:void(0);" data-product_id="{{ $product->id }}" class="btn francse-filter-butn  butn-spacing-padd-1 add addCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
									</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
								</div>
								<!--@if($rowCount == 6)
									</div><div class="row PaddBot30">
								@endif-->
								@php $rowCount++ @endphp
								@endforeach
							</div>
							@endif

						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-pagination">
								{!! $products->render() !!}
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
   
<script type="text/javascript">
$(document).ready(function(){
	//code for delete product
	@if(Session::has('products_count'))
		console.log(' {!! session("products_count") !!} ');
		$('.badge-light').html('{!! session("products_count") !!}');
	@endif
	var product_id = '';
	$('.delete_product').click(function(){
		product_id = $(this).data('product_id');
		$('#myModal2').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("admin/catalogue/deleteproduct") }}'+'/'+product_id;
	});
	
	//Product adding to cart
	$('.addCart').click(function(){
		var product_id = $(this).data('product_id');
		$.ajax({
			url:"{{ url('franchise/addcart') }}",
			method:'POST',
			data:{'product_id':product_id, 'quantity':1, '_token':'{{ csrf_token() }}'},
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
		})
	});	
	
});

$(document).ready(function(){
	$(".product-list-image-cover").width($(".product-list-image-column").width());
	$(".product-list-image-cover").height($(".product-list-image-column").width());
})

$( window ).resize(function() {
	//alert("resize");
	$(".product-list-image-cover").width($(".product-list-image-column").width());
	$(".product-list-image-cover").height($(".product-list-image-column").width());
});

//Filters
$("#product_search").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var filter_category    = $('select[name=\'category\']').val();
    var filter_stock       = $('select[name=\'stock\']').val();

    if(filter_category == "" && filter_stock == ""){
        alert("Please Select Filter Options");
        return false;
    }else{
        url += '?';
    }

    if(filter_category != ""){
        url += 'category=' + encodeURIComponent(filter_category);
    }

    if(filter_stock != ""){
        if(filter_category != "")
            url += '&';
        url += 'stock=' + encodeURIComponent(filter_stock);
    }

    window.location = url;
});

</script>
@endsection