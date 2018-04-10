

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <link href="/static/css/BaseCss.css" rel="stylesheet" />
    <link href="/static/css/public.css" rel="stylesheet" />
    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="/static/css/player/StationLetter.css" />
    <script>
        var messagetype = <?php echo e($MailType); ?>; 
        var messageid = <?php echo e($MailId); ?>; 
    </script>
</head>
<body class="bd_mdetail">
    <div class="m_detailmain">
        <div class="top">
            <span class="top_title">收件箱</span>
            <div class="close"></div>
        </div>
        <div class="title">
            <div class="title_1">
                <?php echo e($MailTitle); ?>

                <!-- <div id="mess_del" class="delete"></div> -->
            </div>
            <span><?php echo e($MailTime); ?></span>

        </div>
       <div class="dialogue">
            
                <ul>
                    <li class="customer">
                        <div class="pic"></div>
                        <div class="text"><div class="text_info">
                            <span class="info"><?php echo e($MailContent); ?></span>
                        </div>
                            
                        </div>
                    </li>
                </ul>
                
       </div>
    </div>
    <div style="display:none">
        <script type="text/javascript" src="/static/js/player/messagedetail.js"></script>
    </div>
</body>
</html>
