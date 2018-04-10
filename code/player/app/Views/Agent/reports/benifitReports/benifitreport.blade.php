@foreach ($benifitData as $_benifit)
<tr><td>{{ $_benifit["month"] or "" }}</td><td>{{ $_benifit["validPlayerCount"] or ""}}</td>
<td><a href="javascript:void(0);" class='agentDetailBtn' onclick="detail('{{ $_benifit["month"] or "" }}', '1')"><i class='fa fa-building-o'></i>{{$_benifit["platformCommision"] or ""}}</a></td>
<td><a href="javascript:void(0);" class='agentDetailBtn' onclick="detail2('{{ $_benifit["month"] or "" }}', '1')"><i class='fa fa-building-o'></i>{{$_benifit["costAllocation"] or ""}}</a></td>
<td>{{ $_benifit["lastMonthLeftAmount"] or "" }}</td><td>{{ $_benifit["adjustmentAmount"] or "" }}</td><td>{{ $_benifit["commisionAmount"] or "" }}</td><td>{{ $_benifit["lastMonthLeftAmount"] or "" }}</td>
<td>{{ $_benifit["commisionResultAmount"] or "" }}</td><td>{{ $_benifit["checkStatus"] or "" }}</td>
</tr>
@endforeach