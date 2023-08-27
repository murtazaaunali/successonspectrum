@extends('parent.layout.main')
@php $router_name = Request::route()->getName();@endphp
@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>@if($router_name != 'parent.insurance')Client / @else View @endif<span id="change-bread-crumb">Insurance</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('parent.client.clientTop')	

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main @if($router_name == "parent.insurance") view-tab-content-head-main-3 @endif ">
				    		<div class="view-tab-content-head">
				    			<h3>Insurance</h3>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	@if($Client->client_insurancecompanyidcard != '')
                            <div class="blue-border-box blue-border-box-3 pos-rel">
                                <a href="javascript:;" data-client_id="{{ $Client->id }}" class="owner_edit upload_client_insurancecompanyidcard"><i class="fa fa-pencil"></i></a>
                                <form action="@if($router_name != 'parent.insurance'){{ url('parent/client/editinsurance/deleteinsurancecompanyidcard/'.$Client->id) }} @else {{ url('parent/insurance/edit/deleteinsurancecompanyidcard/'.$Client->id) }} @endif" method="post" id="insurance_form">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                	<button class="owner_delete" style="border:none;"><i class="fa fa-trash"></i></button>
                                </form>
                                <img src="{{ url($Client->client_insurancecompanyidcard) }}" class="w-100"> 
                            </div>
                            @else 
                            <div class="upload-box-main upload_client_insurancecompanyidcard" style="width:25%; padding: 25px 20px;">
                                <div class="drop">
                                    <div class="cont">
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </div>
                                        <div class="upload-para">
                                            <p>click here to upload Insurance ID<span class="required-field">*</span></p>
                                        </div>
                                    </div>

                                    @if($errors->has('client_insurancecompanyidcard'))
                                        <span class="help-block error">{{ $errors->first('client_insurancecompanyidcard') }}</span>			    	
                                    @endif
                                    <div class="file-upload">
                                        <div class="file-select-name noFile"></div> 
                                    </div>
                                    <label class="error" for="client_insurancecompanyidcard"></label>
                                </div>
                            </div>
                            @endif
                            <div class="hidden">
                                <form action="@if($router_name != 'parent.insurance'){{ url('parent/client/editinsurance/uploadinsurancecompanyidcard/'.$Client->id) }} @else {{ url('parent/insurance/edit/uploadinsurancecompanyidcard/'.$Client->id) }} @endif" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input id="client_insurancecompanyidcard" name="client_insurancecompanyidcard" type="file"/>
                                </form>
                            </div>
                            <div class="clearfix"></div>  
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Primary Policy</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="@if($router_name != 'parent.insurance'){{ url('parent/client/editinsurance/primarypolicy/'.$Client->id) }} @else {{ url('parent/insurance/edit/primarypolicy/'.$Client->id) }} @endif" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<figure><h5>Insurance Company Name</h5><h4>{{ $Client->client_insurancecompanyname }}</h4></figure>
                            <figure><h5>Member ID</h5><h4>{{ $Client->client_memberid }}</h4></figure>
                            <figure><h5>Group ID</h5><h4>{{ $Client->client_groupid }}</h4></figure>
				    		<figure><h5>Policyholder's Name (Usually a parent)</h5><h4>{{ $Client->client_policyholdersname }}</h4></figure>
                            <figure>
                            	<h5>Policyholder's Date of Birth</h5>
                                @if($Client->client_policyholdersdateofbirth != "" && $Client->client_policyholdersdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_policyholdersdateofbirth)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>Client's Name</h5><h4>{{ $Client->client_childfullname }}</h4></figure>
                            <figure>
                            	<h5>Client's DOB</h5>
                                @if($Client->client_childdateofbirth != "" && $Client->client_childdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_childdateofbirth)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>Client's Address</h5><h4>{{ $Client->client_custodialparentsaddress }}</h4></figure>
                            <figure><h5>Subscriber's Name</h5><h4>{{ $Client->client_subscribername }}</h4></figure>
                            <figure>
                            	<h5>Subscriber's DOB</h5>
                                @if($Client->client_subscriberdateofbirth != "" && $Client->client_subscriberdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_subscriberdateofbirth)) }}</h4>
                                @endif
                            </figure>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Benefits</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="@if($router_name != 'parent.insurance'){{ url('parent/client/editinsurance/benefits/'.$Client->id) }} @else {{ url('parent/insurance/edit/benefits/'.$Client->id) }} @endif" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            <figure>
                            	<h5>Effective Date</h5>
                                @if($Client->client_benefiteffectivedate != "" && $Client->client_benefiteffectivedate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_benefiteffectivedate)) }}</h4>
                                @endif
                            </figure>
                            <figure>
                            	<h5>Expiration Date</h5>
                                @if($Client->client_benefitexpirationdate != "" && $Client->client_benefitexpirationdate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_benefitexpirationdate)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>Copay</h5><h4>${{ $Client->client_benefitcopay }}</h4></figure>
                            <figure><h5>OOPM</h5><h4>{{ $Client->client_benefitoopm }}</h4></figure>
                            <figure><h5>Annual Benefit</h5><h4>${{ $Client->client_benefitannualbenefit }}</h4></figure>
                            <figure><h5>Claim's Address</h5><h4>{{ $Client->client_benefitclaimaddress }}</h4></figure>
                            <figure>
                            	<h5>Date Verified</h5>
                                @if($Client->client_benefitdateverified != "" && $Client->client_benefitdateverified != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_benefitdateverified)) }}</h4>
                                @endif
                            </figure>
				    		<figure><h5>Insurance Employee</h5><h4>{{ $Client->client_benefitinsuranceemployee }}</h4></figure>
                            <figure><h5>Reference Number</h5><h4>{{ $Client->client_benefitreferencenumber }}</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Authorizations</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="@if($router_name != 'parent.insurance'){{ url('parent/client/editinsurance/authorizations/'.$Client->id) }} @else {{ url('parent/insurance/edit/authorizations/'.$Client->id) }} @endif" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            <figure>
                            	<h5>Start Date</h5>
                                @if($Client->client_authorizationsstartdate != "" && $Client->client_authorizationsstartdate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_authorizationsstartdate)) }}</h4>
                                @endif
                            </figure>
                            <figure>
                            	<h5>End Date</h5>
                                @if($Client->client_authorizationseenddate != "" && $Client->client_authorizationseenddate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_authorizationseenddate)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>ABA</h5><h4>${{ $Client->client_authorizationsaba }}</h4></figure>
                            <figure><h5>Supervision</h5><h4>{{ $Client->client_authorizationssupervision }}</h4></figure>
                            <figure>
                            	<h5>Parent Training</h5>
                                @if($Client->client_authorizationsparenttraining != "" && $Client->client_authorizationsparenttraining != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_authorizationsparenttraining)) }}</h4>
                                @endif
                            </figure>
                            <figure>
                            	<h5>Reassessment</h5>
                                @if($Client->client_authorizationsreassessment != "" && $Client->client_authorizationsreassessment != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_authorizationsreassessment)) }}</h4>
                                @endif
                            </figure>
				    		<div class="padd-view"></div>
				    	</div>
					</div>
                </div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>

	 <div class="delete-popup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="myModal2" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content DeleteEmployeepopup">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Delete Insurance Company ID Card?</h4>
	        </div>
	        <div class="modal-body">
	          <p>Are you sure you want to delete this Insurance Company ID Card?</p>
	          <input class="btn popup-delete-butn" type="button" value="Delete">
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
        $('document').ready(function(){
            $('.upload_client_insurancecompanyidcard').click(function () {
			  $('input[name="client_insurancecompanyidcard"]').click();
			});
			$('input[name="client_insurancecompanyidcard"]').change(function () {
			  /*if (before_img_upload == "") before_img_upload = $('.upload-display-icon-main').html();
			  if ($('.upload-display-icon-main').hasClass('no-border') && hasborder == 0) hasborder = 1;else if (hasborder != 1) hasborder = 2;
			  console.log(hasborder);*/
			
			  if (this.files[0]) {
				/*var reader = new FileReader();
			
				reader.onload = function (e) {
				  if (hasborder == 2) $('.upload-display-icon-main').addClass('no-border');
				  $('.upload-display-icon-main').html('<img src="' + e.target.result + '" class="img-responsive img-circle" />');
				};
			
				reader.readAsDataURL(this.files[0]);*/
				$(this).parent().submit();
			  } else {
				/*if (hasborder == 2) $('.upload-display-icon-main').removeClass('no-border');
				$('.upload-display-icon-main').html(before_img_upload);*/
			  }
			});

			//DELETE INSURANCE IMAGE CODE
			$('.owner_delete').click(function(event){
				event.preventDefault();
				$('#myModal2').modal('show');
			});
			
			$('.popup-delete-butn').click(function(){
				$('#insurance_form').submit();
			});
		
        });
    </script>
@endsection
