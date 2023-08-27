@extends('parent.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise view-tab-control">
        	<h6>{{$Client->client_childfullname}}</h6>
        	<p>Client / Task List / Add</p>
        </div>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="newTask">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="trigger"><a data-toggle="tab" href="#">Client Information</a></li>
				  <li class="trigger"><a href="{{ url('parent/client/viewinsurance/'.$Client->id) }}">Insurance</a></li>
				  <li class="trigger"><a href="{{ url('parent/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
				  <li class="trigger pos-rel"><a href="{{ url('parent/client/viewarchives/'.$Client->id) }}">Archives</a>
	              	@if(!$ClientArchives->isEmpty())
						<span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
					@endif
	              </li>
				  <li class="trigger"><a href="{{ url('parent/client/viewagreement/'.$Client->id) }}">Agreement</a></li>
				  <li class="trigger padd-left-anchor active"><a href="{{ url('parent/client/viewtasklist/'.$Client->id) }}">Task List</a></li>
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
