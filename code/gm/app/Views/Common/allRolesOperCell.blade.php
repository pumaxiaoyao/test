@if ($status == 2)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account }}")' class='btn mini red'>
    <i class='fa fa-lock'>锁定</i>
</a>
@elseif ($status == 3)
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "{{ $account }}")' class='btn mini green'>
    <i class='fa fa-unlock'>解锁</i>
</a>
@endif
&nbsp; &nbsp;
<a id='edit' href='javascript:void(0)' onclick='editPlayerDetail("{{ $account }}")' class='btn mini blue'>
    <i class='fa fa-edit'></i>编辑</a>
<br/><br/>
<a id='pwd' href='javascript:void(0)' reset='reset' uid='{{ $account }}' class='btn mini blue'>
    <i class='fa fa-edit'></i>修改密码</a>
    &nbsp; &nbsp;
<a id='msg' href="javascript:void(0);" message=message uid="{{ $account }}" class='btn mini blue'>
    <i class=\"fa fa-bell\"></i>发消息</a>