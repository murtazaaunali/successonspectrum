@extends('admin.layout.main')

@section('content')
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
		<div class="main-head-franchise">
			<div class="main-deck-head main-deck-head-franchise">
				<h4>{{ $sub_title }}</h4>
			</div>
			<div class="add-franchise-butn-main">
				<a href="javascript:void(0);" class="btn create_cargohold_folder"><i class="fa fa-plus" aria-hidden="true"></i>Create Folder</a>
                <a href="{{ url('admin/cargohold/uploaddocument') }}" class="btn"><i class="fa fa-upload" aria-hidden="true"></i>Upload Document</a>
			</div>
			<div class="clearfix"></div>
		</div>
		
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		
		@php $requests = array('tab3','tab4'); @endphp 
		
		<div class="super-admin-cargo-hold-main">
			<div class="super-cargo-tabs-main">
				<ul class="nav nav-tabs" id="myTab">
					<li class="@if( !in_array(Request::get('tab'),$requests) ) active @endif"><a data-id="?tab=tab2" data-toggle="tab" href="#Completed_Franchisee_Forms">Completed Franchisee Forms</a></li>
					<li class="@if(Request::get('tab') == 'tab3') active @endif"><a data-id="?tab=tab3" data-toggle="tab" href="#Personal_Documents">Personal Documents</a></li>
					<!--<li class="@if(Request::get('tab') == 'tab4') active @endif"><a data-id="?tab=tab4" data-toggle="tab" href="#Employee_Forms">Employee Forms</a></li>-->
					<li class="pos-rel @if(Request::get('tab') == 'tab4') active @endif"><a data-id="?tab=tab4" data-toggle="tab" href="#Archives">Archives</a>
						@if(!$Archives->isEmpty())
							<span class="pos-abs-cargo-tab">{{ $Archives->count() }}</span>
						@endif
					</li>
				</ul>
			</div>
			<div class="super-admin-cargo-tab-content">
				<div class="tab-content">
					
					<div id="Completed_Franchisee_Forms" class="tab-pane fade @if( !in_array(Request::get('tab'),$requests) ) in active @endif">
						<div class="super-admin-cargo-hold-box-main super-admin-cargo-hold-box-main-tab-folders">
							@if(!$Cargohold_folders->isEmpty())
							@php $count = 1; @endphp
                            @foreach($Cargohold_folders as $cargohold_folder)
                                @if($count > 8)
                                    {!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main super-admin-cargo-hold-box-main-folders">' !!}
                                    @php $count = 1; @endphp
                                @endif
                                @if($cargohold_folder->category == "Completed Franchisee Forms" && file_exists(storage_path().'/app/public/cargohold/'.$cargohold_folder->name))
                                <div class="super-admin-cargo-hold-box dropdown super-admin-cargo-hold-box-main-tab-folders-inner">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                    <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                        <a href="javascript:void(0);" data-tab="" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="head-active view_cargohold_folder">View</a>
                                        <a href="javascript:void(0);" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="bord-bot-0 red-clr delete_cargohold_folder">Delete</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void(0);" data-tab="" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="view_cargohold_folder">
                                        <img src="{{ asset('assets') }}/images/folder.jpg">
                                        <p>{{ $cargohold_folder->name }}</p>
                                    </a>
                                </div>
                                @php $count ++; @endphp
                                <div class="super-admin-cargo-hold-box-main-folder-tabs super-admin-cargo-hold-box-main-tab-folder-tabs" id="folder-tab-{{ $cargohold_folder->id }}">
                                    <div class="clearfix"></div>
                                    <h5><strong>{{ $cargohold_folder->name }}'s Documents</strong> <a href="javascript:void(0);" data-tab="" class="btn cargohold_folder_back pull-right">< Back</a></h5>
                                    @if(!$cargohold_folder->cargohold_files->isEmpty())
                                        @php $count_files = 1; @endphp
                                        @foreach($cargohold_folder->cargohold_files as $cargo)
                                            @if($count_files > 8)
                                                {!! '<div class="clearfix"></div>' !!}
                                                @php $count_files = 1; @endphp
                                            @endif
                                            <div class="super-admin-cargo-hold-box dropdown">
                                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                                <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                    <!--<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>-->
                                                    <a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
                                                    <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>
                                                    <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="moveto_cargohold">Move To</a>
                                                    <a href="{{ url('admin/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
                                                    <a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">
                                                    {!! fileExtension($cargo->file) !!}
                                                    <p>{{ $cargo->title }}</p>
                                                </a>
                                            </div>
                                            @php $count_files ++; @endphp
                                        @endforeach
                                    @else
                                    <div class="clearfix">&nbsp;</div>
                                    <p>No record found</p>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                                @endif
                            @endforeach
                            <div class="clearfix"></div>
                            <hr />
							@endif
						</div>
                        
                        <div class="super-admin-cargo-hold-box-main">
							@if(!$Completed_Franchisee_Forms->isEmpty())
							@php $count = 1; @endphp
                            @foreach($Completed_Franchisee_Forms as $cargo)
								@if($count > 8)
                                    {!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
                                    @php $count = 1; @endphp
                                @endif
                                <div class="super-admin-cargo-hold-box dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                    <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                        <!--<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>-->
                                        <a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
                                        <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>
                                        <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="moveto_cargohold">Move To</a>
                                        <a href="{{ url('admin/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
                                        <a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">
                                        {!! fileExtension($cargo->file) !!}
                                        <p>{{ $cargo->title }}</p>
                                    </a>
                                </div>
                                @php $count ++; @endphp
							@endforeach
                            @else
                            <div class="clearfix">&nbsp;</div>
                            <p>No record found</p>
							@endif
							<div class="clearfix"></div>
						</div>
					</div><!-- Disclosure -->
					
					<div id="Personal_Documents" class="tab-pane fade @if(Request::get('tab') == 'tab3' ) in active @endif">
						<div class="super-admin-cargo-hold-box-main super-admin-cargo-hold-box-main-tab3-folders">
							@if(!$Cargohold_folders->isEmpty())
							@php $count = 1; @endphp
                            @foreach($Cargohold_folders as $cargohold_folder)
                                @if($count > 8)
                                    {!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main super-admin-cargo-hold-box-main-folders">' !!}
                                    @php $count = 1; @endphp
                                @endif
                                @if($cargohold_folder->category == "Personal Documents" && file_exists(storage_path().'/app/public/cargohold/'.$cargohold_folder->name))
                                <div class="super-admin-cargo-hold-box dropdown super-admin-cargo-hold-box-main-tab3-folders-inner">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                    <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                        <a href="javascript:void(0);" data-tab="3" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="head-active view_cargohold_folder">View</a>
                                        <a href="javascript:void(0);" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="bord-bot-0 red-clr delete_cargohold_folder">Delete</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void(0);" data-tab="3" data-cargohold_folder_id="{{ $cargohold_folder->id }}" class="view_cargohold_folder">
                                        <img src="{{ asset('assets') }}/images/folder.jpg">
                                        <p>{{ $cargohold_folder->name }}</p>
                                    </a>
                                </div>
                                @php $count ++; @endphp
                                <div class="super-admin-cargo-hold-box-main-folder-tabs super-admin-cargo-hold-box-main-tab3-folder-tabs" id="folder-tab-{{ $cargohold_folder->id }}">
                                    <div class="clearfix"></div>
                                    <h5><strong>{{ $cargohold_folder->name }}'s Documents</strong> <a href="javascript:void(0);" data-tab="3" class="btn cargohold_folder_back pull-right">< Back</a></h5>
                                    @if(!$cargohold_folder->cargohold_files->isEmpty())
                                    @php $count_files = 1; @endphp
                                    @foreach($cargohold_folder->cargohold_files as $cargo)
                                        @if($count_files > 8)
                                            {!! '<div class="clearfix"></div>' !!}
                                            @php $count_files = 1; @endphp
                                        @endif
                                        <div class="super-admin-cargo-hold-box dropdown">
                                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                            <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                <!--<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>-->
                                                <a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
                                                <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>
                                                <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="moveto_cargohold">Move To</a>
                                                <a href="{{ url('admin/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
                                                <a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">
                                                {!! fileExtension($cargo->file) !!}
                                                <p>{{ $cargo->title }}</p>
                                            </a>
                                        </div>
                                        @php $count_files ++; @endphp
                                    @endforeach
                                    @else
                                    <div class="clearfix">&nbsp;</div>
                                    <p>No record found</p>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                                @endif
                            @endforeach
                            <div class="clearfix"></div>
                            <hr />
							@endif
						</div>
                        
                        <div class="super-admin-cargo-hold-box-main">
							@if(!$Personal_Documents->isEmpty())
							@php $count = 1; @endphp
                            @foreach($Personal_Documents as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
                            <div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<!--<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>-->
									<a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>
                                    <a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="moveto_cargohold">Move To</a>
									<a href="{{ url('admin/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
								</div>
								<div class="clearfix"></div>
								<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">
									{!! fileExtension($cargo->file) !!}
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
                            @php $count ++; @endphp
							@endforeach
                            @else
                            <div class="clearfix">&nbsp;</div>
                            <p>No record found</p>
							@endif
							<div class="clearfix"></div>
						</div>						
					</div><!--Required-Insurance-->


					{{--<div id="Employee_Forms" class="tab-pane fade @if(Request::get('tab') == 'tab4' ) in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Employee_Forms->isEmpty())
							@php $count = 1; @endphp
							@foreach($Employee_Forms as $cargo)

							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
							
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
								</div>
								<div class="clearfix"></div>
								<a href="#">
									{!! fileExtension($cargo->file) !!}
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
							@php $count ++; @endphp
							@endforeach
							@endif
							<div class="clearfix"></div>
						</div>						
					</div>--}}<!--Required-Insurance-->
					
					<div id="Archives" class="tab-pane fade @if(Request::get('tab') == 'tab4') in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Archives->isEmpty())
							@php $count = 1; @endphp
                            @foreach($Archives as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
                            <div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('admin/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('admin/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="active_cargohold">Active</a>
									<a href="{{ url('admin/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
								</div>
								<div class="clearfix"></div>
								<a href="#">
									{!! fileExtension($cargo->file) !!}
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
                            @php $count ++; @endphp
							@endforeach
                            @else
                            <div class="clearfix">&nbsp;</div>
                            <p>No record found</p>
							@endif
							<div class="clearfix"></div>
						</div>					
					</div><!--Archives-->
					
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
          <h4 class="modal-title">Delete Cargo Hold?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this Cargo Hold ? All data of the existing Cargo Hold will be lost. This action cannot be undone</p>
          <input class="btn popup-delete-butn" type="button" value="Delete Cargo Hold">
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="delete-popup-main">
	<!-- Modal -->
	<div class="modal fade" id="myModal3" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content DeleteEmployeepopup">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Archive Cargo Hold?</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to move this Cargo Hold to Archive? <br />This action can be undone by going to Archives and Click on Active.</p>
					<input class="btn popup-archive-butn" type="button" value="Archive Cargo Hold" />
				</div>
			</div>

		</div>
	</div>
</div>

<div class="delete-popup-main">
	<!-- Modal -->
	<div class="modal fade" id="myModal4" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content DeleteEmployeepopup">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Active Cargo Hold?</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to Active this Cargo Hold? <br />This action can be undone by going to Specific Category for this document and Click on Archive.</p>
					<input class="btn popup-active-butn" type="button" value="Active Cargo Hold" />
				</div>
			</div>

		</div>
	</div>
</div>

<div class="create-folder-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModalCreateFolder" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content poupup-main-information-modal-content">
        <div class="modal-header poupup-main-information-modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Folder</h4>
        </div>
        <div class="modal-body poupup-main-information-modal-body">
          <form action="{{ url('admin/cargohold/createfolder') }}" method="post" id="createCargoHoldFolder" style="text-align:left !important;">
              <input type="hidden" name="action" value="create"/>
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <input type="text" name="create_folder_name" id="create_folder_name"/>
              <label class="error" for="create_folder_name"></label>
              <select name="create_folder_category" id="create_folder_category">
                <option value="">Category</option>
                @if($Cargohold_folders_category)
                    @foreach($Cargohold_folders_category as $category)
                        @if($category != "null")	
                        <option>{{ $category }}</option>
                        @endif
                    @endforeach
                @endif	
              </select>
              <label class="error" for="create_folder_category"></label>
              <input class="btn add-franchise-data-butn-1 create-cargohold-folder-butn" type="submit" value="Create">
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="create-folder-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModalCargoholdMoveTo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content poupup-main-information-modal-content">
        <div class="modal-header poupup-main-information-modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Move To</h4>
        </div>
        <div class="modal-body poupup-main-information-modal-body">
          <form action="{{ url('admin/cargohold/moveto') }}" method="post" id="moveToCargoHold">
              <input type="hidden" name="cargo_id" value=""/>
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <select name="cargohold_folder_id" id="cargohold_folder_id">
                <option value="">Select</option>
                @if($Cargohold_folders)
                    @foreach($Cargohold_folders as $cargohold_folder)
                        <option value="{{$cargohold_folder->id}}">{{ $cargohold_folder->name }}</option>
                    @endforeach
                @endif	
              </select>
              <label class="error" for="create_folder_category"></label>
              <input class="btn add-franchise-data-butn-1 create-cargohold-folder-butn" type="submit" value="Submit">
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModalDeleteFolder" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Folder?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this folder ? All data of the existing folder will be lost. This action cannot be undone</p>
          <input class="btn popup-delete-cargohold-folder-butn" type="button" value="Delete Folder">
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('a[data-toggle="tab"]').click(function(e) {
        window.history.replaceState(null, null, "/admin/cargohold/"+$(this).data("id"))
        e.preventDefault();
    });

	//code for delete cargo hold
	var cargo_id = '';
	var cargohold_folder_id = '';
	$('.delete_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal3').modal('hide');
		$('#myModal2').modal('show');
		$('#myModal4').modal('hide');
		$('#myModalCreateFolder').modal('hide');
		$('#myModalCargoholdMoveTo').modal('hide');
	});

	$('.archive_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal2').modal('hide');
		$('#myModal3').modal('show');
		$('#myModal4').modal('hide');
		$('#myModalCreateFolder').modal('hide');
		$('#myModalCargoholdMoveTo').modal('hide');
	});

	$('.active_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal2').modal('hide');
		$('#myModal3').modal('hide');
		$('#myModal4').modal('show');
		$('#myModalCreateFolder').modal('hide');
		$('#myModalCargoholdMoveTo').modal('hide');
	});
	
	$('.moveto_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal2').modal('hide');
		$('#myModal3').modal('hide');
		$('#myModal4').modal('hide');
		$('#myModalCreateFolder').modal('hide');
		$('#myModalCargoholdMoveTo').modal('show');
		$('#myModalCargoholdMoveTo').find('input[name="cargo_id"]').val(cargo_id);
	});
	
	$('.create_cargohold_folder').click(function(){
		$('#myModal2').modal('hide');
		$('#myModal3').modal('hide');
		$('#myModal4').modal('hide');
		$('#myModalCreateFolder').modal('show');
		$('#myModalCargoholdMoveTo').modal('hide');
	});
	
	$('.delete_cargohold_folder').click(function(){
		$('#myModal2').modal('hide');
		$('#myModal3').modal('hide');
		$('#myModal4').modal('hide');
		$('#myModalDeleteFolder').modal('show');
		$('#myModalCargoholdMoveTo').modal('hide');
		cargohold_folder_id = $(this).data('cargohold_folder_id');
	});
	
	$('.view_cargohold_folder').click(function(){
		var tab = $(this).data('tab');
		cargohold_folder_id = $(this).data('cargohold_folder_id');
		$('.super-admin-cargo-hold-box-main-tab'+tab+'-folders-inner').hide();
		$('.super-admin-cargo-hold-box-main-tab'+tab+'-folder-tabs').hide();$('#folder-tab-'+cargohold_folder_id).show();
	});
	
	$('.cargohold_folder_back').click(function(){
		var tab = $(this).data('tab');
		$('.super-admin-cargo-hold-box-main-tab'+tab+'-folder-tabs').hide();
		$('.super-admin-cargo-hold-box-main-tab'+tab+'-folders-inner').show();
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("admin/cargohold/deletecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-archive-butn').click(function(){
		window.location.href = '{{ url("admin/cargohold/archivecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-active-butn').click(function(){
		window.location.href = '{{ url("admin/cargohold/activecargohold") }}'+'/'+cargo_id;
	});
	
	$('#createCargoHoldFolder').validate({
		rules:{
			create_folder_name:{required:true},
			create_folder_category:{required:true},
		},
		messages:{
			
		}
	});
	
	$('.popup-delete-cargohold-folder-butn').click(function(){
		window.location.href = '{{ url("admin/cargohold/removefolder") }}'+'/'+cargohold_folder_id;
	});
	
	//Code for when clicked on pagination then default tab should be active
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
	  var CurrentUrl = window.location.href;
	  console.log(CurrentUrl);
	  var UrlBreaked = CurrentUrl.split("?");
	  console.log(UrlBreaked[1]);
	  if(UrlBreaked[1]){
		  $('ul.pagination > .page-item').each(function(){
		  	if($(this).find('a').length){
			  	pageLink = $(this).find('a').attr('href');
			  	$(this).find('a').attr('href', pageLink + '&' + UrlBreaked[1]);
			}
		  });
	  }
	});	
});
</script>

@endsection