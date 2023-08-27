<!-- side-bar-sec -->
<!-- ================ Franchise menus =================== -->
@if(Auth::guard('franchise')->check())
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('franchise')->check()) href="{{ route('franchise.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <img src="{{ asset('assets/images/logo-res.png') }}" />
      </div>
    </a>
  </div>
  <div class="res-bar-icon">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </div>
  <div class="clearfix"></div>
</div>
<div class="side-bar-main">
  <div class="logo-main">
    <a @if(Auth::guard('franchise')->check()) href="{{ route('franchise.home') }}" @else href="#" @endif>
    <!--<img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">-->
    <img class="side-bar-image-1" width="125" src="{{ asset('assets/images/SOS-Dashboard Logo.png') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>

      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      <li @if($menu == 'main_deck') class="active" @endif>
      	@php
        $unread_notifications = \App\Models\Notifications::where('send_to_type','Franchise Administration')->where(function($query){
                                    $query->where("send_to_franchise_admin","1")->orWhere('send_to_everyone','1');
                                })->orderby('created_at','desc')->get();
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
        <a class="pull-left" href="{{ route('franchise.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck <span>{{ count($unRead_Noti) }}</span></a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'main_deck' && ($sub_menu == 'notification' || $sub_menu == 'main_notification')) act_open @endif">
          <li><a href="{{ route('franchise.notification_list_main') }}" @if($sub_menu == 'main_notification') class="act_white" @endif>My Deck</a></li>
          <li><a href="{{ route('franchise.notification_list') }}" @if($sub_menu == 'notification') class="act_white" @endif>Create Notification</a></li>
        </ul>
      </li>
      @endif

	  @php $rules = array('Owner','Manager','BCBA','Intern','Receptionist'); @endphp
	  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      <li @if($menu == 'clients') class="active" @endif><a href="{{ route('franchise.clients') }}" @if($menu == 'clients') class="act_white" @endif><i class="fa fa-group" aria-hidden="true"></i>Clients</a></li>
      @endif
      
      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      
	      <?php /*?><li @if($menu == 'staff') class="active" @endif>
	        <a  class="pull-left" href="{{ route('franchise.staff') }}"><i class="fa fa-user" aria-hidden="true"></i>Staff</a>
	        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
	        <div class="clearfix"></div>
	        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'staff' && $sub_menu == 'add_user' ) act_open @endif">
	          <li><a class="@if($sub_menu == 'add_user') act_white @endif" href="{{ url('franchise/adduser') }}">Add User</a></li>
	        </ul>
	      </li><?php */?>

      @endif

	  @php $rules = array('Owner','Manager','BCBA','Intern'); @endphp
	  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
	      <li @if($menu == 'employees') class="active" @endif>
	        <a href="{{ route('franchise.employees') }}"><i class="fa fa-user" aria-hidden="true"></i>Employees</a>
	      </li>
	  @endif    

      @php $rules = array('Owner','Manager','BCBA'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      	<li @if($menu == 'message') class="active" @endif><a href="{{ route('franchise.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a></li>
      @endif


      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
	      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('franchise.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
	      <li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('franchise.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>
	      <li @if($menu == 'catalog') class="active" @endif><a href="{{ route('franchise.catalog') }}"><i class="fa fa-file-text" aria-hidden="true"></i>Catalogue</a></li>
	  @endif
     
    </ul>
  </div>
</div>
@endif
@php
$franchise_id = Auth::guard('franchise')->user()->franchise_id;
$FranchiseSettings = App\Models\Franchise::find($franchise_id);
@endphp
<div class="footer-main">
  <div class="footer-content">
    @if(empty($FranchiseSettings))
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>SW Houston,<br>9894 Bissonnet St #500<br>Houston TX 77036</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:(346) 217-8328">(346) 217-8328</a>
    @else
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>{{ $FranchiseSettings->address }}<br>{{ $FranchiseSettings->city }} {{ $FranchiseSettings->state}} {{ $FranchiseSettings->zipcode }}</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:{{ $FranchiseSettings->phone }}">{{ $FranchiseSettings->phone }}</a>
    @endif
  </div>
</div>
<!-- side-bar-sec -->