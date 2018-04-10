<div class="container" style="text-align: center;">
    <div class="find_pwd_box">
        <div class="find_pwd_step">
            <div class="find_pwd_line">
                <div class="on">
                    <span>1</span>
                    <p>填写验证码</p>
                </div>
                <div>
                    <span>2</span>
                    <p>修改密码</p>
                </div>
                <div>
                    <span>3</span>
                    <p>完成</p>
                </div>
            </div>
        </div>
        <div class="find_pwd_step_one">
            <div class="find_pwd_iphone">
                <h3>
                    <i></i>手机找回密码</h3>
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">
                        手机号码：
                        <input id="rest_phonenumber" class="r_inptut inputwd300" type="text" />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input class="r_inptut inputwd300" id="rest_phonecode" type="text" style="width:177px;vertical-align: middle;">
                        <span class="setting_phone_tip">
                                <div style="cursor:pointer;" id="GetPhoneCodeBt">获取验证码</div>
                                <b style="display:none" id="GetPhoneTime">
                                    <span class="time_sec" id="phoneTiming">60</span> 秒后重新发送</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="check_phonenumber" type="button" class="as_but inputwd300"> 下一步</button>
                    </div>
                </div>

            </div>
            <div class="find_pwd_email">
                <h3>
                    <i></i>邮箱找回密码</h3>
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">
                        邮箱账号：
                        <input id="rest_emailnumber" class="r_inptut inputwd300" type="text" />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input id="rest_emailcode" class="r_inptut inputwd300" type="text" style="width:177px;vertical-align: middle;">
                        <span class="setting_phone_tip">
                                <div style="cursor:pointer;" id="GetEmailCodeBt">获取验证码</div>
                                <b id="GetEmailTime" style="display: none; ">
                                    <span class="time_sec" id="emailTiming">60</span> 秒后重新发送</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="check_emailnumber" type="button" class="as_but inputwd300"> 下一步</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="find_pwd_step_two" style="display:none">
            <div class="from_Centered find_pwd_newpws ">
                <h3>
                    <i></i>创建新密码:</h3>
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">　　新密码：
                        <input id="rest_password" class="r_inptut inputwd300" type="password" style="width:220px;">
                    </div>
                    <div class="setting_pwd_box_row">确认新密码：
                        <input id="rest_comfpassword" class="r_inptut inputwd300" type="password" style="width:220px;vertical-align: middle;">
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="restpwd_submit" type="button" class="as_but inputwd300"> 下一步</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="find_pwd_step_three" style="display:none">
            <div class="from_Centered find_pwd_end ">
                <div class="setting_pwd_box_row">
                    <h3>
                        <i>
                                <img src="../../static/img/pwd_ok.png" />
                            </i>密码修改成功！</h3>
                    <button type="button" class="as_but inputwd300" onclick="javascript:window.location.href='/player/Login'">使用新密码登录</button>
                </div>
                <div style="display:none;" class="setting_pwd_box_row">
                    <h3>
                        <i>
                                <img src="../../static/img/pwd_help.png" />
                            </i>因您尚未绑定手机和邮箱，无法使用自助找回密码服务。
                        <br />请使用人工审核找回密码。</h3>
                    <button type="button" class="as_but inputwd300 rg_but"> 进入人工审核</button>
                </div>
            </div>
        </div>
    </div>
</div>