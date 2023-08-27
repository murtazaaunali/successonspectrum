@extends('parent.layout.main')

@section('content')
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
		<div class="main-head-franchise">
			<div class="main-deck-head main-deck-head-franchise">
				<h4>{{ $Client->client_childfullname }}</h4>
                <p>{{ $sub_title }} / <span id="change-bread-crumb">Documents </span></p>
			</div>
			<div class="add-franchise-butn-main">
				<a href="{{ url('parent/cargohold/uploaddocument') }}" class="btn"><i class="fa fa-upload" aria-hidden="true"></i>Upload Document</a>
			</div>
			<div class="clearfix"></div>
		</div>
		
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		
		<div class="super-admin-cargo-hold-main">
			<div class="super-cargo-tabs-main">
				<ul class="nav nav-tabs">
					<li class="active"><a data-id="?tab=tab1" data-toggle="tab" href="#Documents">Documents</a></li>
					<li><a data-id="?tab=tab2" data-toggle="tab" href="#Parent_Training">Parent Training</a></li>
					<li><a data-id="?tab=tab3" data-toggle="tab" href="#Parent_Forms">Parent Forms</a></li>
                    <li><a data-id="?tab=tab4" data-toggle="tab" href="#SOS_Forms">SOS Forms</a></li>
				</ul>
			</div>
			<div class="super-admin-cargo-tab-content">
				<div class="tab-content">
					<div id="Documents" class="tab-pane fade in active">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Documents->isEmpty())
							@foreach($Documents as $cargo)
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('parent/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('parent/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<!--<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>-->
									<a href="{{ url('parent/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
								</div>
								<div class="clearfix"></div>
								<a href="#">
									@if(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets') }}/images/pdf.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'ppt')
                                    	<img src="{{ asset('assets') }}/images/ppt.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'png')
                                    	<img src="{{ asset('assets') }}/images/png.png">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'jpg')
                                    	<img src="{{ asset('assets') }}/images/jpg.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pptx')
                                    	<img src="{{ asset('assets') }}/images/pptx.jpg">
                                    @else
                                        <img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                    @endif
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
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
					
					<div id="Parent_Training" class="tab-pane fade">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Parent_Training->isEmpty())
							@foreach($Parent_Training as $cargo)
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('parent/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('parent/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<!--<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>-->
									<!--<a href="{{ url('parent/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>-->
								</div>
								<div class="clearfix"></div>
								<a href="#">
									@if(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets') }}/images/pdf.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'ppt')
                                    	<img src="{{ asset('assets') }}/images/ppt.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'png')
                                    	<img src="{{ asset('assets') }}/images/png.png">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'jpg')
                                    	<img src="{{ asset('assets') }}/images/jpg.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pptx')
                                    	<img src="{{ asset('assets') }}/images/pptx.jpg">
                                    @else
                                        <img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                    @endif
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
							@endforeach
							@endif
							<div class="clearfix"></div>
						</div>
					</div><!-- Disclosure -->
					
					<div id="Parent_Forms" class="tab-pane fade">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Parent_Forms->isEmpty())
							@foreach($Parent_Forms as $cargo)
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('parent/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('parent/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
								</div>
								<div class="clearfix"></div>
								<a href="#">
									@if(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets') }}/images/pdf.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'ppt')
                                    	<img src="{{ asset('assets') }}/images/ppt.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'png')
                                    	<img src="{{ asset('assets') }}/images/png.png">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'jpg')
                                    	<img src="{{ asset('assets') }}/images/jpg.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pptx')
                                    	<img src="{{ asset('assets') }}/images/pptx.jpg">
                                    @else
                                        <img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                    @endif
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
							@endforeach
							@endif
							<div class="clearfix"></div>
						</div>						
					</div>
                    
                    <div id="SOS_Forms" class="tab-pane fade">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$SOS_Forms->isEmpty())
							@foreach($SOS_Forms as $cargo)
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('parent/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('parent/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<!--<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="archive_cargohold">Archive</a>-->
									<!--<a href="{{ url('parent/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>-->
								</div>
								<div class="clearfix"></div>
								<a href="#">
									@if(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets') }}/images/pdf.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'ppt')
                                    	<img src="{{ asset('assets') }}/images/ppt.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'png')
                                    	<img src="{{ asset('assets') }}/images/png.png">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'jpg')
                                    	<img src="{{ asset('assets') }}/images/jpg.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pptx')
                                    	<img src="{{ asset('assets') }}/images/pptx.jpg">
                                    @else
                                        <img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                    @endif
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
							@endforeach
							@endif
							<div class="clearfix"></div>
						</div>						
					</div><!--Required-Insurance-->
					
					<div id="Archives" class="tab-pane fade">
						<div class="super-admin-cargo-hold-box-main">
							@if(!$Archives->isEmpty())
							@foreach($Archives as $cargo)
							<div class="super-admin-cargo-hold-box dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
								<div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                	<a href="{{ url('parent/cargohold/viewpdf/'.$cargo->id) }}" class="head-active" target="_blank">View</a>
									<a href="{{ url('parent/cargohold/downloadpdf/'.$cargo->id) }}" class="head-active">Download</a>
									<!--<a href="javascript:void(0);" data-cargo_id="{{ $cargo->id }}" class="active_cargohold">Active</a>-->
									<a href="{{ url('parent/cargohold/edit/?cargo_id='.$cargo->id) }}">Edit</a>
									<a href="#" data-cargo_id="{{ $cargo->id }}" class="bord-bot-0 red-clr delete_cargohold">Delete</a>
								</div>
								<div class="clearfix"></div>
								<a href="#">
									@if(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets') }}/images/pdf.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'ppt')
                                    	<img src="{{ asset('assets') }}/images/ppt.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'png')
                                    	<img src="{{ asset('assets') }}/images/png.png">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'jpg')
                                    	<img src="{{ asset('assets') }}/images/jpg.jpg">
                                    @elseif(pathinfo($cargo->file,PATHINFO_EXTENSION) == 'pptx')
                                    	<img src="{{ asset('assets') }}/images/pptx.jpg">
                                    @else
                                        <img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                    @endif
									<p>{{ $cargo->title }}</p>
								</a>
							</div>
							@endforeach
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

<script type="text/javascript">
$(document).ready(function(){
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
		window.location.href = '{{ url("parent/cargohold/deletecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-archive-butn').click(function(){
		window.location.href = '{{ url("parent/cargohold/archivecargohold") }}'+'/'+cargo_id;
	});

	$('.popup-active-butn').click(function(){
		window.location.href = '{{ url("parent/cargohold/activecargohold") }}'+'/'+cargo_id;
	});
});
</script>

@endsection