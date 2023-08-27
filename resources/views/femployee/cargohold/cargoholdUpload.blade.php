@extends('femployee.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control float-none mnt-spc">
			<h6>{{ $sub_title }}</h6>
            <p>{{ $sub_title }} / <span id="change-bread-crumb">Documents </span> / <span id="change-bread-crumb">Upload Document </span></p>
		</div>
		<div class="upload-document-cargo-head">
				<h4>Upload Document Details</h4>
			</div>
		<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload UploadCargHoldMainDiv">
			
			<form action="{{ $action }}" method="post" id="cargoHold" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
			<div class="add-employee-data">
		    	<div class="franchise-data">
		    		<div class="row">
			    		<div class="col-md-2">
				    		<label>Document Title<span class="required-field">*</span></label>
				    	</div>
				    	<div class="col-md-3">
					    	<input type="text" name="title" value="{{ $title }}">
						    @if($errors->has('title'))
			                    <span class="help-block error">{{ $errors->first('title') }}</span>	   		    	
						    @endif
						    <label class="error" for="title" style="display: inherit !important;"></label>
					    </div>
				    </div>
			    </div>
			    <div class="franchise-data pos-rel">
			    	<div class="row">
			    		<div class="col-md-2">
				    		<label>Document Expiration (If any)</label>
				    	</div>
				    	<div class="col-md-3">
					    	<input type="text" autocomplete="off" name="expiration" class="datepicker" value="@if($expiration) {{ date('m/d/Y',strtotime($expiration)) }} @endif">
					    	<i class="fa fa-calendar pos-abs-2 DocumentCalendar datepicker" aria-hidden="true"></i>
						    @if($errors->has('expiration'))
			                    <span class="help-block error">{{ $errors->first('expiration') }}</span>			    	
						    @endif
					    </div>
				    </div>			    
				</div>
			    <div class="franchise-data">
			    	<div class="row">
			    		<div class="col-md-2">
				    		<label>Category</label>
				    	</div>
				    	<div class="col-md-3">
					    	<select class="category" name="category">
					    		<option value="">Select</option>
					    		<option @if( $category == 'Personal Documents' ) selected @endif value="Personal Documents">Personal Documents</option>
					    		<option @if( $category == 'Parent Training' ) selected @endif value="Parent Training">Parent Training</option>
					    	</select>
                            <!--<input id="hidden" name="category" value="Personal Documents"/>-->
				    	</div>
			    	</div>
			    </div>
			    <div class="franchise-data hidden">
			    	<div class="row">
			    		<div class="col-md-2">
				    		<label>Select User(s)<span class="required-field">*</span></label>
				    	</div>
				    	<div class="col-md-3">
					    	<div class="franchise-data-check-box">
					    		<b><input class="wid-auto" name="user_type[]" type="checkbox" value="Everyone" @if(in_array('Everyone',$user_type)) checked @endif ><span>Everyone</span></b>
						    	<b><input class="wid-auto" name="user_type[]" type="checkbox" value="Employees" @if(in_array('Employees',$user_type)) checked @endif ><span>Employees</span></b>
						    	<b><input class="wid-auto" name="user_type[]" type="checkbox" value="Clients" @if(in_array('Clients',$user_type)) checked @endif ><span>Clients</span></b>
						    	<br/><label for="user_type[]" class="error" style="display: inherit !important;"></label>
							    @if($errors->has('user_type'))
				                    <span class="help-block error">{{ $errors->first('user_type') }}</span>
							    @endif
					    	</div>
				    	</div>
			    	</div>
			    	<div class="clearfix"></div>
			    </div>
			    
			    <div class="upload-box-main">
					<div class="drop">
					    <div class="cont">
					      	<div class="upload-icon">
			    				<i class="fa fa-upload" aria-hidden="true"></i>
			    			</div>
					    	<div class="upload-para">
					    		<p>Click here to upload file<span class="required-field">*</span></p>
					    	</div>
					    </div>
					    <input id="files" name="document" type="file" @if($type == 'add') required @endif  />
					    @if($errors->has('document'))
	                    	<span class="help-block error">{{ $errors->first('document') }}</span>			    	
				   		@endif
				   		<div class="file-upload">
		                	<div class="file-select-name noFile"></div> 
		            	</div>
		            	<label class="error" for="files"></label>
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
		  $(function () {
			$('.datepicker').datetimepicker({
				pickerPosition: 'bottom-left',
	            format: 'mm/dd/yyyy',
	            maxView: 4,
	            minView: 2,
	            autoclose: true,
	            pickTime: false,
	            startDate: new Date()
	        }); 
		});

		
		$('input[name="user_type[]"]').click(function(){

			if($(this).is(':checked')){
				if($(this).val() == 'Everyone')
				{
					$('input[name="user_type[]"]').prop('checked',true);
				}
				else
				{
					if($(this).val() == 'Self')
					{
						$('input[name="user_type[]"]').prop('checked',false);
						$(this).prop('checked',true);
					}
					else
					{
						$('input[name="user_type[]"]').each(function(){
							if($(this).val() == 'Everyone' ){
								$(this).prop('checked',false);
							}
							else if($(this).val() == 'Self' ){
								$(this).prop('checked',false);
							}
						});
					}
				}
			}
			else
			{
				if($(this).val() == 'Everyone')
				{
					$('input[name="user_type[]"]').prop('checked',false);
				}
				else
				{
					$('input[name="user_type[]"]').each(function(){
						if($(this).val() == 'Everyone' ){
							$(this).prop('checked',false);
						}
						else if($(this).val() == 'Self' ){
							$(this).prop('checked',false);
						}
					});
				}
			}
		});

		jQuery.validator.addMethod("nameRegex", function(value, element) {
    	        return this.optional(element) || /^[a-zàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\ \s]+$/i.test(value);
    	}, "Special characters and numbers are not allowed");
    			
		$('#cargoHold').validate({
			rules:{
				franchise:{required:true},
				title:{required:true, nameRegex:true},
				expiration:{required:true},
				'user_type[]':{required:true},
				document:{extension:'pdf|docx'}
			},
			messages:{
				document:{
					extension:'Upload only pdf or doc file.'
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