<?php $__env->startSection('script'); ?>
    <?php echo $__env->make("Message.agent.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("Message.agent.content", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Home.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>