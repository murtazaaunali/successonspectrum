@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise"><h4>{{$sub_title}}</h4></div>
        <div class="clearfix"></div>
    </div>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="padd-left-anchor Task-List-1"><a href="#payment">Franchisee Demographic</a></li>
				  <li class="Task-List"><a href="#payment">Task List</a></li>
				  <li class="Task-List-1 active Task-List-2 "><a data-toggle="tab" href="#payment">Payments</a></li>
				</ul>
			</div>
			<div class="view-tab-control-butn-main">
				<a href="{{ url('admin/franchise/viewpayment/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
				<a href="javascript:;" class="btn add-franchise-data-butn-1 submit_payments"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save Changes</a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="tab-content">

			<div id="payment" class="tab-pane fade in active">
			    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table padd-zero-lines">

				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table payments-head-top-blue">
						{{--<form action="" method="get">
							<div class="super-admin-table-select col-sm-8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
								<input type="text" name="year" value="{{ Request::get('year') }}" class="datepicker_filter">
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
							<div class="pull-right">
								<a href="{{ url('admin/franchise/view/'.$Franchise->id.'?tab=payment') }}" class="btn btn-primary">Clear Filters</a>
								<button type="submit" class="btn btn-primary">Search</button>
							</div>
							<div class="clearfix"></div>
						</form>--}}
						<div class="alert alert-success hidden update-payment-response">Payment Updated Successfully</div>
						<div class="super-admin-table-1 table-responsive">
							<table class="PaymentTableInputWidth table-striped table-input-wid">
								<tr>
									<th>Invoice Name</th>
									<th>Amount</th>
									<!--<th>Status</th>-->
                                    <th>Year</th>
									<th>Month</th>
									<th>Late Fee</th>
									<th>Comment</th>
									<th style="line-height:25px;">Payment Received</span></th>
									<th>Actions</th>
								</tr>

							@if(!$Franchise->payments->isEmpty())
								<form action="{{ url('/admin/franchise/updatepayments/'.$Franchise->id) }}" method="post" id="payment_form">
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
								@php $count = 1;  @endphp
								@forelse( $Payments as $payment)
								@php
									$class = ''; 
									if($payment->action == 'Not Recieved') $class = 'red-clr';
								@endphp
								<tr>
									<td class="{{ $class }}" width="20%">{{ substr($payment->invoice_name, 0, 20) .((strlen($payment->invoice_name) > 20) ? '...' : '') }}</td>
									<td class="{{ $class }}">
										<input type="text" data-field_type="amount" name="payment[{{$count}}][amount]" id="amount{{ $payment->id }}" value="{{ $payment->amount }}" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}"/>
										<input type="hidden" name="payment[{{$count}}][payment_id]" value="{{ $payment->id }}"/>
									</td>

									<?php /*?><td class="{{ $class }}">

									<select name="payment[{{$count}}][status]" id="status{{ $payment->id }}" data-field_type="status" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}">
										<option selected="" value="">Select</option>
										<option @if($payment->status == 'Paid') selected="" @endif>Paid</option>
										<option @if($payment->status == 'Overdue') selected="" @endif>Overdue</option>
									</select>
									</td><?php */?>
                                    <td class="{{ $class }} pos-rel">
										<input type="text" name="payment[{{$count}}][year]" id="year{{ $payment->id }}" data-field_type="year" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}" class="datepicker_filter payment_year_datepicker" value="{{ $payment->year }}" style="width:90%;">
                                        <i class="fa fa-calendar calender-icon-table-i payment_year_datepicker" aria-hidden="true"></i>
									</td>
									<td class="{{ $class }}">
									<select name="payment[{{$count}}][month]" id="month{{ $payment->id }}" data-field_type="month" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}">
										<option selected="" value="">Select</option>
										@foreach($months as $key => $getMonth)
											<option @if($getMonth == $payment->month) selected @endif >{{ $getMonth }}</option>
										@endforeach
									</select>
									
									</td>
									
									<td class="{{ $class }}">
										<input type="text" value="{{ $payment->late_fee }}" data-field_type="late_fee" name="payment[{{$count}}][late_fee]" id="late_fee{{ $payment->id }}" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}" />
									</td>
									
									<td><input type="text" data-field_type="comment" name="payment[{{$count}}][comment]" id="comment{{ $payment->id }}" value="{{ $payment->comment }}" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}" style="width: 90%;"/></td>
									
									<td class="{{ $class }}">
										<?php /*?><input type="text" data-field_type="payment_recieved_on" class="datepicker payment_recieved" name="payment[{{$count}}][payment_recieved_on]" id="payment_recieved_on{{ $payment->id }}" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}" value="@if($payment->payment_recieved_on && $payment->payment_recieved_on != '0000-00-00'){{ date('j M Y',strtotime($payment->payment_recieved_on)) }} @endif" style="width: 90%;" /><?php */?>
                                        <input type="text" data-field_type="payment_recieved_on" class="datepicker payment_recieved payment_recieved_datepicker" name="payment[{{$count}}][payment_recieved_on]" id="payment_recieved_on{{ $payment->id }}" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}" value="@if($payment->payment_recieved_on && $payment->payment_recieved_on != '0000-00-00'){{ date('m/d/Y',strtotime($payment->payment_recieved_on)) }} @endif" style="width: 90%;" />
										<i class="fa fa-calendar calender-icon-table-i payment_recieved_datepicker" aria-hidden="true"></i>
									</td>
									
									<td class="{{ $class }}">
									<select name="payment[{{$count}}][action]" id="action{{ $payment->id }}" class="action" data-field_type="action" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}">
										<option selected="" value="">Select</option>
										<option value="Received" @if($payment->action == 'Received') selected @endif >Received</option>
                                        <option value="Overdue" @if($payment->status == 'Overdue') selected="" @endif>Overdue</option>
										<option value="Not Received" @if($payment->action == 'Not Received') selected @endif >Not Received</option>
									</select>
									</td>
								</tr>
                                <tr><td></td><!--<td colspan="7" class="text-right"><a class="btn btn-primary btn-sm update-payment-details" data-payment_id="{{ $payment->id }}" data-franchise_id="{{ $payment->franchise_id }}"><i class="fa fa-save"></i> Save Changes</a>&nbsp;&nbsp; </td>--></tr>
								@php $count++;  @endphp
								@empty
								<tr><td colspan="8">No Records Found.</td></tr>
								@endforelse
							</form>	
							@else
								<tr><td colspan="8">No Payments Found.</td></tr>	
							@endif	
								
							</table>
						</div>
						<div class="super-admin-table-bottom">
							<div class="super-admin-table-bottom-para">
								<!--<p>Showing 1 to 10 of 57 entries</p>-->
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
	
 <div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment Updated Successfully</h4>
        </div>
        <div class="modal-body">
          <input class="btn" type="button" data-dismiss="modal" value="Close">
        </div>
      </div>
      
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		/*$('.datepicker_filter').datetimepicker({
			format:'yyyy',
			today:  1,
	        autoclose: true,
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'top-left',
		});*/
		$('.datepicker_filter').datetimepicker({
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});
		
		$('.payment_year_datepicker').datetimepicker({	
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});
		
		$('.submit_payments').click(function(){
			$('#payment_form').submit();	
		});
		
		//$( ".datepicker" ).datetimepicker({
		$( ".payment_recieved_datepicker" ).datetimepicker({	
			//formatType:'php',
			format:'dd M yyyy',
			today:  1,
	        autoclose: true,
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'top-left',
		}).on('changeDate', function (selected) {
			
			var date = new Date(selected.date.valueOf());
			var suffix = "";
			switch(date.getDate()) {
	            case '1': case '21': case '31': suffix = 'st'; break;
	            case '2': case '22': suffix = 'nd'; break;
	            case '3': case '23': suffix = 'rd'; break;
	            default: suffix = 'th';
	        }

	        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			var newDate = date.getDate()+""+suffix+" "+months[date.getMonth()] +" "+ date.getFullYear();
			$(this).val(newDate);
			changePaymentRecieved($(this));
	        
	 	});
		
		//UPDATE Recieved on
		function changePaymentRecieved(current,  ){
			var franchise_id = current.data('franchise_id');
			var payment_id = current.data('payment_id');
			var mDate = current.val();
			//current.val(newDate);
			//alert(franchise_id)
			$.ajax({
				url:'{{ url("admin/franchise/updaterecievedon/".$Franchise->id)}}',
				method:'post',
				data: { 'date': mDate, 'franchise_id': franchise_id, 'payment_id': payment_id, '_token':'{{ csrf_token() }}' },
				beforeSend: function( xhr ) {
					current.attr('disabled','disabled');
				},
				success:function(response){
					current.removeAttr('disabled','disabled');
					if(response == 'success'){
						//$('#myModal2').modal('show');
					}
				}
			});				
			
		}

		//UPDATE amount
		$(document).on('change','input[name=amount]',function(){
			current = $(this);
			updateField(current);
		});	
		
		//late Fee
		$(document).on('change','input[name=late_fee]',function(){
			current = $(this);
			updateField(current);
		});			

		//UPDATE month
		$(document).on('change','select[name=month]',function(){
			current = $(this);
			updateField(current);
		});		
		
		//UPDATE Status
		$(document).on('change','select[name=status]',function(){
			current = $(this);
			updateField(current);
		});	
		
		//UPDATE Comment
		$(document).on('change','input[name=comment]',function(){
			current = $(this);
			updateField(current);
		});	

		//UPDATE Action
		$(document).on('change','.action',function(){
			current = $(this);
			updateField(current);
		});		

		function updateField(current){
			/*var franchise_id = current.data('franchise_id');
			var payment_id = current.data('payment_id');
			var action = current.val();
			var field_type = current.data('field_type');
			$.ajax({
				url:'{{ url("admin/franchise/updatepaymentfields/".$Franchise->id)}}',
				method:'post',
				data: { 'action': action, 'franchise_id': franchise_id, 'field_type':field_type, 'payment_id': payment_id, '_token':'{{ csrf_token() }}' },
				beforeSend: function( xhr ) {
					current.attr('disabled','disabled');
				},
				success:function(response){
					current.removeAttr('disabled','disabled');
					if(response == 'success'){
						//$('#myModal2').modal('show');
					}
				}
			});*/				
		}
		
		//UPDATE Action
		$(document).on('click','.update-payment-details',function(){
			current = $(this);
			updatePaymentDetails(current);
		});	
		function updatePaymentDetails(current){
			var payment_id = current.data('payment_id');
			var franchise_id = current.data('franchise_id');
			var amount = $("#amount"+payment_id).val();
			var status = $("#status"+payment_id).val();
			var month = $("#month"+payment_id).val();
			var late_fee = $("#late_fee"+payment_id).val();
			var comment = $("#comment"+payment_id).val();
			var payment_recieved_on = $("#payment_recieved_on"+payment_id).val();

			var action = $("#action"+payment_id).val();
			$.ajax({
				url:'{{ url("admin/franchise/updatepaymentdetails/".$Franchise->id)}}',
				method:'post',
				data: { 'action': action, 'franchise_id': franchise_id, 'payment_id': payment_id, '_token':'{{ csrf_token() }}', 'amount': amount, 'status': status, 'month': month, 'late_fee': late_fee, 'comment': comment, 'payment_recieved_on': payment_recieved_on, 'action': action },
				beforeSend: function( xhr ) {
					//current.attr('disabled','disabled');
					$(".update-payment-response").addClass('hidden');
				},
				success:function(response){
					//current.removeAttr('disabled','disabled');
					if(response == 'success'){
						//$('#myModal2').modal('show');
						$(".update-payment-response").fadeIn();
						$(".update-payment-response").removeClass('hidden');
						$(".update-payment-response").fadeOut(2000);
					}
				}
			});				
		}
		
	});	

</script>
 
@endsection
