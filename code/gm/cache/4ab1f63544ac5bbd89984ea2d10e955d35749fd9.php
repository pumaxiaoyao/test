<!-- 4 -->
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo e(isset($title) ? $title : ''); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="keywords" content="<?php echo e(isset($keywords) ? $keywords : ''); ?>" />
    <meta name="description" content="<?php echo e(isset($description) ? $description : ''); ?>" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <?php echo $__env->make('Home.login.headScript', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent("scripts"); ?>
</head>
<body class="login">
    
    <?php echo $__env->yieldContent('content'); ?>
</body>
<footer>
    <?php echo $__env->make('Home.login.footScripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</footer>
</html>

    
    