@extends('parent.layout.main')

@section('content')

	<div class="add-franchise-super-main">
		<div class="view-tab-control">
            <h6>{{ $Client->client_childfullname }}</h6>
            <p>Client / <span id="change-bread-crumb">Archives</span></p>
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
				    			<h3>Archives</h3>
				    		</div>
				    		<!--<div class="view-tab-content-butn">
				    			<a href="{{ url('parent/client/editmedicalinformation/'.$Client->id) }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
				    		</div>-->
				    		<div class="clearfix"></div>
				    	</div>
				    	<div class="view-tab-content">
                            @if(!$ClientArchives->isEmpty())
                            @php $count = 1; @endphp
                            @foreach($ClientArchives as $key=>$archives)
                                <div class="super-admin-cargo-hold-box dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                                    <div class="logout-box-main dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                        <a href="{{ url('parent/client/downloadmedicaldocuments/'.$Client->id.'/'.$archives->id) }}" class="head-active">Download</a>
                                        <form action="{{ url('parent/client/activemedicaldocuments/'.$Client->id.'/'.$archives->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                            <a href="javascript:void(0);" class="active_client_medicaldocument">Active</a>
                                        </form>
                                        <form action="{{ url('parent/client/deletemedicaldocuments/'.$Client->id.'/'.$archives->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                            <a href="javascript:void(0);" class="bord-bot-0 red-clr delete_client_medicaldocument">Delete</a>
                                        </form>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="#">

                                        @if(pathinfo($archives->document_file,PATHINFO_EXTENSION) == 'docx')
                                        	<img src="{{ asset('assets') }}/images/pdf-1.jpg">
                                        @else
                                        	<img src="{{ asset('assets') }}/images/pdf.jpg">
                                        @endif

                                        <!--<p>{{ $archives->document_name }}</p>-->
                                        <p>{{ str_limit($archives->document_name, $limit = 15, $end = '...') }}</p> 
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                                @php $count ++; @endphp
                            @endforeach
                            @endif
				    		<div class="padd-view"></div>
                            <div class="clearfix"></div>
                            <div class="super-admin-table-bottom">
                                <div class="super-admin-table-bottom-para">
                                    @if($ClientArchives->firstItem())
                                    <p>Showing {{ $ClientArchives->firstItem() }} to {{ $ClientArchives->lastItem() }} of {{ $ClientArchives->total() }} entries</p>
                                    @else
                                    <p>Showing 0 Entries</p>
                                    @endif
                                </div>
                                <div class="super-admin-table-bottom-pagination">
                                    {!! $ClientArchives->links() !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>
				    	</div>
					</div>
                </div>
			</div>
		</div>
	<!-- header-bottom-sec -->
	</div>

	<script type="text/javascript">
        $('document').ready(function(){
            $('.upload_client_medicaldocument').click(function () {
			  var document = $(this).data('document');$('#'+document).click();
			});
			$('.file_client_medicaldocument').change(function () {
			  if (this.files[0]) {$(this).parent().submit();} 
			});
			$('.active_client_medicaldocument,.delete_client_medicaldocument').click(function () {
			  $(this).parent().submit();
			});
        });
    </script>
@endsection

