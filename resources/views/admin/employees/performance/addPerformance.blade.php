@extends('admin.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control float-none">
			<h6>{{ $Employee->fullname }}</h6>
			<p><a href="{{ url('admin/employees') }}">Employee</a> / <a href="{{ url('admin/employee/view/') }}/{{ $Employee->id }}">{{ $Employee->fullname }} </a> / Performance Log Add</p>
		</div>
		<div class="upload-document-cargo-head upload-document-cargo-head-2">
				<h4>Add Performance Log</h4>
			</div>
		<div class="franchise-list-main upload-document-cargo-upload Performance_main AddPerformanceLogMain">
			
			<form action="" method="post" id="PerformanceLog">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
			<div class="add-employee-data Padd-left-7">
		    	<div class="franchise-data row">
		    		<div class="col-sm-6">
			    		<label>Date</label>
			    	</div>
			    	<div class="col-sm-6">
			    		<input type="text" name="date" id="date" autocomplete="off" class="date">
			    		<i class="fa fa-calendar pos-abs-left-30 date" aria-hidden="true"></i>
			    		<label class="error error1" for="date"></label>
			    	</div>
			    </div>
			    <div class="franchise-data row">
			    	<div class="col-sm-6">
			    		<label>Event</label>
			    	</div>
			    	<div class="col-sm-6">
				    	<select name="event">
				    		<option value="">Select Event</option>
				    		@foreach($PerformanceLogEvents as $event)
				    			<option>{{ $event }}</option>
				    		@endforeach
				    	</select>
				    	<label class="error error1" for="event"></label>
			    	</div>
			    </div>
			    <div class="franchise-data row">
			    	<div class="col-sm-6">
			    		<label>Comment</label>
			    	</div>
			    	<div class="col-sm-6">
			    		<input type="text" name="comment">
			    		<label class="error error1" for="comment"></label>
			    	</div>
			    </div>
			    <div class="franchise-data row">
			    	<div class="col-sm-6">
				    	<div class="performance_lable">
				    		<label>Description</label>
				    	</div>
			    	</div>
			    	<div class="col-sm-6">
			    		<div class="performane_textare">
			    			<textarea name="description"></textarea>
			    			<label class="error error1" for="description"></label>
			    		</div>
			    	</div>
			    </div>
			    <div class="clearfix"></div>
				<div class="franchise-data franchise-data-1 two-butn">
					<label></label>
					<ul class="pager wizard two-btn front">
						<li class="previous pull-left">
							<a href="{{ url("admin/employee/view/".$Employee->id)."?tab=performance_log" }}" style="padding:0px;"><button type="button" class="btn add-franchise-data-butn padd-butn-2"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancel</button></a>
						</li>
						<li class="next pull-right">
							<button type="submit" class="btn add-franchise-data-butn padd-butn-2"><i class="fa fa-building" aria-hidden="true"></i>Add Record</button>
						</li>
					</ul>
				</div>

			</div>
			</form>
			
		</div>
	<!-- header-bottom-sec -->
	</div>

<script type="text/javascript">

	$('document').ready(function(){
		
		$('#PerformanceLog').validate({
			rules:{
				'date':{required:true},
				'event':{required:true},
				'comment':{required:true},
				'description':{required:true},
			}
		});
		
	});
  $(function () {
		  	
		var oneWeekAgo = new Date();
		oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
		  	
		//$('#date').datetimepicker({
		$('.date').datetimepicker({	
			pickerPosition: 'bottom-left',
            format: 'mm/dd/yyyy',
            maxView: 4,
            minView: 2,
            autoclose: true,
            pickTime: false,
            startDate: oneWeekAgo
        }); 
	});
</script>
 
@endsection
