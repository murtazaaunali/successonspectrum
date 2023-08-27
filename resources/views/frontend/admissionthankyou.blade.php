@include('frontend.includes.header')
	<section>
		<div class="container">
			<div class="thanks_main admission_main">
				<div class="admission_content">
					<h2>THANK YOU</h2>
					<p>We will verify your insurance benefits and contact you within 3 business days
					</p>
					@php 
						$url = url('admissionform/pdfdownload').'/'.Session::get('link');
					@endphp
					<a class="let_butt" href=" @if(Session::has('link'))  {{ $url }} @else {{'#'}} @endif "><i class="fa fa-cloud-download" aria-hidden="true"></i>Download</a>
				</div>
			</div>
		</div>
	</section>
@include('frontend.includes.footer')