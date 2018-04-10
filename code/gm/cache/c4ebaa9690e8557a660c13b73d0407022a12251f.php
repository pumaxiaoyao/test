<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner ">
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        setSideBar();
    });

    function setSideBar(){
        // 设置边栏的选择和特效
        var pathname = window.location.pathname;
        var paths = pathname.split("/");
        var cpath = (paths.length > 2)?[paths[1], paths[2]]:["home", "index"];// 获取不到时默认给首页的选择

        var menu = $("#side-toggler");
        
        menu.children('li').each(function () {
            if ($(this).attr("id") != undefined) {

                if ($(this).attr("id") == cpath[0]) {
                    $(this).addClass("start active open");
                } else {
                    $(this).removeClass("start active open");
                }
                
                var submenu = $(this).find(".sub-menu");
                if (submenu != undefined) {
                    var submethods = submenu.children('li');
                    submethods.each(function(){
                        if ($(this).attr("id") != undefined) {
                            if ($(this).attr("id") == cpath[1]) {
                                $(this).addClass("active");
                            } else {
                                $(this).removeClass("active");
                            }
                        } 
                    });  
                }
            }
        })
    }
</script>
