@extends('franchise.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client /</a><a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }} /</a>Edit Agreement</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    	<form action="{{ url('franchise/client/updateagreement/'.$Client->id) }}" method="post" id="editAgreement">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			    	<div class="view-tab-content-head-main view-tab-content-head-main-3">
			    		<div class="view-tab-content-head">
			    			<h3>Agreement</h3>
			    		</div>
			    		<div class="view-tab-content-butn">
			    			<button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
			    		</div>
			    		<div class="clearfix"></div>
			    	</div>
			    	<div class="super-admin-add-relation-main">
			    		<div class="super-admin-add-relation border-bot-0">

                            <div class="radio-btun">
                                <figure>	
                                    <label>HIPAA Agreement Form</label>
                                    <input type="radio" value="1" name="agreement_hippa" class="vartical-top hipaa" @if($Client->agreement_hippa) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_hippa" class="vartical-top hipaa" @if($Client->agreement_hippa === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="hippaa_cover pos-rel">
                                <label>HIPAA Agreement Date</label>
                                <input type="text" name="hipaa_date" id="hipaa_date" autocomplete="off" class="inp-hi hipaa_date" value="@if($Client->hipaa_date != '' && $Client->hipaa_date != '0000-00-00'){{ date('m/d/Y',strtotime($Client->hipaa_date)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar hipaa_date" aria-hidden="true"></i></a>
                                <label class="error" for="hipaa_date"></label>
                            </figure>

                            <div class="radio-btun">
                                <figure>	
                                    <label>Payment Agreement</label>
                                    <input type="radio" value="1" name="agreement_payment" class="vartical-top payment" @if($Client->agreement_payment) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_payment" class="vartical-top payment" @if($Client->agreement_payment === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="payment_cover pos-rel">
                                <label>Payment Agreement Date</label>
                                <input type="text" name="payment_date" id="payment_date" autocomplete="off" class="inp-hi payment_date" value="@if($Client->payment_parentsdate != '' && $Client->payment_parentsdate != '0000-00-00'){{ date('m/d/Y',strtotime($Client->payment_parentsdate)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar payment_date" aria-hidden="true"></i></a>
                                <label class="error" for="payment_date"></label>
                            </figure>
                            
                            <div class="radio-btun">
                                <figure>	
                                    <label>Informed Consent For Services</label>
                                    <input type="radio" value="1" name="agreement_informed" class="vartical-top informed" @if($Client->agreement_informed) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_informed" class="vartical-top informed" @if($Client->agreement_informed === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="informed_cover pos-rel">
                                <label>Informed Agreement Date</label>
                                <input type="text" name="informed_date" id="informed_date" autocomplete="off" class="inp-hi informed_date" value="@if($Client->informed_date != '' && $Client->informed_date != '0000-00-00'){{ date('m/d/Y',strtotime($Client->informed_date)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar informed_date" aria-hidden="true"></i></a>
                                <label class="error" for="informed_date"></label>
                            </figure>
                            
                            <div class="radio-btun">
                                <figure>	
                                    <label>Security System Waiver</label>
                                    <input type="radio" value="1" name="agreement_security" class="vartical-top security" @if($Client->agreement_security) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_security" class="vartical-top security" @if($Client->agreement_security === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="security_cover pos-rel">
                                <label>Security Agreement Date</label>
                                <input type="text" name="security_date" id="security_date" autocomplete="off" class="inp-hi security_date" value="@if($Client->security_date != '' && $Client->security_date != '0000-00-00'){{ date('m/d/Y',strtotime($Client->security_date)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar security_date" aria-hidden="true"></i></a>
                                <label class="error" for="security_date"></label>
                            </figure>
                            
                            <div class="radio-btun">
                                <figure>	
                                    <label>Release of Liability</label>
                                    <input type="radio" value="1" name="agreement_release" class="vartical-top release" @if($Client->agreement_release) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_release" class="vartical-top release" @if($Client->agreement_release === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="release_cover pos-rel">
                                <label>Release Agreement Date</label>
                                <input type="text" name="release_date" id="release_date" autocomplete="off" class="inp-hi release_date" value="@if($Client->release_date != '' && $Client->release_date != '0000-00-00'){{ date('m/d/Y',strtotime($Client->release_date)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar release_date" aria-hidden="true"></i></a>
                                <label class="error" for="release_date"></label>
                            </figure>
                            
                            <div class="radio-btun">
                                <figure>	
                                    <label>Parent Handbook Agreement</label>
                                    <input type="radio" value="1" name="agreement_parent" class="vartical-top parent" @if($Client->agreement_parent) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_parent" class="vartical-top parent" @if($Client->agreement_parent === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <figure class="parent_cover pos-rel">
                                <label>Parent Handbook Date</label>
                                <input type="text" name="parent_date" id="parent_date" autocomplete="off" class="inp-hi parent_date" value="@if($Client->parent_date != '' && $Client->parent_date != '0000-00-00'){{ date('m/d/Y',strtotime($Client->parent_date)) }}@endif">
                                <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar parent_date" aria-hidden="true"></i></a>
                                <label class="error" for="parent_date"></label>
                            </figure>
                            
			    		</div>	
			    	</div>
			    </form>
			    </div>
			</div>
		</div>
		<!-- header-bottom-sec -->
	</div>	



<script type="text/javascript">

	$('#editAgreement').validate({
		rules:{
			hipaa_date:{ required: function(element) { if($("input[name='agreement_hippa']:checked").val() == '1') return true; } },
			payment_date:{ required: function(element) { if($("input[name='agreement_payment']:checked").val() == '1') return true; } },
			informed_date:{ required: function(element) { if($("input[name='agreement_informed']:checked").val() == '1') return true; } },
			security_date:{ required: function(element) { if($("input[name='agreement_security']:checked").val() == '1') return true; } },
			release_date:{ required: function(element) { if($("input[name='agreement_release']:checked").val() == '1') return true; } },
			parent_date:{ required: function(element) { if($("input[name='agreement_parent']:checked").val() == '1') return true; } },
		}
	});

	function agreements(Curr, FieldName, CoverName){
		if($(Curr).val() == '1'){
			$('.'+CoverName).show();
			$('input[name='+FieldName+']').rules("add", {required:true});
		}else{
			$('.'+CoverName).hide();
			$('input[name='+FieldName+']').rules("remove");
		}			
	}

	$(document).ready(function(){
		$('.hipaa').change(function(){
			agreements($(this), 'hipaa_date', 'hippaa_cover');
		});
		$('.payment').change(function(){
			agreements($(this), 'payment_date', 'payment_cover');
		});	
		$('.informed').change(function(){
			agreements($(this), 'informed_date', 'informed_cover');
		});
		$('.security').change(function(){
			agreements($(this), 'security_date', 'security_cover');
		});
		$('.release').change(function(){
			agreements($(this), 'release_date', 'release_cover');
		});	
		$('.parent').change(function(){
			agreements($(this), 'parent_date', 'parent_cover');
		});
		
		agreements('.hipaa:checked', 'hipaa_date', 'hippaa_cover');
		agreements('.payment:checked', 'payment_date', 'payment_cover');
		agreements('.informed:checked', 'informed_date', 'informed_cover');	
		agreements('.security:checked', 'security_date', 'security_cover');
		agreements('.release:checked', 'release_date', 'release_cover');
		agreements('.parent:checked', 'parent_date', 'parent_cover');
		
		$('.hippaa_cover input, .payment_cover input, .informed_cover input, .security_cover input, .release_cover input, .parent_cover input').datetimepicker({
			useCurrent: false,
			autoclose:true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,   
		    endDate: new Date(),
		    orientation: "auto right",
		    allowInputToggle: true
		});
		
		$('.hippaa_cover .hipaa_date, .payment_cover .payment_date, .informed_cover .informed_date, .security_cover .security_date, .release_cover .release_date, .parent_cover .parent_date').datetimepicker({
			useCurrent: false,
			autoclose:true,
	        format: 'mm/dd/yyyy',
		    maxView: 4,
		    minView: 2,   
		    endDate: new Date(),
		    orientation: "auto right",
		    allowInputToggle: true
		});		
	});
</script>
 
@endsection
