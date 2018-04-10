<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('Player.retrieve.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Player.retrieve.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Player.retrieve.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>