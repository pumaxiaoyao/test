<?php if($checkStatus == 1): ?>
<a href='#acturalModal' data-toggle='modal' onclick="acturalstart('<?php echo e($dno); ?>','<?php echo e($commisionResultAmount); ?>', '<?php echo e($platformCommision); ?>');"
    class='btn btn-xs green'><i class='fa fa-edit'></i><?php echo e($commisionResultAmount); ?></a> <?php else: ?> <?php echo e($commisionResultAmount); ?> <?php endif; ?>