<?php if($code == 4): ?>
<a href="javascript:void(0);" reset="reset" dno="<?php echo e($dno); ?>" class="btn mini green">重置</a>
<?php else: ?>
    <a href="javascript:void(0);" onclick="resetAlert()" class="btn mini grey-steel">重置</a>
<?php endif; ?>
