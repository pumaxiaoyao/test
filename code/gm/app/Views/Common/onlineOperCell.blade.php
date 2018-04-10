@if ($status == 2)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account }}")'  class='btn mini red'><i class='fa fa-lock'>锁定</i></a>
@elseif ($status == 3)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account }}")'  class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>
@endif
&nbsp; &nbsp;<a href='javascript:void(0)' onclick='playerkickdown("{{ $account }}")'  class='btn mini blue'><i class='icon-trash'></i>踢线</a>