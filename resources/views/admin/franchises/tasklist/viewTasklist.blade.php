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
					  <li class="padd-left-anchor Task-List-1"><a href="{{ url('admin/franchise/view/'.$Franchise->id) }}">Franchisee Demographic</a></li>
					  <li class="Task-List active"><a href="#">Task List</a></li>
					  <!--<li class="Task-List-1 Task-List-2"><a href="{{ url('admin/franchise/viewpayment/'.$Franchise->id) }}">Payments</a></li>-->
					</ul>
				</div>
				<div class="view-tab-control-butn-main">
					<a href="{{ url('admin/franchise/addtasklist/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-plus" aria-hidden="true"></i><!--Add Task List-->Add To Task List</a>
					<a href="{{ url('admin/franchise/edittasklist/'.$Franchise->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Task List</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="tab-content">
				<div id="task-list" class="tab-pane fade in active">
				    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table padd-zero-lines">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3 class="MargBot20">{{ $Franchise->name }}, {{ $Franchise->getState->state_name }} Task List</h3>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="employee-content-left add-franchise-lines-data Task_List_Main">
					      	@if(!$Franchise->tasklist->isEmpty())
					      	<ul>
					      		@forelse($Franchise->tasklist()->orderBy('sort','asc')->get() as $task)
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
	$(document).ready(function(){
		$('.datepicker_filter').datetimepicker({
			autoclose: true,
	        format: 'yyyy',
		    maxView: 4,
		    minView: 4,
		    startView: 4,
		});
	});//ready

</script>
@endsection
