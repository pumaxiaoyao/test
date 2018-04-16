<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" style="background:#FFF;">

<head>
    <link rel="stylesheet" href="/static/css/member/StationLetter.css" />
    <link href="/static/css/promotions.css" rel="stylesheet" />
    <title></title>
</head>
<body class="bd_mdetail" >
    <?php echo $__env->make('Activity.showDetail.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div style="display:none">
    <?php echo $__env->make('Activity.showDetail.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    </div>
</body>
</html>