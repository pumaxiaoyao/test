@if ($flag === false)
    <a href="javascript:void(0);" onclick="endWater('{{ $dno }}','{{ $account }}', 66);" class="btn btn-xs red"><i class="icon-trash"></i>重启</a></td>
@else
    <a href="javascript:void(0);" onclick="endWater('{{ $dno }}','{{ $account }}', 99);" class="btn btn-xs green"><i class="icon-trash"></i>OK</a></td>
@endif
