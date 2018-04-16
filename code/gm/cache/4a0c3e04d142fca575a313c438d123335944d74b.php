<?php if($status == 2): ?>
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "<?php echo e($account); ?>")'  class='btn mini red'><i class='fa fa-lock'>锁定</i></a>
<?php elseif($status == 3): ?>
<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, "<?php echo e($account); ?>")'  class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>
<?php endif; ?>
&nbsp; &nbsp;<a href='javascript:void(0)' onclick='playerkickdown("<?php echo e($account); ?>")'  class='btn mini blue'><i class='icon-trash'></i>踢线</a>