@extends('admin.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<h6>{{$sub_title}}</h6>
			<p>{{ $Franchise->name }} / {{ $Franchise->getState->state_name }} / <span id="change-bread-crumb">Payments</span></p>
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
					  <li class="padd-left-anchor Task-List-1"><a href="{{ url('admin/franchise/view/'.$Franchise->id) }}">Franchisee Demographic</a></li>
					  <li class="Task-List "><a href="{{ url('admin/franchise/viewtasklist/'.$Franchise->id) }}">Task List</a></li>
					  <li class="Task-List-1 Task-List-2 active"><a data-toggle="tab" onclick="payments()" href="#payments">Payments</a></li>
					</ul>
				</div>
				<div class="view-tab-control-butn-main">
					<a href="#" class="btn add-franchise-data-butn-2 " data-target="#myModal-1" data-toggle="modal" ><i class="fa fa-file-text" aria-hidden="true"></i>Print</a>
					<a href="{{ url('admin/franchise/editpayment/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Fee</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="tab-content">
				<div id="payments" class="tab-pane fade in active ">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table payments-head-top-blue FranchiseViewMainDiv">
						<h6>Payment Records</h6>
						<form action="" method="get" id="searchPayment">
						<div class="super-admin-table-select col-sm-8">
							<input type="text" name="year" placeholder="Year" value="{{Request::get('year')}}" class="datepicker_filter">
							<select name="invoice_name">
								<option value="">Select</option>
								<option @if(Request::get('invoice_name') == 'Initial Franchise Fee') selected @endif  >Initial Franchise Fee</option>
								<option @if(Request::get('invoice_name') == 'Monthly Royalty Fee') selected @endif >Monthly Royalty Fee</option>
								<option @if(Request::get('invoice_name') == 'Monthly System Advertising Fee') selected @endif >Monthly System Advertising Fee</option>
								<option @if(Request::get('invoice_name') == 'Renewal Fee') selected @endif >Renewal Fee</option>
							</select>
							<div class="super-admin-table-select-calender-icon">
								<i class="fa fa-calendar datepicker_filter" aria-hidden="true"></i>
							</div>
							<input type="hidden" name="tab" value="payment"/>
						</div>
						<div class="pull-right MargBot10">
							<button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
							<a href="{{ url('admin/franchise/viewpayment/'.$Franchise->id) }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
						</div>
						<div class="clearfix"></div>
						</form>
						
						<div class="super-admin-table-1 table-responsive">
							<!--<table class="table-striped FranchiseesViewTableWidth FranchiseViewPaymentTableWidth">-->
                            <table class="table-striped FranchiseesViewTableWidth">
								<tr>
									<th>Invoice Name</th>
									<th>Amount</th>
									<!--<th>Status</th>-->
                                    <th>Year</th>
									<th>Month</th>
									<th>Late Fee</th>
									<!--<th class="CommentWidthTh">Comment</th>-->
                                    <th width="30%">Comment</th>
									<th>Payment Received</th>
									<th><!--Actions-->Status</th>
								</tr>

							@if(!$Payments->isEmpty())
								@foreach( $Payments as $payment)
								@php
									$class = ''; 
									if($payment->action == 'Not Recieved') $class = 'red-clr';
								@endphp
								<tr>
									<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>{{ $payment->invoice_name }}</td>
									<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>${{ $payment->amount }}@if($payment->invoice_name != 'Initial Franchise Fee' && $payment->invoice_name != 'Renewal Fee')/mo @endif </td>
									<?php /*?><td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>{{ $payment->status }}</td><?php */?>
                                    <td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>{{ $payment->year }}</td>
									<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>{{ $payment->month }}</td>
									<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>@if($payment->late_fee) ${{ $payment->late_fee }} @endif</td>
									<!--<td class="CommentWidthTd">--><td>{{ $payment->comment }}</td>
									<!--<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>@if($payment->payment_recieved_on != ''  && $payment->payment_recieved_on != '0000-00-00') {{ date('dS M Y',strtotime($payment->payment_recieved_on)) }} @endif</td>-->
                                    <td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>@if($payment->payment_recieved_on != ''  && $payment->payment_recieved_on != '0000-00-00') {{ date('m/d/Y',strtotime($payment->payment_recieved_on)) }} @endif</td>
									<td class="{{ $class }}" @if($payment->action == 'Not Received') style="color: #fc6666 !important;" @endif>

										@if($payment->action)
											{{ $payment->action }}
										@else
											-
										@endif	
										
									</td>
								</tr>
								@endforeach
								
							@else
								<tr><td colspan="8">No Payments Found.</td></tr>	
							@endif	
								
							</table>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-para">
								{{--@if($Payments->firstItem())
									<p>Showing {{ $Payments->firstItem() }} to {{ $Payments->lastItem() }} of {{ $Payments->total() }} entries</p>
								@else
									<p>Showing 0 Entries</p>
								@endif--}}
							</div>
							<div class="super-admin-table-bottom-pagination">
								@if(Request::has('tab') && Request::has('invoice_name'))
									{!! $Payments->appends(['tab'=>Request::get('tab'), '_token'=>Request::get('_token'), 'year'=>Request::get('year'), 'invoice_name'=>Request::get('invoice_name')])->links() !!}
								@else
									{!! $Payments->appends(['tab'=> 'payment'])->links() !!}
								@endif
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- header-bottom-sec -->
</div>

<!-- Payment Report -->
<div class="poupup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal-1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content add-forgetten-modal-content EventModel">
        <div class="modal-header add-forgetten-modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print Report</h4>
        </div>
        <div class="modal-body add-forgetten-modal-body">
          	<form action="{{ url('admin/franchise/paymentprintreport/'.$Franchise->id) }}" method="post" id="printReport">
	          	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	          	
	          	<select name="action">
	          		<option value="">Payment Type</option>
	          		<option>Received</option>
                    <option>Overdue</option>
	          		<option>Not Received</option>
	          	</select>
				
	          	<div class="modal-position">
	          	<input type="text" name="startReport" autocomplete="off" placeholder="Date (From)" class="startReport">
				<a class="pos-abs-pop-up startReport"><i class="fa fa-calendar" aria-hidden="true"></i></a>
	          	</div>
	          	<div class="modal-position">
	          	<input type="text" name="endReport" autocomplete="off" placeholder="Date (To)" class="endReport">
				<a class="pos-abs-pop-up-1 endReport" ><i class="fa fa-calendar" aria-hidden="true"></i></a>
				</div>
	          	
	          	<input class="btn add-franchise-data-butn-1" type="submit" value="Print Report">
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
	});//ready

	//PERFORMANCE FILTERS
	$("#searchPayment").on("submit",function(e){
	    e.preventDefault();
	    var url = $(this).attr("action");

	    var year        = $('input[name=\'year\']').val();
	    var invoice_name       = $('select[name=\'invoice_name\']').val();

	    if(year == "" && invoice_name == "")
	    {
	        alert("Please select atleast one field");
	        return false;
	    }
	    else
	    {
	        url += '?tab=performance_log&';
	    }

	    if(year != "")
	    {
	        url += 'year=' + encodeURIComponent(year);
	    }

	    if(invoice_name != "")
	    {
	        if(year != "")
	            url += '&';
	        url += 'invoice_name=' + encodeURIComponent(invoice_name);
	    }

	    window.location = url;
	})	
</script>
@endsection
