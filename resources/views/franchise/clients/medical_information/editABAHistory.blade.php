@extends('franchise.layout.main')

@section('content')
<div class="add-franchise-super-main">
    <h6>{{ $Client->client_childfullname }}</h6>
    <p><a href="#">Client</a> / <a href="{{ url('franchise/client/view/'.$Client->id) }}">{{ $Client->client_childfullname }}</a> Edit ABA History</p>
    <div class="add-franchise-data-main-1 add-franchise-data-main-2">
        <div id="franchise-demography" class="tab-pane fade in active">
            <div class="view-tab-content-main">
                <form action="{{ url('franchise/client/viewmedicalinformation/editabahistory/'.$Client->id) }}" method="post" id="editABAHistory">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <div class="view-tab-content-head-main view-tab-content-head-main-3">
                    <div class="view-tab-content-head">
                        <h3>ABA History Details</h3>
                    </div>
                    <div class="view-tab-content-butn">
                        <button type="submit" class="btn add-franchise-data-butn-1"><i class="fa fa-check" aria-hidden="true"></i>Save ABA History</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="super-admin-add-relation-main">
                    <div class="super-admin-add-relation border-bot-0">
                        <figure class="pos-rel">
                            <label>Which facility?<span class="required-field">*</span></label>
                            <input type="text" name="client_aba_facility" value="" id="client_aba_facility">
                            <label class="error error1" for="client_aba_facility"></label>
                        </figure>
                        <figure class="pos-rel">
                            <label>What year did they start<span class="required-field">*</span></label>
                            <input type="text" name="client_aba_start" value="" id="client_aba_start" placeholder="mm/dd/yy" class="client_aba_start">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_start" aria-hidden="true"></i></a>
                            <label class="error error1" for="client_aba_start"></label>
                        </figure>
                        <figure class="pos-rel">
                            <label>What year did they end<span class="required-field">*</span></label>
                            <input type="text" name="client_aba_end" value="" id="client_aba_end" placeholder="mm/dd/yy" class="client_aba_end">
                            <a class="employe-edit-cal-pos-abs" href="javascript:void(0);"><i class="fa fa-calendar client_aba_end" aria-hidden="true"></i></a>
                            <label class="error error1" for="client_aba_end"></label>
                        </figure>
                        <figure>
                            <label>How many hours of ABA did they receive per week<span class="required-field">*</span></label>
                            <input type="text" name="client_aba_hours" value="">
                            <label class="error error1" for="client_aba_hours"></label>
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
	$(function () {
		$('.client_aba_start').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var start_date = new Date(selected.date.valueOf());
			var setStartDate = new Date();setStartDate.setDate(start_date.getDate()+1);
			$('#client_aba_end').datetimepicker('setStartDate', setStartDate);
		});
		
		$('.client_aba_end').datetimepicker({
			pickerPosition: 'top-left',
			format: 'mm/dd/yyyy',
			maxView: 4,
			minView: 2,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var end_date = new Date(selected.date.valueOf());
			var setEndDate = new Date();setEndDate.setDate(end_date.getDate()-1);
			$('#client_aba_start').datetimepicker('setEndDate', setEndDate);
		});
	});

	$(document).ready(function() {
		$("#editABAHistory").validate({
			rules:{
				client_aba_facility:{required:true},
				client_aba_start:{required:true,date:true},
				client_aba_end:{required:true,date:true},
				client_aba_hours:{required:true,number:true},
			},
		});
	});

</script>
@endsection
