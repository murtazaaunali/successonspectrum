@extends('admin.layout.main')

@section('content')
	<div class="add-franchise-super-main">
		<div class="msg-in-a-bottle-head-top msg-in-a-bottle-font NotificationHeading">
			<h6>{{$sub_title}}</h6>
		</div>
		<div class="msg-in-a-bottle-head-top-butn msg-btn-pos msg-in-a-bottle-head-top">
			<a href="{{ route('admin.archive_notifications') }}" class="btn grey-clr-butn-msg"><i class="fa fa-archive" aria-hidden="true"></i>Archived Message @if($archive_notifications->count()) <span>{{ $archive_notifications->count() }}</span >@endif </a>
			<a href="{{ route('admin.add_notification') }}" class="btn red-clr-butn-msg"><i class="fa fa-bell" aria-hidden="true"></i>Create Notification</a>
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
					<li class="active"><a data-toggle="tab" href="#home-1">All Posted Notifications</a></li>
					<li><a data-toggle="tab" href="#menu-1"><!--Franchise Wide-->All Franchisees Admin</a></a></li>
					<!--<li><a data-toggle="tab" href="#menu-2">Administrators</a></li>-->
					<li><a data-toggle="tab" href="#menu-3"><!--Employees-->SOS Franchising</a></li>
					<!--<li><a data-toggle="tab" href="#menu-4">Clients</a></li>-->
				</ul>

				<div class="tab-content">
					<div id="home-1" class="tab-pane fade in active">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">

								@if($notifications->count())
								@php 
									$dateOrder = array();
									$todayDate = date('Y-m-d');
								@endphp
									@foreach($notifications as $notification)
										<span class="notifiTime">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span><br/>
										<div class="create-notification-main">

												{{--@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<span class="circle-super-admin circle-super-admin-blue"></span>
												@elseif($notification->type == 'Update')
													<span class="circle-super-admin circle-super-admin-green"></span>
												@else
													<span class="circle-super-admin"></span>
												@endif--}}

												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													@if(!$notification->franchises->isEmpty())
													@foreach($notification->franchises as $franchise)
                                                        @if($count_notifications < 4)
														
                                                            <?php /*?><h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</button></h5><?php */?>
                                                            @php $count_notifications++; @endphp
                                                            @if(isset($franchise->notificaiton_franchise))
                                                            	<h5><button>{{ $franchise->notificaiton_franchise->name }} </button></h5>
                                                            @endif
                                                            
															<?php /*?>@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif<?php */?>
														
														@else
															
															@if($dropdown == FALSE)
																@php $dropdown = TRUE; @endphp
																<h5>
																	<div class="create-notification-main-dropdown">
																		<button class="create-notifi-butn-dot noti_dots">
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																		</button>
																		<div class="create-notification-dropdown-content">
															@endif
																		<?php /*?><a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</a><?php */?>
                                                                        @if(isset($franchise->notificaiton_franchise))
                                                                            <a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
                                                                        @endif
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
													@endif
												</div>
												<div class="create-notification-del-butn">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
													<a href="{{ route('admin.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
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

					<div id="menu-1" class="tab-pane fade">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
								@php
									$i = 0;
								@endphp
								@if($notifications->count())
									@foreach($notifications as $notification)
										{{--@if($notification->send_to_everyone)--}}
                                        @if($notification->send_to_type == "All Franchises")
											<span class="notifiTime">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span><br/>
											@php
												$i++;
											@endphp
											<div class="create-notification-main">
												{{--@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<span class="circle-super-admin circle-super-admin-blue"></span>
												@elseif($notification->type == 'Update')
													<span class="circle-super-admin circle-super-admin-green"></span>
												@else
													<span class="circle-super-admin"></span>
												@endif--}}
												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													@foreach($notification->franchises as $franchise)
														@if($count_notifications < 4)
															<?php /*?><h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</button></h5><?php */?>
                                                            @php $count_notifications++; @endphp
                                                            @if(isset($franchise->notificaiton_franchise))
                                                                <h5><button>{{ $franchise->notificaiton_franchise->name }}</button></h5>
                                                            @endif
															<!--@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
															@if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
															@if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif-->
														@else
															@if($dropdown == FALSE)
																@php $dropdown = TRUE; @endphp
																<h5>
																	<div class="create-notification-main-dropdown">
																		<button class="create-notifi-butn-dot noti_dots">
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																		</button>
																		<div class="create-notification-dropdown-content">
																			@endif

																			<?php /*?><a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a><?php */?>
                                                                            @if(isset($franchise->notificaiton_franchise))
                                                                                <a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
                                                                            @endif
																			<!--@if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
																			@if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
																			@if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif-->

																			@endif
																			@endforeach

																			@if($dropdown == TRUE)
																		</div>
																	</div>
																</h5>
															@endif
												</div>
												<div class="create-notification-del-butn">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
													<a href="{{ route('admin.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
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
										@endif
									@endforeach
								@endif

								@if($i == 0)
									No Notification Found!
								@endif
							</div>
						</div>
					</div>

					<div id="menu-2" class="tab-pane fade hidden">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
								@php
									$i = 0;
								@endphp
								@if($notifications->count())
									@foreach($notifications as $notification)
										@if($notification->send_to_franchise_admin)
											<span class="notifiTime">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span><br/>
											@php
												$i++;
											@endphp
											<div class="create-notification-main">
												@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<span class="circle-super-admin circle-super-admin-blue"></span>
												@elseif($notification->type == 'Update')
													<span class="circle-super-admin circle-super-admin-green"></span>
												@else
													<span class="circle-super-admin"></span>
												@endif
												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													@foreach($notification->franchises as $franchise)
														@if($count_notifications < 4)
															<?php /*?><h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</button></h5><?php */?>
                                                            @php $count_notifications++; @endphp
                                                            @if(isset($franchise->notificaiton_franchise))
                                                                <h5><button>{{ $franchise->notificaiton_franchise->name }}</button></h5>
                                                            @endif
															<!--@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
															@if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
															@if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif-->
														@else
															@if($dropdown == FALSE)
																@php $dropdown = TRUE; @endphp
																<h5>
																	<div class="create-notification-main-dropdown">
																		<button class="create-notifi-butn-dot noti_dots">
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																		</button>
																		<div class="create-notification-dropdown-content">
																			@endif

																			<?php /*?><a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a><?php */?>
                                                                            @if(isset($franchise->notificaiton_franchise))
                                                                                <a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
                                                                            @endif
																			<!--@if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
																			@if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
																			@if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif-->

																			@endif
																			@endforeach

																			@if($dropdown == TRUE)
																		</div>
																	</div>
																</h5>
															@endif
												</div>
												<div class="create-notification-del-butn">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
													<a href="{{ route('admin.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
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
										@endif
									@endforeach
								@endif

								@if($i == 0)
									No Notification Found!
								@endif
							</div>
						</div>
					</div>

					<div id="menu-3" class="tab-pane fade">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
								@php
									$i = 0;
								@endphp
								@if($notifications->count())
									@foreach($notifications as $notification)
										{{--@if($notification->send_to_employees)--}}
                                        @if($notification->send_to_type == "Administration")
											<span class="notifiTime">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span><br/>
											@php
												$i++;
											@endphp
											<div class="create-notification-main">
												{{--@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<span class="circle-super-admin circle-super-admin-blue"></span>
												@elseif($notification->type == 'Update')
													<span class="circle-super-admin circle-super-admin-green"></span>
												@else
													<span class="circle-super-admin"></span>
												@endif--}}
												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													@foreach($notification->franchises as $franchise)
														@if($count_notifications < 4)
															<?php /*?><h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif </button></h5><?php */?>
                                                            @php $count_notifications++; @endphp
                                                            @if(isset($franchise->notificaiton_franchise))
                                                                <h5><button>{{ $franchise->notificaiton_franchise->name }}</button></h5>
                                                            @endif
															<!--@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
															@if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
															@if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif-->
														@else
															@if($dropdown == FALSE)
																@php $dropdown = TRUE; @endphp
																<h5>
																	<div class="create-notification-main-dropdown">
																		<button class="create-notifi-butn-dot noti_dots">
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																		</button>
																		<div class="create-notification-dropdown-content">
																			@endif

																			<?php /*?>@if($franchise->notificaiton_franchise)<a href="javascript:void(0);"> {{ $franchise->notificaiton_franchise->name }} </a>@endif<?php */?>
                                                                            @if(isset($franchise->notificaiton_franchise))
                                                                                <a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
                                                                            @endif
																			<!--@if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
																			@if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
																			@if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif-->

																			@endif

																		
																			@endforeach

																			@if($dropdown == TRUE)
																		</div>
																	</div>
																</h5>
															@endif

													@if($notification->send_to_type == 'Administration')
														<h5><button> SOS Franchising </button></h5>
													@endif
												</div>
												<div class="create-notification-del-butn">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
													<a href="{{ route('admin.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
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
										@endif
									@endforeach
								@endif

								@if($i == 0)
									No Notification Found!
								@endif
							</div>
						</div>
					</div>

					<div id="menu-4" class="tab-pane fade hidden">
						<div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
							<div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
								@php
									$i = 0;
								@endphp
								@if($notifications->count())
									@foreach($notifications as $notification)
										@if($notification->send_to_clients)
											<span class="notifiTime">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span><br/>
											@php $i++; @endphp
											<div class="create-notification-main">
												@if( in_array($notification->type, array('Announcement', 'Activity')) )
													<span class="circle-super-admin circle-super-admin-blue"></span>
												@elseif($notification->type == 'Update')
													<span class="circle-super-admin circle-super-admin-green"></span>
												@else
													<span class="circle-super-admin"></span>
												@endif
												<div class="create-notification-main-main">
													<h3 style="margin-top: 0;">{!! strip_tags($notification->title) !!}</h3>
													@php $count_notifications = 0; @endphp
													@php $dropdown = FALSE; @endphp
													@foreach($notification->franchises as $franchise)
														@if($count_notifications < 4)
															<?php /*?><h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->name }} @endif</button></h5><?php */?>
                                                            @php $count_notifications++; @endphp
                                                            @if(isset($franchise->notificaiton_franchise))
                                                                <h5><button>{{ $franchise->notificaiton_franchise->name }}</button></h5>
                                                            @endif
															<!--@if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
															@if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
															@if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif-->
														@else
															@if($dropdown == FALSE)
																@php $dropdown = TRUE; @endphp
																<h5>
																	<div class="create-notification-main-dropdown">
																		<button class="create-notifi-butn-dot noti_dots">
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																			<i class="fa fa-circle" aria-hidden="true"></i>
																		</button>
																		<div class="create-notification-dropdown-content">
																			@endif

																			<?php /*?><a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a><?php */?>
                                                                            @if(isset($franchise->notificaiton_franchise))
                                                                                <a href="javascript:void(0);">{{ $franchise->notificaiton_franchise->name }}</a>
                                                                            @endif
																			<!--@if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
																			@if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
																			@if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif-->

																			@endif
																			@endforeach

																			@if($dropdown == TRUE)
																		</div>
																	</div>
																</h5>
															@endif
												</div>
												<div class="create-notification-del-butn">
													@if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
													<a href="{{ route('admin.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
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
										@endif
									@endforeach
								@endif

								@if($i == 0)
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
									<h4 class="pull-left">{!! strip_tags($notification->title) !!}</h4>
									<span class="pull-right viewNotiTimeSpan">{{ date('H:iA | M j, Y', strtotime($notification->created_at)) }}</span>
									<div class="clearfix"></div>
									<p><strong>{{ $notification->type }}:</strong>{{$notification->description}}</p>
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
												<td>@if(isset($franchise->notificaiton_franchise)) {{ $franchise->notificaiton_franchise->name }} @endif</td>
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
										<a href="{{ route('admin.process_archive',['id'=>$notification->id]) }}" class="btn btn-primary">Yes, Continue</a>
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