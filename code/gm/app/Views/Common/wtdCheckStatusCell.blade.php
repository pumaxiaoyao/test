@if($status == 1)
    <a href="#WCheck" data-toggle="modal" onclick="getWList('{{ $dno }}', '{{ $account }}',1);" class="btn mini green"><i class="icon-trash"></i>请检查</a>
@elseif($status == 2)
    <label value='{{ $status }}'>已通过</label>
@elseif($status == 4)
    <label value='{{ $status }}'>未通过</label>
@else
    <label value='{{ $status }}'>未定义状态</label>
@endif