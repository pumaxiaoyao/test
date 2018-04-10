<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo e(isset($title) ? $title : ''); ?></title>    
        <meta charset="utf-8">    
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="keywords" content="<?php echo e(isset($keywords) ? $keywords : ''); ?>" />
        <meta name="description" content="<?php echo e(isset($description) ? $description : ''); ?>" />
        
        <?php echo $__env->make('Common.headerScripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <?php echo $__env->yieldContent("scripts"); ?>
    </head>
    <body>
        
        <?php echo $__env->make('Common.navigate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        
        <?php echo $__env->yieldContent('content'); ?>
    </body>
    <footer>
        
        <?php echo $__env->make('Common.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </footer>
</html>

    
    