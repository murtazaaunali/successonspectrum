@extends('admin.layout.main')

@section('content')
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
		<div class="main-head-franchise">
			<div class="main-deck-head main-deck-head-franchise Catalogue">
				<h4>Corporate Catalogue</h4>
				<p><a href="{{ url('admin/catalogue') }}">Corporate Catalogue </a> / Products</p>
			</div>
			<div class="add-franchise-butn-main add-product-butn-main marg-top-15">
				<a href="{{ url('admin/catalogue/addproduct') }}" class="btn"><i class="fa fa-building" aria-hidden="true"></i>Add Product</a>
			</div>
			<div class="clearfix"></div>
		</div>
		
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif

		<form method="GET" action="{{ route("admin.catalogue") }}" id="product_search">
			<div class="frnchise-select-main">
				<label>Search by Product Categories</label>
				<select name="category">
					<option value="">Select Category</option>
					@if($categories->count())
						@foreach($categories as $category)
							<option value="{{ $category->id  }}" @if(Request::has('category')) @if(Request::get('category') == $category->id) selected="" @endif @endif>{{ $category->category_name }}</option>
						@endforeach
					@endif
				</select>

				<label>Search by Product Stock</label>
				<select name="stock">
					<option value="">Select Stock</option>
					<option value="In Stock" @if(Request::has('stock')) @if(Request::get('stock') == "In Stock") selected="" @endif @endif>In Stock</option>
					<option value="Out of Stock" @if(Request::has('stock')) @if(Request::get('stock') == "Out Of Stock") selected="" @endif @endif>Out Of Stock</option>
				</select>
				<div class="fiter-butn-main">
					<button class="btn franchise-search-butn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
					<a href="{{ route('admin.catalogue')  }}@if(Request::has('page'))?page={{ Request::get('page')  }}@endif" class="btn francse-filter-butn  butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
				</div>
			</div>
		</form>
				
		<div class="super-admin-catalogue-main">
			<div class="super-cargo-tabs-main">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#Listed-Products">Listed Products</a></li>
				</ul>
			</div>
			<div class="super-admin-cargo-tab-content">
				<div class="tab-content">
					<div id="Listed-Products" class="tab-pane fade in active">
						<div class="super-admin-catalogue-select-main">

							<div class="clearfix"></div>
						</div>
						<div class="super-admin-table-1 table-responsive">
							<table class="CatalogueTableInput table-striped CatalogueTableWidth">
								<tr>
									<th><i class="fa fa-picture-o padd-left-11" aria-hidden="true"></i></th>
									<th>Name</th>
									<th>Cost Price</th>
									<th>Selling Price</th>
									<th>Stock</th>
									<th>Category</th>
									<th class="super-admin-table-position-1">Actions</th>
								</tr>
								@if($products->count())
									@foreach($products as $product)
										<tr>
											<td>
												<div class="ThumbnailMargin">
                                                    <div class="pImageCover">
                                                        @if($product->image)
                                                            <img class="product_img" src="{{ asset($product->image) }}" />
                                                            {{--<img class="product_img" src="{{ url('productimage/'.basename($product->image)) }}" />--}}
                                                        @else
                                                            <img class="product_img" src="{{ asset('assets') }}/images/product_placeholder.png" />
                                                        @endif
                                                    </div>
                                                </div>
											</td>
											<td>{{ $product->product_name }}</td>
											<td>$ {{ $product->cost_price }}</td>
											<td>$ {{ $product->selling_price }}</td>
											<td @if($product->stock_status == "In Stock") style="color: #5ddf9e;" @else class="red-clr" @endif>{{ $product->stock_status  }}</td>
											<td>@if($product->product_category_id) {{ $product->product_category->category_name }} @else - @endif</td>
											<td class="super-admin-table-position">
												<a class="table-bin-butn" href="{{ url('admin/catalogue/viewproduct/'.$product->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<a href="{{ url('admin/catalogue/editproduct/'.$product->id) }}" class="table-bin-butn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:;" class="table-bin-butn-1 delete_product" data-product_id="{{ $product->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
									@endforeach
								@else
									<tr><td colspan="6">No Products found.</td></tr>
								@endif
							</table>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-para">
								@if($products->firstItem())
									<p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries</p>
								@else
									<p>Showing 0 Entries</p>
								@endif
							</div>
							<div class="super-admin-table-bottom-pagination">
								{!! $products->appends(request()->query())->links() !!}
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
	  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
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


   
<script type="text/javascript">
$(document).ready(function(){
	//code for delete employee
	var product_id = '';
	$('.delete_product').click(function(){
		product_id = $(this).data('product_id');
		$('#myModal2').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("admin/catalogue/deleteproduct") }}'+'/'+product_id;
	});	
});

//Filters
$("#product_search").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var filter_category    = $('select[name=\'category\']').val();
    var filter_stock       = $('select[name=\'stock\']').val();

    if(filter_category == "" && filter_stock == "")
    {
        alert("Please Select Filter Options");
        return false;
    }
    else
    {
        url += '?';
    }

    if(filter_category != "")
    {
        url += 'category=' + encodeURIComponent(filter_category);
    }

    if(filter_stock != "")
    {
        if(filter_category != "")
            url += '&';
        url += 'stock=' + encodeURIComponent(filter_stock);
    }

    window.location = url;
})

</script>
@endsection