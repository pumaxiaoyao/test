<?php if($status == 1): ?>
    <a href="#WCheck" data-toggle="modal" onclick="getWList('<?php echo e($dno); ?>', '<?php echo e($account); ?>',1);" class="btn mini green"><i class="icon-trash"></i>请检查</a>
<?php elseif($status == 2): ?>
    <label value='<?php echo e($status); ?>'>已通过</label>
<?php elseif($status == 4): ?>
    <label value='<?php echo e($status); ?>'>未通过</label>
<?php else: ?>
    <label value='<?php echo e($status); ?>'>未定义状态</label>
<?php endif; ?>