    
    <link href="/static/css/foot.css" rel="stylesheet" />
    <div class="ft_content_black" style="font-size:12px;">
        <div class="ft_cn" style="height: 240px;">
            <div>
                <div class="fl33">
                    <div style="margin:5px 0 10px 0">
                        <img src="/static/img/beplay_logo_031.png" />
                    </div>
                    <div style="color: #a0adc3; line-height: 30px; margin-top: 5px; "> Beplay 是注册于欧洲 马耳他 的合法博彩公司。受马耳他博彩管理委员会(MGA)及其政府监管并遵守欧洲游戏和博彩协会(EGBA)制定的行为和准则</div>
                    <div class="ft_mg34">
                        <a href="/help/default?id=1">如何存款</a>
                        <a href="/help/default?id=2">如何提款</a>
                        <a href="/help/default?id=3">游戏帮助</a>
                        <a href="/help/default?id=4">博彩责任</a>
                        <!-- <a href="/" style="margin-left: -5px; margin-right: 0" target="_blank">AbetLife</a> -->
                    </div>
                    <div class="ft_mg34">
                        <a href="/help/default?id=5">隐私保护</a>
                        <a href="/help/default?id=6">关于我们</a>
                        <a href="/help/default?id=7">联系我们</a>
                        <!-- <a onclick="joinusaff()">加入合营</a> -->
                        <a href="/agent/index">加入合营</a>
                    </div>
                </div>
                <div class="fl33">
                    <div class="ft_gz " style="margin-top: 10px; margin-left: 40px;">合作伙伴</div>
                    <!--<a class="r_icon fs_ya"></a>-->
                    <div style=" clear: both;margin-left: 40px;">
                        <img src="/static/img/ft_gz.png" />
                    </div>
                </div>
                <div class="fl33">
                    <div class="ft_gz " style="margin-top: 10px; margin-left: 40px;">喜欢就分享我们</div>
                    <div style=" margin-left: 40px;">
                        <a class="r_icon fs_weibo mg35"></a>
                        <a class="r_icon fs_qqkj mg35"></a>
                        <a class="r_icon fs_pyq mg35"></a>
                        <a class="r_icon fs_weixin2 mg35"></a>
                        <a class="r_icon fs_qq "></a>
                    </div>
                    <div style=" margin-left: 40px;height: 40px; line-height: 40px; clear: both; color: #a0adc3">浏览器 ( 为了获取更好的体验,建议下载以下浏览器进行游戏 )</div>
                    <div style=" margin-left: 40px;">
                        <a class="r_icon fs_360"></a>
                        <a class="r_icon fs_ie"></a>
                        <a class="r_icon fs_chorom"></a>
                        <a class="r_icon fs_firefox"></a>
                    </div>
                    <div style=" margin-left: 40px;height: 40px; line-height: 40px; clear: both; color: #a0adc3">版权所有 © 2016-2026 BEPLAY 保留所有权</div>
                </div>
            </div>
        </div>
    </div>
    <!--滚动顶部-->
    <div class="fixed_div">
        <div class="fixed_top"></div>
    </div>
    <!-- 滚动顶部结束-->
    <script>
        $(document).ready(function () {
        $('.fixed_top').click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        });
        $('.fixed_qrcode_div ul li').mouseover(function (e) {
            var num = $(this).attr('data-id');
            $(this).addClass('on').siblings().removeClass('on');
            $('.qrcode_nr').hide();
            $('.qrcode_' + num).show();
            e.stopPropagation()
        })
    });
    </script>