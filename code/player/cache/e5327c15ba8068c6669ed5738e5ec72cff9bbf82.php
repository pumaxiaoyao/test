<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('Player.AccountSetting.home.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("as_nav"); ?>
    <?php echo $__env->make('Player.AccountSetting.home.as_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Player.AccountSetting.home.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Player.AccountSetting.home.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>