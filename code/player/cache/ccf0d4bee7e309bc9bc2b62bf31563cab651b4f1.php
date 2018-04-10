<script src="/static/js/retrieve.js?201801051113"></script>
</div>
<link href="/static/css/index.css" rel="stylesheet" />
<script>
    function addon(id, num, classid) {
        $(id).click(function () {
            $('.find_pwd_line div').eq(num).addClass('on').siblings().removeClass('on');
            $('div[class^="find_pwd_step_"]').hide();
            $(classid).show()
        })
    }
    addon('#setting_phonenext_box_submit', 1, '.find_pwd_step_two')
    addon('#setting_emailnext_box_submit', 1, '.find_pwd_step_two')
    addon('#setting_pwdnext_box_submit', 2, '.find_pwd_step_three')
</script>