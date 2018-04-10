<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('Agent.AccountSetting.home.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("as_nav"); ?>
    <?php echo $__env->make('Agent.AccountSetting.home.as_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Agent.AccountSetting.home.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Agent.AccountSetting.home.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>