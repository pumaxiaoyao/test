<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('Player.registerok.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Player.registerok.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Player.registerok.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>