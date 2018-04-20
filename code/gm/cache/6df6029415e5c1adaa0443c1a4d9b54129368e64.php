
<?php if( $status == 2): ?>
    <span class='label label-success'> 正常 </span>
<?php elseif($status = 3): ?>
    <span class='label label-danger'> 锁定 </span>
<?php elseif($status = 1): ?> 
    <span class='label label-success'> 未激活</span>
<?php elseif($status = 4): ?> 
    <span class='label label-success'> 已删除</span>
<?php endif; ?>