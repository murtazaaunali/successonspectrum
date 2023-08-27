@extends('franchise.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>Client / {{ $Client->client_childfullname }} / <span id="change-bread-crumb">Insurance</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		

		<!-- Image modal -->
		<div class="modal fade image_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <img src="" width="100%">
		    </div>
		  </div>
		</div>
		
		@include('franchise.clients.clientTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('franchise.clients.clientTabMenu')
            <!--<ul class="nav nav-tabs ClientNavTabs">
			  <li class="trigger"><a href="{{ url('franchise/client/view/'.$Client->id) }}">Client Information</a></li>
			  <li class="trigger padd-left-anchor active"><a href="#">Insurance</a></li>
			  <li class="trigger"><a href="{{ url('franchise/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
			  <li class="trigger pos-rel"><a href="{{ url('franchise/client/viewarchives/'.$Client->id) }}">Archives</a>
              	@if(!$ClientArchives->isEmpty())
					<span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
				@endif
              </li>
			  <li class="trigger"><a href="{{ url('franchise/client/viewagreement/'.$Client->id) }}" style="padding-left:30px;">Agreement</a></li>
              <li class="trigger"><a href="{{ url('franchise/client/viewtasklist/'.$Client->id) }}">Task List</a></li>
			</ul>-->

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<!--<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Insurance</h3>
				    		</div>
                            <div class="view-tab-content-butn">
                                <a href="{{ url('franchise/client/addinsurance/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-plus" aria-hidden="true"></i>Add Insurance</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>-->
				    	<div class="view-tab-content">
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="super-admin-table-select">
                                        <select name="client_related_insurance">
                                            <option value="">Select Related (Insurance)</option>
                                            @if(!$ClientInsurancePolicies->isEmpty())
                                                @foreach($ClientInsurancePolicies as $eachClientInsurancePolicy)
                                                    <?php /*?>@if($eachClientInsurancePolicy->id != $ClientInsurancePolicy->id)<?php */?>
                                                    <option value="{{ $eachClientInsurancePolicy->id }}" @if($client_related_insurance == $eachClientInsurancePolicy->id) selected="" @endif>
                                                    @if($eachClientInsurancePolicy->client_insurance_primary == 0 && $eachClientInsurancePolicy->client_insurancename == "")    							{{ $eachClientInsurancePolicy->client_insurancecompanyname }}    
                                                    @elseif($eachClientInsurancePolicy->client_insurance_primary == 1 && $eachClientInsurancePolicy->client_insurancename == "")
                                                        Primary Policy
                                                    @elseif($eachClientInsurancePolicy->client_insurance_primary == 0 && $eachClientInsurancePolicy->client_insurancename != "")    							{{ $eachClientInsurancePolicy->client_insurancename }}
                                                    @elseif($eachClientInsurancePolicy->client_insurance_primary == 1 && $eachClientInsurancePolicy->client_insurancename != "")
                                                        {{ $eachClientInsurancePolicy->client_insurancename }} (Primary Policy)
                                                    @endif
                                                    </option>
                                                    <?php /*?>@endif<?php */?>        
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                	<a href="{{ url('franchise/client/addinsurance/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-plus" aria-hidden="true"></i>Add Insurance</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!--@if($Client->client_insurancecompanyidcard != '')
                            <div class="blue-border-box blue-border-box-3 pos-rel"  style="width: auto !important;">
                                <a href="javascript:;" data-client_id="{{ $Client->id }}" class="owner_edit upload_client_insurancecompanyidcard"><i class="fa fa-pencil"></i></a>
                                <a href="{{ url('franchise/client/downloadidcard/'.$Client->id) }}" data-client_id="{{ $Client->id }}" class="download_insuarance"><i class="fa fa-download"></i></a>
                                <form action="{{ url('franchise/client/editinsurance/deleteinsurancecompanyidcard/'.$Client->id) }}" method="post" id="insurance_form">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                	<button class="owner_delete" style="border:none;"><i class="fa fa-trash"></i></button>
                                </form>
                                <a href="javascript:;"><img class="insurance_image" src="{{ url($Client->client_insurancecompanyidcard) }}" width="200" data-toggle="modal" data-target=".image_modal"></a>
                                
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
                                <form action="{{ url('franchise/client/editinsurance/uploadinsurancecompanyidcard/'.$Client->id) }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input id="client_insurancecompanyidcard" name="client_insurancecompanyidcard" type="file" accept="image/*" />
                                </form>
                            </div>
                            <div class="clearfix"></div>-->  
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>
                                @if($ClientInsurancePolicy->client_insurance_primary == 0 && $ClientInsurancePolicy->client_insurancename == "")    								Policy Details    
                                @elseif($ClientInsurancePolicy->client_insurance_primary == 1 && $ClientInsurancePolicy->client_insurancename == "")
                                    Primary Policy
                                @elseif($ClientInsurancePolicy->client_insurance_primary == 0 && $ClientInsurancePolicy->client_insurancename != "")    											
                                	{{ $ClientInsurancePolicy->client_insurancename }}
                                @elseif($ClientInsurancePolicy->client_insurance_primary == 1 && $ClientInsurancePolicy->client_insurancename != "")
                                    {{ $ClientInsurancePolicy->client_insurancename }} (Primary Policy)
                                @endif
                                </h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			@if($ClientInsurancePolicy->client_insurance_primary != 1)
                                    <a href="{{ url('franchise/client/setinsurance/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Set as Primary</a>
                                @endif   
                                <a href="{{ url('franchise/client/editinsurance/primarypolicy/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	@if( !$ClientInsurancePolicyIDCards->isEmpty() )
                            	@foreach($ClientInsurancePolicyIDCards as $ClientInsurancePolicyIDCard)
                                	<div class="blue-border-box blue-border-box-3 pos-rel"  style="width: 20% !important;height:150px;text-align:center">
                                        <a href="javascript:;" data-client_id="{{ $Client->id }}" data-client_insurance_id="{{ $ClientInsurancePolicy->id }}" data-client_insurancepolicycard_id="{{ $ClientInsurancePolicyIDCard->id }}" class="owner_edit upload_client_insurancecompanyidcard"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('franchise/client/viewinsurance/downloadinsuranceidcard/'.$Client->id.'/'.$ClientInsurancePolicy->id.'/'.$ClientInsurancePolicyIDCard->id) }}" class="download_insuarance_idcard"><i class="fa fa-download"></i></a>
                                        <form action="{{ url('franchise/client/viewinsurance/deleteinsuranceidcard/'.$Client->id.'/'.$ClientInsurancePolicy->id.'/'.$ClientInsurancePolicyIDCard->id) }}" method="post" id="insurance_form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                            <button class="owner_delete delete_insuarance_idcard" style="border:none;"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="javascript:;"><img class="insurance_image" src="{{ url($ClientInsurancePolicyIDCard->client_insurancecompanyidcard) }}" width="auto" height="100%" data-toggle="modal" data-target=".image_modal"></a>
                                    </div>
                                @endforeach
                            @endif
                            <div class="upload-box-main upload_client_insurancecompanyidcard" style="width:20%; padding: 34px 20px;float:left">
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
                            <!--@if($Client->client_insurancecompanyidcard != '')
                            <div class="blue-border-box blue-border-box-3 pos-rel"  style="width: auto !important;">
                                <a href="javascript:;" data-client_id="{{ $Client->id }}" data-client_insurance_id="{{ $ClientInsurancePolicy->id }}" data-client_insurance_idcard_id="{{ $ClientInsurancePolicy->id }}" class="owner_edit upload_client_insurancecompanyidcard"><i class="fa fa-pencil"></i></a>
                                <a href="{{ url('franchise/client/downloadidcard/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" data-client_id="{{ $Client->id }}" data-client_insurance_id="{{ $ClientInsurancePolicy->id }}" data-client_insurance_idcard_id="{{ $ClientInsurancePolicy->id }}" class="download_insuarance_idcard"><i class="fa fa-download"></i></a>
                                <form action="{{ url('franchise/client/editinsurance/deleteinsurancecompanyidcard/'.$Client->id) }}" method="post" id="insurance_form">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                	<button class="owner_delete delete_insuarance_idcard" style="border:none;"><i class="fa fa-trash"></i></button>
                                </form>
                                <a href="javascript:;"><img class="insurance_image" src="{{ url($Client->client_insurancecompanyidcard) }}" width="200" data-toggle="modal" data-target=".image_modal"></a>
                                
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
                            @endif-->
                            <div class="hidden">
                                <form action="{{ url('franchise/client/viewinsurance/uploadinsuranceidcard/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input type="hidden" name="client_insurancepolicycard_id" value="" >
                                    <input id="client_insurancecompanyidcard" name="client_insurancecompanyidcard" type="file" accept="image/*" />
                                </form>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
				    		<figure><h5>Insurance Name</h5><h4>{{ $ClientInsurancePolicy->client_insurancename }}</h4></figure>
                            <figure><h5>Insurance Payer Id</h5><h4>{{ $ClientInsurancePolicy->client_insurancepayerid }}</h4></figure>
                            <?php /*?><figure><h5>Insurance Company Name</h5><h4>{{ $ClientInsurancePolicy->client_insurancecompanyname }}</h4></figure><?php */?>
                            <figure><h5>Insurance Phone Number</h5><h4>{{ $ClientInsurancePolicy->client_insurancephone_number }}</h4></figure>
                            <figure><h5>Member ID</h5><h4>{{ $ClientInsurancePolicy->client_memberid }}</h4></figure>
                            <figure><h5>Group ID</h5><h4>{{ $ClientInsurancePolicy->client_groupid }}</h4></figure>
				    		<figure><h5>Policyholder's Name (Usually a parent)</h5><h4>{{ $ClientInsurancePolicy->client_policyholdersname }}</h4></figure>
                            <figure>
                            	<h5>Policyholder's Date of Birth</h5>
                                @if($ClientInsurancePolicy->client_policyholdersdateofbirth != "" && $ClientInsurancePolicy->client_policyholdersdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($ClientInsurancePolicy->client_policyholdersdateofbirth)) }}</h4>
                                @endif
                            </figure>
                            <?php /*?><figure><h5>Client's Name</h5><h4>{{ $Client->client_childfullname }}</h4></figure>
                            <figure>
                            	<h5>Client's DOB</h5>
                                @if($Client->client_childdateofbirth != "" && $Client->client_childdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_childdateofbirth)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>Client's Address</h5><h4>{{ $Client->client_custodialparentsaddress }}</h4></figure><?php */?>
                            <figure class="hidden"><h5>Subscriber's Name</h5><h4>{{ $Client->client_subscribername }}</h4></figure>
                            <figure class="hidden">
                            	<h5>Subscriber's DOB</h5>
                                @if($ClientInsurancePolicy->client_subscriberdateofbirth != "" && $ClientInsurancePolicy->client_subscriberdateofbirth != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($ClientInsurancePolicy->client_subscriberdateofbirth)) }}</h4>
                                @endif
                            </figure>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Benefits</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('franchise/client/editinsurance/benefits/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            <figure>
                            	<h5>Effective Date</h5>
                                @if($ClientInsurancePolicy->client_benefiteffectivedate != "" && $ClientInsurancePolicy->client_benefiteffectivedate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($ClientInsurancePolicy->client_benefiteffectivedate)) }}</h4>
                                @endif
                            </figure>
                            <figure>
                            	<h5>Expiration Date</h5>
                                @if($ClientInsurancePolicy->client_benefitexpirationdate != "" && $ClientInsurancePolicy->client_benefitexpirationdate != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($ClientInsurancePolicy->client_benefitexpirationdate)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>Copay</h5><h4>{{ $ClientInsurancePolicy->client_benefitcopay }}</h4></figure>
                            <figure><h5>OOPM</h5><h4>{{ $ClientInsurancePolicy->client_benefitoopm }}</h4></figure>
                            <figure><h5>Annual Max Benefit</h5><h4>{{ $ClientInsurancePolicy->client_benefitannualbenefit }}</h4></figure>
                            <figure><h5>Claim's Address</h5><h4>{{ $ClientInsurancePolicy->client_benefitclaimaddress }}</h4></figure>
                            <figure>
                            	<h5>Date Verified</h5>
                                @if($ClientInsurancePolicy->client_benefitdateverified != "" && $ClientInsurancePolicy->client_benefitdateverified != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($ClientInsurancePolicy->client_benefitdateverified)) }}</h4>
                                @endif
                            </figure>
				    		<figure><h5>Insurance Employee</h5><h4>{{ $ClientInsurancePolicy->client_benefitinsuranceemployee }}</h4></figure>
                            <figure><h5>Reference Number</h5><h4>{{ $ClientInsurancePolicy->client_benefitreferencenumber }}</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Authorizations</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<!--<a href="{{ url('franchise/client/editinsurance/authorizations/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>-->
                                <a href="{{ url('franchise/client/viewinsurance/addauthorization/'.$Client->id.'/'.$ClientInsurancePolicy->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Add Authorization</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	<div class="blue-border-box-main">
                                @if( !$ClientInsurancePolicyAuthorizations->isEmpty() )
				    				@php $count = 1; @endphp
					    			@foreach($ClientInsurancePolicyAuthorizations as $clients_insurance_policy_authorization)
                                        @if($clients_insurance_policy_authorization->archive == 0 && $clients_insurance_policy_authorization->isactive == 1)
                                        	<div class="blue-border-box blue-border-box-3 client-view-insurance-authorization-box @if($clients_insurance_policy_authorization->client_authorizationseenddate != "" && $clients_insurance_policy_authorization->client_authorizationseenddate != '0000-00-00')@if(\Carbon\Carbon::createFromFormat('Y-m-d H:s:i',Carbon\Carbon::now())->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d',$clients_insurance_policy_authorization->client_authorizationseenddate)) < 15)expiry @else active @endif @endif">
                                                @include('franchise.clients.insurance.viewInsuranceAuthorizationBox')
                                            </div>
                                        @endif
							    	@php $count++; @endphp	
						    		@endforeach
                                    
                                    @php $count = 1; @endphp
					    			@foreach($ClientInsurancePolicyAuthorizations as $clients_insurance_policy_authorization)
                                        @if($clients_insurance_policy_authorization->archive == 0 && $clients_insurance_policy_authorization->isactive == 0)
                                        	<!--@if($count == 1)
                                            	<div class="blue-border-box blue-border-box-3 client-view-insurance-authorization-box active">
                                                    @include('franchise.clients.insurance.viewInsuranceAuthorizationBox')
                                                </div>
                                            @else-->
                                                <!--@if($clients_insurance_policy_authorization->client_authorizationseenddate != "" && $clients_insurance_policy_authorization->client_authorizationseenddate != '0000-00-00')
                                                    @if(\Carbon\Carbon::createFromFormat('Y-m-d H:s:i',Carbon\Carbon::now())->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d',$clients_insurance_policy_authorization->client_authorizationseenddate)) < 15)
                                                        <div class="blue-border-box blue-border-box-3 client-view-insurance-authorization-box expired">
                                                            @include('franchise.clients.insurance.viewInsuranceAuthorizationBox')
                                                        </div>
                                                    @endif
                                                @endif-->
                                                <div class="blue-border-box blue-border-box-3 client-view-insurance-authorization-box expired">
                                                    @include('franchise.clients.insurance.viewInsuranceAuthorizationBox')
                                                </div>
                                            <!--@endif-->
                                        @endif
							    	@php $count++; @endphp	
						    		@endforeach
                                    
                                    @php $count = 1; @endphp
					    			@foreach($ClientInsurancePolicyAuthorizations as $clients_insurance_policy_authorization)
                                        @if($clients_insurance_policy_authorization->archive == 1)
                                        	<div class="blue-border-box blue-border-box-3 client-view-insurance-authorization-box archived">
                                            	@include('franchise.clients.insurance.viewInsuranceAuthorizationBox')
                                            </div>
                                        @endif
							    	@php $count++; @endphp	
						    		@endforeach
                                @else
                                	<p class="text-center">No Authorizations Found</p>    
					    		@endif
					    		<div class="clearfix"></div>
				    		</div>
				    		<div class="padd-view-1"></div>
				    	</div>
					</div>
                </div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>

	 <div class="delete-popup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="myModalIDCardDelete" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
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
    
    <div class="delete-popup-main">
	  <!-- Modal -->
	  <div class="modal fade" id="myModalAuthorizationDelete" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Delete Authorization?</h4>
	        </div>
	        <div class="modal-body">
	          <p>Are you sure you want to delete this Authorization?</p>
	          <input class="btn popup-delete-butn popup-delete-authorization-butn" type="button" value="Delete">
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
        $('document').ready(function(){
            $('.upload_client_insurancecompanyidcard').click(function () {
			  $('input[name="client_insurancecompanyidcard"]').click();
			  $('input[name="client_insurancepolicycard_id"]').val($(this).data('client_insurancepolicycard_id'));
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
			$('.delete_insuarance_idcard').click(function(event){
				event.preventDefault();
				$('#myModalIDCardDelete').modal('show');
			});
			
			$('.popup-delete-butn').click(function(){
				$('#insurance_form').submit();
			});

			$('.insurance_image').click(function(){
				var Img = $(this).attr('src');
				$('.image_modal img').attr('src',Img);
			})
			
			$('select[name=client_related_insurance]').change(function(){
				var pid = $(this).val();
				window.location = "{{ url('franchise/client/viewinsurance/'.$Client->id) }}/"+pid;
			})
			
			//code for delete contact
			var client_id = '';
			var authorization_id = '';
			var client_insurance_id = '';
			$('.authorization_action_icon').click(function(){
				client_id = $(this).data('client_id');
				authorization_id = $(this).data('authorization_id');
				client_insurance_id = $(this).data('client_insurance_id');
				if($(this).hasClass('authorization_delete'))$('#myModalAuthorizationDelete').modal('show');
			});
			
			$('.popup-delete-authorization-butn').click(function(){
				window.location.href = '{{ url("franchise/client/viewinsurance/trashauthorization") }}'+'/'+client_id+'/'+client_insurance_id+'/'+authorization_id;
			});
			
			$('.authorization_archive').click(function(){
				window.location.href = '{{ url("franchise/client/viewinsurance/archiveauthorization") }}'+'/'+client_id+'/'+client_insurance_id+'/'+authorization_id;
			});
			
			$('.authorization_unarchive').click(function(){
				window.location.href = '{{ url("franchise/client/viewinsurance/unarchiveauthorization") }}'+'/'+client_id+'/'+client_insurance_id+'/'+authorization_id;
			});
		
        });
    </script>
@endsection
