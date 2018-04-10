<?php if($flag === false): ?>
    <a href="javascript:void(0);" onclick="endWater('<?php echo e($dno); ?>','<?php echo e($account); ?>', 66);" class="btn btn-xs red"><i class="icon-trash"></i>重启</a></td>
<?php else: ?>
    <a href="javascript:void(0);" onclick="endWater('<?php echo e($dno); ?>','<?php echo e($account); ?>', 99);" class="btn btn-xs green"><i class="icon-trash"></i>OK</a></td>
<?php endif; ?>
