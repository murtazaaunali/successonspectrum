<a href="{{ url('franchise/client/viewinsurance/editauthorization/'.$Client->id.'/'.$ClientInsurancePolicy->id.'/'.$clients_insurance_policy_authorization->id) }}" class="owner_edit authorization_action_icon authorization_edit" title="Edit Authorization"><i class="fa fa-pencil"></i></a>
<a href="javascript:;" data-authorization_id="{{ $clients_insurance_policy_authorization->id }}" data-client_id="{{ $Client->id }}" data-client_insurance_id="{{ $ClientInsurancePolicy->id }}" class="owner_archive authorization_action_icon @if($clients_insurance_policy_authorization->archive == 1)authorization_unarchive @else authorization_archive @endif" title="@if($clients_insurance_policy_authorization->archive == 1)Activate @else Archive @endif Authorization"><i class="fa fa-archive"></i></a>
<a href="javascript:;" data-authorization_id="{{ $clients_insurance_policy_authorization->id }}" data-client_id="{{ $Client->id }}" data-client_insurance_id="{{ $ClientInsurancePolicy->id }}" class="owner_delete authorization_action_icon authorization_delete" title="Delete Authorization"><i class="fa fa-trash"></i></a>
<figure>
    <h5>Start Date</h5>
    @if($clients_insurance_policy_authorization->client_authorizationsstartdate != "" && $clients_insurance_policy_authorization->client_authorizationsstartdate != '0000-00-00')
    <h4>{{ date('jS M Y',strtotime($clients_insurance_policy_authorization->client_authorizationsstartdate)) }}</h4>
    @endif
</figure>
<figure>
    <h5>End Date</h5>
    @if($clients_insurance_policy_authorization->client_authorizationseenddate != "" && $clients_insurance_policy_authorization->client_authorizationseenddate != '0000-00-00')
    <h4>{{ date('jS M Y',strtotime($clients_insurance_policy_authorization->client_authorizationseenddate)) }}</h4>
    @endif
</figure>
<figure><h5>ABA</h5><h4>{{ $clients_insurance_policy_authorization->client_authorizationsaba }}</h4></figure>
<figure><h5>Supervision</h5><h4>{{ $clients_insurance_policy_authorization->client_authorizationssupervision }}</h4></figure>
<figure>
    <h5>Parent Training</h5>
    <?php /*?>@if($clients_insurance_policy_authorization->client_authorizationsparenttraining != "" && $clients_insurance_policy_authorization->client_authorizationsparenttraining != '0000-00-00')
    <h4>{{ date('jS M Y',strtotime($clients_insurance_policy_authorization->client_authorizationsparenttraining)) }}</h4>
    @endif<?php */?>
    <h4>{{ $clients_insurance_policy_authorization->client_authorizationsparenttraining }}</h4>
</figure>
<figure>
    <h5>Reassessment</h5>
    <?php /*?>@if($clients_insurance_policy_authorization->client_authorizationsreassessment != "" && $clients_insurance_policy_authorization->client_authorizationsreassessment != '0000-00-00')
    <h4>{{ date('jS M Y',strtotime($clients_insurance_policy_authorization->client_authorizationsreassessment)) }}</h4>
    @endif<?php */?>
    <h4>{{ $clients_insurance_policy_authorization->client_authorizationsreassessment }}</h4>
</figure>