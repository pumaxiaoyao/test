<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('Agent.index.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Agent.index.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Agent.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>