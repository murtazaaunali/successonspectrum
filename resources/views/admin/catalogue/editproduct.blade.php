@extends('admin.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control float-none">
			<h6>{{ $sub_title }}</h6>
			<p><a href="{{ url('admin/catalogue') }}">Corporate Catalogue </a> / {{ $page_title }}</p>
		</div>
		<div class="upload-document-cargo-head upload-document-cargo-head-2">
				<h4>{{ $page_title }}</h4>
			</div>
		<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload">
			
			<form action="{{ url('admin/catalogue/updateproduct') }}" method="post" enctype="multipart/form-data" id="Product">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
			<div class="add-employee-data Padd-left-7">
			    	<div class="franchise-data">
				    	<label>Product Name*</label>
				    	<input type="text" name="name" value="{{ $product->product_name }}">
				    </div>
				    <div class="franchise-data">
				    	<label>Product Category</label>
				    	<select name="category">
				    		<option value="">Select Category</option>
				    		@if(!$categories->isEmpty())
				    			@foreach($categories as $cat)
				    				<option value="{{ $cat->id }}" @if($product->product_category_id == $cat->id ) selected @endif >{{ $cat->category_name }}</option>
				    			@endforeach
				    		@endif
				    	</select>
				    </div>
				    <div class="franchise-data">
				    	<label>Stock Quantity</label>
				    	<input type="number" name="stock_quantity" min="0" value="{{ $product->stock_quantity }}" />
				    </div>
				    <div class="franchise-data">
				    	<label class="classy">Product Description</label>
				    	<textarea name="description">{{ $product->product_description }}</textarea>
				    </div>
				    <div class="franchise-data">
                        <div class="ad-product-label-input-main AddAttributeStyle w-100">
                            <label>Add Attribute</label>
                            <input type="text" name="attr">
                            <a href="javascript:;" class="btn add-franchise-data-butn padd-butn-2 add_attr" style="float:none">Add</a>
				    		<div class="clearfix"></div>
				    		<div class="attr_cover">
				    			@if(!$product->attributes->isEmpty())
				    				@foreach($product->attributes as $attr)
                                    <div class="attr_newCov">
                                    	<label class="pull-left">&nbsp;</label>
                                    	<div class="add-product-input-main attr_removeDiv pull-left">
	                                		<table>
	                                			<tr>
	                            				<td width="79.5%"><span>&nbsp;&nbsp;&nbsp;{{ $attr->attribute_description }}</span></td>
	                            				<td width="20.5%" align="center">
	                            					<input type="hidden" value="{{ $attr->attribute_description }}" name="p_attributes[]" />
	                            					<a href="javascript:;" class="remove-butn pull-left">Remove</a>
	                            				</td>
	                            				</tr>
	                            			</table>
                            			</div>
                            			<div class="clearfix"></div>
                            		</div>
                                    <div class="clearfix"></div>
					    			@endforeach
				    			@endif
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    </div>
				    <div class="franchise-data">
				    	<label>Cost Price</label>
				    	<input type="text" name="cost_price" value="{{ $product->cost_price }}">
				    </div>
				    <div class="franchise-data">
				    	<label>Selling Price</label>
				    	<input type="text" name="selling_price" value="{{ $product->selling_price }}">
				    </div>
				    <div class="franchise-data">
				    	<label>Tax (Add %)</label>
				    	<input type="text" name="tax" value="{{ $product->tax }}">
				    </div>
				    <div class="franchise-data">
				    	<label style="float: left;">Product Thumbnail</label>
				    	<div class="upload-box-main upload-box-main-create-notification dropzone" id="imageDropzone" style="width:43.5%;">
					    	<div class="upload-icon">
					    		<i class="fa fa-upload" aria-hidden="true"></i>
					    	</div>
					    </div>
					    @if($product->image)
					    	<div class="ThumbnailMargin">
					    		<div class="pImageCover">
					    			<img width="200" class="img-responsive" src="{{ url($product->image) }}" /> 
					    		</div>
					    		<div class="clearfix"></div>
				    		</div>
				    	@endif
				    	<div class="clearfix"></div>
				    </div>
				    
				    
				    <div class="franchise-data row ProductGalleryMainDiv">
				    		<label>Product Gallery</label>
					    	<div class="upload-box-main dropzone" id="galleryDropzone" style="width: 100%;">
						    	<div class="upload-icon">
						    		<i class="fa fa-upload" aria-hidden="true"></i>
						    	</div>
						    </div>
						    
							@if(!$product->gallery->isEmpty())
								<div class="MainProGalley">
									@foreach($product->gallery as $image)
							    		<div class="pImageCover">
								    		<img src="{{ url($image->image_path) }}" /> 
								    		<button type="button" class="btn btn-primary pBtnDlt" data-image_id="{{ $image->id }}"><i class="fa fa-trash"></i></button>
							    		</div>
						    		@endforeach
					    			<div class="clearfix"></div>
					    		</div>
					    	@endif
				    </div>
				    
				    <div class="franchise-data franchise-data-1 add-pro-data-butn UploadProductBtn w-100">
				    	<div class="product_gallery"></div>
				    	<div class="product_image"></div>
                        <div class="clearfix"></div>
                        <label style="float: left;">&nbsp;</label>
				    	<input type="hidden" name="product_id" value="{{ $product->id }}"/>
				    	<button type="submit" class="btn add-franchise-data-butn padd-butn-2 pull-left"><i class="fa fa-building" aria-hidden="true"></i>Update Product</button>
				    	<div class="clearfix"></div>
				    </div>
				    <div class="clearfix"></div>
			</div>
			</form>
		</div>
	<!-- header-bottom-sec -->
	</div>

<script type="text/javascript">
	$(document).ready(function(){
		jQuery.validator.addMethod("descimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");
    	
		$('#Product').validate({
			rules:{
				name:{required:true},
				description:{required:true},
				stock_quantity:{required:true, digits:true, min:0},
				cost_price:{required:true, number:true, descimalPlaces:true},
				selling_price:{required:true, number:true, descimalPlaces:true},
			}
		});
		
		/////////////////////
		// Adding attributes
		/////////////////////
		$('.add_attr').click(function(){
			if($('input[name=attr]').val() != ''){
				var attr = $('input[name=attr]').val();
				/*var Html = '<div class="add-product-input-main attr_removeDiv"><span>'+attr+'</span><input type="hidden" value="'+attr+'" name="p_attributes[]" /><a href="javascript:;" class="remove-butn">Remove</a></div>';*/
				var Html = '<div class="attr_newCov">\
								<label class="pull-left">&nbsp;</label>\
								<div class="add-product-input-main attr_removeDiv pull-left">\
									<table>\
										<tr>\
											<td width="79.5%"><span>&nbsp;&nbsp;&nbsp;'+attr+'</span></td>\
											<td width="20.5%" align="center">\
											<input type="hidden" value="'+attr+'" name="p_attributes[]" />\
											<a href="javascript:;" class="remove-butn pull-left">Remove</a>\
											</td>\
										</tr>\
									</table>\
								</div>\
								<div class="clearfix"></div>\
							</div>\
							<div class="clearfix"></div>';
				$('.attr_cover').append(Html);
				$('input[name=attr]').val('');
			}
		});
		$(document).on('click','.remove-butn',function(){
			$(this).parent().parent().parent().parent().parent().parent('.attr_newCov').remove();
		});


		/////////////////////////
		// Adding Product Gallery
		/////////////////////////
		var myDropzone = new Dropzone("div#galleryDropzone", { 
			url: "{{ url('admin/catalogue/storegallery') }}",
			maxFilesize: 222,
			paramName: "product_gallery",
			headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			acceptedFiles: ".jpeg,.jpg,.png",
			addRemoveLinks: true,
            success: function(file, response){
            	if('image_ids' in response){
	            	$.each(response.image_ids, function(key, value){
	                	$('.product_gallery').append('<input type="hidden" data-name="'+key+'" name="product_gallery[]" value="'+value+'" />');
	                });
				}
				if('error' in response){
					alert(response.error);
				}
            },
		});
		
		Dropzone.autoDiscover = false;
		
		myDropzone.on("removedfile", function(file){
			$(".product_gallery").find("[data-name='" + file.name + "']").remove();
		});		
		/////////////////////////
		// Adding Product Gallery
		/////////////////////////


		/////////////////////////
		// Adding Product Image
		/////////////////////////
		var myDropzone = new Dropzone("div#imageDropzone", { 
			url: "{{ url('admin/catalogue/storeimage') }}",
			maxFilesize: 222,
			maxFiles: 1,
			paramName: "product_image",
			headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			acceptedFiles: ".jpeg,.jpg,.png",
			addRemoveLinks: true,
            success: function(file, response){
            	if('image_ids' in response){
	            	$('.product_image').html('');
	            	$.each(response.image_ids, function(key, value){
	                	$('.product_image').append('<input type="hidden" data-image="'+key+'" name="product_image" value="'+value+'" />');
	                });
				}
				if('error' in response){
					alert(response.error);
				}
            },
		});
		
		Dropzone.autoDiscover = false;
		
		myDropzone.on("removedfile", function(file){
			$(".product_image").find("[data-image='" + file.name + "']").remove();
		});		
		/////////////////////////
		// Adding Product Gallery
		/////////////////////////
		
		//Delete Gallery Image
		$(document).on('click','.pBtnDlt',function(){
			var _this = $(this);
			var image_id = $(this).data('image_id');
			if(confirm('Are you sure you want to delete this')){
				$.ajax({
					url: "{{ url('admin/catalogue/deleteimage') }}",
					method:'POST',
					data:{'image_id':image_id, '_token':'{{ csrf_token() }}'},
				    beforeSend: function() {
				        $(_this).html('<i class="fa fa-spinner fa-spin"></i>');
				    },
		            success: function(file, response){
		            	$(_this).html('<i class="fa fa-trash"></i>');
		            	if(response == 'success'){
			            	$(_this).parent('.pImageCover').remove();
						}
		            },			
				});
			}
		});
		
		
		
	});
</script>

@endsection