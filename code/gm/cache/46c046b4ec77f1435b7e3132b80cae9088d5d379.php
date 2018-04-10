<?php if($checkStatus == 1): ?>
<a href='#adjustModal' data-toggle='modal' onclick="adjuststart('<?php echo e($dno); ?>', '<?php echo e($adjustmentAmount); ?>');" class='btn btn-xs green'><i class='fa fa-edit'></i><?php echo e($adjustmentAmount); ?></a>
<?php else: ?>
<?php echo e($adjustmentAmount); ?>

<?php endif; ?>