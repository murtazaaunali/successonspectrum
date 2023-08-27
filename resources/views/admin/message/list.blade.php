@extends('admin.layout.main')

@section('content')
	<div class="main-deck-head">
		<h4>{{$sub_title}}</h4>
	</div>
	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif

    <ul>
        @foreach ($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
        @endforeach
    </ul>

	@php 

		function searchForId($id, $array) {
		   foreach ($array as $key => $val) {
		       if ($val['uid'] === $id) {
		           return $key;
		       }
		   }
		   return null;
		}
	
	@endphp

	<div class="super-msg-in-bottle-main franchise-message-box">
		<div class="row mar0">
			<div class="col-md-4 col-2">
				<div class="super-msg-in-bottle-left">
					<div class="super-admin-message-left-top">
						<div class="super-admin-message-tittle">
							<h4>{{ $inner_title }}</h4>
						</div>
						<i class="fa fa-pencil-square-o pull-right fa-2x newMsgIcon" data-toggle="modal" data-target="#new_message_pop"></i>
						<div class="clearfix"></div>

						{{--<div class="super-admin-message-tittle-bin">
							<a href="#" class="btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<a href="#" class="btn active-bin-butn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						</div>--}}
						<div class="clearfix"></div>
						<form action="" method="get">
						<div class="super-admin-message-input">
							<input type="search" name="search" autocomplete="off" placeholder="search chat or people to message"
							value="@if(Request::has('search') && Request::get('search') != '') {{ Request::get('search') }} @endif">
							<div class="super-admin-message-input-icon">
								@if(Request::has('search') && Request::get('search') != '')
									<i class="fa fa-times searchCut" aria-hidden="true"></i>
								@else
									<i class="fa fa-search" aria-hidden="true"></i>
								@endif
							</div>
						</div>
						</form>
					</div>

					<div class="super-admin-message-left-bottom">
						<div class="msgin-botle-pills-main">
							<ul class="nav nav-pills">
								@php $channels = array('Administration','Admin BCBA','Director Of Operations','Director Of Administration','Human Resources','SOS Distributor','BCBA') @endphp
								@foreach($messages_list as $message_list)
								
								@if(Request::has('search') && Request::get('search') != '')
									@if(stripos($message_list['title'], Request::get('search')) === false)
										@php continue; @endphp
									@endif
								@endif
								<li>
									<a href="{{ $message_list['url']  }}">
										<div class="super-admin-mess-content-main super-admin-mess-content-main-1" @if(!in_array($message_list['title'],$channels)) style="background:#fff !important; border:1px solid #fbf0f0 !important;" @endif>
											<div class="super-admin-mess-content-left">
												<div class="super-admin-mess-content-left-icon super-admin-message-text-icon">
													<img src="{{ $message_list['message_image']  }}" />
												</div>
												<div class="super-admin-mess-content-left-text msgsTitle_list">
													
													<b>{!! substr($message_list['title'], 0, 20).'..'  !!}</b>
													
													<p>@if($message_list['last_message'] != "")
														@if(strlen($message_list['last_message']) >= 20)
															{{ substr($message_list['last_message'],0,20).'...'  }}
														@else
															{{ $message_list['last_message']  }}
														@endif
													@else 
														
													@endif </p>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="super-admin-mess-content-right">
												<p>@if($message_list['last_message_time'] != "") {{ $message_list['last_message_time'] }} @else &nbsp; @endif</p>
												{{--<a href="#" class="btn"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>--}}
												@if(in_array($message_list['title'],$channels)) <i class="fa fa-thumb-tack thumb_icon" aria-hidden="true"></i> @endif
												@if($message_list['unseen_messages'])<span class="count_msg">{{ $message_list['unseen_messages']  }}</span>@endif
											</div>
											<div class="clearfix"></div>
										</div>
									</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>

				</div>
			</div>
			<div class="col-md-8 col-2">
				<div class="tab-content">

					<div>
						<div class="super-msg-in-bottle-right">
							<div class="super-admin-message-right-top">
								<h4>{!! $messenger_title  !!}</h4>
							</div>
						</div>

						@if(is_array($messages))
							<div class="super-admin-message-right-bottom">
								@foreach($messages as $message)
									@if($message['my_reply'])
										<div class="super-admin-message-text-main">
											<div class="super-admin-message-text-icon">
												<img src="{{ $message['message_from']['image']  }}" />
											</div>
											<div class="super-admin-message-text super-admin-message-text-second-tab">
												<p>
													{{ $message['message']  }}
													<br />
													@if($message['file'] != '')
														@if(pathinfo($message['file'],PATHINFO_EXTENSION) == 'jpeg')
															<a href="{{ url($message['file']) }}" target="_blank"><img width="100" src="{{ url($message['file']) }}" /></a>
														@elseif(pathinfo($message['file'],PATHINFO_EXTENSION) == 'pdf')
															<a href="{{ url($message['file']) }}" target="_blank"><img src="{{ asset('assets') }}/images/pdf.jpg"></a>
														@else	 
															<a href="{{ url($message['file']) }}" target="_blank"><img src="{{ asset('assets') }}/images/pdf-1.jpg"></a>
														@endif
													@endif
												</p>
											</div>
											<div class="super-admin-message-para-main">
												<p>{{ $message['message_time']  }}</p>
											</div>
											<div class="clearfix"></div>
										</div>
									@else
										<div class="super-admin-message-text-main mar-top-10px super-admin-message-text-main-right">
											<div class="super-admin-message-text-icon super-admin-message-text-icon-right">
												<img src="{{ $message['message_from']['image']  }}" />
											</div>
											<div class="super-admin-message-text super-admin-message-text-right">
												<h6>{{ $message['message_from']['name']  }}</h6>
												<button class="noitfication-drop-down-4">...</button>
												<div class="logout-box-main active-msg-drop-down logout-box-main-cargo notnone-6">
													@if( $message['message_read'] == 0 )
														<a href="{{ route("admin.message_status", ["name" => "read", "id" => $message['message_id'] ])  }}" class="head-active">Mark as Read</a>
													@else
														<a href="{{ route("admin.message_status", ["name" => "unread", "id" => $message['message_id'] ])  }}">Mark as Unread</a>
													@endif
													
													@if($name != 'Admin_Employee' && $name != 'Franchise_Employee')
														@if(isset($message['message_from']['reply_url']) && $message['message_from']['type'] != "Administration")<a href="{{ $message['message_from']['reply_url']  }}" class="bord-bot-0">Reply in Chat</a>@endif
													@endif
												</div>
												<div class="clearfix"></div>
												<p>
													{{ $message['message']  }}
													<br/>
													@if($message['file'] != '')
														@if(pathinfo($message['file'],PATHINFO_EXTENSION) == 'jpeg')
															<a href="{{ url($message['file']) }}" target="_blank"><img width="100" src="{{ url($message['file']) }}" /></a>
														@elseif(pathinfo($message['file'],PATHINFO_EXTENSION) == 'pdf')
															<a href="{{ url($message['file']) }}" target="_blank"><img src="{{ asset('assets') }}/images/pdf.jpg"></a>
														@else	 
															<a href="{{ url($message['file']) }}" target="_blank"><img src="{{ asset('assets') }}/images/pdf-1.jpg"></a>
														@endif
													@endif
												</p>
												@if( $message['message_read'] == 0 )<span></span>@endif
											</div>
											<div class="super-admin-message-para-main super-admin-message-para-main-right">
												<p>{{ $message['message_time']  }}</p>
											</div>
											<div class="clearfix"></div>
										</div>
									@endif
								@endforeach

								<div class="clearfix"></div>
							</div>
							
						@if($send_message)
							<form method="POST" action="{{ route('admin.send_message')  }}" id="chatForm" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input type="hidden" name="sender_id" value="{{ $sender_id }}" />
								<input type="hidden" name="sender_type" value="{{ $sender_type }}" />
								<input type="hidden" name="reciever_id" value="{{ $id }}" />
								<input type="hidden" name="message_to" value="{{ str_replace("_"," ",$name) }}" />
								<div class="super-admin-message-right-input-main">
									
									<div class="imageShow hidden" style="background: #ccc; padding: 10px 10px;"></div>
									<div class="super-admin-message-right-input sendmsgInput">
										<input type="text" autocomplete="off" name="message" placeholder="Your Message" />
										<span class="attachSpan"><i class="fa fa-paperclip fa-2x"></i></span>
									</div>
									<input type="file" name="img" class="msg_attachment hidden" />
									
									<div class="super-admin-message-right-send-butn">
										<button type="submit" class="btn"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
									</div>
									<div class="clearfix"></div>
								</div>
							</form>
						@endif

						@else
							<div class="super-admin-message-right-bottom">
								<div class="super-admin-message-text">
									Start Messaging through left menu..
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="new_message_pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
     <form action="{{ route('admin.send_message') }}" method="post" id="message_form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="sender_id" value="{{ $sender_id }}" />
		<input type="hidden" name="sender_type" value="{{ 'Admin Employee' }}" />
		<input type="hidden" name="message_to" value="{{ 'Admin Employee' }}" />
		

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Message</h4>
      </div>
      
      <div class="modal-body">
		  <div class="form-group">
		    <label for="messageto">Message To</label>
		    <!--<input type="text" class="form-control" name="messageto" id="messageto" placeholder="Email">-->
			<br />
			<select class="select-multiple form-control" style="width: 100%" name="reciever_id[]" multiple>
				@if(!$Employees->isEmpty())
					@foreach($Employees as $employee)
						<option value="{{ $employee->id }}" @if( is_array(old('reciever_id')) && in_array($employee->id,old('reciever_id')) ) selected="" @endif>{{ $employee->fullname }}</option>
					@endforeach
				@endif
			</select>
		  </div>
		  <div class="form-group">
		    <label for="message">Message</label>
		    <textarea class="form-control" rows="6" name="message" placeholder="Message"></textarea>
		  </div>        
		  
		  
      </div>
      
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Send Message</button>
      </div>
     </form>
      
    </div>
  </div>
</div>
	
<script type="text/javascript">
	$(document).ready(function(){
		
		var fileSize = 0;
		$('.attachSpan').click(function(){
			$('.msg_attachment').val('');
			$('.imageShow').html('');
			$('.imageShow').addClass('hidden');
			$('.msg_attachment').click();
		});
		
		$('.msg_attachment').bind('change', function() {
		  fileSize = this.files[0].size;
		  $('.imageShow').html(this.files[0].name + ' <i class="fa fa-times cutFile"></i>');
		  $('.imageShow').removeClass('hidden');
		});
		
		$('#chatForm').submit(function(){
			//4 mb 4000000
			if(fileSize > 4000000){
				alert('file is too large');
				return false;
			}
		});
		
		$(document).on('click','.cutFile',function(){
			$('.msg_attachment').val('');
			$('.imageShow').html('');
			$('.imageShow').addClass('hidden');
		})

		$('.select-multiple').select2({
			placeholder:'Select Employee(s)',
			width: 'resolve',
		});
		
		$(document).on('click','.searchCut',function(){
			window.location.href = '{{ url("admin/messages") }}';
		});
		
	})
</script>	
@endsection
