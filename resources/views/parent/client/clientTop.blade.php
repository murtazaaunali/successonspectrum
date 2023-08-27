@php 
$router_name = Request::route()->getName();
$method_name = Request::route()->getActionMethod();
$controller_name = Request::route()->getActionName();
$controller_name; preg_match('/([a-z]*)@/i', $controller_name, $matches);
$controller_name = $matches[1];
@endphp
@if($router_name != "parent.insurance")
<ul class="nav nav-tabs">
    <li class="@if($method_name == 'index' || $method_name == 'view') padd-left-anchor active @else trigger @endif "><a href="{{ url('parent/client/view') }}">Client Information</a></li>
    <!--<li class="@if($method_name == 'viewInsurance') padd-left-anchor active @else trigger @endif"><a href="{{ url('parent/client/viewinsurance') }}">Insurance</a></li>-->
    <li class="@if($method_name == 'viewMedicalInformation') padd-left-anchor active @else trigger @endif"><a href="{{ url('parent/client/viewmedicalinformation') }}">Medical Information</a></li>
    <li class="@if($method_name == 'viewArchives') padd-left-anchor active @else trigger @endif pos-rel"><a href="{{ url('parent/client/viewarchives') }}">Archives</a>
      @if(!$ClientArchives->isEmpty())
          <span class="pos-abs-cargo-tab" style="left:80%">{{ $ClientArchives->count() }}</span>
      @endif
    </li>
    <li class="@if($method_name == 'viewAgreement') padd-left-anchor active @else trigger @endif"><a href="{{ url('parent/client/viewagreement') }}">Agreement</a></li>
    <li class="@if($method_name == 'viewTasklist') padd-left-anchor active @else trigger @endif"><a href="{{ url('parent/client/viewtasklist') }}">Task List</a></li>
    <li class="@if($method_name == 'SessionsLogs') padd-left-anchor active @else trigger @endif"><a href="{{ url('parent/client/sessionslogs') }}">Sessions Logs</a></li>
</ul>
@endif