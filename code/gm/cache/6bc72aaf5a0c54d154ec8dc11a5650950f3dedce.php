<a href='#accountModal' data-toggle='modal' astatus='<?php echo e($status); ?>' aname='<?php echo e($agentName); ?>' aid='<?php echo e($agentId); ?>' onclick='lockunlock(this);'
<?php if($status == 2): ?>
    class='btn btn-xs red status'>锁定</a>
<?php elseif($status == 3): ?>
    class='btn btn-xs green status'>解锁</a>
<?php endif; ?>
<a href='#editModal' class='btn btn-xs blue' data-toggle='modal' onclick="initModal('<?php echo e($agentId); ?>')">编辑</a><br/><br>
<a href='#resetPwd' class='btn btn-xs blue' data-toggle='modal' aid='<?php echo e($agentId); ?>' onclick='resetPwdModal(this)' > 修改密码</a>
<a href='#levelModal' data-toggle='modal' class='btn btn-xs blue level' aid='<?php echo e($agentId); ?>' layerid='<?php echo e($layerId); ?>' onclick='getLayerList(this);'> 调整层级</a>

