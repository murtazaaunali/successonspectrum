@extends('parent.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>Client / <span id="change-bread-crumb">Client Information</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			<?php /*?><ul class="nav nav-tabs ClientNavTabs">
			  <li class="padd-left-anchor active"><a data-toggle="tab" href="#">Client Information</a></li>
			  <li class="trigger"><a href="{{ url('parent/client/viewinsurance/'.$Client->id) }}">Insurance</a></li>
			  <li class="trigger"><a href="{{ url('parent/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
			  <li class="trigger pos-rel"><a href="{{ url('parent/client/viewarchives/'.$Client->id) }}">Archives</a>
              	@if(!$ClientArchives->isEmpty())
					<span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
				@endif
              </li>
			  <li class="trigger"><a href="{{ url('parent/client/viewagreement/'.$Client->id) }}">Agreement</a></li>
			  <li class="trigger"><a href="{{ url('parent/client/viewtasklist/'.$Client->id) }}">Task List</a></li>
			</ul><?php */?>
            @include('parent.client.clientTop')

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Client's Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('parent/client/edit/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            <figure><h5>Status</h5>
				    		<h4 class="green-clr" @if($Client->client_status == 'Terminated') style="color: #fc6666 !important;" @endif>
                            <?php /*?>{{ $Client->client_status }}<?php */?>
                            @if($Client->client_status == 'Terminated')
                            Inactive
                            @elseif($Client->client_status == 'Applicant')
                            Waiting List
                            @else
                            {{ $Client->client_status }}
                            @endif
                            </h4>
				    		</figure>
				    		<figure><h5>Client's Name</h5><h4>{{ $Client->client_childfullname }}</h4></figure>
                            <figure>
                            	<h5>Child's Date of Birth</h5>
                                @if($Client->client_childdateofbirth != "" && $Client->client_childdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_childdateofbirth)) }}</h4>
                                @endif
                            </figure>
				    		<figure><h5>Custodial Parent</h5><h4>{{ $Client->client_custodialparent }}</h4></figure>
                            <figure><h5>Location of Services</h5><h4>{{ $Client->chooselocation_interest }}</h4></figure>
                            <figure><h5>Child's School</h5><h4>{{ $Client->client_schoolname }}</h4></figure>
                            <?php /*?><figure><h5>Crew</h5><h4>@if($Client->client_crew) @if($Client->ClientCrew) {{ $Client->ClientCrew->personal_name }} @endif @endif</h4></figure><?php */?>
                            <figure><h5>Crew</h5><h4>{{ $Client->client_crew }}</h4></figure>
                            <figure><h5>Client Address</h5><h4>{{ $Client->client_custodialparentsaddress }}</h4></figure>
                            <figure><h5>Mom's Name</h5><h4>{{ $Client->client_momsname }}</h4></figure>
				    		<figure><h5>Mom's Email</h5><h4>{{ $Client->client_momsemail }}</h4></figure>
                            <figure><h5>Mom's Cell</h5><h4>{{ $Client->client_momscell }}</h4></figure>
                            <figure><h5>Custodial Parent's Address</h5><h4>{{ $Client->client_custodialparentsaddress }}</h4></figure>
                            <figure><h5>Dad's Name</h5><h4>{{ $Client->client_dadsname }}</h4></figure>
				    		<figure><h5>Dad's Email</h5><h4>{{ $Client->client_dadsemail }}</h4></figure>
                            <figure><h5>Dad's Cell</h5><h4>{{ $Client->client_dadscell }}</h4></figure>
                            <figure><h5>Emergency Contact Name</h5><h4>{{ $Client->client_emergencycontactname }}</h4></figure>
				    		<figure><h5>Emergency Contact Phone</h5><h4>{{ $Client->client_emergencycontactphone }}</h4></figure>
                            <figure><h5>Login Email</h5><h4>{{ $Client->email }}</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
					</div>
                </div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>

<script type="text/javascript">
	$('document').ready(function(){
		
		//code for delete contact
		var Client_id = '';
		var contact_id = '';
		$('.owner_delete').click(function(){
			Client_id 	= $(this).data('Client_id');
			contact_id 		= $(this).data('contact_id');
			$('#myModal-22').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/Client/deletecontact") }}'+'/'+Client_id+'/'+contact_id;
		});
		
		//code for delete certification
		var Client_id = '';
		var certification_id = '';
		$('.certification_delete').click(function(){
			Client_id 	= $(this).data('Client_id');
			certification_id 		= $(this).data('certification_id');
			$('#myModal-Certification').modal('show');
		});
		
		$('.popup-certification-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/Client/deletecertification") }}'+'/'+Client_id+'/'+certification_id;
		});
		
		//code for delete credential
		var Client_id = '';
		var credential_id = '';
		$('.credential_delete').click(function(){
			Client_id 	= $(this).data('Client_id');
			credential_id 		= $(this).data('credential_id');
			$('#myModal-Credential').modal('show');
		});
		
		$('.popup-credential-delete-butn').click(function(){
			window.location.href = '{{ url("franchise/Client/deletecredential") }}'+'/'+Client_id+'/'+credential_id;
		});
		
		//Print Report of time punches
	});
</script>


@endsection
