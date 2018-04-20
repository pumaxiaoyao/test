<?php $__env->startSection('scripts'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts1'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("Setting.agentLevel.content", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts2'); ?>
    <?php echo $__env->make("Setting.agentLevel.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Home.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>