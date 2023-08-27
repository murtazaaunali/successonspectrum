@extends('franchise.layout.main')

@section('content')
	<div class="main-deck-head">
		<h4>{{$sub_title}}</h4>
	</div>
	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif

	<style>
		.super-admin-mess-content-left{
			width: 62% !important;
		}
		.designation{
			font-size:9px !important;
			font-weight: 100 !important;
		}
		.super-admin-mess-content-left-text{
			line-height: 14px !important;
		}
	</style>

	<div class="super-msg-in-bottle-main franchise-message-box">
		<div class="row mar0">
			<div class="col-md-4 col-2">
				<div class="super-msg-in-bottle-left">
					<div class="super-admin-message-left-top">
						<div class="super-admin-message-tittle">
							<h4>{{ $inner_title  }}</h4>
						</div>
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
								@php $channels = array('Administration','Admin BCBA','Director Of Operations','Director Of Administration','Human Resources','SOS Distributor','BCBA','Franchise Administration','Franchise BCBA') @endphp
								@foreach($messages_list as $message_list)

								@if(Request::has('search') && Request::get('search') != '')
									@if(stripos($message_list['title'], Request::get('search')) === false)
										@php continue; @endphp
									@endif
								@endif
								<li>
									<a href="{{ $message_list['url']  }}">
										<div class="super-admin-mess-content-main super-admin-mess-content-main-1" @if(!in_array($message_list['title'],$channels)) style="background:#fff !important;" @endif>
											<div class="super-admin-mess-content-left">
												<div class="super-admin-mess-content-left-icon super-admin-message-text-icon">
													<img src="{{ $message_list['message_image']  }}" />
												</div>
												<div class="super-admin-mess-content-left-text">
													<b>{!! $message_list['title']  !!}</b>
													<p>@if($message_list['last_message'] != "") 
														@if(strlen($message_list['last_message']) >= 20)
															{{ substr($message_list['last_message'],0,20).'...'  }} 
														@else
															{{ $message_list['last_message']  }} 
														@endif		
													@else 
														&nbsp; 
													@endif &nbsp;{{--Upcoming performance review--}}</p>
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
								<h4>{{ $messenger_title  }}</h4>
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
													@if($message['file'] != '')
														<br />
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
														<a href="{{ route("franchise.message_status", ["name" => "read", "id" => $message['message_id'] ])  }}" class="head-active">Mark as Read</a>
													@else
														<a href="{{ route("franchise.message_status", ["name" => "unread", "id" => $message['message_id'] ])  }}">Mark as Unread</a>
													@endif

													@if($name != 'Admin_Employee' && $name != 'Franchise_Employee' && $name != 'Administration')
														@if(isset($message['message_from']['reply_url']))<a href="{{ $message['message_from']['reply_url']  }}" class="bord-bot-0">Reply in Chat</a>@endif
													@endif
												</div>
												<div class="clearfix"></div>
												<p>
													{{ $message['message']  }}
													@if($message['file'] != '')
													<br />
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
								<form method="POST" action="{{ route('franchise.send_message')  }}">
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

		$(document).on('click','.searchCut',function(){
			window.location.href = '{{ url("franchise/messages") }}';
		});
		
	})
</script>	
@endsection
