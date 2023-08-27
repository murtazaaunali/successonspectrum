@extends('admin.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<h6>{{$sub_title}}</h6>
			<p>{{ $Franchise->name }} / 
				@if($Franchise->state != "")
				{{ $Franchise->getState->state_name }}
				@else
				 - 
				@endif			
			 / <span id="change-bread-crumb">Franchisee Demographic</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>

		<div class="clearfix"></div>
		<div class="add-franchise-data-main-1">
			<div class="view-tabs-control-main">
				<div class="view-tab-control">
					<ul class="nav nav-tabs tabs-fonts">
					  <li class="active padd-left-anchor Task-List-1"><a  href="#franchise-demography">Franchisee Demographic</a></li>
					  <li class="Task-List "><a href="{{ url('admin/franchise/viewtasklist/'.$Franchise->id) }}">Task List</a></li>
					  <!--<li class="Task-List-1 Task-List-2"><a href="{{ url('admin/franchise/viewpayment/'.$Franchise->id) }}">Payments</a></li>-->
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Demographic</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<!--<a href="#" class="btn add-franchise-data-butn-2 impersonate" data-franchise_id="{{ $Franchise->id }}"><i class="fa fa-user" aria-hidden="true"></i>Impersonate Franchisee Admin</a>-->
				    			<a href="{{ url('admin/franchise/edit/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<figure><h5>Franchise Status</h5><h4 class="green-clr" @if($Franchise->status == 'Expired' || $Franchise->status == 'Terminated' ) style="color: #fc6666 !important;" @endif>{{ $Franchise->status }}</h4></figure>
				    		{{--<figure><h5>Franchise Activation Date</h5><h4>{{ date('jS M Y',strtotime($Franchise->franchise_activation_date)) }}</h4></figure>--}}
				    		<figure><h5>Franchise Location</h5><h4>{{ $Franchise->location }}</h4></figure>
				    		<figure><h5>Franchise Address</h5><h4>{{ $Franchise->address }}, {{ $Franchise->city }}, 
							@if($Franchise->state != "")
							{{ $Franchise->getState->state_name }}
							@else
							 - 
							@endif			
							
							{{ $Franchise->zipcode }}</h4></figure>
				    		<figure><h5>Franchise Phone</h5><h4>{{ $Franchise->phone }}</h4></figure>
				    		<figure><h5>Franchise Fax</h5><h4>{{ $Franchise->fax }}</h4></figure>
				    		<figure><h5>Email Address</h5><h4>{{ $Franchise->email }}</h4></figure>
				    		<!--<figure><h5>No Of Clients</h5><h4>{{$total_clients}}</h4></figure>
				    		<figure><h5>No Of Employees</h5><h4>{{$total_employees}}</h4></figure>-->
				    		<?php /*?><figure><h5>Date FDD Was Signed</h5><h4>{{ date('jS M Y',strtotime($Franchise->fdd_signed_date)) }}</h4></figure><?php */?>
                            <figure><h5>Date FDD Was Signed</h5><h4>@if($Franchise->fdd_signed_date != "" && $Franchise->fdd_signed_date != '0000-00-00'){{ date('m/d/Y',strtotime($Franchise->fdd_signed_date)) }}@endif</h4></figure>
				    		<?php /*?><figure class="border-bot-0 red"><h5>Date Of FDD Expiration</h5><h4>{{ date('jS M Y',strtotime($Franchise->fdd_expiration_date)) }}</h4></figure><?php */?>
                            <figure class="border-bot-0 red"><h5>Date Of FDD Expiration</h5><h4>@if($Franchise->fdd_expiration_date != "" && $Franchise->fdd_expiration_date != '0000-00-00'){{ date('m/d/Y',strtotime($Franchise->fdd_expiration_date)) }}@endif</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Franchise Owner(s)</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('admin/franchise/addowner/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-user-o" aria-hidden="true"></i>Add Owner</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
				    		<div class="blue-border-box-main">
				    			@if(!$Franchise->franchise_owners->isEmpty())
				    			@foreach($Franchise->franchise_owners as $owner)
						    		<div class="blue-border-box owner_box">
						    			<a href="{{ url('admin/franchise/editowner/'.$owner->franchise_id.'/'.$owner->id) }}" class="owner_edit"><i class="fa fa-pencil"></i></a>
						    			<a href="#" data-owner_id="{{ $owner->id }}" data-franchise_id="{{ $owner->franchise_id }}" class="owner_delete "><i class="fa fa-trash"></i></a>
						    			<figure><h5>Franchise Owner</h5><h4>{{ substr($owner->fullname, 0, 15) .((strlen($owner->fullname) > 15) ? '...' : '') }}</h4></figure>
						    			<figure class="border-bot-0"><h5>Phone Number</h5><h4>{{ $owner->phone }}</h4></figure>
						    		</div>
					    		@endforeach
					    		@endif

					    		<div class="clearfix"></div>
				    		</div>
				    		<div class="padd-view"></div>
				    	</div>
                        
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Required Insurance</h3>
				    		</div>
                            <div class="clearfix"></div>
                            <div class="alert alert-success hidden franchise-insurance-response" style="line-height: initial;">Insurance Updated Successfully</div>
        					<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	<div class="super-admin-table-1 table-responsive">
                                <table class="table-striped FranchiseesViewTableWidth FranchiseRequiredInsurance">
                                    <thead>
                                        <tr>
                                            <th>Insurance Type(s)</th>
                                            <th>Expiration Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!$RequiredInsurance->isEmpty())
                                            @foreach( $RequiredInsurance as $required_insurance)
                                            @php
                                                $class = ''; 
                                                $class_status = ''; 
                                                $expiration_date_display = "";
                                                $insurance_status = $required_insurance->status;
                                                $expiration_date = $required_insurance->expiration_date;
                                                if($insurance_status == 'Active') $class_status = 'green-clr';
                                                if($insurance_status == 'Expired') $class_status = 'red-clr';
                                                if($expiration_date != '' && $expiration_date != '0000-00-00')
                                                {
                                                	$expiration_date_display = date('m/d/Y',strtotime($expiration_date));
                                                    if(strtotime($expiration_date) < strtotime(date("Y-m-d")) && $insurance_status != "Active")
                                                    {
                                                    	$class = 'red-clr';
                                                        $class_status = 'red-clr';
                                                        $insurance_status = 'Expired';
                                                    }
                                                }
                                            @endphp
                                            <tr id="row-{{ $required_insurance->id }}">
                                                <td class="{{ $class }}">{{ $required_insurance->insurance_type }}</td>
                                                <td class="{{ $class }}">{{ $expiration_date_display }}</td>
                                                <td class="{{ $class }} {{ $class_status }}">
                                                    @if($insurance_status)
                                                        {{ $insurance_status }}
                                                    @else
                                                        -
                                                    @endif	
                                                </td>
                                                <td class="{{ $class }}" width="15%">
	                                             	<button type="button" class="btn franchise-search-butn franchise-insurance-update-form-load-btn" data-id="{{ $required_insurance->id }}" data-expiration-date="{{ $expiration_date_display }}" data-status="{{ $required_insurance->status }}" data-insurance-type="{{ $required_insurance->insurance_type }}">Update</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="4">No Insurance Found.</td></tr>	
                                        @endif	
                                    </tbody>
                                </table>
                            </div>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Required Local Advertising</h3>
				    		</div>
                            <div class="clearfix"></div>
                            <div class="alert alert-success hidden franchise-advertisement-response" style="line-height: initial;">Advertising Received Successfully</div>
        					<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	<div class="super-admin-table-1 table-responsive">
                                <table class="table-striped FranchiseesListTableWidth FranchiseRequiredLocalAdvertisements">
                                    <thead>
                                        <tr>
                                            <th>
                                            	<form action="{{ url('admin/franchise/view') }}/{{$Franchise->id}}" method="get">
                                                Proof of Local Advertising&nbsp;
                                                @if(!$RequiredLocalAdvertisementsYears->isEmpty())
                                                    <span>
                                                        <select class="change_franchise_local_advertisements_year" name="local_advertisements_year" style="width:auto;" onchange="this.form.submit();">
                                                            @foreach($RequiredLocalAdvertisementsYears as $local_advertisement_years)
                                                                <option value="{{ $local_advertisement_years->year }}" @if($local_advertisements_year == $local_advertisement_years->year) selected="selected" @endif>{{ $local_advertisement_years->year }}</option>
                                                            @endforeach
                                                        </select>
                                                    </span>
                                                @endif
                                                </form>
                                            </th>
                                            <th>Completion Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
    								<tbody>
                                        @if(!$RequiredLocalAdvertisements->isEmpty())
                                            @foreach( $RequiredLocalAdvertisements as $local_advertisement)
                                            @php
                                                $class = '';
                                                $class_highlight = '';
                                                $current_month = date('m');
                                                //$current_month_quarter = ceil(2 / 3);
                                                $local_advertisement_applicable = true;
                                                //$local_advertisement_applicable = false;
                                                $current_month_quarter = ceil(date("n") / 3);
                                                $local_advertisement_completion_date_display = "";
                                                $local_advertisement_year = $local_advertisement->year;
                                                $local_advertisement_status = $local_advertisement->status;
                                                $local_advertisement_quarter = $local_advertisement->quarter;
                                                if($local_advertisement_status == 'Pending') $class = 'red-clr';
                                                if($local_advertisement_status == 'Received') $class = 'green-clr';
                                                $local_advertisement_completion_date = $local_advertisement->completion_date;
                                                /*if(date("n") <= ($local_advertisement_quarter*3))
                                                {
                                                    $local_advertisement_applicable = true;
                                                }*/
                                                $fdd_signed_date = $Franchise->fdd_signed_date;
                                                $fdd_signed_date_year = date('Y',strtotime($fdd_signed_date));
                                                $fdd_signed_date_month = date('m',strtotime($fdd_signed_date));
                                                $current_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::today());
                                                $fdd_signed_year_last_date = \Carbon\Carbon::parse($fdd_signed_date)->endOfYear()->toDateString();
                                                $fdd_signed_year_number_months = \Carbon\Carbon::parse($fdd_signed_date)->diffInMonths( $fdd_signed_year_last_date );
                                                $local_advertisements_not_applicable_quarters = (int)((4)-ceil($fdd_signed_year_number_months/3));
                                                if($local_advertisement_year == $fdd_signed_date_year)
                                                {
                                                	if($local_advertisement_quarter <= $local_advertisements_not_applicable_quarters)
                                                    {
                                                        $local_advertisement_applicable = false;
                                                    }
                                                }      
                                                
                                                if($current_month_quarter == $local_advertisement_quarter)
                                                {
                                                	$class_highlight = "active";
                                                    if($local_advertisement_status == 'Pending') $class_highlight = 'pending';
                                                    if($local_advertisement_status == 'Received') $class_highlight = 'received';
                                                }
                                                
                                                if($local_advertisement_completion_date != '' && $local_advertisement_completion_date != '0000-00-00')
                                                {
                                                	$local_advertisement_completion_date_display = date('m/d/Y',strtotime($local_advertisement_completion_date));
                                                }
                                            @endphp
                                            <tr class="{{ $class_highlight }}" id="franchise-advertisement-row{{ $local_advertisement->id }}">
                                                <td class="{{ $class }}" width="35%">Quarter {{ $local_advertisement->quarter }} - {{ $local_advertisement->year }}</td>
                                                <td class="{{ $class }}" width="25%">
                                                    @if($local_advertisement_applicable)
                                                        <span class="pos-rel">
                                                            <input class="datepicker local_advertisement_completion_date local_advertisement_completion_datepicker" id="local_advertisement_completion_date{{ $local_advertisement->id }}" name="local_advertisement_completion_date{{ $local_advertisement->id }}" autocomplete="off" type="text" placeholder="mm/dd/yy" value="{{ $local_advertisement_completion_date_display }}">
                                                            <i class="fa fa-calendar pos-abs-cal local_advertisement_completion_datepicker" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="{{ $class }}" width="20%">
                                                    @if($local_advertisement_applicable)
                                                        <span class="pos-rel">
                                                            <select name="local_advertisement_status{{ $local_advertisement->id }}" id="local_advertisement_status{{ $local_advertisement->id }}" class="local_advertisement_status" data-id="{{ $local_advertisement->id }}">
                                                              <option value="">Status</option>
                                                              @if($FranchiseLocalAdvertisementsStatus)
                                                                  @foreach($FranchiseLocalAdvertisementsStatus as $local_advertisement_status)
                                                                      @if($local_advertisement_status != "Not Applicable")	
                                                                      <option @if($local_advertisement_status == $local_advertisement->status)) selected="selected" @endif>{{ $local_advertisement_status }}</option>
                                                                      @endif
                                                                  @endforeach
                                                              @endif	
                                                            </select>
                                                        </span>
                                                    @else
                                                        Not Applicable
                                                    @endif	
                                                </td>
                                                <td class="{{ $class }}" width="20%">
	                                             	<button type="button" class="btn franchise-search-butn local-advertisement-upload-form-load-btn" data-id="{{ $local_advertisement->id }}">Upload Document</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="4">No AdvertisementFound.</td></tr>	
                                        @endif	
                                    </tbody>
                                </table>
                            </div>
				    		<div class="padd-view"></div>
				    	</div>
                        <div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Audit</h3>
				    		</div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="alert alert-success hidden franchise-audit-response" style="line-height: initial;">Audit Conducted Successfully</div>
        					<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                        	<div class="super-admin-table-1 table-responsive">
                                <table class="table-striped FranchiseesListTableWidth FranchiseAudit">
                                    <thead>
                                        <tr>
                                            <th>Audit</th>
                                            <th>Conducted On</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
    								<tbody>
                                        @if(!$Audit->isEmpty())
                                            @foreach( $Audit as $audit)
                                            @php
                                                $class = '';
                                                $class_highlight = "";
                                                $current_year = date("Y"); 
                                                $audit_status = $audit->status;
                                                $audit_year = $audit->from_year;
                                                $audit_conducted_date_display = "";
                                                if($audit_status == 'Pending') $class = 'red-clr';
                                                if($audit_status == 'Completed') $class = 'green-clr';
                                                $audit_conducted_date = $audit->conducted_date;
                                                
                                                if($current_year == $audit_year)
                                                {
                                                	$class_highlight = "active";
                                                    if($audit_status == 'Pending') $class_highlight = 'pending';
                                                    if($audit_status == 'Completed') $class_highlight = 'received';
                                                }
                                                
                                                if($audit_conducted_date != '' && $audit_conducted_date != '0000-00-00')
                                                {
                                                	$audit_conducted_date_display = date('m/d/Y',strtotime($audit_conducted_date));
                                                }
                                            @endphp
                                            <tr class="{{ $class_highlight }}" id="franchise-audit-row{{ $audit->id }}">
                                                <td class="{{ $class }}" width="50%">Audit {{ $audit->from_year }} - {{ $audit->to_year }}</td>
                                                <td class="{{ $class }}" width="30%">
                                                	<span class="pos-rel">
                                                    	<input class="datepicker audit_conducted_date audit_conducted_datepicker" id="audit_conducted_date{{ $audit->id }}" name="audit_conducted_date{{ $audit->id }}" autocomplete="off" type="text" placeholder="mm/dd/yy" value="{{ $audit_conducted_date_display }}">
						    							<i class="fa fa-calendar pos-abs-cal audit_conducted_datepicker" aria-hidden="true"></i>
                                                    </span>
                                                </td>
                                                <td class="{{ $class }}" width="20%">
                                                    <span class="pos-rel">
                                                        <select name="audit_status{{ $audit->id }}" id="audit_status{{ $audit->id }}" class="audit_status"  data-id="{{ $audit->id }}">
                                                          <option value="">Status</option>
                                                          @if($FranchiseAuditStatus)
                                                              @foreach($FranchiseAuditStatus as $audit_status)
                                                                  @if($audit_status != "Not Conducted")	
                                                                  <option @if($audit_status == $audit->status)) selected="selected" @endif>{{ $audit_status }}</option>
                                                                  @endif
                                                              @endforeach
                                                          @endif	
                                                        </select>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="3">No Audit Found.</td></tr>	
                                        @endif	
                                    </tbody>
                                </table>
                            </div>
				    		<div class="padd-view"></div>
				    	</div>
                        
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Fee</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('admin/franchise/editfee/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Fee</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content view-tab-content-1">
				    		@if($Franchise->franchise_fees)
				    		@php 
				    			$F_fee = $Franchise->franchise_fees; 

								$ends = array('th','st','nd','rd','th','th','th','th','th','th');
								if (($F_fee->fee_due_date %100) >= 11 && ($F_fee->fee_due_date%100) <= 13)
								   $abbreviation = $F_fee->fee_due_date. 'th';
								else
								   $abbreviation = $F_fee->fee_due_date. $ends[$F_fee->fee_due_date % 10];
				    		@endphp
				    		<?php /*?><figure><h5>Contract Duration</h5><h4>{{ $F_fee->contract_duration }}</h4></figure><?php */?>
				    		<figure><h5>Fee Due Date</h5><h4>{{ $abbreviation }} of every month</h4></figure>
				    		<figure><h5>Initial Franchise Fee<br>(one time fee)</h5><h4>${{$F_fee->initial_fee}}</h4></figure>
				    		{{--<figure><h5>Monthly Royalty Fee<br>(once a month for 5 year)</h5><h4>${{$F_fee->monthly_royalty_fee}}</h4></figure>--}}
                            <figure>
                            	<h5 class="w-100">Monthly Royalty Fee (once a month for 5 year)</h5>
                                <div class="clearfix"></div>
                                <h5>For first year</h5><h4>${{$F_fee->monthly_royalty_fee}}</h4>
                                <div class="clearfix"></div>
                                <h5>For second year</h5><h4>${{$F_fee->monthly_royalty_fee_second_year}}</h4>
                                <div class="clearfix"></div>
                                <h5>For subsequent years</h5><h4>${{$F_fee->monthly_royalty_fee_subsequent_years}}</h4>
                                <div class="clearfix">&nbsp;</div>
                            </figure>
				    		<figure><h5>Monthly System Advertising Fee<br>(once a month for 5 years)</h5><h4>${{$F_fee->monthly_advertising_fee}}</h4></figure>
				    		<figure class="border-bot-0"><h5>Renewal Fee<br>(Due Upon Expiration of the FDD contract)</h5><h4>${{$F_fee->renewal_fee}}</h4></figure>
				    		@endif
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
          <h4 class="modal-title">Delete Franchise Owner?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this owner permanently ? This action cannot be undone</p>
          <input class="btn popup-delete-butn" type="button" value="Delete Owner">
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
          <h4 class="modal-title">LOGIN AS A FRANCHISE?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to login as a franchise ?</p>
          <input class="btn impersonate-delete-butn" type="button" value="Yes">
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="poupup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModalInsuranceUpdate" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content update-required-insurance-modal-content">
        <div class="modal-header update-required-insurance-modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Insurance Type</h4>
        </div>
        <div class="modal-body update-required-insurance-modal-body pos-rel">
          <form action="{{ url('admin/franchise/updateinsurance') }}" method="post" id="updateRequiredInsurance" enctype="multipart/form-data">
              <input type="hidden" name="id" value=""/>
              <input type="hidden" name="insurance_type" value=""/>
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <input type="hidden" name="franchise_id" value="{{ $Franchise->id }}"/>
              <div class="pop_position-rel">
                  <input type="text" name="expiration_date" id="expiration_date" placeholder="Expiration Date" class="update-franchise-insurance-expiration-date update_franchise_insurance_expiration_datepicker">
                  <a><i class="fa fa-calendar update_franchise_insurance_expiration_datepicker" aria-hidden="true"></i></a>
                  <label class="error" for="expiration_date"></label>
              </div>
              <div class="pop_position-rel">
                  <select name="status" id="status">
                  	<option value="">Status</option>
                    @if($FranchiseInsuranceStatus)
						@foreach($FranchiseInsuranceStatus as $franchise_insurance_status)
                        	@if($franchise_insurance_status != "null")	
                            <option>{{ $franchise_insurance_status }}</option>
                            @endif
                        @endforeach
                    @endif	
                  </select>
              </div>
              <div class="pop_position-rel ">
                  <input type="file" name="file" id="file" class="update-franchise-insurance-file"/>
                  <input type="text" autocomplete="off" placeholder="Upload" readonly="readonly">
                  <a><i class="fa fa-upload" aria-hidden="true"></i></a>
              </div>
              <label class="error" for="file"></label>
              <input class="btn add-franchise-data-butn-1 update-franchise-insurance-butn" type="submit" value="Update">
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="poupup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModalLocalAdvertisementsUpdate" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content upload-local-advertisements-modal-content">
        <div class="modal-header upload-local-advertisements-modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Document</h4>
        </div>
        <div class="modal-body upload-local-advertisements-modal-body pos-rel">
          <form action="{{ url('admin/franchise/uploadlocaladvertisementsdocument') }}" method="post" id="uploadLocalAdvertisementsDocument" enctype="multipart/form-data">
              <input type="hidden" name="id" value=""/>
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <input type="hidden" name="franchise_id" value="{{ $Franchise->id }}"/>
              <div class="pop_position-rel ">
                  <input type="file" name="file" id="file" class="upload-local-advertisements-file"/>
                  <input type="text" autocomplete="off" placeholder="Upload" readonly="readonly">
                  <a><i class="fa fa-upload" aria-hidden="true"></i></a>
              </div>
              <label class="error" for="file"></label>
              <input class="btn add-franchise-data-butn-1 upload-local-advertisements-butn" type="submit" value="Upload">
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.datepicker_filter').datetimepicker({
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});
		
		$(window).load(function(){
			var tab = '{{ Request::get("tab") }}';
			console.log(tab);
			if(tab == 'payment'){
				$(".dis-none-4").show();
			}
		});

		//code for delete owner
		var franchise_id = '';
		var owner_id = '';
		$('.owner_delete').click(function(){
			franchise_id 	= $(this).data('franchise_id');
			owner_id 		= $(this).data('owner_id');
			$('#myModal2').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			window.location.href = '{{ url("admin/franchise/deleteowner") }}'+'/'+franchise_id+'/'+owner_id;
		});

		//CODE FOR LOGIN AS FRANCHISE
		var franchise_id = '';
		$('.impersonate').click(function(){
			franchise_id 	= $(this).data('franchise_id');
			$('#myModal3').modal('show');
		});
		
		$('.impersonate-delete-butn').click(function(){
			window.location.href = '{{ url("admin/impersonate") }}'+'/'+franchise_id;
		});
		
		//Print Report of time punches
		
		$( function() {
			$(".startReport").datetimepicker({
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    }).on('changeDate', function (selected) {
		        var minDate = new Date(selected.date.valueOf());
		        minDate.setDate(minDate.getDate() + 1);
		        $(this).parents('.add-forgetten-modal-body').find('.endReport').datetimepicker('setStartDate', minDate);
		    });
		    $(".endReport").datetimepicker({
		        autoclose: true,
		        format: 'mm/dd/yyyy',
			    maxView: 4,
			    minView: 2,  	
		    }).on('changeDate', function (selected) {
		        var minDate = new Date(selected.date.valueOf());
		        minDate.setDate(minDate.getDate() - 1);
		        $(this).parents('.add-forgetten-modal-body').find('.startReport').datetimepicker('setEndDate', minDate);
		    });
		});

		$('#printReport').validate({
			rules:{
				'startReport':{required:true},
				'endReport':{required:true},
			}			
		});
		
		//Tasklist tab Code
		if('{{ Request::get("tab") }}' == 'tasklist'){
			$(".dis-none-3").show();
		}
		$(".Task-List").click(function(){
		    $(".dis-none-3").show();
		    $(".dis-none-4").hide();
		});
		//Tasklist tab Code end here

		//Payment code
		$(".Task-List-1").click(function(){
		    $(".dis-none-3").hide();
		    $(".dis-none-4").hide();
		});
		$(".Task-List-2").click(function(){
		    $(".dis-none-4").show();
		});

		if('{{ Request::get("tab") }}' == 'payment'){
			$(".dis-none-4").show();
		}
		//Payment code
		
		//Franchise Insurance Update Date
		//$('.update-franchise-insurance-expiration-date').datetimepicker({
		$('.update_franchise_insurance_expiration_datepicker').datetimepicker({	
            maxView: 4,
            minView: 2,
            autoclose: true,
			//startDate: new Date(),
			format: 'mm/dd/yyyy',
    	});
		
		//$('.local_advertisement_completion_date,.audit_conducted_date').datetimepicker({
		$('.local_advertisement_completion_datepicker,.audit_conducted_datepicker').datetimepicker({	
            maxView: 4,
            minView: 2,
            autoclose: true,
			//startDate: new Date(),
			format: 'mm/dd/yyyy',
    	});	
		
		//Load Franchise Insurance Update Form
		$('.franchise-insurance-update-form-load-btn').click(function(){
			var id = $(this).data('id');
			var status = $(this).data('status');
			var expiration_date = $(this).data('expiration-date');
			var insurance_type = $(this).data('insurance-type');
			var myModalInsuranceUpdate = $('#myModalInsuranceUpdate');
			myModalInsuranceUpdate.find('input[name="id"]').val(id);
			myModalInsuranceUpdate.find('h4.modal-title').text(insurance_type);
			myModalInsuranceUpdate.find('select[name="status"]').val(status);
			myModalInsuranceUpdate.find('input[name="insurance_type"]').val(insurance_type);
			myModalInsuranceUpdate.find('input[name="expiration_date"]').val(expiration_date);
			myModalInsuranceUpdate.modal('show');
		});
		
		$('#updateRequiredInsurance').validate({
			rules:{
				status:{required:true},
				expiration_date:{required:true},
				file:{required:true,extension:'pdf|docx'}
			},
			messages:{
				file:{
					extension:'Upload only pdf or doc file.'
				}
			}
		});
		
		//Update Franchise Insurance Local Advertisement
		$('.local_advertisement_status').change(function(){
			var status = $(this).val();
			var id = $(this).data('id');
			var completion_date = $("#local_advertisement_completion_date"+id).val();
			$.ajax({
				url:'{{ url("admin/franchise/updateadvertisement") }}',
				type:'POST',
				dataType:'json',
				data:{id: id, status: status, completion_date: completion_date, franchise_id: '{{ $Franchise->id }}', '_token':'{{ csrf_token() }}'},
				beforeSend: function( xhr ) {
					$(".franchise-advertisement-response").addClass('hidden');
				},
				success:function(response){
					if(typeof(response) == 'object'){
						if('success' in response){
							$(".franchise-advertisement-response").fadeIn();
							$(".franchise-advertisement-response").removeClass('hidden');
							$(".franchise-advertisement-response").fadeOut(2000);
							$("#franchise-advertisement-row"+id).removeAttr('class').addClass(status.toLowerCase());
							if(status.toLowerCase() == "pending")
							$("#franchise-advertisement-row"+id).find('td').removeClass('green-clr').addClass('red-clr');
							else
							$("#franchise-advertisement-row"+id).find('td').removeClass('red-clr').addClass('green-clr');
						}
					}
				},
			});
		});
		
		//Load Franchise Local Advertisement Upload Form
		$('.local-advertisement-upload-form-load-btn').click(function(){
			var id = $(this).data('id');
			var myModalLocalAdvertisementsUpdate = $('#myModalLocalAdvertisementsUpdate');
			myModalLocalAdvertisementsUpdate.find('input[name="id"]').val(id);
			myModalLocalAdvertisementsUpdate.modal('show');
		});
		
		$('#uploadLocalAdvertisementsDocument').validate({
			rules:{
				file:{required:true,extension:'pdf|docx'}
			},
			messages:{
				file:{
					extension:'Upload only pdf or doc file.'
				}
			}
		});
		
		//Update Franchise Audit
		$('.audit_status').change(function(){
			var status = $(this).val();
			var id = $(this).data('id');
			var conducted_date = $("#audit_conducted_date"+id).val();
			$.ajax({
				url:'{{ url("admin/franchise/updateaudit") }}',
				type:'POST',
				dataType:'json',
				data:{id: id, status: status, conducted_date: conducted_date, franchise_id: '{{ $Franchise->id }}', '_token':'{{ csrf_token() }}'},
				beforeSend: function( xhr ) {
					$(".franchise-audit-response").addClass('hidden');
				},
				success:function(response){
					console.log(response);
					if(typeof(response) == 'object'){
						if('success' in response){
							$(".franchise-audit-response").fadeIn();
							$(".franchise-audit-response").removeClass('hidden');
							$(".franchise-audit-response").fadeOut(2000);
							$("#franchise-audit-row"+id).removeAttr('class').addClass(status.toLowerCase());
							if(status.toLowerCase() == "pending")
							$("#franchise-audit-row"+id).find('td').removeClass('green-clr').addClass('red-clr');
							else
							$("#franchise-audit-row"+id).find('td').removeClass('red-clr').addClass('green-clr');
						}
					}
				},
			});
		});
	});//ready

	function taskList() {
	    document.getElementById("change-bread-crumb").innerHTML = "Task List";
	}
	function payments() {
	    document.getElementById("change-bread-crumb").innerHTML = "Payments";
	}
	function franchisedemography() {
	    document.getElementById("change-bread-crumb").innerHTML = "Franchisee Demographic";
	}

</script>
@endsection
