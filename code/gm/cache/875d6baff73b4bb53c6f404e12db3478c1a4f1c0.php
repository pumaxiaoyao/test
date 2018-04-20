<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<!-- <html lang="en" class="no-js"> -->
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo e(isset($title) ? $title : ""); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="<?php echo e(isset($desc) ? $desc : " "); ?>" name="description" />
    <meta content="<?php echo e(isset($author) ? $author : " "); ?>" name="author" />
    <?php echo $__env->make('Home.common.headScript', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    
    <?php echo $__env->yieldContent("scripts"); ?>

    <?php echo $__env->yieldContent("scripts1"); ?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-quick-sidebar-over-content page-style-square page-footer-fixed">
    <!-- BEGIN HEADER -->
    <?php echo $__env->make('Home.common.navContent', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('Home.common.sideBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->yieldContent('modals'); ?>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
</body>
<footer>
    <?php echo $__env->make('Home.common.footScripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent("scripts2"); ?>
</footer>
</html>