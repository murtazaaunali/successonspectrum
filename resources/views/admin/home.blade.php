@extends('admin.layout.main')

@section('content')
    <div class="main-deck-head">
        <h4>{{$sub_title}}</h4>
    </div>
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif
    <div class="main-deck-card-main">
        <div class="main-deck-card main-deck-card-1">
            <div class="main-deck-card-text">
                <p>Active Franchises</p>
                <b class="block-1">{{ $active_franchises }}</b>
                <span>Total Franchise:</span>
                <b>{{ $total_franchises  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-1">
                <i class="fa fa-building" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="main-deck-card main-deck-card-2">
            <div class="main-deck-card-text">
                <p>Terminated Franchises</p>
                <b class="block-1">{{ $terminated_franchises  }}</b>
                <span>Total Franchise:</span>
                <b>{{ $total_franchises  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-2">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="main-deck-card main-deck-card-3">
            <div class="main-deck-card-text">
                <p>Potential Franchises</p>
                <b class="block-1">{{ $potential_franchises  }}</b>
                <span>Total Franchise:</span>
                <b>{{ $total_franchises  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-2">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="main-deck-card main-deck-card-4">
            <div class="main-deck-card-text">
                <p>Expired Franchises</p>
                <b class="block-1">{{ $expired_franchises  }}</b>
                <span>Total Franchise:</span>
                <b>{{ $total_franchises  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-2">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="main-deck-card main-deck-card-5">
            <div class="main-deck-card-text">
                <p>Most Franchises In A State</p>
                <b class="block-1">{{ $most_franchises_state  }}</b>
                <span>Total Active States:</span>
                <b>{{ $total_franchises_states  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-3">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php /*?><div class="main-deck-card main-deck-card-4">
            <div class="main-deck-card-text">
                <!--<p>Most Clients (Monthly)</p>-->
                <p>Most Clients ({{ date('F')}})</p>
                <b class="block-1">{{ number_format($most_clients_monthly)  }}</b>
                <span>Franchise:</span>
                <b>{{ $most_clients_franchise  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-4">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="main-deck-card main-deck-card-5">
            <div class="main-deck-card-text">
                <p>Highest # Of Employees</p>
                <b class="block-1">{{ $most_employees_franchise  }}</b>
                <span>Franchise:</span>
                <b>{{ $most_employees_franchise_name  }}</b>
            </div>
            <div class="main-deck-card-icon main-deck-card-icon-5">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div><?php */?>
        <div class="clearfix"></div>
    </div>
    <div class="upcoming-contact-expiration">
        <h6>{{ $upcoming_contract_expiration_title  }}</h6>
        <!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
        <div class="super-admin-table-1 table-responsive">
            <table>
                <tr>
                    <th>Franchisees</th>
                    <th>Expiration Date</th>
                    <th class="super-admin-table-position-1">Actions</th>
                </tr>
                @if(!$franchises->isEmpty())
                    @foreach($franchises as $rec_contract)
                        @if(is_array($rec_contract) || is_object($rec_contract))
                        <tr>
                            <td class="td-width">{{ substr($rec_contract->location, 0, 20) .((strlen($rec_contract->location) > 20) ? '...' : '') }}</td>
                            <?php /*?><td @if(date('Y-m-d') > $rec_contract->fdd_expiration_date) style="color: #fc6666" @endif >{{ date('dS M Y',strtotime($rec_contract->fdd_expiration_date)) }}</td><?php */?>
                            <td @if(date('Y-m-d') > $rec_contract->fdd_expiration_date) style="color: #fc6666" @endif >{{ date('m/d/Y',strtotime($rec_contract->fdd_expiration_date)) }}</td>
                            <td class="super-admin-table-position"><a href="{{ url('admin/franchise/view/'.$rec_contract->id) }}" class="btn snd-mes-butn-1 eye-butn"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>
                        </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No Records Found!</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="super-admin-table-bottom">
            <div class="super-admin-table-bottom-para">
                @if($franchises->firstItem())
                	<p>Showing {{ $franchises->firstItem() }} to {{ $franchises->lastItem() }} of {{ $franchises->total() }} entries</p>
                @else
                	<p>Showing 0 Entries</p>
                @endif
            </div>
            <div class="super-admin-table-bottom-pagination">
            	{!! $franchises->render() !!}
                {{--<ul>
                    <li><a href="#">Previous</a></li>
                    <li><a class="nav-a" href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">Next</a></li>
                </ul>--}}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
