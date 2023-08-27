@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<div class="msg-in-a-bottle-head-top msg-in-a-bottle-font NotificationHeading">
			<h6>{{$sub_title}}</h6>
		</div>
		<div class="msg-in-a-bottle-head-top-butn msg-btn-pos msg-in-a-bottle-head-top">
			<a href="{{ url('franchise/notifications') }}" class="btn grey-clr-butn-msg" style="background: #4e98ca ; "><i class="fa fa-bell" aria-hidden="true"></i>Notifications </a>
			<a href="{{ route('franchise.add_notification') }}" class="btn red-clr-butn-msg"><i class="fa fa-bell" aria-hidden="true"></i>Create Notification</a>
		</div>
		<div class="clearfix"></div>

		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		@if ($errors->any())
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div id="client-main-deck" class="scroll-body-1">
			<div class="inner-tabs-main inner-tabs-parent inner-tabs-admin inner-tabs-super-admin TabsPadd">
				<ul class="nav nav-tabs padd-left-1">
					<li class="active"><a data-toggle="tab" href="#home-1">Archive Notifications</a></li>
				</ul>

				<div class="tab-content">
					<div id="home-1" class="tab-pane fade in active">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">

								@if($notifications->count())
									@foreach($notifications as $notification)
										<div class="create-notification-main">
											<span class="circle-super-admin"></span>
											<div class="create-notification-main-main">
												<h3 style="margin-top: 0;">{{ $notification->title  }}</h3>
												@php $count_notifications = 0; @endphp
												@php $dropdown = FALSE; @endphp
												@foreach($notification->franchises as $franchise)
													@if($count_notifications < 4)
														<h5><button> @php $count_notifications++; @endphp {{ $franchise->notificaiton_franchise->name }} </button></h5>
														@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
														@if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
														@if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
													@else
														@if($dropdown == FALSE)
															@php $dropdown = TRUE; @endphp
															<h5>
																<div class="create-notification-main-dropdown">
																	<button class="create-notifi-butn-dot">
																		<i class="fa fa-circle" aria-hidden="true"></i>
																		<i class="fa fa-circle" aria-hidden="true"></i>
																		<i class="fa fa-circle" aria-hidden="true"></i>
																	</button>
																	<div class="create-notification-dropdown-content">
																		@endif

																		<a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
																		@if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
																		@if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
																		@if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif

																		@endif
																		@endforeach

																		@if($dropdown == TRUE)
																	</div>
																</div>
															</h5>
														@endif
											</div>
											<div class="create-notification-del-butn">
												@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-2"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
												<a href="javascript:voide(0);" class="btn edit-noti-butn-2" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-file" aria-hidden="true"></i></a>
											</div>
											<div class="clearfix"></div>
											@if($notification->old_description)
												<p>
													<label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
													<span class="inner-para-span">{{ $notification->old_description }}</span>
													<span class="clearfix"></span>
												</p>
											@else
												<p>{{ $notification->description }}</p>
											@endif
										</div>
									@endforeach
								@else
									No Notification Found!
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if($notifications->count())
			@foreach($notifications as $notification)
				<div class="create-notification-popup-main">
					<div class="modal fade" id="Archive{{ $notification->id }}" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>UnArchive Notification</h4>
								</div>

								<div class="modal-body">
									<p>Are you sure, you want to unarchive this Notification?</p>
								</div>

								<div class="modal-footer">
									<a href="{{ route('franchise.remove_archive',['id'=>$notification->id]) }}" class="btn btn-primary">Yes, Continue</a>
									<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
								</div>

							</div>

						</div>
					</div>
				</div>
			@endforeach
		@endif

	</div>
@endsection