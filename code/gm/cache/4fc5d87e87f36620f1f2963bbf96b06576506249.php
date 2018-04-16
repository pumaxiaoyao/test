<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make("Player.online.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts1'); ?>
    <?php echo $__env->make("Player.allRoles.script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("Player.allRoles.content", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $__env->make("Player.modal.agentModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.layerModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.balanceModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.bonusModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.waterCheckModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.remarkModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.resetPwdModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Player.modal.messageModal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Home.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>