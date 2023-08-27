@php 
$router_name = Request::route()->getName();
$method_name = Request::route()->getActionMethod();
@endphp
<ul class="nav nav-tabs ClientNavTabs">
  <li class="trigger @if($method_name == 'view') padd-left-anchor active @endif"><a href="{{ url('franchise/client/view/'.$Client->id) }}">Client Information</a></li>
  <li class="trigger @if($method_name == 'viewInsurance') padd-left-anchor active @endif"><a href="{{ url('franchise/client/viewinsurance/'.$Client->id) }}">Insurance</a></li>
  <li class="trigger @if($method_name == 'viewMedicalInformation') padd-left-anchor active @endif"><a href="{{ url('franchise/client/viewmedicalinformation/'.$Client->id) }}">Medical Information</a></li>
  <li class="trigger @if($method_name == 'viewArchives') padd-left-anchor active @endif pos-rel" @if(!$ClientArchives->isEmpty()) style="padding-right:10px;"@endif><a href="{{ url('franchise/client/viewarchives/'.$Client->id) }}">Archives</a>
    @if(!$ClientArchives->isEmpty())
        <span class="pos-abs-cargo-tab" style="left:auto;right:5px">{{ $ClientArchives->count() }}</span>
    @endif
  </li>
  <li class="trigger @if($method_name == 'viewAgreement') padd-left-anchor active @endif hidden"><a href="{{ url('franchise/client/viewagreement/'.$Client->id) }}" @if(!$ClientArchives->isEmpty() && $method_name == 'viewAgreement')style="margin-left:15px !important;"@endif>Agreement</a></li>
  <li class="trigger @if($method_name == 'viewTasklist') padd-left-anchor active @endif"><a href="{{ url('franchise/client/viewtasklist/'.$Client->id) }}">Task List</a></li>
  <li class="trigger @if($method_name == 'viewTripitinerary') padd-left-anchor active @endif"><a href="{{ url('franchise/client/viewtripitinerary/'.$Client->id) }}">Schedule</a></li>	
</ul>