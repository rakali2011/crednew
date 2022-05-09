<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #fafad2; font-size: 14; color: #000000; text-align: center; " colspan="8" ><strong>{{"Group Name : ".$practice->practice_name}}</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="8"></td>
        </tr>
    </tbody>
</table>
@foreach($providers as $key=>$provider)

<table>
    <thead>
        <tr>
            <th style=" border: 1px solid black; background-color: #e0ffff; font-size: 14; color: #d0211c; text-align: center; " colspan="8" ><strong>{{$provider->full_name}}</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="background-color: #add8e6; color: #003eff; width:200px;"><strong>Insurance Carrier</strong></td>
            <td style="background-color: #add8e6; color: #003eff; width:120px;"><strong>Initiated Date</strong></td>
            <td style="background-color: #add8e6; color: #003eff; width:120px;"><strong>Effective Date</strong></td>
            <td style="background-color: #add8e6; color: #003eff; width:120px;"><strong>Status</strong></td>
            <td style="background-color: #add8e6; color: #003eff; width:120px;"><strong>Provider ID</strong></td>
            <td colspan="3" style="background-color: #add8e6; color: #003eff; width:200px;"><strong>Comments</strong></td>
        </tr>
        @foreach($provider->payers as $payer)
            @php
             $allremarks = "";
             $count=1;
            @endphp
        @foreach($payer->remarks as $remark)
            @php
            
            $allremarks .= " (Date: ".date("M j, Y g:ia", strtotime($remark->created_at)).") ".$remark->remarks;
            @endphp
        @endforeach
        <tr>
            <td style="background-color: #add8e6"><strong>{{$payer->name}}</strong></td>
            <td style="background-color: #add8e6"><strong>{{isset($payer->appstatuschanges[0]->status_change_date)? $payer->appstatuschanges[0]->status_change_date:"NA"}}</strong></td>
            <td style="background-color: #add8e6"><strong>{{isset($payer->pivot->effective_date)? $payer->pivot->effective_date: "NA"}}</strong></td>
            <td style="background-color: #add8e6"><strong>{{$payer->pivot->status}}</strong></td>
            <td style="background-color: #add8e6"><strong>{{$payer->pivot->provider_identifier}}</strong></td>
            <td colspan="3" style="background-color: #add8e6"><strong>{{$allremarks}}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach