@extends('femployee.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<div class="msg-in-a-bottle-head-top msg-in-a-bottle-font NotificationHeading">
			<h6 class="margin-6">{{$sub_title}}</h6>
			<p>Notifications / <span id="change-bread-crumb">My Deck</span></p>
		</div>
		<div class="msg-in-a-bottle-head-top-butn msg-btn-pos msg-in-a-bottle-head-top">
			<!--<a href="{{ route('franchise.archive_notifications') }}" class="btn grey-clr-butn-msg"><i class="fa fa-archive" aria-hidden="true"></i>Archived Message @if($archive_notifications->count()) <span>{{ $archive_notifications->count() }}</span >@endif </a>
			<a href="{{ route('franchise.add_notification') }}" class="btn red-clr-butn-msg"><i class="fa fa-bell" aria-hidden="true"></i>Create Notification</a>-->
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
					<li class="active"><a data-toggle="tab" href="#home-1">Notifications</a></li>
				</ul>

				<div class="tab-content">
					<div id="home-1" class="tab-pane fade in active">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">

								@if($notifications->count())
									@foreach($notifications as $notification)
										<div class="create-notification-main">

												@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<!--<span class="circle-super-admin circle-super-admin-blue"></span>-->
												@elseif($notification->type == 'Update')
													<!--<span class="circle-super-admin circle-super-admin-green"></span>-->
												@else
													<!--<span class="circle-super-admin"></span>-->
												@endif

												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													{{--@if(!$notification->franchises->isEmpty())
													@foreach($notification->franchises as $franchise)
														@if($count_notifications < 4)

															<h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</button></h5>
															@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif

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
																			<a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</a>

														@endif
													@endforeach
													@endif

																			@if($notification->send_to_type == 'Administration')
																				<h5><button> SOS Franchising </button></h5>
																			@endif


													@if($dropdown == TRUE)
																		</div>
																	</div>
																</h5>
													@endif--}}
												</div>
                                                
                                                <div class="create-notification-del-butn" style="top:5px;">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
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
					<div class="modal fade" id="myModal{{ $notification->id }}" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Notification Details</h4>
								</div>
								<div class="modal-body">
									<h4 class="pull-left">{{ $notification->title }}</h4>
									<span class="pull-right viewNotiTimeSpan">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span>
									<div class="clearfix"></div>
									<p>@if($notification->old_description) <b>Update</b> @endif {{ $notification->description }}</p>
								</div>
								<div class="modal-header" style="border-radius: 0px;">
									<h4>Shared With</h4>
								</div>
								<div class="pop-up-table table-responsive">
									<table>
										<tr>
											<th>Franchise(s)</th>
											<th>Admin</th>
											<th>Employees</th>
											<th>Clients</th>
										</tr>
										@foreach($notification->franchises as $franchise)
											<tr class="border-bot-grey">
												<td>@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</td>
												<td class="padd-perc @if($notification->send_to_franchise_admin == 0) grey-clr @endif"><i class="fa @if($notification->send_to_franchise_admin == 0) fa-times @else fa-check @endif" aria-hidden="true"></i></td>
												<td class="padd-perc @if($notification->send_to_employees == 0) grey-clr @endif"><i class="fa @if($notification->send_to_employees == 0) fa-times @else fa-check @endif" aria-hidden="true"></i></td>
												<td class="padd-perc @if($notification->send_to_clients == 0) grey-clr @endif"><i class="fa @if($notification->send_to_clients == 0) fa-times @else fa-check @endif" aria-hidden="true"></i></td>
											</tr>
										@endforeach
									</table>
								</div>
							</div>

						</div>
					</div>
					<div class="delete-popup-main ArchiveNotificationPopupMain">
						<div class="modal fade" id="Archive{{ $notification->id }}" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Archive Notification</h4>
									</div>
									<div class="modal-body">
										<p>Are you sure, you want to archive this Notification?</p>
										<a href="{{ route('franchise.process_archive',['id'=>$notification->id]) }}" class="btn btn-primary">Yes, Continue</a>
										<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif

	</div>
@endsection