
@foreach ($gameData as $gpName=>$gpData)
<tr><td>{{ $gpName or "" }}</td>
    <td>{{ $gpData["winLoseAmount"] or "" }}</td>
    <td>{{ sprintf($gpName["pumpingCommisionRate"] * 100) or "" }}</td>
    <td>{{ $gpName["pumpingCommisionAmount"] or "" }}</td>
    <td>{{ $gpName["validStakeAmount"] or "" }}</td>
    <td>{{ sprintf($gpName["pumpingWaterRate"] * 100) or "" }}</td>
    <td>{{ $gpName["pumpingWaterAmount"] or "" }}</td>
</tr>
@endforeach

<tr><td>小计</td>
    <td>{{$TotalWinLose}}</td><td></td>
    <td>{{$TotalCommision}}</td>
    <td>{{$TotalStake}}</td><td></td>
    <td>{{$TotalWater}}</td></tr>
<tr><td>平台合计</td>
    <td>{{$TotalCommision}}</td>
    <td>线路费</td>
    <td>{{$lineChargeRate}}%</td>
    <td>代理线佣金</td>
    <td colspan='2'>{{$lineCommision}}</td></tr>