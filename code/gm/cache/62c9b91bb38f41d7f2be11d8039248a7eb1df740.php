<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Home.index.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Home.index.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>