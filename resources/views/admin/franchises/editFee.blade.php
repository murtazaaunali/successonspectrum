@extends('admin.layout.main')

@section('content')
   <div class="add-employee-tabs-main-main add-employee-tabs-main-main add-franchise-super-main FranchiseEditTastListMain"> 
    <div class="main-head-franchise">
        <h6>{{$sub_title}}</h6>
			<p>{{ $Franchise->name }} / 
				@if($Franchise->state != "")
				{{ $Franchise->getState->state_name }}
				@else
				 - 
				@endif			
			 / <span id="change-bread-crumb">Franchisee Demographic</span></p>
        <div class="clearfix"></div>
    </div>

	<form method="post" id="editFee">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	<div class="add-franchise-data-main-1 add-franchise-data-main-2">
		<div class="view-tabs-control-main">
			<div class="view-tab-control">
				<ul class="nav nav-tabs">
				  <li class="active padd-left-anchor Task-List-1"><a data-toggle="tab" href="#fees">Fees</a></li>
				</ul>
			</div>
			<div class="view-tab-control-butn-main">
				<button type="submit" class="btn add-franchise-data-butn-1 pos-rel-sav-butn"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button> 
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="tab-content">
			<div id="fees" class="tab-pane fade in active">
			    <div class="super-admin-add-relation-main super-admin-add-relation-main-add-fee">
		    		<div class="super-admin-add-relation border-bot-0 FranchiseEditFeeFieldsWidth">
		    			<figure class="pos-rel hidden">
				    		<label>Contract Duration</label>
				    		<input type="text" id="contract_startdate" name="contract_startdate" value="{{ date('m/d/Y',strtotime($Franchise->contract_startdate)) }}" class="input-wid-franchise-1 mar-rit-5 contract_startdate">
				    		<i class="fa fa-calendar pos-abs-cal-1-1 contract_startdate" aria-hidden="true"></i>
				    		
				    		<input type="text" id="contract_enddate" name="contract_enddate" value="{{ date('m/d/Y',strtotime($Franchise->contract_enddate)) }}" class="input-wid-franchise-1 mar-rit-5 contract_enddate">
				    		<i class="fa fa-calendar pos-abs-cal contract_enddate" aria-hidden="true"></i>
				    		<label class="error error1" for=""></label>
				    	</figure>
			    		<figure class="pos-rel">
				    		<label>Fee Due Date</label>
				    		<input type="number" name="fee_due_date" id="fee_due_date" value="{{ $F_fees->fee_due_date }}" min="1" max="30">
                            @if ($errors->has('fee_due_date'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('fee_due_date') }}</strong>
                                </span>
                            @endif				    		
				    		<label class="error error1" for="fee_due_date"></label>
				    	</figure>
				    	<figure class="lin-higt-maintan">	
				    		<label>Initial Franchise Fee<!--<span class="required-field">*</span>--> <br> (one time fee)</label>
				    		<input class="pos-rel-input-type" name="initial_fee" type="text" value="{{ $F_fees->initial_fee }}">
				    		<label class="error error1" for="initial_fee"></label>
				    	</figure>
				    	{{--<figure class="lin-higt-maintan">	
				    		<label>Monthly Royalty Fee<span class="required-field">*</span> <br>(once a month for 5 year)</label>
				    		<input class="pos-rel-input-type" name="monthly_royalty_fee" type="text" value="{{ $F_fees->monthly_royalty_fee }}">
                            @if ($errors->has('monthly_royalty_fee'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('monthly_royalty_fee') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="monthly_royalty_fee"></label>
				    	</figure>--}}
                        <figure class="lin-higt-maintan">	
				    		<label class="w-100">Monthly Royalty Fees (once a month for 5 year)</label>
                            <div class="clearfix"></div>
				    	</figure>
                        <figure>	
                            <label style="font-weight:500">For first year<!--<span class="required-field">*</span>--></label>
				    		<input name="monthly_royalty_fee" type="text" value="{{ $F_fees->monthly_royalty_fee }}">
                            @if ($errors->has('monthly_royalty_fee'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('monthly_royalty_fee') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="monthly_royalty_fee"></label>
                        </figure>
                        <figure>
                            <label style="font-weight:500">For second year<!--<span class="required-field">*</span>--></label>
				    		<input name="monthly_royalty_fee_second_year" type="text" value="{{ $F_fees->monthly_royalty_fee_second_year }}">
                            @if ($errors->has('monthly_royalty_fee_second_year'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('monthly_royalty_fee_second_year') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="monthly_royalty_fee_second_year"></label>
                        </figure>
                        <figure style="border-bottom: 1px #eee solid;">
                            <label style="font-weight:500">For subsequent years<!--<span class="required-field">*</span>--></label>
				    		<input name="monthly_royalty_fee_subsequent_years" type="text" value="{{ $F_fees->monthly_royalty_fee_subsequent_years }}">
                            @if ($errors->has('monthly_royalty_fee_subsequent_years'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('monthly_royalty_fee_subsequent_years') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="monthly_royalty_fee_subsequent_years"></label>
                            <div class="clearfix">&nbsp;</div>
				    	</figure>
                        <figure class="lin-higt-maintan">
				    		<label>Monthly System advertising Fee<!--<span class="required-field">*</span>--> <br> (once a manth for 5 years)</label>
				    		<input class="pos-rel-input-type" name="monthly_advertising_fee" id="monthly_advertising_fee" type="text" value="{{ $F_fees->monthly_advertising_fee }}">
                            @if ($errors->has('monthly_advertising_fee'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('monthly_advertising_fee') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="monthly_advertising_fee"></label>
			    		</figure>
			    		<figure class="lin-higt-maintan">
				    		<label>Renewal Fee<!--<span class="required-field">*</span>--> <br> (Due Upon Expiration of the FDD contract)</label>
				    		<input class="pos-rel-input-type" name="renewal_fee" type="text" value="{{ $F_fees->renewal_fee }}">
                            @if ($errors->has('renewal_fee'))
                                <span class="help-block error">
                                    <strong style="color:red">{{ $errors->first('renewal_fee') }}</strong>
                                </span>
                            @endif
                            <label class="error error1" for="renewal_fee"></label>
				    	</figure>
		    		</div>	
		    	</div>
			</div>
		</div>
	</div>

	</form>
</div>	
	



<script type="text/javascript">
	$(document).ready(function() {

		jQuery.validator.addMethod("decimalPlaces", function(value, element) {
    	        return this.optional(element) || /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(value);
    	},"Only 2 decimal places are allowed.");
    			
		$( "#editFee" ).validate({
		  rules: {
		    //contract_start:{required:true, date:true},
		    //contract_end:{required:true, date:true},
		    //fee_due_date:{required:true, digits: true},
		    /*monthly_royalty_fee:{required:true,number:true, decimalPlaces:true},
		    initial_fee:{required:true,number:true, decimalPlaces:true},
		    monthly_advertising_fee:{required:true, number:true, decimalPlaces:true},
		    renewal_fee:{required:true,number:true, decimalPlaces:true},*/
			/*monthly_royalty_fee:{required:true},
		    initial_fee:{required:true},
		    monthly_advertising_fee:{required:true},
		    renewal_fee:{required:true},*/
		  },
		});

		//$("#contract_startdate").datetimepicker({
		$(".contract_startdate").datetimepicker({	
	        today:  1,
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'bottom-left',
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        minDate.setMonth(minDate.getMonth() + 12);
	        $(this).parents('.super-admin-add-relation').find('#contract_enddate').datetimepicker('setStartDate', minDate);
	    });
	    //$("#contract_enddate").datetimepicker({
		$(".contract_enddate").datetimepicker({	
	        autoclose: true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,
		    pickerPosition: 'bottom-left',  	
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        minDate.setMonth(minDate.getMonth() - 12);
	        $(this).parents('.super-admin-add-relation').find('#contract_startdate').datetimepicker('setEndDate', minDate);
	 		});
});	//ready
	
</script>
 
@endsection
