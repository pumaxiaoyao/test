@if($ckStatus == 1)
    @if ($status == 1)
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('{{ $dno }}',
    '{{ $amount }}','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    @elseif($status == 2)
    <a href="#passModal" data-toggle="modal" onclick="passSet('{{ $dno }}',
'{{ $amount }}','{{ $rname }}','{{ $bank }}','{{ $card }}','{{ $account }}');"class="btn btn-xs green"><i class="icon-trash"></i>通过</a>
    &nbsp;
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('{{ $dno }}',
    '{{ $amount }}','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    @elseif($status == 4)
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('{{ $dno }}',
    '{{ $amount }}','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    @endif
@elseif($ckStatus == 2){
<a href='#bankModal' data-toggle='modal' onclick='setbankModal('{{ $dno}}');' class='btn btn-xs blue'><i class='icon-trash'></i>银行卡出款</a>
@endif