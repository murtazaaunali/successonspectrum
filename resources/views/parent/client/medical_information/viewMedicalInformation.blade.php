@extends('parent.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>Client / <span id="change-bread-crumb">Medical Information</span></p>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>		
		
		<div class="add-franchise-data-main-1 PerformanceNone">
			@include('parent.client.clientTop')	

			<div class="tab-content">
				<div id="franchise-demography" class="tab-pane fade in active ">
				    <div class="view-tab-content-main">
				    	<div class="view-tab-content-head-main">
				    		<div class="view-tab-content-head">
				    			<h3>Medical Information</h3>
				    		</div>
				    		<div class="view-tab-content-butn">
				    			<a href="{{ url('parent/client/editmedicalinformation/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    			<a href="{{ url('parent/client/uploadreport/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Upload New Report</a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            @if(!$Client->documents->isEmpty())
                                	@php $count_dignostic = 1; $count_iep = 1; @endphp
                                	@foreach($Client->documents as $doc)
                                		@php if($doc->archive == 1) continue; @endphp
                                        <div class="super-admin-cargo-hold-box dropdown">
                                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                            <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                <a href="{{ url('parent/client/downloadmedicaldocuments/'.$Client->id.'/'.$doc->id) }}" class="head-active">Download</a>
                                                <form action="{{ url('parent/client/archivemedicaldocuments/'.$Client->id.'/'.$doc->id) }}" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                                    <a href="javascript:void(0);" class="archive_client_medicaldocument">Archive</a>
                                                </form>
                                                <form action="{{ url('parent/client/deletemedicaldocuments/'.$Client->id.'/'.$doc->id) }}" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                                    <a href="javascript:void(0);" class="bord-bot-0 red-clr delete_client_medicaldocument">Delete</a>
                                                </form>
                                            </div>
                                            <div class="clearfix"></div>
                                            <a href="#">
                                                @if(pathinfo($doc->document_file,PATHINFO_EXTENSION) == 'docx')
                                                	<img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                                @elseif(pathinfo($doc->document_file,PATHINFO_EXTENSION) == 'pdf')
                                                	<img src="{{ asset('assets') }}/images/pdf.jpg">  
                                                @else
                                                	<img src="{{ url($doc->document_file) }}" style="width:100%;max-height:70px;" class="client_medicaldocuments_view">
                                                @endif
                                                
                                                <!--<p>{{ $doc->document_name }}</p>-->
                                                <p>{{ str_limit($doc->document_name, $limit = 15, $end = '...') }}
                                                @if($doc->document != '') 
                                                	@if($doc->document == 'Childs Dignostic') ({{ $doc->document }}) @endif
                                                	@if($doc->document == 'Childs IEP') ({{ $doc->document }}) @endif
                                                @endif
                                                </p> 
                                                                                               	
                                            </a>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                	@endforeach
                            @endif
                            
                            <!--@if($Client->client_childiep != '')
	                            @php 
	                            $client_childiep = explode("/",$Client->client_childiep);
	                            $client_childiep = end($client_childiep);
	                            @endphp
	                            <div class="super-admin-cargo-hold-box dropdown">
	                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
	                                <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
	                                    <a href="{{ url('parent/client/downloadmedicaldocuments/client_childiep/'.$client_childiep.'/'.$Client->id) }}" class="head-active">Download</a>
	                                    <form action="{{ url('parent/client/archivemedicaldocuments/client_childiep/'.$client_childiep.'/'.$Client->id) }}" method="post">
	                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
	                                        <a href="javascript:void(0);" class="archive_client_medicaldocument">Archive</a>
	                                    </form>
	                                    <a href="javascript:void(0);" class="upload_client_medicaldocument" data-document="client_childiep" data-document_name="{{ $client_childiep }}">Edit</a>

	                                    <form action="{{ url('parent/client/deletemedicaldocuments/client_childiep/'.$client_childiep.'/'.$Client->id) }}" method="post">
	                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
	                                        <a href="javascript:void(0);" class="bord-bot-0 red-clr delete_client_medicaldocument">Delete</a>
	                                    </form>
	                                    
	                                </div>
	                                <div class="clearfix"></div>
	                                <a href="#">
	                                    <img src="{{ asset('assets') }}/images/pdf-1.jpg">
	                                    <p>Child's IEP</p>
	                                </a>
	                                <div class="clearfix"></div>
	                            </div>
                            @endif-->

                            <div class="clearfix">&nbsp;</div>
				    		<figure><h5>Describe The Age</h5><h4>{{ $Client->client_ageandsymtoms }}</h4></figure>
                            <figure>
                            	<h5>Date of Autism Diagnosis</h5>
                                @if($Client->client_dateofautism != "" && $Client->client_dateofautism != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_dateofautism)) }}</h4>
                                @endif
                            </figure>
				    		<figure><h5>Diagnosing Doctor</h5><h4>{{ $Client->client_diagnosingdoctor }}</h4></figure>
                            <figure><h5>Primary Diagnosis</h5><h4>{{ $Client->client_primarydiagnosis }}</h4></figure>
                            <figure><h5>Secondary Diagnosis, if any</h5><h4>{{ $Client->client_secondarydiagnosis }}</h4></figure>
                            <figure><h5>List Child's Current Medications and Doses</h5><h4>{{ $Client->client_childcurrentmedications }}</h4></figure>
                            <figure><h5>List any allergies Or food restrictions</h5><h4>{{ $Client->client_allergies }}</h4></figure>
                            <figure><h5>Has your Child ever received ABA before?</h5><h4>{{ $Client->client_aba }}</h4></figure>
				    		@if($Client->client_aba_facilities != "")
                            @php
	                            $facility_count = 1;
	                            $client_aba_facilities = unserialize($Client->client_aba_facilities);
                            @endphp
                            <div class="blue-border-box-main">
                            
                            @foreach($client_aba_facilities as $key=>$client_aba_facility)
                            <div class="blue-border-box blue-border-box-3 pos-rel" style="width:48.5%">
                            <a class="owner_delete">{{ $key+1 }}</a>
                            <figure><!--<h5>{{ $key+1 }} )</h5><div class="clearfix"></div>--><h5>If yes, which facility?</h5><h4>{{ $client_aba_facility['client_facility'] }}</h4></figure>
                            <figure>
                            	<h5>What year did they start?</h5>
                                @if($client_aba_facility['client_start'] != "" && $client_aba_facility['client_start'] != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($client_aba_facility['client_start'])) }}</h4>
                                @endif
                            </figure>
                            <figure>
                            	<h5>What year did they finish?</h5>
                                @if($client_aba_facility['client_end'] != "" && $client_aba_facility['client_end'] != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($client_aba_facility['client_end'])) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>How many hours of ABA did they receive per week</h5><h4>{{ $client_aba_facility['client_hours'] }} hours</h4></figure>
                            </div>
                            @if($facility_count%2 == 0)
                            <div class="clearfix"></div>
                            <br />
                            @endif
                            @php $facility_count ++; @endphp
                            @endforeach
                            </div>
                            <div class="clearfix"></div>
				    		@endif
                            <figure>&nbsp;</figure>
                            <figure><h5>Is your child currently in Speech Therapy?</h5><h4>{{ $Client->client_speechtherapy }}@if($Client->client_speechtherapy == 'Yes'), {{ $Client->client_speechinstitution }}, {{ $Client->client_speechhoursweek }}hr/week @endif</h4></figure>
                            <figure><h5>Is your child currently in Occupational Therapy?</h5><h4>{{ $Client->client_occupationaltherapy }}@if($Client->client_occupationaltherapy == 'Yes'), {{ $Client->client_occupationalinstitution }}, {{ $Client->client_occupationalhoursweek }}hr/week @endif</h4></figure>
                            <figure><h5>Does your child attend school?</h5><h4>{{ $Client->client_childattendschool }}</h4></figure>
				    		<figure><h5>Name of school</h5><h4>{{ $Client->client_schoolname }}</h4></figure>
                            <figure><h5>If so, are they in a special needs class?</h5><h4>{{ $Client->client_specialclass }}</h4></figure>
                            <figure><h5>Medication</h5><h4>{{ $Client->client_medicalmedication }}</h4></figure>
                            <figure><h5>ABA History</h5><h4>{{ $Client->client_medicalabahistory }}</h4></figure>
                            <figure>
                            	<h5>Last Vision Exam</h5>
                                @if($Client->client_medicallastvisionexam != "" && $Client->client_medicallastvisionexam != '0000-00-00')
                                <h4>{{ date('jS M Y',strtotime($Client->client_medicallastvisionexam)) }}</h4>
                                @endif
                            </figure>
                            <figure><h5>How Many Hours of ABA Did They Receive Per Week</h5><h4>{{ $Client->client_medicalabahoursperweek }}</h4></figure>
                            <figure><h5>Tool Used</h5><h4>{{ $Client->client_medicaltoolused }}</h4></figure>
                            <figure><h5>Phone Number</h5><h4>{{ $Client->client_medicalphonenumber }}</h4></figure>
                            <figure><h5>Fax Number</h5><h4>{{ $Client->client_medicalfaxnumber }}</h4></figure>
                            <figure><h5>Address</h5><h4>{{ $Client->client_medicaladdress }}</h4></figure>
				    		<div class="padd-view"></div>
				    	</div>
					</div>
                </div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>
    
    <!-- Creates the bootstrap modal where the image will appear -->
    <div class="modal fade" id="client_medicaldocuments_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <img src="" id="client_medicaldocuments_preview" style="width: 100%;" >
        </div>
      </div>
    </div>

	<script type="text/javascript">
        $('document').ready(function(){
			$('.file_client_medicaldocument').change(function () {
			  if (this.files[0]) {$(this).parent().submit();} 
			});
			
			$('.archive_client_medicaldocument,.delete_client_medicaldocument').click(function () {
			  $(this).parent().submit();
			});
			
			$(".client_medicaldocuments_view").on("click", function() {
			   //$('#client_medicaldocuments_preview').attr('src', $(this).find('.client_medicaldocuments_resource').attr('src')); // here asign the image to the modal when the user click the enlarge link
			   $('#client_medicaldocuments_preview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
			   $('#client_medicaldocuments_modal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
			});
        });
    </script>
@endsection
