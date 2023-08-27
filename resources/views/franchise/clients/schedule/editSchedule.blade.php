@extends('franchise.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main"> 
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise view-tab-control">
        	<h6>{{$sub_title}}</h6>
            <p>Client / {{ $Client->client_childfullname }} / Task List / Edit</p>
        </div>
        <div class="clearfix"></div>
    </div>

	<div class="text-left">
	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	</div>

	<form method="post" id="newTask">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="trigger"><a href="{{ url('franchise/client/view/'.$Client->id) }}">Client Information</a></li>
				  <li class="trigger"><a href="{{ url('franchise/client/viewinsurance/'.$Client->id) }}">Insurance</a></li>
				  <li class="trigger"><a href="{{ url('franchise/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
				  <li class="trigger pos-rel"><a href="{{ url('franchise/client/viewarchives/'.$Client->id) }}">Archives</a>
	              	@if(!$ClientArchives->isEmpty())
						<span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
					@endif
	              </li>
				  <li class="trigger"><a href="{{ url('franchise/client/viewagreement/'.$Client->id) }}">Agreement</a></li>
				  <li class="trigger padd-left-anchor active"><a href="{{ url('franchise/client/viewtasklist/'.$Client->id) }}">Task List</a></li>
				</ul>
			</div>

			<div class="clearfix"></div>
		</div>
		<div class="tab-content">

			<div id="task-list" class="tab-pane fade in active">
			    
			    <form action="" method="post">
			    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
				<div class="add-franchise-data-main-1 upcoming-contact-expiration-view-table padd-zero-lines">
			    	<div class="view-tab-content-head-main">
			    		<div class="view-tab-content-head">
                            <h3>{{ $Client->client_childfullname }}'s Task List</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="employee-content-left add-franchise-lines-data ">
				      	<div class="edit-task-list-li-edit">
						    <ul class="sortableList">
						        @if(!$Client->tasklist->isEmpty())
						        @php 
						        	$taskList = $Client->tasklist()->orderBy('sort','asc')->get();
						        	$sort = 0;
						        @endphp 
						        	@foreach($taskList as $task)
								        <li class="ui-state-default" data-sort="{{ $sort }}"><label>:::</label><p class="task_headline">{{ $task->task }}</p>
								        	<span>
								        		<a href="#" class="butn-edit-del edit-clr task_edit">
								        			<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								        		</a>
								        		<a href="#" class="butn-edit-del task_del" data-deltask_id="{{ $task->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
								        		
								        		@if($task->status == 'Incomplete')
								        			<button type="button" class="btn butn-edit-lines-edit red-clr-butn-edit change_status "><i class="fa fa-times" aria-hidden="true"></i>Mark Incomplete</button>
								        		@else
								        			<button type="button" class="btn butn-edit-lines-edit change_status"><i class="fa fa-times" aria-hidden="true"></i>Mark Complete</button>
								        		@endif
								        	</span>	
								        	<div class="clearfix"></div>
								        	<input type="hidden" class="task_sort" name="task[{{$sort}}][sort]" value="{{ $sort }}"/>
								        	<input type="hidden" name="task[{{$sort}}][task_id]" value="{{ $task->id }}"/>
								        	<input type="hidden" name="task[{{$sort}}][employee_id]" value="{{ $Client->id }}"/>
								        	<input type="hidden" class="status" name="task[{{$sort}}][status]" value="{{ $task->status }}"/>
								        	<input type="hidden" class="task_description" name="task[{{$sort}}][task_description]" value="{{ $task->task }}"/>
								        </li>
								       @php $sort++; @endphp
						        	@endforeach
						        @endif 

						    </ul>
						</div>
			      	</div>
			    </div>
			    </form>
			    
			</div>


		</div>
	</div>
	<!-- header-bottom-sec -->	

	</form>
</div>

<!-- Modal for edit -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Task</h4>
      </div>
      <div class="modal-body">
        <textarea class="modal_taskDescription form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_task">Save changes</button>
      </div>
    </div>
  </div>
</div>	
<!-- Modal for Delete -->
 <div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModaldel" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Task List?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this list permanently ? This action cannot be undone</p>
          <input class="btn popup-delete-butn" type="button" value="Delete List">
        </div>
      </div>
      
    </div>
  </div>
</div>		
<script type="text/javascript">
	$(document).ready(function(){
	    $(".sortableList").sortable({
	        revert: true,
		    update: function(e,ui) {
		        $('.sortableList li').each(function(index, value) {
		            $(this).attr("data-sort", index);
		            $(this).find('.task_sort').val(index);
		        });
		    },
	    });
	    $(".draggable").draggable({
	        connectToSortable: '.sortableList',
	        cursor: 'pointer',
	        helper: 'clone',
	        revert: 'invalid'
	    });
	    
	    var current_task;
	    $('.task_edit').click(function (){
	    	current_task = $(this);
	    	var taskDescription = $(this).parents('.ui-state-default').find('.task_description').val();

	    	$('.modal_taskDescription').val(taskDescription);
	    	$('#myModal').modal('show');
	    	
	    });
	    
	    $('.save_task').click(function(){
	    	var NewTaskDescription = $('.modal_taskDescription').val();
	    	current_task.parents('.ui-state-default').find('.task_description').val(NewTaskDescription);
	    	//task_headline
	    	current_task.parents('.ui-state-default').find('.task_headline').html(NewTaskDescription);
	    	$('#myModal').modal('hide');
	    });
	    
	    $('.change_status').click(function(){
	    	if($(this).hasClass('red-clr-butn-edit')){
				$(this).removeClass('red-clr-butn-edit');
				$(this).html('<i class="fa fa-times" aria-hidden="true"></i>Mark Complete');
				$(this).parents('.ui-state-default').find('.status').val('Complete');
			}else{
				$(this).addClass('red-clr-butn-edit');
				$(this).html('<i class="fa fa-times" aria-hidden="true"></i>Mark Incomplete');
				$(this).parents('.ui-state-default').find('.status').val('Incomplete');
			}
	    });
	    var task_del = '';
		$('.task_del').click(function(){
			task_del 	= $(this).data('deltask_id');
			$('#myModaldel').modal('show');
		});
		
		$('.popup-delete-butn').click(function(){
			var Url = '{{ url("franchise/client/deletetask/") }}';
			var Client_id = '{{ $Client->id }}';
			window.location.href = Url+'/'+Client_id+'/'+task_del;
		});
	});	
</script>
 
@endsection
