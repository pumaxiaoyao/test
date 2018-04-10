<link href="/static/css/player/AccountOverview.css?201803142235" rel="stylesheet" />
<link href="/static/css/bootstrap.min.css" rel="stylesheet" />
<script src="/static/js/player/Accountmenu.js?201803150050"></script>
<script>
    
    <?php if($PhoneCodeInterval > 0): ?>
    var LastPhoneCode=true; 
    var PhoneCodeInterval=<?php echo e($PhoneCodeInterval); ?>;
    <?php else: ?>
    var LastPhoneCode=false; 
    var PhoneCodeInterval=0;
    <?php endif; ?>
    
    <?php if($unPhoneCodeInterval > 0): ?>
    var LastUnPhoneCode=true; 
    var UnPhoneCodeInterval=<?php echo e($unPhoneCodeInterval); ?>;
    <?php else: ?>
    var LastUnPhoneCode=false; 
    var UnPhoneCodeInterval=0;
    <?php endif; ?>
    
    <?php if($EMailCodeInterval > 0): ?>
    var LastMailCode=true; 
    var MailCodeInterval=<?php echo e($EMailCodeInterval); ?>;
    <?php else: ?>
    var LastMailCode=false; 
    var MailCodeInterval=0;
    <?php endif; ?>

    
    <?php if($unEMailCodeInterval > 0): ?>
    var LastUnMailCode=true; 
    var UnMailCodeInterval=<?php echo e($unEMailCodeInterval); ?>;
    <?php else: ?>
    var LastUnMailCode=false; 
    var UnMailCodeInterval=0;
    <?php endif; ?>
</script>
<script src="/static/js/player/accountSetting.js?201803181336"></script>
<script>
    $(function () {
        function addClasson(id) {
            $(id).find('.left_nav_title').click(function () {
                var $left_nav_one = $(id);
                $(this).toggleClass("on");
                if (!$(this).hasClass("on")) {
                    $left_nav_one.find('dl').slideUp()
                } else {
                    $left_nav_one.find('dl').slideDown()
                }
            })
        };
        addClasson('.left_nav_one');
        addClasson('.left_nav_two');
        $(".nr_left_nav").find("dl").find(".on").parent().prev().toggleClass("on");
        $(".nr_left_nav").find("dl").find(".on").parent().show();
    })
</script>