<?php if($checkStatus == 2): ?>
<a href='#verifyModal' data-toggle='modal' onclick="verifystart(2,'<?php echo e($dno); ?>');" class='btn btn-xs red'><i class='icon-question'></i>终审</a>
<?php elseif($checkStatus == 1): ?>
<a href='#verifyModal' data-toggle='modal' onclick="verifystart(1, '<?php echo e($dno); ?>');" class='btn btn-xs blue'><i class='icon-question'></i>初审</a>
<?php endif; ?>

