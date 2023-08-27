@extends('franchise.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>Client / {{ $Client->client_childfullname }} / <span id="change-bread-crumb">Agreement</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('franchise.clients.clientTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('franchise.clients.clientTabMenu')
            <!--<ul class="nav nav-tabs ClientNavTabs">
			  <li class="trigger"><a href="{{ url('franchise/client/view/'.$Client->id) }}">Client Information</a></li>
			  <li class="trigger"><a href="{{ url('franchise/client/viewinsurance/'.$Client->id) }}">Insurance</a></li>
			  <li class="trigger"><a href="{{ url('franchise/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
			  <li class="trigger pos-rel"><a href="{{ url('franchise/client/viewarchives/'.$Client->id) }}">Archives</a>
              	@if(!$ClientArchives->isEmpty())
					<span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
				@endif
              </li>
			  <li class="trigger padd-left-anchor active"><a href="#" style="padding-left:30px;">Agreement</a></li>
			  <li class="trigger"><a href="{{ url('franchise/client/viewtasklist/'.$Client->id) }}">Task List</a></li>	
			</ul>-->

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Agreement</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/client/editagreement/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            
				    		<figure><h5>HIPAA Agreement Form</h5><h4>@if($Client->agreement_hippa == 1)Yes ({{ date('jS M Y',strtotime($Client->hipaa_date)) }}) @else No @endif</h4></figure>
                            <figure><h5>Payment Agreement</h5><h4>@if($Client->agreement_payment == 1)Yes ({{ date('jS M Y',strtotime($Client->payment_parentsdate)) }}) @else No @endif</h4></figure>
                            <figure><h5>Informed Consent For Services</h5><h4>@if($Client->agreement_informed == 1)Yes ({{ date('jS M Y',strtotime($Client->informed_date)) }}) @else No @endif</h4></figure>
				    		<figure><h5>Security System Waiver</h5><h4>@if($Client->agreement_security == 1)Yes ({{ date('jS M Y',strtotime($Client->security_date)) }}) @else No @endif</h4></figure>
                            <figure><h5>Release of Liability</h5><h4>@if($Client->agreement_release == 1)Yes ({{ date('jS M Y',strtotime($Client->release_date)) }}) @else No @endif</h4></figure>
                            <figure><h5>Parent Handbook Agreement</h5><h4>@if($Client->agreement_parent == 1)Yes ({{ date('jS M Y',strtotime($Client->parent_date)) }}) @else No @endif</h4></figure>
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
            
            
        });
    </script>

@endsection
