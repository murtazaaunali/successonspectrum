@extends('parent.layout.main')

@section('content')
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
            <h4 class="margin-6">{{ $sub_title }}</h4>
            <p>{{ $sub_title }} / <span id="change-bread-crumb">Chat </span></p>
        </div>
        <div class="clearfix"></div>
    </div>
	@if(Session::has('Success'))
		{!! session('Success') !!}
	@endif
	<div class="super-msg-in-bottle-main" style="margin-top: 0;">
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
						{{--<div class="super-admin-message-input">
							<input type="search" placeholder="search chat or people to message">
							<div class="super-admin-message-input-icon">
								<i class="fa fa-search" aria-hidden="true"></i>
							</div>
						</div>--}}
					</div>

					<div class="super-admin-message-left-bottom">
						<div class="msgin-botle-pills-main">
							<ul class="nav nav-pills">
								@foreach($messages_list as $message_list)
								
								<li>
									<a href="{{ $message_list['url']  }}">
										<div class="super-admin-mess-content-main super-admin-mess-content-main-1">
											<div class="super-admin-mess-content-left">
												<div class="super-admin-mess-content-left-icon super-admin-message-text-icon">
													<img src="{{ $message_list['message_image']  }}" />
												</div>
												<div class="super-admin-mess-content-left-text">
													<b>{!! $message_list['title'] !!}</b>
													<p>
														@if($message_list['last_message'] != "")
															@if(strlen($message_list['last_message']) >= 20)
																{{ substr($message_list['last_message'],0,20).'...'  }}
															@else
																{{ $message_list['last_message']  }}
															@endif
														@else 
															
														@endif 														
													</p>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="super-admin-mess-content-right">
												<p>@if($message_list['last_message_time'] != "") {{ $message_list['last_message_time'] }} @else &nbsp; @endif</p>
												{{--<a href="#" class="btn"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>--}}
												@if($message_list['unseen_messages'])<span>{{ $message_list['unseen_messages']  }}</span>@endif
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
												<p>{{ $message['message']  }}</p>
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
														<a href="{{ route("parent.message_status", ["name" => "read", "id" => $message['message_id'] ])  }}" class="head-active">Mark as Read</a>
													@else
														<a href="{{ route("parent.message_status", ["name" => "unread", "id" => $message['message_id'] ])  }}">Mark as Unread</a>
													@endif
												</div>
												<div class="clearfix"></div>
												<p>{{ $message['message']  }}</p>
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

								@if($send_message)
									<form method="POST" action="{{ route('parent.send_message')  }}">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<input type="hidden" name="sender_id" value="{{ $sender_id }}" />
										<input type="hidden" name="sender_type" value="{{ $sender_type }}" />
										<input type="hidden" name="reciever_id" value="{{ $id }}" />
										<input type="hidden" name="message_to" value="{{ str_replace("_"," ",$name) }}" />
										<div class="super-admin-message-right-input-main">
											<div class="super-admin-message-right-input">
												<input type="text" autocomplete="off" name="message" placeholder="Your Message" />
											</div>
											<div class="super-admin-message-right-send-butn">
												<button type="submit" class="btn"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
											</div>
											<div class="clearfix"></div>
										</div>
									</form>
								@endif

							</div>
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
@endsection
