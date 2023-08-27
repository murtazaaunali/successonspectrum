<form action="{{ route('franchise.clients') }}" method="get" id="view_client">
    <div class="frnchise-select-main">
        <label>Select Related (Client)</label>
        <select name="client_sibling">
            <option value="">Search By Client</option>
            @if($clients)
                @foreach($clients as $client)
                    @if($Client->id != $client->id)
                    <option value="{{ $client->id }}" @if(Request::get('client_sibling') == $client->id) selected="" @endif>{{ $client->client_childfullname }}</option>
            		@endif        
                @endforeach
            @endif
        </select>
    </div>
</form>
<script type="text/javascript">
$('document').ready(function(){
	$('select[name=client_sibling]').change(function () {
	  var $client_id = $(this).val();
	  window.location = "{{ url('franchise/client/view/') }}/"+$client_id;
	});
});
</script>