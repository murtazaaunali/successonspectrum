@extends('franchise.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise view-tab-control">
        	<h6>{{$sub_title}}</h6>
        	<!--<p>Employee / {{ $Employee->fullname }} / Task List / Add</p>-->
            <p>Employee / {{ $Employee->personal_name }} / Task List / Add</p>
        </div>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="newTask">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="padd-left-anchor">
				  <a href="{{ url('franchise/employee/view/'.$Employee->id) }}">Employee Demographic</a></li>
				  <li class="trigger-5 active"><a href="#" >Task List</a></li>
				  <li class="trigger"><a href="{{ url('franchise/employee/viewtripitinerary/'.$Employee->id) }}">Trip Itinerary</a></li>
				  <li class="trigger task-btn"><a href="{{ url('franchise/employee/viewtimepunches/'.$Employee->id) }}">Time Punches</a></li>
				  <li class="trigger-1"><a href="{{ url('franchise/employee/viewperformancelog/'.$Employee->id) }}">Performance Log</a></li>
				</ul>
			</div>
			<div class="view-tab-control-butn-main">
				<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add Task List</button>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="tab-content">

			<div id="task-list" class="tab-pane fade in active">
			    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table padd-zero-lines EmployeeAddTaskListMainDiv">
			    	<div class="task-list-main">
			    		<div class="super-admin-add-relation-main border-bot-0">
			    			<div class="super-admin-add-relation border-bot-0">
				    			<div id="tasks_cover">
				    				<div class="taskDiv">
				    					<div class="performance_lable">
					    					<label>Task Detail</label>
					    				</div>
					    				<div class="performane_textare">
						    				<textarea class="task_text" name="task[]"></textarea>
						    				<label class="error" for="task[]"></label>
				                            @if ($errors->has('task[]'))
				                                <span class="help-block error">
				                                    <strong style="color:red">{{ $errors->first('task[]') }}</strong>
				                                </span>
				                            @endif
			                        	</div>
			                        	<div class="clearfix"></div>
				    				</div>
				    			</div>
				    			<figure>
				    				<label class="task-list-label-wid"></label><input id="addTask" style="width: 52%;" type="button" class="btn add-relation-dashed" value="+ Add Another Task">
				    			</figure>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>


		</div>
	</div>
	<!-- header-bottom-sec -->	

	</form>
</div>	
	



<script type="text/javascript">
	$(document).ready(function() {
		$( ".datepicker" ).datepicker();
		
		$( "#newTask" ).validate({
		  rules: {
		    'task[]':{required:true},
		  },
		});
		
		$(document).on('click','#addTask',function(){
			//alert();
			var mhtml = '<div class="taskDiv"><div class="performance_lable"><label>Task Detail</label></div><div class="performane_textare"><textarea class="task_text" name="task[]" required></textarea><label class="error" for="task[]"></label></div><i class="fa fa-times remove_div"></i></div><div class="clearfix"></div>';
			$('#tasks_cover').append(mhtml);

			$(".task_text").each(function(){$(this).rules("add", {required:true,}) });
			
		});
		$(document).on('click','.remove_div',function(){
			$(this).parent('.taskDiv').remove();
		});
	});	

</script>
 
@endsection
