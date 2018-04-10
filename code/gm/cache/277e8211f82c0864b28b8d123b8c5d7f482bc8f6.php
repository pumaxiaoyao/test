<script src="/static/js/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="/static/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/static/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="/static/js/bootstrap.min.js" type="text/javascript"></script>
<!--[if lt IE 9]>
    <script src="/static/js/excanvas.min.js"></script>
    <script src="/static/js/respond.min.js"></script>
    <![endif]-->
<script src="/static/js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/static/js/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/static/js/jquery.cookie.min.js" type="text/javascript"></script>
<script src="/static/js/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/static/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/static/js/app.js" type="text/javascript"></script>
<script src="/static/js/login.js" type="text/javascript"></script>
<script src="/static/js/support/error.js?20171227" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/rsa/jsbn.js"></script>
<script type="text/javascript" src="/static/js/rsa/prng4.js"></script>
<script type="text/javascript" src="/static/js/rsa/rng.js"></script>
<script type="text/javascript" src="/static/js/rsa/rsa.js"></script>
<script type="text/javascript" src="/static/js/rsa/base64.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>

    function SetCookie(name,value) 
        { 
            var Days = 365; 
            var exp = new Date(); 
            exp.setTime(exp.getTime() + Days*24*60*60*1000); 
            document.cookie = name + "="+ escape (value) + ";path=/;expires=" + exp.toGMTString(); 
        } 
    
    jQuery(document).ready(function () {
        App.init();
        Login.init();
        
        SetCookie('la','cn');
        $("#la").find("option[value=cn]").attr('selected',true);
        $("#la").change(function(){
            SetCookie('la',$(this).val());
        });
    });
</script>