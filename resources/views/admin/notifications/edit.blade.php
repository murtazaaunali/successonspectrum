@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main">
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
			<h4>Edit Notification</h4>
		</div>

		<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload">

			<form enctype="multipart/form-data" method="POST" action="{{ route('admin.store_edit') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="notification_id" value="{{ $notification->id }}" />
				<div class="add-employee-data FieldsWidth">
					<div class="franchise-data">
						<label>Notification Title <span class="required-field">*</span></label>
						<input class="NotificationInputWidth" type="text" autocomplete="off" name="title" @if(old('title')) value="{{ old('title') }}" @else value="{{ $notification->title }}" @endif placeholder="Type Notification Title Here..." />
					</div>
					<div class="franchise-data">
						<label>Select Franchise(s) <span class="required-field">*</span></label>
						<select class="select-multiple" name="franchises[]" multiple>
							<option value="SOS Franchising" @if($notification->franchise_id == 0 && $notification->send_to_type == 'Administration') selected="" @endif>SOS Franchising</option>
							<option value="All" @if($notification->franchise_id == 0 && $notification->send_to_type == 'All Franchises') selected="" @endif>All</option>
							@if(!$franchises->isEmpty())
								@foreach($franchises as $franchise)
									<option value="{{ $franchise->id }}" @if( is_array(old('franchises')) && in_array($franchise->id,old('franchises')) ) selected="" @else @foreach($notification->franchises as $franchise2) @if($franchise2->franchise_id == $franchise->id && $notification->send_to_type != 'All Franchises') selected="" @endif @endforeach @endif>{{ $franchise->name }}</option>
								@endforeach
							@endif
						</select>
					</div>

					<div class="franchise-data">
						<label>Type of Notification <span class="required-field">*</span></label>
						<select name="type">
							<option value="">Select Type</option>
							<option value="Announcement" @if(old('type') == "Announcement") selected="" @elseif($notification->type == "Announcement") selected="" @endif>Annoucement</option>
							<option value="Update" @if(old('type') == "Update") selected="" @elseif($notification->type == "Update") selected="" @endif>Update</option>
							<option value="Notice" @if(old('type') == "Notice") selected="" @elseif($notification->type == "Notice") selected="" @endif>Notice</option>
							<option value="Activity" @if(old('type') == "Activity") selected="" @elseif($notification->type == "Activity") selected="" @endif>Activity</option>
						</select>
					</div>

					<div class="franchise-data sUserDiv">
						<label class="float-l">Select User(s) <span class="required-field">*</span></label>
						<div class="franchise-data-check-box">
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="everyone" @if( is_array(old('select_user')) && in_array("everyone",old('select_user'))) checked="" @elseif($notification->send_to_everyone) checked="" @endif /><span>Everyone</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="franchise_admin" @if( is_array(old('select_user')) && in_array("franchise_admin",old('select_user'))) checked="" @elseif($notification->send_to_franchise_admin) checked="" @endif /><span>Franchise Admin(s)</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="employees" @if( is_array(old('select_user')) && in_array("employees",old('select_user'))) checked="" @elseif($notification->send_to_employees) checked="" @endif /><span>Employees</span></b>
							<b><input class="wid-auto select_users" type="checkbox" name="select_user[]" value="clients" @if( is_array(old('select_user')) && in_array("clients",old('select_user'))) checked="" @elseif($notification->send_to_clients) checked="" @endif /><span>Clients</span></b>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="franchise-data">
						<label class="classy">Description <span class="required-field">*</span></label>
						@if(old('description'))
							<textarea name="description" placeholder="Type Your Description/Message Here...">{{ old('description') }}</textarea>
						@elseif($notification->description)
							<textarea name="description" placeholder="Type Your Description/Message Here...">{{ $notification->description }}</textarea>
						@endif
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

					@if($notification->attachment)
						<div class="franchise-data">
							<label class="pull-left">Uploaded File</label>
							<div class="pull-left">
								<a target="_blank" href="{{ asset($notification->attachment)  }}">Download Attachment</a>
							</div>

							<div class="clearfix"></div>
						</div>
					@endif

					<div class="franchise-data franchise-data-1">
						<label></label>
						<button type="submit" class="btn add-franchise-data-butn padd-butn-2"><i class="fa fa-check" aria-hidden="true"></i>Update Notification</button>
					</div>

				</div>
			</form>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">

		$(document).ready(function(){
			
			@if($notification->franchise_id == 0 && $notification->send_to_type == 'Administration')
				$('.sUserDiv').addClass('hidden');
				$('.sUserDiv').append('<input type="hidden" name="select_user[]" value="1" class="select_userType">')
			@endif

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
					/*$('.select-multiple option').each(function(value){
						if(CurrentVal != value){
							$(this).attr('disabled','disabled');
						}
					});*/
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
					$('.select-multiple option').each(function(value){
						var value = $(this).map(function() { return $(this).val(); }).get();
						if(value == 'All' || value == 'SOS Franchising'){
							$(this).attr('disabled','disabled');
						}
					});
				}
			});			

			$('.select-multiple').on('select2:open', function (e) {
				var getSelect = $('.select-multiple').select2('data');
				console.log(getSelect);
				
				var selectedValue = '';
				if(getSelect.length > 0){
					checkForAll = true;
					$.each(getSelect,function(key, object){
						//console.log(object.id);
						if(checkForAll){
							if(object.id == 'All' || object.id == 'SOS Franchising'){
								selectedValue = object.id;
								checkForAll = false;
							}
							if(getSelect.length == 1)
							{
								$('.select-multiple option').each(function(){
									$(this).removeAttr('disabled');
								});
							}
						}
					});
					//console.log(checkForAll);
					if(checkForAll){
						$('.select-multiple option').each(function(value){
							var value = $(this).map(function() { return $(this).val(); }).get();
							if(value[0] != 'All' && value[0] != 'SOS Franchising'){
								$(this).removeAttr('disabled');
							}else{
								$(this).attr('disabled','disabled');
							}
						});					
					}else{
						$('.select-multiple option').each(function(value){
							var value = $(this).map(function() { return $(this).val(); }).get();
							if(value[0] == selectedValue){
								$(this).removeAttr('disabled');
							}else{
								$(this).attr('disabled','disabled');
							}
						});					
					}
					
				}else{
					$('.select-multiple option').each(function(){
						$(this).removeAttr('disabled');
					});
				}

			});
			
			//UNSELECTING 
			$('.select-multiple').on('select2:unselecting', function (e) {
				var CurrentVal = e.params.args.data.id;
				console.log($(this).select2('data'));
				
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