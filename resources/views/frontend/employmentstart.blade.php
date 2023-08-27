@include('frontend.includes.header')
	<section>
		<div class="container">
			<div class="admission_main">
				<div class="admission_content employe_main">
					<h2>EMPLOYMENT APPLICATION</h2>
					<p>Success On The Spectrum is looking for enthusiastic, hard-working, and professional employees.</p>
					<p>If this describes you and you are looking for an ABA company that make you love coming to work each day, please apply!</p>

					<a class="let_butt" href="{{ url('/employmentform') }}">Let's Start</a>
					<div class="print_anc">
						<a href="#"><i class="fa fa-print" aria-hidden="true"></i>Print Form</a>
					</div>
				</div>
			</div>
		</div>
	</section>	
@include('frontend.includes.footer')