<a href='#accountModal' data-toggle='modal' astatus='{{ $status }}' aname='{{ $agentName }}' aid='{{ $agentId }}' onclick='lockunlock(this);'
@if ($status == 2)
    class='btn btn-xs red status'>锁定</a>
@elseif ($status == 3)
    class='btn btn-xs green status'>解锁</a>
@endif
<a href='#editModal' class='btn btn-xs blue' data-toggle='modal' onclick="initModal('{{ $agentId }}')">编辑</a><br/><br>
<a href='#resetPwd' class='btn btn-xs blue' data-toggle='modal' aid='{{ $agentId }}' onclick='resetPwdModal(this)' > 修改密码</a>
<a href='#levelModal' data-toggle='modal' class='btn btn-xs blue level' aid='{{ $agentId }}' layerid='{{ $layerId }}' onclick='getLayerList(this);'> 调整层级</a>

