@extends('franchise.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control float-none mnt-spc">
			<h6>{{ $sub_title }}</h6>
		</div>
		<div class="upload-document-cargo-head">
				<h4>Upload ID Card</h4>
			</div>
		<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload UploadCargHoldMainDiv">
			
			<form action="{{ url('franchise/client/storereport/'.$client->id) }}" method="post" id="cargoHold" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
			<div class="add-employee-data">

		    	<div class="franchise-data">
		    		<div class="row">
			    		<div class="col-md-2">
				    		<label>Document Title<span class="required-field">*</span></label>
				    	</div>
				    	<div class="col-md-3">
					    	<input type="text" name="document_name" value="">
						    @if($errors->has('document_name'))
			                    <span class="help-block error">{{ $errors->first('document_name') }}</span>	   		    	
						    @endif
						    <label class="error" for="document_name" style="display: inherit !important;"></label>
					    </div>
				    </div>
			    </div>

			    <div class="franchise-data hidden">
			    	<div class="row">
			    		<div class="col-md-2">
				    		<label>Document Type</label>
				    	</div>
				    	<div class="col-md-3">
					    	<select class="category" name="document_type">
					    		<option value="">Select Type</option>
					    		<option>Childs Dignostic</option>
					    		<option>Childs IEP</option>
					    	</select>
				    	</div>
			    	</div>
			    </div>
			    
			    <div class="upload-box-main">
					<div class="drop">
					    <div class="cont">
					      	<div class="upload-icon">
			    				<i class="fa fa-upload" aria-hidden="true"></i>
			    			</div>
					    	<div class="upload-para">
					    		<p>click here to upload file<span class="required-field">*</span></p>
					    	</div>
					    </div>
					    <input id="files" name="document" type="file"/>
					    @if($errors->has('document'))
	                    	<span class="help-block error">{{ $errors->first('document') }}</span>			    	
				   		@endif
				   		<div class="file-upload">
		                	<div class="file-select-name noFile"></div> 
		            	</div>
		            	<label class="error" for="files" style="display: none !important;"></label>
					</div>
				</div>
			    <div class="franchise-data franchise-data-1">
			    	<button type="submit" class="btn add-franchise-data-butn padd-butn-2"><i class="fa fa-upload" aria-hidden="true"></i>Upload Document</button>
			    	<div class="clearfix"></div>
			    </div>
			</div>
			</form>
		</div>
	<!-- header-bottom-sec -->
</div>


<script type="text/javascript">
	$(document).ready(function(){

		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");
    			
		$('#cargoHold').validate({
			rules:{
				document_name:{required:true, nameRegex:true},
				//document:{required:true,extension:'pdf|docx'}
				document:{required:true,extension: "doc,rtf,docx,pdf,jpg.jpeg,png,JPG.JPEG,PNG"}
			},
			messages:{
				document:{
					//extension:'Upload only pdf or doc file.'
					extension:'Upload only pdf, doc or image file.'
				}
			}
		});
	});


	var drop = $("input");
		drop.on('dragenter', function (e) {
	}).on('dragleave dragend mouseout drop', function (e) {
	});
	
	function handleFileSelect(evt) {
	  var files = evt.target.files;
	  for (var i = 0, f; f = files[i]; i++) {

	    var filename = $(this).val();
	            if (/^\s*$/.test(filename)) {
	                $(".file-upload").removeClass('active');
	                $(this).parent('div').find(".noFile").text(""); 
	            }
	            else {
		            $(".file-upload").addClass('active');
		            $(this).parent('div').find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
	            }

	    var reader = new FileReader();
	    reader.onload = (function(theFile) {
	      return function(e) {
	      };
	    })(f);
	    reader.readAsDataURL(f);
	  }
	}
	$('#files').change(handleFileSelect);
</script>
@endsection