@extends('franchise.layout.main')

@section('content')

		<!-- header-bottom-sec -->
		<div class="add-franchise-super-main">
			<div class="view-tab-control float-none">
				<div class="main-deck-head main-deck-head-franchise Catalogue">
					<h6>Catalog</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			
			<div class="upload-document-cargo-head add-product-view"> <h4>SOS Products</h4></div>
			<div class="upcoming-contact-expiration franchise-list-main upload-document-cargo-upload spinner_main">
	
				<div class="row">

					<div class="col-sm-12">
						<div class=" text-center" style="padding:50px 0;">
							<h2>Thank You!</h2>
							<p>Your order has been placed. Someone from SOS Corporate<br/> office will be back to you shortly.</p>
							<div class="add-franchise-butn-main" style="float:none;">
								<a href="{{ url('franchise/catalog') }}" class="btn CartBadge">Back to Catalog</a>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		<!-- header-bottom-sec -->
	</div>

@endsection

@push('js')
<script type="text/javascript">
	

</script>
@endpush