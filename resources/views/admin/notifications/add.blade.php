@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main AddNotificationMain">
		<div class="view-tab-control float-none main-deck-head">
			<h4>{{$sub_title}}</h4>
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

		<div class="upload-document-cargo-head">
			<h4>Create Notification</h4>
		</div>

		<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload">

			<form enctype="multipart/form-data" method="POST" action="{{ route('admin.store_add') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="add-employee-data FieldsWidth">
					<div class="franchise-data">
						<label>Notification Title <span class="required-field">*</span></label>
						<input type="text" name="title" value="{{ old('title') }}" autocomplete="off" placeholder="Type Notification Title Here..." />
					</div>
					<div class="franchise-data">
						<label>Select Franchise(s) <span class="required-field">*</span></label>
						<select class="select-multiple" name="franchises[]" multiple>
							<option value="SOS Franchising">SOS Franchising</option>
							<option value="All">All Franchisees Admin</option>
							@if(!$franchises->isEmpty())
								@foreach($franchises as $franchise)
									<option value="{{ $franchise->id }}" @if( is_array(old('franchises')) && in_array($franchise->id,old('franchises')) ) selected="" @endif>{{ $franchise->name }}</option>
								@endforeach
							@endif
						</select>
					</div>

					<div class="franchise-data hidden">
						<label>Type of Notification <span class="required-field">*</span></label>
						<select name="type">
							<option value="">Select Type</option>
							<option value="Announcement" @if(old('type') == "Announcement") selected="" @endif>Announcement</option>
							<option value="Update" @if(old('type') == "Update") selected="" @endif>Update</option>
							<option value="Notice" @if(old('type') == "Notice") selected="" @endif>Notice</option>
							<option value="Activity" @if(old('type') == "Activity") selected="" @endif>Activity</option>
						</select>
					</div>

					<div class="franchise-data sUserDiv hidden">
						<label class="float-l">Select User(s) <span class="required-field">*</span></label>
						<div class="franchise-data-check-box">
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="everyone" @if( is_array(old('select_user')) && in_array("everyone",old('select_user'))) checked="" @endif /><span>Everyone</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="franchise_admin" @if( is_array(old('select_user')) && in_array("franchise_admin",old('select_user'))) checked="" @endif /><span>Franchise Admin(s)</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="employees" @if( is_array(old('select_user')) && in_array("employees",old('select_user'))) checked="" @endif /><span>Employees</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="clients" @if( is_array(old('select_user')) && in_array("clients",old('select_user'))) checked="" @endif /><span>Clients</span></b>
							{{--<b><input class="wid-auto" type="checkbox"><span>Others</span></b>--}}
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="franchise-data">
						<label class="classy">Description <span class="required-field">*</span></label>
						<textarea name="description" placeholder="Type Your Description/Message Here...">{{ old('description') }}</textarea>
					</div>

					<div class="franchise-data">
						<label style="float: left;">Upload an Attachment</label>
						<div class="upload-box-main pull-left">
							<div class="drop">
								<div class="cont">
									<div class="upload-icon">
										<i class="fa fa-upload" aria-hidden="true"></i>
									</div>
									<div class="upload-para">
										<p>Click here to upload file</p>
									</div>
								</div>
								<input id="files" name="attachment" type="file" />
								<div class="file-upload">
									<div class="file-select-name noFile"></div>
								</div>
								<label class="error" for="files"></label>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="franchise-data franchise-data-1">
						<label></label>
						<button type="submit" class="btn add-franchise-data-butn padd-butn-2"><i class="fa fa-check" aria-hidden="true"></i>Create Notification</button>
					</div>

				</div>
			</form>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">

		$(document).ready(function(){
			$('.select_users').click(function(){
				if($(this).is(':checked')){
					if($(this).val() == 'everyone')
					{
						$('.select_users').prop('checked',true);
					}
					else
					{
						$('.select_users').each(function(){
							if($(this).val() == 'everyone' ){
								$(this).prop('checked',false);
							}
						});
					}
				}
				else
				{
					if($(this).val() == 'everyone')
					{
						$('.select_users').prop('checked',false);
					}
					else
					{
						$('.select_users').each(function(){
							if($(this).val() == 'everyone' ){
								$(this).prop('checked',false);
							}
						});
					}
				}
			});
			
			
			//multiple select options
			$('.select-multiple').select2({
				placeholder:'Select Franchise(s)',
			});
			
			$('.select-multiple').on('select2:select', function (e) {
				var CurrentVal = $(this).val();	
				if(CurrentVal == 'All' || CurrentVal == 'SOS Franchising'){
					$('.select-multiple > option').each(function(value){
						var value = $(this).map(function() { return $(this).val(); }).get();
						if(value[0] != CurrentVal){
							$(this).attr('disabled','disabled');
						}
						if(CurrentVal == 'SOS Franchising' && value[0] == 'SOS Franchising'){
							$('.sUserDiv').addClass('hidden');
							$('.sUserDiv').append('<input type="hidden" name="select_user[]" value="1" class="select_userType">')
						}
					});
				}else{
					$('.select-multiple > option').each(function(value){
						var value = $(this).map(function() { return $(this).val(); }).get();
						if(value == 'All' || value == 'SOS Franchising'){
							$(this).attr('disabled','disabled');
						}
					});
				}
			});			

			$('.select-multiple').on('select2:unselecting', function (e) {
				var CurrentVal = e.params.args.data.id;
				getSelections = $(this).select2('data');
				var checkForAll = true;
				$.each(getSelections,function(key, object){
					//object formate {selected: true, disabled: false, text: "Hyderabad", id: "1", title: "", …}
					if(object.id != 'All'){
						checkForAll = false;
					}
					if(getSelections.length == 1)
					{
						$('.select-multiple option').each(function(){
							$(this).removeAttr('disabled');
						});
						$('.sUserDiv').removeClass('hidden');
						$('.select_userType').remove();
					}
				});

				//If condition is true then remove disabled from all
				if(checkForAll)
				{
					$('.select-multiple option').each(function(){
						$(this).removeAttr('disabled');
					});
					$('.sUserDiv').removeClass('hidden');
					$('.select_userType').remove();
				}
			});
			
		});
		//Multiple select option

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
@endpush