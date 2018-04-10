
    <div class="r_content">
        <!--内容-->
        <div class="r_content_fixed">
            <div class="r_content_box">
                <div class="r_logo"><a href="/"><img src="/static/img/player/reglogin.png"></a></div>
                <div class="login_img"><img src="/static/img/player/regfont.png " width="398" height="49"></div>
                <div class="r_content_box">
                    <div class="r_rigest radius">
                        <div style="font-size: 18px; color: #ffffff">注册</div>
                        <div class="mg10">
                            <div class="r_name radius" style="margin-top: 20px;">
                                <label class="r_icon r_s_name r_s_ps"></label>
                                <input placeholder=" 用 户 名" class="r_inptut pd35" id="userName" type="text" maxlength="16" />
                            </div>
                            <div class="r_s_box">
                                <div class="r_s_tips" id="user_Error">*用户名由5-15个字符（A-Z ,a-z,0-9）组成</div>
                            </div>
                        </div>
                        <div class="mg10">
                            <div class="r_name radius">
                                <label class="r_icon r_s_pwd r_s_ps"></label>
                                <input placeholder=" 密 码" class="r_inptut pd35" id="Password" type="password" maxlength="20" />
                            </div>
                            <div class="r_s_box">
                                <div class="r_s_tips" id="password_Error">*密码由8-20个字符组成,区分大小写</div>
                            </div>
                        </div>
                        <div class="mg10">
                            <div class="r_name radius">
                                <label class="r_icon r_s_pwd r_s_ps"></label>
                                <input placeholder=" 确 认 密 码" id="Passwordcof" class="r_inptut pd35" type="password" maxlength="20" />
                            </div>
                            <div class="r_s_box">
                                <div class="r_s_tips" id="passwordcof_Error">*请再次输入密码</div>
                            </div>
                        </div>
                        <div style="padding-left:6px; margin-top:10px;" class="mg10" id="embed-captcha">
                        </div>
                        <div class="reg_tk">
                            <input checked="checked" type="checkbox" style=" vertical-align: baseline;width: 16px;" /> 我已阅读并同意相关的条款和隐私政策。
                        </div>
                        <div style="margin-top: 20px;">
                            <button class="submit_blue_bt" id="submit_rg">注 册</button>
                        </div>
                        <div class="reg_font">
                            <div>已有账号? 请<a class="login_box_foot_regist_link" href="Login">登录</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <video id="video-bg" muted="muted" autoplay="autoplay" loop="loop">
        <source src="/static/img/player/login_video.mp4" type="video/mp4" />
    </video>
    
