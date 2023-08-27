@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise view-tab-control">
        	<h6>{{$sub_title}}</h6>
        	<p>{{ $Franchise->name }} / {{ $Franchise->getState->state_name }} / Task List / Add</p>
        </div>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="newTask">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs tabs-fonts">
				  <li class="padd-left-anchor Task-List-1"><a href="{{ url('admin/franchise/view/'.$Franchise->id) }}">Franchisee Demographic</a></li>
				  <li class="Task-List active"><a href="#">Task List</a></li>
				  <!--<li class="Task-List-1 Task-List-2"><a href="{{ url('admin/franchise/viewpayment/'.$Franchise->id) }}">Payments</a></li>-->
				</ul>
			</div>
			<div class="view-tab-control-butn-main">
				<!--<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add Task List</button>-->
                <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Add To Task List</button>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="tab-content">

			<div id="task-list" class="tab-pane fade in active">
			    <div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table padd-zero-lines FranchiseAddTaskListBtnWidth">
			    	<div class="task-list-main">
			    		<div class="super-admin-add-relation-main border-bot-0">
			    			<div class="super-admin-add-relation border-bot-0">
				    			<div id="tasks_cover">
				    				<div class="taskDiv">
					    				<label class="pos-rel-label-3 task-list-label-wid">Task Detail</label><textarea name="task[]" style="width: 52%; height: 147px;"></textarea>
					    				<br><span for="task[]"></span>
			                            @if ($errors->has('task[]'))
			                                <span class="help-block error">
			                                    <strong style="color:red">{{ $errors->first('task[]') }}</strong>
			                                </span>
			                            @endif
			                            <label class="error error-text" for="task[]"></label>
				    				</div>
				    			</div>
				    			<figure>
				    				<!--<label class="task-list-label-wid"></label><input id="addTask" style="width: 52%;" type="button" class="btn add-relation-dashed" value="+ Add Another Task">-->
                                    <label class="task-list-label-wid"></label><input id="addTask" style="width: 52%;" type="button" class="btn add-relation-dashed" value="+  Add Multiple Tasks">
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
			var mhtml = '<div class="taskDiv"><label class="pos-rel-label-3 task-list-label-wid">Task Detail</label><textarea name="task[]" style="width: 52%; height: 147px;" required></textarea><i class="fa fa-times remove_div"></i><label class="error error-text" for="task[]"></label></div>';
			$('#tasks_cover').append(mhtml);
		});
		$(document).on('click','.remove_div',function(){
			$(this).parent('.taskDiv').remove();
		});
	});	

</script>
 
@endsection
