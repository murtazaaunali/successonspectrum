@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main FranchiseEditTastListMain"> 
    <div class="main-head-franchise">
        <h6>{{$sub_title}}</h6>
        <p>Settings / <span id="change-bread-crumb">Edit Details</span></p>
        <div class="clearfix"></div>
    </div>
	    
    <div class="add-franchise-data-main-1 add-franchise-data-main-2">
        <div id="franchise-demography" class="tab-pane fade in active">
            <div class="view-tab-content-main">
            <form action="" method="post" id="editSettingsDetails">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                    <div class="view-tab-content-head-main view-tab-content-head-main-3">
                        <div class="view-tab-content-head">
                            <h3>Settings Details</h3>
                        </div>
                        <div class="view-tab-content-butn">
                            <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="super-admin-add-relation-main">
                        <div class="super-admin-add-relation border-bot-0">
                            @if($Settings)
                                @foreach($Settings as $setting)
                                    @if($setting->key)	
                                    <figure>
                                        <label style="vertical-align:top">{{ ucfirst($setting->key) }}</label>
                                        @if($setting->key == "State") 
                                        <select name="settings[{{ ucfirst($setting->key) }}]" class="settings_fields">
                                        	<option value="">Select</option>
                                            @if($States)
                                				@foreach($States as $state)
                                                	<option value="{{ $state->code }}" @if($state->code == $setting->value) selected="selected" @endif>{{ $state->state_name }}</option>
                                                @endforeach
                                            @endif    
                                        </select>
                                        @elseif($setting->key == "Address") 
                                        <textarea type="text" name="settings[{{ ucfirst($setting->key) }}]" class="settings_fields" cols="42">{{ $setting->value }}</textarea>
                                        @else
                                        <input type="text" name="settings[{{ ucfirst($setting->key) }}]" value="{{ $setting->value }}" class="settings_fields">
                                        @endif
                                        <div class="clearfix"></div>
                                        <label class="error error1" for="settings[{{ ucfirst($setting->key) }}]"></label>
                                    </figure>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>	

<script type="text/javascript">
$(document).ready(function() {
	$("#editSettingsDetails").validate({
		rules:{
		},
		messages:{
		}			
	});
	$(".settings_fields").each(function(){$(this).rules("add", {required:true}) });	
});	
</script>
 
@endsection
