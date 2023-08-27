<!-- side-bar-sec -->
@if(Auth::guard('admin')->check())
@php
$SOSSettings = array();
$Settings = App\Models\Settings::get()->toArray();
if(!empty($Settings))
{
    array_walk($Settings, function($val,$key) use(&$SOSSettings){
      $SOSSettings[$val['key']] = $val['value'];
    });
}

$Franchises_Incomplete_Tasks = App\Models\Franchise_tasklist::where("status","Incomplete")->get()->count();
@endphp 
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('admin')->check()) href="{{ route('admin.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <!--<img src="{{ asset('assets/images/logo-res.png') }}" />-->
        <img src="{{ asset('assets/images/logo-admin-white-res.png') }}" style="height:auto !important;"/>
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
    <a @if(Auth::guard('admin')->check()) href="{{ route('admin.home') }}" @else href="#" @endif>
    <!--<img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">-->
    <img class="side-bar-admin-image-1" width="125" src="{{ asset('assets/images/SOS-Dashboard Logo.png') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>
      <li @if($menu == 'main_deck' || $menu == 'notification') class="active" @endif>
      	@php
        $unread_notifications = \App\Models\Notifications::where(array("send_to_admin"=>"1", 'notification_type'=>'System Notification'))->whereIn('send_to_type',array('Director of Administration', 'Administration'))->where('notification_groups','!=','tasklist')->orderby('created_at','desc')->get();
        @endphp
        <!--<a class="pull-left"  href="{{ route('admin.home') }}">--><a href="{{ route('admin.home') }}"><i class="fa fa-user" aria-hidden="true"></i>Main Deck <!--<span>{{ $unread_notifications->count() }}</span>--></a>
        <!--<a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'notification') act_open @endif">
          <li>
            <a href="{{ route('admin.notification_list') }}" @if($sub_menu == 'notification') class="act_white" @endif>Create Notification</a>
          </li>
        </ul>-->
      </li>
      <li @if($menu == 'franchise') class="active" @endif><a href="{{ route('admin.franchises') }}"><i class="fa fa-building" aria-hidden="true"></i>Franchisees @if($Franchises_Incomplete_Tasks)&nbsp;<span>{{ $Franchises_Incomplete_Tasks }}</span> @endif</a></li>
      <li @if($menu == 'employees') class="active" @endif>
        <a href="{{ route('admin.employees') }}" class="pull-left"><i class="fa fa-users" aria-hidden="true"></i>Employees</a>
        <!--<a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'employees' && $sub_menu == 'employees_payroll') act_open @endif">
          <li>
            <a @if($sub_menu == 'employees_payroll') class="act_white" @endif href="{{ route('admin.payroll') }}">Run Payroll</a>
          </li>
        </ul>-->
        <div class="clearfix"></div>
      </li>
      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('admin.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
      <!--<li @if($menu == 'message') class="active" @endif>
        <a href="{{ route('admin.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a>
      </li>-->
      <!--<li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('admin.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>-->
      <!--<li @if($menu == 'catalogue') class="active" @endif>
        <a class="pull-left" href="{{ url('admin/catalogue') }}"><i class="fa fa-file-text" aria-hidden="true"></i>Catalogue</a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'catalogue' && ($sub_menu == 'catalogue_product' || $sub_menu == 'order' ) ) act_open @endif">
          <li>
            <a class="@if($sub_menu == 'catalogue_product') act_white @endif" href="{{ url('admin/catalogue/addproduct') }}">Add product</a>
          </li>
          <li>
            <a @if($sub_menu == 'order') class="act_white" @endif href="{{ route('admin.orders_list') }}">Order {{--<span>16</span>--}}</a>
          </li>
        </ul>
      </li>-->
      <li @if($menu == 'settings') class="active" @endif><a href="{{ route('admin.settings') }}"><i class="fa fa-gear" aria-hidden="true"></i>Settings</a></li>
    </ul>
  </div>
</div>
@endif

<div class="footer-main">
  <div class="footer-content">
    @if(empty($SOSSettings))
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>SW Houston,<br>9894 Bissonnet St #500<br>Houston TX 77036</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:(346) 217-8328">(346) 217-8328</a>
    @else
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>{!! nl2br($SOSSettings['Address']) !!}<br>{{ $SOSSettings['City'] }} {{ $SOSSettings['State'] }} {{ $SOSSettings['Zip'] }}</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:{{ $SOSSettings['Phone'] }}">{{ $SOSSettings['Phone'] }}</a>
    @endif
  </div>
</div>
<!-- side-bar-sec -->