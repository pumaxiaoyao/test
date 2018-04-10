@if ($status == 2)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account or ""}}")' class='btn mini red'><i class='fa fa-lock'>锁定</i></a>@elseif ($status == 3)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account or ""}}")' class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>@endif &nbsp; &nbsp;
<a id='edit' href='javascript:void(0)' onclick='editPlayerDetail("{{ $account or ""}}")' class='btn mini green'><i class='fa fa-edit'></i>校验</a>