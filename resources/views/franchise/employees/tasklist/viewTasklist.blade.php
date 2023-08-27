@extends('franchise.layout.main')

@section('content')


	<div class="add-franchise-super-main">
		<div class="view-tab-control">
			<!--<h6>{{ $Employee->fullname }}</h6>
			<p>Employee / {{ $Employee->fullname }} / <span id="change-bread-crumb">Task List</span></p>-->
            <h6>{{ $Employee->personal_name }}</h6>
			<p>Employee / {{ $Employee->personal_name }} / <span id="change-bread-crumb">Task List</span></p>
		</div>
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		@include('franchise.employees.employeeTop')
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			<ul class="nav nav-tabs">
			  <li class="padd-left-anchor">
			  <a href="{{ url('franchise/employee/view/'.$Employee->id) }}">Employee Demographic</a></li>
			  <li class="trigger-5 active"><a href="#" >Task List</a></li>
			  <li class="trigger"><a href="{{ url('franchise/employee/viewtripitinerary/'.$Employee->id) }}">Trip Itinerary</a></li>
			  <li class="trigger task-btn"><a href="{{ url('franchise/employee/viewtimepunches/'.$Employee->id) }}">Time Punches</a></li>
			  <li class="trigger-1"><a href="{{ url('franchise/employee/viewperformancelog/'.$Employee->id) }}">Performance Log</a></li>
			</ul>

			<div class="tab-content">
				
				<div id="task-list" class="tab-pane fade in active">
					<div class="view-tab-content-head-main">
					    		<div class="view-tab-content-head">
					    			<!--<h3>{{ $Employee->fullname }}'s Task List</h3>-->
                                    <h3>{{ $Employee->personal_name }}'s Task List</h3>
					    		</div>
					    		<div class="view-tab-content-butn">
					    			<a href="{{ url('franchise/employee/addtasklist/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-plus" aria-hidden="true"></i>Add Task List</a>
					    			<a href="{{ url('franchise/employee/edittasklist/'.$Employee->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Eidt Details</a>
					    		</div>
					    		<div class="clearfix"></div>
					    	</div>
				    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table view-employee-tabs-task-list-lines">
				    	<div class="employee-content-left add-franchise-lines-data Task_List_Main">
					      	@if(!$Employee->tasklist->isEmpty())
					      	<ul>
					      		@forelse($Employee->tasklist()->orderBy('sort','asc')->get() as $task)
					      		<li>
					      			@if($task->status == 'Complete')
					      				<span><i class="fa fa-check " aria-hidden="true"></i></span>
					      			@else
					      				<span><i class="fa fa-times icon-back" aria-hidden="true"></i></span>
					      			@endif
					      			<h1 class="task_description">{{ $task->task }}</h1>
					      			<div class="clearfix"></div>
					      		</li>
					      		@empty
					      			<li>No Tasks found.</li>
					      		@endforelse
					      	</ul>
					      	@endif
				      	</div>
				    </div>
				</div>
		
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
	

	
<script type="text/javascript">

	$(document).ready(function(e) {

		
		$('.popup-delete-butn').click(function(){
			currentRow.parents('tr').remove();
			$('#myModal2').modal('hide');
		});
		

		
	});


    if('{{ Request::get("tab") }}' == 'tasklist'){
    	$(".dis-none-5").show();
    }

	//BREADCRUMBS CODE 
	function EmployeesDemographic() {
	    document.getElementById("change-bread-crumb").innerHTML = "Employees Demographic";
	}
	function TasksList() {
	    document.getElementById("change-bread-crumb").innerHTML = "Tasks List";
	}
	function TripItenary() {
	    document.getElementById("change-bread-crumb").innerHTML = "Trip Itenary";
	}
	function TimePunches() {
	    document.getElementById("change-bread-crumb").innerHTML = "Time Punches";
	}
	function PerformanceLog() {
	    document.getElementById("change-bread-crumb").innerHTML = "Performance Log";
	}
	
	

	
	
</script>


@endsection
