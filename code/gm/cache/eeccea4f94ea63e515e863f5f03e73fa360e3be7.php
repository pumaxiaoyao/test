<?php $__env->startSection('script'); ?>
    <?php echo $__env->make("Player.online.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script1'); ?>
    <?php echo $__env->make("Player.regDaily.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("Player.regDaily.content", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Home.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>