<!-- header-sec -->
<div class="head-top-main">
  <div class="head-top">
    <div class="head-1">
      	<h1>@php echo \App\Models\Franchise::find(Auth::guard('franchise')->user()->franchise_id)->location @endphp</h1>
    </div>

    @php
    $message_title  = "";
    $unread_messages  = array();
    $total_unread     = 0;
    $user_type        = "";
    $user_id          = Auth::guard('franchise')->user()->id;

    $messages = \App\Models\Messages::where("is_private",1)
    			->where(function ($query) use ($user_id) {
    				$query->where(array('reciever_id'=> $user_id, 'message_to'=> 'Franchise Employee'));	
    			})->orderBy("created_at","DESC")->limit(5)->get();
    
    if(Auth::guard('franchise')->check())
    {
      $user_type = "Franchise";
    }

    if($messages->count())
    {
      foreach($messages as $message)
      {
        $where = array(
          "message_id"  =>  $message->id,
          "user_type"   =>  $user_type,
          "user_id"     =>  $user_id,
        );

        $message_read_by = \App\Models\Messages_read_by::where($where)->get();

        if($message_read_by->count() == 0)
        {

          //if($total_unread <= 4)
          //{

            //$id           = $message->reciever_id;
            $id           = $message->sender_id;
            $name         = "";
            $sender_type  = $message->sender_type;
            $sender_id    = $message->sender_id;
            //$type         = $message->message_to;
            $type         = $message->sender_type;
            
            $sender_image = asset('assets/images/super-mess-icon.jpg');

            if($sender_type == "Franchise Employee" || $sender_type == "Franchise BCBA")
            {
              $get_franchise = \App\Models\Franchise::find( \App\Models\Franchise\Fuser::find($sender_id)->franchise_id );
              $sender = \App\Models\Franchise\Fuser::find($sender_id);
              if($get_franchise){
	              if($get_franchise->profile_picture)
	              {
	                $sender_image = asset($get_franchise->profile_picture);
	              }
	              //$name = $get_franchise->location;
	              $name = $sender->fullname . "<br/><small>(".$sender->type.') | '.$get_franchise->location.'</small>';
			  }
              
            }

            if($sender_type == "Administration")
            {
              $admin = \App\Models\Admin::find($sender_id);
              if($admin->profile_picture)
              {
                $sender_image = asset($admin->profile_picture);
              }
              $name = $admin->fullname;
            }

            if($sender_type == "Admin Employee")
            {
              $admin_employee = \App\Models\Admin::find($sender_id);
              if($admin_employee->profile_picture)
              {
                $sender_image = asset($admin_employee->profile_picture);
              }
              $name = $admin_employee->fullname."<br/><small>(Admin Employee)</small>";
            }

            if($sender_type == "Employee")
            {
              $get_employee = \App\Models\Franchise\Femployee::find($sender_id);
              if($get_employee->personal_picture)
              {
                $sender_image = asset($get_employee->personal_picture);
              }
              $name = $get_employee->personal_name."<br/><small>(Employee)</small>";
            }

            if($sender_type == "Parent")
            {
              $parent = \App\Models\Franchise\Client::find($sender_id);
              if($parent->client_profilepicture)
              {
                $sender_image = asset($parent->client_profilepicture);
              }
              $name = $parent->client_childfullname."<br/><small>(Client)</small>";
            }

            if($sender_type == "Admin BCBA"){
                $message_title  = "BCBA";
            }

            if($sender_type == "Administration"){
                $message_title  = $name;
            }

            if($sender_type == "Franchise Administration"){
                $message_title  = $name;
            }
            
            if($sender_type == "Employee"){
                $message_title  = $name;
            } 
            
            if($sender_type == "Franchise BCBA"){
                $message_title  = $name;
            }

            if($sender_type == "Admin Employee"){
                $message_title  = $name;
            }

            if($sender_type == "Franchise Employee"){
                $message_title  = $name;
            }
            
            if($sender_type == "SOS Distributor"){
                $message_title  = $sender_type;
            }

            if($type == "Admin BCBA"){
                $url = route('franchise.messages', ['name' => "Admin_BCBA"]);
            }

            if($type == "Administration"){
                $url = route('franchise.messages', ['name' => $type]);
            }

            if($type == "Franchise Administration"){
                $url = route("franchise.messages", ["name" => "Franchise_Administration"]);
            }

            if($type == "Franchise BCBA"){
                $url = route("franchise.messages", ["name" => "Franchise_BCBA", "id" => $id]);
            }

            if($type == "Admin Employee"){
                $url = route("franchise.messages", ["name" => "Admin_Employee", "id" => $id]);
            }

            if($type == "Franchise Employee"){
                $url = route("franchise.messages", ["name" => "Franchise_Employee", "id" => $id]);
            }
            
            if($type == "Employee"){
                $url = route("franchise.messages", ["name" => "Employee", "id" => $id]);
            }

            if($type == "Parent"){
                $url = route("franchise.messages", ["name" => "Parent", "id" => $id]);
            }
                        
            if($type == "SOS Distributor"){
                $url = route("franchise.messages", ["name" => "SOS_Distributor"]);
            }

            $unread_messages[] = array(
              "title"         =>  $message_title,
              "url"           =>  $url,
              "message_time"  =>  date("h:i a | M d Y",strtotime($message->created_at)),
              "message"       =>  $message->message,
              "image"         =>  $sender_image,
            );
          //}

          $total_unread++;
        }
      }
    }

    $getNot = \App\Models\Notifications_to_franchise::where('franchise_id',Auth::user()->franchise_id)->get();
    $notifications_ids = array();
    if(!$getNot->isEmpty()){
		foreach($getNot as $noti){
			$notifications_ids[] = $noti->notification_id;
		}
	}
	
    $unread_notifications = \App\Models\Notifications::
    						//whereIn('id', $notifications_ids)
    						//->where('user_type','Administration')
    						where('send_to_type','Franchise Administration')
    						->where(function($query){
    							$query->where("send_to_franchise_admin","1")
    							->orWhere('send_to_everyone','1');
    						})
    						->orderby('created_at','desc')->get();

    //GETTING UNREAD NOTIFICATIONS
    $unRead_Noti = array();
    if(!$unread_notifications->isEmpty())
    {
	    foreach($unread_notifications as $getNoti)
	    {
			$getUnread = \App\Models\Notifications_read_by::where('notification_id',$getNoti->id)->first();
			if(!$getUnread)
			{
				$unRead_Noti[] = $getNoti->id;
			}
		}
	}
    @endphp


<script type="text/javascript">
	//$('#dropdownMenuButton').
	$(document).ready(function(){
		var Count = 1;
		$('#myNotification').on('shown.bs.dropdown', function () {
		  	// do something…
			if(Count == 1){

			  Count = Count + 1;
			  var UnRead = @php echo json_encode($unRead_Noti); @endphp;
			  $.ajax({
			  	method:'POST',
			  	url:'{{ route("franchise.notification_read") }}',
			  	dataType:'json',
			  	data:{'ids': UnRead, '_token':'{{ csrf_token() }}'},
			  	beforeSend: function( xhr ) {

					$('#myNotification').find('.myNotCount').html('0');
					$('#myNotification').find('.drop-down-1-para .fa-circle').remove();

			  	}
			  })
			  .done(function(response){
				
				if(response == 'Success')
				{
					$('#myNotification').find('.myNotCount').html('0');
					$('#myNotification').find('.drop-down-1-para .fa-circle').remove();
				}
			  });

			}

		});
	})
</script>
    
    <div class="head-2">
      <div class="HeadNotfication dropdown noitfication-drop-down noitfication-drop-down-2 hidden" id="myNotification">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="noti-img" src="{{ asset('assets/images/bell.jpg') }}"><span class="myNotCount">{{ count($unRead_Noti) }}</span></a>
        <div class="drop-down-main notnone dropdown-menu" aria-labelledby="dropdownMenuButton">
          <h5>Notification</h5>
          @if($unread_notifications->count())
            @foreach($unread_notifications as $notification)
              <div class="drop-down-1">
                <figure>
                  <div class="drop-down-1-para">
                    <b>{!! $notification->title  !!}</b>
                    
                    <span>{{ date("h:i a | M d Y",strtotime($notification->created_at)) }}
                    @if(in_array($notification->id, $unRead_Noti))
                    	<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i>
                    @endif
                    </span>
                    
                    <div class="clearfix"></div>
                    <p>{{ $notification->description }}</p>
                  </div>
                  <div class="clearfix"></div>
                </figure>
              </div>
            @endforeach
          @else
            <p class="NotifiationsFound">No Notifications Found!</p>
          @endif
          {{--
          <h6>Monday, January 5th</h6>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          --}}
        </div>
      </div>

      <div class="HeadNotfication dropdown noitfication-drop-down-1 noitfication-drop-down-2">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="noti-img" src="{{ asset('assets/images/bell-1.jpg') }}" /><span>{{ $total_unread }}</span></a>
        <div class="drop-down-main-1 notnone-1 dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <h5>Unread Messages</h5>

          @if(!empty($unread_messages))
            @foreach($unread_messages as $unread_message)

                  <div class="drop-down-1">
                    <a href="{{ $unread_message["url"] }}">
                      <h1><img src="{{ $unread_message["image"] }}" /></h1>
                    </a>
                    <figure>
                      <div class="drop-down-2-para">
                        <a href="{{ $unread_message["url"] }}"><b>{!! $unread_message["title"] !!}</b></a>
                          <span>{{ $unread_message["message_time"] }}<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                        <div class="clearfix"></div>
                        <a href="{{ $unread_message["url"] }}">
                          <p class="notification-para5">
							@if($unread_message["message"] != "") 
								@if(strlen($unread_message["message"]) >= 20)
									{{ substr($unread_message["message"],0,20).'...'  }} 
								@else
									{{ $unread_message["message"]  }} 
								@endif		
							@else 
								&nbsp; 
							@endif &nbsp;
						  </p>
                        </a>
                      </div>
                      <div class="clearfix"></div>
                    </figure>
                  </div>
            @endforeach
          @else
            <p class="NotifiationsFound">No Notifications Found!</p>
          @endif

          {{--
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          --}}
        </div>
      </div>

      <div class="HeadNotfication dropdown">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
            @if(Auth::guard('franchise')->user()->profile_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('franchise')->user()->profile_picture) }}" />
            @elseif(Auth::guard('franchise')->user()->personal_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('franchise')->user()->personal_picture) }}" />
            @elseif(Auth::guard('franchise')->user()->client_profilepicture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('franchise')->user()->client_profilepicture) }}" />    
            @else
              <!--<img class="cntct-img" src="{{ asset('assets/images/bell-4.jpg') }}" />-->
              <i class="fa fa-user cntct-img profile-image-display-icon" aria-hidden="true"></i>
            @endif

          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        <div class="logout-box-main notnone-5 dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <a href="#" class="head-active">{{Auth::guard('franchise')->user()->fullname}}</a>
          
          <a href="{{ url('franchise/edit_profile')  }}">Edit Profile</a>
          @php $rules = array('Owner','Manager'); @endphp
  		  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
          <a href="{{ url('franchise/adduser')  }}">Add User</a>
          @endif
          
          <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
		  <form id="logout-form" action="{{ url('franchise/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
          
        </div>
      </div>
    </div>
    
    @if(Session::has('impersonate'))
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('franchise.LogoutImpersonate') }}" class="pull-right">Back to Admin</a>
    @endif
    <div class="clearfix"></div>
  </div>
</div>
<!-- header-sec -->