@extends('admin.layout.main')

@section('content')
	<div class="main-deck-head main-deck-head-franchise">
		<h4>{{$sub_title}}</h4>
	</div>
	<div class="add-franchise-butn-main">
		<a href="javascript:void(0);" class="btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar" aria-hidden="true"></i>Add New Event</a>
	</div>
	<div class="poupup-main">
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content add-forgetten-modal-content EventModel">
					<div class="modal-header add-forgetten-modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add New Event</h4>
					</div>
					<form action="{{ url('admin/trip_itinerary/add') }}" method="post" id="addnewevent">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
						<div class="modal-body add-forgetten-modal-body">
							<select name="selectfranchise">
								<option value="">Select Franchise</option>
								@if($all_franchises->count())
									@foreach($all_franchises as $rec_franchise)
										<option value="{{ $rec_franchise->id }}">{{ $rec_franchise->location  }}</option>
									@endforeach
								@endif
							</select>
							@if($errors->has('selectfranchise'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('selectfranchise') }}</label>
                                </span>
							@endif

							<div class="pop_position-rel">
								<input name="eventdate" type="text" placeholder="Date" class="datepicker">
								<a href="javascript:void(0);"><i class="fa fa-calendar datepicker" aria-hidden="true"></i></a>
							</div>
							@if($errors->has('eventdate'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('eventdate') }}</label>
                                </span>
							@endif
							
							<input name="starttime" type="text" placeholder="Start Time" id="starttime" autocomplete="off"/>
							@if($errors->has('starttime'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('starttime') }}</label>
                                </span>
							@endif

							<input name="endtime" type="text" placeholder="End Time" id="endtime" autocomplete="off"/>
							@if($errors->has('endtime'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('endtime') }}</label>
                                </span>
							@endif

							<input name="eventname" type="text" placeholder="Event Name" />
							@if($errors->has('eventname'))
                                <span class="help-block error login-error-txt">
                                    <label class="error">{{ $errors->first('eventname') }}</label>
                                </span>
							@endif
							<input class="btn add-franchise-data-butn-1" type="submit" value="Add New Event">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	<form method="GET" action="{{ route('admin.trip_itinerary') }}" id="trip_itinerary_search">
		<div class="frnchise-select-main">
			<label>Search by Franchise State</label>
			<select name="state">
				<option value="">Select State</option>
				@if($all_states->count())
					@foreach($all_states as $state)
						<option value="{{ $state->id }}" @if(Request::has('state')) @if(Request::get('state') == $state->id) selected="" @endif @endif>{{ $state->state_name  }}</option>
					@endforeach
				@endif
			</select>

			<label>Search by Franchise Name</label>
			<select name="franchise">
				<option value="">Select Franchise</option>
				@if($all_franchises->count())
					@foreach($all_franchises as $rec_franchise)
						<option value="{{ $rec_franchise->id }}" @if(Request::has('franchise')) @if(Request::get('franchise') == $rec_franchise->id) selected="" @endif @endif>{{ $rec_franchise->location  }}</option>
					@endforeach
				@endif
			</select>
			<div class="fiter-butn-main">
				<button class="btn franchise-search-butn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
				<a href="{{ route('admin.trip_itinerary')  }}@if(Request::has('page'))?page={{ Request::get('page')  }}@endif" class="btn francse-filter-butn  butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
			</div>
		</div>
	</form>
	<div class="upcoming-contact-expiration franchise-list-main">
		<h6>{{ $inner_title  }}</h6>
		<div class="super-admin-table-2 table-responsive">
			<table>
				<tr>
					<th class="width15">Franchisees </th>
					<th>State</th>
					<th class="super-admin-table-position-1">Actions</th>
				</tr>
				@if($franchises->count())
					@foreach($franchises as $franchise)
						<tr>
							<td>{{ substr($franchise->location, 0, 20) .((strlen($franchise->location) > 20) ? '...' : '') }}</td>
							<td>{{ $franchise->getState->state_name  }}</td>
							<td class="super-admin-table-position ButtonAlignRight"><a href="{{ route("admin.trip_itinerary_franchise",["id"=>$franchise->id])  }}" class="btn snd-mes-butn-1 eye-butn"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>
						</tr>
					@endforeach
				@else
					<tr><td colspan="3">No Franchises found.</td></tr>
				@endif
			</table>
		</div>
		<div class="super-admin-table-bottom">
			<div class="super-admin-table-bottom-para">
				@if($franchises->firstItem())
					<p>Showing {{ $franchises->firstItem() }} to {{ $franchises->lastItem() }} of {{ $franchises->total() }} entries</p>
				@else
					<p>Showing 0 Entries</p>
				@endif
			</div>
			<div class="super-admin-table-bottom-pagination">
				{!! $franchises->appends(request()->query())->links() !!}
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">
		
		//Validation
		$('#addnewevent').validate({
			rules:{
				'selectfranchise':{required:true},
				'eventdate':{required:true},
				'starttime':{required:true},
				'endtime':{required:true},
				'eventname':{required:true},
			}
		});
		
		$('.datepicker').datetimepicker({
			pickerPosition: 'bottom-left',
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
        });

    function timeRange_back(startTime, endTime){
    	//START TIME
  	  	$(startTime).datetimepicker({
		  	//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 0,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1,
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
	  	}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes() );
	        $(endTime).datetimepicker('setStartDate', minTime);
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
	        if(minutes >= 55){
	        	$(endTime).datetimepicker('setHoursDisabled', [Hours]);
	        }else{
				$(endTime).datetimepicker('setHoursDisabled', []);
			}
		});
		
		//END TIME
		$(endTime).datetimepicker({
			//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 1,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1, 
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
		}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes());
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
        	
        	minTime.setMinutes(minTime.getMinutes() - 5);
        	$(startTime).datetimepicker('setEndDate', minTime);
	 	}); 
    } 
	function timeRange(startTime, endTime){
    	//START TIME
  	  	$(startTime).datetimepicker({
		  	//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 0,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1,
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
	  	}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes() );
	        $(endTime).datetimepicker('setStartDate', minTime);
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
	        if(minutes >= 55){
	        	$(endTime).datetimepicker('setHoursDisabled', [Hours]);
	        }else{
				$(endTime).datetimepicker('setHoursDisabled', []);
			}
		});
		
		//END TIME
		$(endTime).datetimepicker({
			//minuteStep: 30,
	        autoclose: true,
	        minView: 0,
	        maxView: 1,
	        startView: 1,
		    format: 'HH:ii P',
		    showMeridian: 1, 
		    pickerPosition: 'bottom-left',
		    hoursDisabled: false,
		}).on('changeDate', function (selected) {
	        var minTime = new Date(selected.date.valueOf());
	        minTime.setMinutes(minTime.getMinutes());
	        var Hours = minTime.getHours();
	        var minutes = minTime.getMinutes();
        	
        	minTime.setMinutes(minTime.getMinutes() - 5);
        	$(startTime).datetimepicker('setEndDate', minTime);
	 	}); 
    }	 
    
    timeRange('#starttime', '#endtime');	 

	//Filters
	$("#trip_itinerary_search").on("submit",function(e){
	    e.preventDefault();
	    var url = $(this).attr("action");

	    var filter_franchise    = $('select[name=\'franchise\']').val();
	    var filter_state        = $('select[name=\'state\']').val();

	    if(filter_franchise == "" && filter_state == "")
	    {
	        alert("Please Select Filter Options");
	        return false;
	    }
	    else
	    {
	        url += '?';
	    }

	    if(filter_state != "")
	    {
	        url += 'state=' + encodeURIComponent(filter_state);
	    }

	    if(filter_franchise != "")
	    {
	        if(filter_state != "")
	            url += '&';
	        url += 'franchise=' + encodeURIComponent(filter_franchise);
	    }

	    window.location = url;
	})
	</script>
@endpush