@extends('femployee.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<h4>Employee Performance</h4>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		{{--@include('franchise.employees.employeeTop')--}}
		
		<div class="add-franchise-data-main-1 PerformanceNone">

			<div class="tab-content">
				
				<div id="performance-log" class="tab-pane fade in active ">
				    <div class="upcoming-contact-expiration upcoming-contact-expiration-view-table padd-upcoming EmployeePerformanceMainDiv">
				    	
				    	<div class="view-tab-content-head-main view-tab-content-head-main-padd">
				    		<div class="view-tab-content-head">
                                <h3>Performance Log</h3>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
						<div class="super-admin-table-select padd-upcoming-1">
							<form action="" method="get" id="performancelog_filter">
								<label>Month</label>
                                <select name="month">
									<option value="">Select Month</option>
									@foreach($months as $key => $getMonth)
										<option @if(Request('month') == $key) selected @endif value="{{ $key }}">{{ $getMonth }}</option>
									@endforeach
								</select>
                                <label>Event</label>
								<select name="event">
									<option value="">Select Event</option>
						    		@foreach($PerformanceLogEvents as $event)
						    			<option @if(Request('event') == $event) selected @endif >{{ $event }}</option>
						    		@endforeach
								</select>
								@if(Request::has('performance_log'))
									<input type="hidden" name="performance_log" value="edit"/>
								@endif
								<div class="ButtonsPullRightRisponsive">
									<button type="submit" class="btn franchise-search-butn" ><i class="fa fa-search" aria-hidden="true"></i> Search</button>
									<a href="{{ url('femployee/performance') }}@if(Request::has('performance_log')){{ '?performance_log=edit' }}@endif " class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
								</div>
							</form>
						</div>
						<div class="EmployeePerformanceTableMain">
							<div class="PerformanceLogTableWidth Edit-Performance super-admin-table-1 table-responsive super-admin-table-time-punches">
								<form action="{{ url('franchise/employee/performanceupdate/'.$Employee->id) }}" method="post" id="editPerformance">
									<table class="table-striped @if(Request::has('performance_log') == 'edit') EditperformancelogTableWidth @else ViewperformancelogTableWidth @endif">
										<tr>
											<th>Date</th>
											<th>Event</th>
											<th>Comment</th>
											<th>Description</th>
										</tr>
										@if(!$Employee_performance->isEmpty())
											@php $count = 0; @endphp
											@foreach($Employee_performance as $log)
												<tr>
													<td>{{ date('jS M Y', strtotime($log->date)) }}</td>
													<td>
														@if(Request::has('performance_log'))
															<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
															<input type="hidden" name="performance[{{ $count }}][date]" value="{{ $log->date }}"/>
															<input type="hidden" name="performance[{{ $count }}][employee_id]" value="{{ $Employee->id }}"/>
															<select name="performance[{{ $count }}][event]">

													    		@foreach($PerformanceLogEvents as $event)
													    			<option @if($log->event == $event) selected @endif >{{ $event }}</option>
													    		@endforeach

															</select>
														@else
															{{ $log->event }}
														@endif
													</td>
													<td>
														@if(Request::has('performance_log') == 'edit')
															<input type="text" readonly class="performance_input" name="performance[{{ $count }}][comment]" value="{{ $log->comment }}"/>
															<a class="BluePencile"><i class="fa fa-pencil" aria-hidden="true"></i></a>
														@else
															{{ $log->comment }}
														@endif
													
													</td>
													<td class="super-admin-table-time-punches-td">
														@if(Request::has('performance_log') == 'edit')
															<input type="text" readonly class="performance_input" name="performance[{{ $count }}][description]" value="{{ $log->description }}"/>
															<a class="BluePencile"><i class="fa fa-pencil" aria-hidden="true"></i></a>
															<a href="#" class="red-clr delete_performance"><i class="fa fa-trash" aria-hidden="true"></i></a>
														@else
															{{ $log->description }}
														@endif
													</td>
												</tr>
												@php $count++; @endphp
											@endforeach
										@else
											<tr><td colspan="4">No Performance Log found.</td></tr>
										@endif

									</table>
								</form>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	<div class="poupup-main">
	  <!-- Trigger the modal with a button -->


	   <!-- ============== Modal for performance log ================ -->
	  <div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content add-forgetten-modal-content EventModel">
	        <div class="modal-header add-forgetten-modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Add a Forgotten Time Punch</h4>
	        </div>
	        <div class="modal-body add-forgetten-modal-body pos-rel">
	          <form action="{{ url('franchise/employee/addtimepunch/'.$Employee->id) }}" method="post" id="TimePunch">
		          <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          
		          <input type="text" placeholder="Date" name="date" class="TimePunchDate" autocomplete="off">
		          <i class="fa fa-calendar pos-abs-popup-caleder TimePunchDate" aria-hidden="true"></i>
		          <input type="text" placeholder="Time In" name="time_in" class="TimePunchTime" id="add_time_in" autocomplete="off">
		          <input type="text" placeholder="Time Out" name="time_out" class="TimePunchTime" id="add_time_out" autocomplete="off">
		          
		          <input class="btn add-franchise-data-butn-1" type="submit" value="Add Forgotten Time Punch">
	          </form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	  <!-- ============== Modal for performance log ================ -->
	  

	  <!-- ============== Modal for delete performance log ================ -->
		<div class="delete-popup-main">
		  <div class="modal fade" id="myModal2" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content DeleteEmployeepopup">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Delete Performance Log</h4>
		        </div>
		        <div class="modal-body">
		          <p>Are you sure you want to delete this log.</p>
		          <input class="btn popup-delete-butn" type="button" value="Delete">
		        </div>
		      </div>
		      
		    </div>
		  </div>	  
		 </div> 
	  <!-- ============== Modal for delete performance log ================ -->
	  
	</div>
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
	          	<form action="{{ url('franchise/employee/printreport/'.$Employee->id) }}" method="post" id="printReport">
		          	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
		          	<div class="pop_position-rel">
		          	<input type="text" name="startReport" autocomplete="off" placeholder="Date (From)" id="startReport" class="startReport">
					<a><i class="fa fa-calendar startReport" aria-hidden="true"></i></a>
					<label class="error" for="startReport"></label>
					</div>
		          	<div class="pop_position-rel">
		          	<input type="text" name="endReport" autocomplete="off" placeholder="Date (To)" id="endReport" class="endReport">
					<a><i class="fa fa-calendar endReport" aria-hidden="true"></i></a>
					<label class="error" for="endReport"></label>
		          	</div>
		          	<input class="btn add-franchise-data-butn-1" type="submit" value="Print Report">
	          	</form>
	        </div>
	      </div>
	      
	    </div>
	  </div>
	</div>
	
<div class="delete-popup-main">
  <div class="modal fade" id="myModal-22" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Emergency Contact?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this contact ? This action cannot be undo</p>
          <input class="btn popup-delete-butn" type="button" value="Delete Contact">
        </div>
      </div>
      
    </div>
  </div>
</div>
	
<script type="text/javascript">
	$(document).ready(function(e) {
		
		//Code for edit performance log
		$('.BluePencile').click(function(){
			var editInput = $(this).parent('td').find('.performance_input');
			if( editInput.attr('readonly') ){
				editInput.removeAttr('readonly');
			}else{
				editInput.attr('readonly','');
			}
		});
		
		// code for delete Performance
		var currentRow = '';
		$('.delete_performance').click(function(){
			currentRow = $(this);
			$('#myModal2').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			currentRow.parents('tr').remove();
			$('#myModal2').modal('hide');
		});
		
		//Submit update performance form 
		$('.updatePer').click(function(){
			$('#editPerformance').submit();
		});

		
	});

	//PERFORMANCE FILTERS
	$("#performancelog_filter").on("submit",function(e){
	    e.preventDefault();
	    var url = $(this).attr("action");

	    var event        = $('#performancelog_filter select[name=\'event\']').val();
	    var month       = $('#performancelog_filter select[name=\'month\']').val();

	    if(event == "" && month == "")
	    {
	        alert("Please select both fields");
	        return false;
	    }
	    else
	    {
	        url += '?tab=performance_log&';
	    }

	    if(event != "")
	    {
	        url += 'event=' + encodeURIComponent(event);
	    }

	    if(month != "")
	    {
	        if(event != "")
	            url += '&';
	        url += 'month=' + encodeURIComponent(month);
	    }
		@if(Request::has('performance_log'))
			url += '&performance_log=edit';
		@endif

	    window.location = url;
	})	
</script>


@endsection
