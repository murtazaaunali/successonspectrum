@extends('parent.layout.main')

@section('content')
	<div class="add-franchise-super-main">
        <h6>{{ $Client->client_childfullname }}</h6>
		<p><a href="#">Client </a> / </a>Edit Agreement</p>
		<div class="add-franchise-data-main-1 add-franchise-data-main-2">
			<div id="franchise-demography" class="tab-pane fade in active">
			    <div class="view-tab-content-main">
			    
			    	<form action="{{ url('parent/client/updateagreement/'.$Client->id) }}" method="post" id="editAgreement">
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
                                    <input type="radio" value="1" name="agreement_hippa" class="vartical-top" @if($Client->agreement_hippa) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_hippa" class="vartical-top" @if($Client->agreement_hippa === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Payment Agreement</label>
                                    <input type="radio" value="1" name="agreement_payment" class="vartical-top" @if($Client->agreement_payment) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_payment" class="vartical-top" @if($Client->agreement_payment === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Informed Consent For Services</label>
                                    <input type="radio" value="1" name="agreement_informed" class="vartical-top" @if($Client->agreement_informed) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_informed" class="vartical-top" @if($Client->agreement_informed === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Security System Waiver</label>
                                    <input type="radio" value="1" name="agreement_security" class="vartical-top" @if($Client->agreement_security) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_security" class="vartical-top" @if($Client->agreement_security === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Release of Liability</label>
                                    <input type="radio" value="1" name="agreement_release" class="vartical-top" @if($Client->agreement_release) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_release" class="vartical-top" @if($Client->agreement_release === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>
                            <div class="radio-btun">
                                <figure>	
                                    <label>Parent Handbook Agreement</label>
                                    <input type="radio" value="1" name="agreement_parent" class="vartical-top" @if($Client->agreement_parent) checked="" @endif><span class="vartical-top">&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="0" name="agreement_parent" class="vartical-top" @if($Client->agreement_parent === 0) checked="" @endif><span class="vartical-top">&nbsp;No</span>
                                </figure>
                            </div>

                            
			    		</div>	
			    	</div>
			    </form>
			    </div>
			</div>
		</div>
		<!-- header-bottom-sec -->
	</div>	



<script type="text/javascript">
	$(function () {

	});
</script>
 
@endsection
