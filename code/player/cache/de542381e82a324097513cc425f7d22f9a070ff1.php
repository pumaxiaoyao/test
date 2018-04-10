<div class="r_content">
    <!--内容-->
    <div class="r_content_fixed">
        <div class="r_content_box">
            <div class="r_logo"><a href="/"><img src="/static/img/player/reglogin.png"></a></div>
            <div class="login_img"><img src="/static/img/player/regfont.png " width="398" height="49"></div>
            <div class="r_login radius">
                <div style="font-size: 18px; color: #ffffff">
                    登录
                </div>
                <div class="mg10">
                    <div class="r_name radius" style="margin-top: 31px;">
                        <label class="r_icon r_s_name r_s_ps"></label>
                        <input id="login_username" name="login_username" placeholder=" 用 户 名" class="r_inptut pd35 wid317" type="text" />
                    </div>
                    <div style="text-align: left;">
                        <div id="login_username_error" style="display:none;position: relative" class=" r_s_error">
                            <div class="e_icon"></div>用户名不能为空</div>
                    </div>
                </div>
                <div class="mg10">
                    <div class="r_name radius">
                        <label class="r_icon r_s_pwd r_s_ps"></label>
                        <input id="login_password" name="login_password" placeholder=" 密 码" class="r_inptut pd35 wid317" type="password" />
                    </div>
                    <div style="text-align: left;">
                        <div id="login_password_error" style="position: relative;display:none;" class="r_s_error">
                            <div class="e_icon"></div>密码不能为空</div>
                    </div>
                </div>
                <div class="submit_blue_bt" style=" margin-top:25px;" id="lg_submit">登 录</div>
                <div class="login_box_foot">
                    <span class="login_box_foot_regist"><a class="login_box_foot_regist_link" href="Registered">注册账号</a></span>
                    <a href="Retrieve" class="login_box_foot_lostpwd">忘记密码?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<video id="video-bg" muted autoplay loop>
    <source src="/static/img/player/login_video.mp4" type="video/mp4">
</video>