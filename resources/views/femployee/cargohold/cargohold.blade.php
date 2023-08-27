@extends('femployee.layout.main')

@section('content')
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
		<div class="main-head-franchise">
			<div class="main-deck-head main-deck-head-franchise">
				<h4>{{ $sub_title }}</h4>
                <p>{{ $sub_title }} / <span id="change-bread-crumb">Documents </span></p>
			</div>
			<div class="add-franchise-butn-main">
				<a href="{{ url('femployee/cargohold/uploaddocument') }}" class="btn"><i class="fa fa-upload" aria-hidden="true"></i>Upload Document</a>
			</div>
			<div class="clearfix"></div>
		</div>
		
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif

		@php 
			$requests = array('tab2','tab3','tab4','tab5'); 
			$tab = Request::get('tab');
		@endphp
		
		<div class="super-admin-cargo-hold-main">
			<div class="super-cargo-tabs-main">
				<ul class="nav nav-tabs">
					<li class="@if( !in_array(Request::get('tab'),$requests) ) active @endif"><a data-id="?tab=tab1" data-toggle="tab" href="#Documents">Documents</a></li>
					<li class="@if($tab == 'tab2') active @endif"><a data-id="?tab=tab2" data-toggle="tab" href="#Employee_Training">Employee Training</a></li>
					<li class="@if($tab == 'tab3') active @endif"><a data-id="?tab=tab3" data-toggle="tab" href="#SOS_Forms">SOS Forms</a></li>
					<li class="@if($tab == 'tab4') active @endif"><a data-id="?tab=tab4" data-toggle="tab" href="#Parent_training">Parent Training</a></li>
					<li class="@if($tab == 'tab5') active @endif"><a data-id="?tab=tab5" data-toggle="tab" href="#Employee_Forms">Employee Forms</a></li>
				</ul>
			</div>
			<div class="super-admin-cargo-tab-content">
				<div class="tab-content">
					<div id="Documents" class="tab-pane fade @if( !in_array(Request::get('tab'),$requests) ) in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Documents->isEmpty())
							@php $count = 1; @endphp
							@foreach($Documents as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif

							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('femployee/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('femployee/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<a href="{{ url('femployee/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
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
							@endif
	
							<div class="clearfix"></div>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-pagination">
								{{-- {!! $Confidentiality_forms->render() !!} --}}
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					
					<div id="Employee_Training" class="tab-pane fade @if($tab == 'tab2') in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Employee_Training->isEmpty())
							@php $count = 1; @endphp
							@foreach($Employee_Training as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('femployee/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('femployee/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
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
					</div><!-- Disclosure -->
					
					<div id="SOS_Forms" class="tab-pane fade @if($tab == 'tab3') in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$SOS_Forms->isEmpty())
							@php $count = 1; @endphp
							@foreach($SOS_Forms as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('femployee/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('femployee/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
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
					</div><!--Required-Insurance-->

					<div id="Parent_training" class="tab-pane fade @if($tab == 'tab4') in active @endif">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Parent_training->isEmpty())
							@php $count = 1; @endphp
							@foreach($Parent_training as $cargo)
							@if($count > 8)
								{!! '<div class="clearfix"></div></div><div class="super-admin-cargo-hold-box-main">' !!}
								@php $count = 1; @endphp
							@endif
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('femployee/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('femployee/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
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
					</div><!--Required-Insurance-->

					<div id="Employee_Forms" class="tab-pane fade @if($tab == 'tab5') in active @endif">
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
                                	<a href="{{ url('femployee/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('femployee/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
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
					</div><!--Required-Insurance-->
					
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

<script type="text/javascript">
$(document).ready(function(){

    $('a[data-toggle="tab"]').click(function(e) {
        window.history.replaceState(null, null, "/femployee/cargohold/"+$(this).data("id"))
        e.preventDefault();
    });
    
	//code for delete cargo hold
	var cargo_id = '';
	$('.delete_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal3').modal('hide');
		$('#myModal2').modal('show');
		$('#myModal4').modal('hide');
	});

	$('.archive_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal2').modal('hide');
		$('#myModal3').modal('show');
		$('#myModal4').modal('hide');
	});

	$('.active_cargohold').click(function(){
		cargo_id = $(this).data('cargo_id');
		$('#myModal2').modal('hide');
		$('#myModal3').modal('hide');
		$('#myModal4').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("femployee/cargohold/deletecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-archive-butn').click(function(){
		window.location.href = '{{ url("femployee/cargohold/archivecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-active-butn').click(function(){
		window.location.href = '{{ url("femployee/cargohold/activecargohold") }}'+'/'+cargo_id;
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