<div class="as_fl20_right">
    <div class="as_fl20">
        <div class="as_cn">
            <div class="as_menu_icon  zx_icon " id="setting_basicinfo_icon">
                <a id="setting_basicinfo_bt" onclick="selectSettingBox('basicinfo')" class="as_info as_info_select">基本信息</a>
            </div>
            <div class="as_triangle_down" id="setting_pwd_icon">
                <a id="setting_pwd_bt" onclick="selectSettingBox('pwd')" class="as_info">密码管理</a>
            </div>
            <div class="as_triangle_down" id="setting_phone_icon">
                <a id="setting_phone_bt" onclick="selectSettingBox('phone')" class="as_info">手机管理</a>
            </div>
            <div class="as_triangle_down" id="setting_mail_icon">
                <a id="setting_mail_bt" onclick="selectSettingBox('mail')" class="as_info">邮箱管理</a>
            </div>
        </div>
    </div>
    <div class="as_fr80">
        <div style="padding:0px 20px;">
            <div id="setting_basicinfo_box" class="setting_box_div" style="text-align: left;  display:block; ">
                <div class="as_info_xx" style="height:30px"></div>
                <div class="as_info_xx">
                    <div class="as_info_cns ">姓名：</div>
                    <div class="as_info_cn1" style=" letter-spacing: 2px; color: #444;">
                        @if (!$RealName)
                        <input name="FirstName" type="text" id="FirstName" placeholder="真实姓名" class="r_inptut inputwd300" style="width: 150px" />                        @endif
                        <input name="isFristName" type="hidden" id="isFristName" value="{{ $RealName }}" />
                        <div class="r_inptut " id="memberNamelab" style="display: inline-block;width: auto;">{{ $RealName }}</div>
                        <label id="FirstNamelab" class="as_info_tip">*仅允许修改一次，提款人姓名必须与注册姓名一致。</label>
                    </div>
                </div>
                <div class="as_info_xx">
                    <div class="as_info_cns">　</div>
                    <div class="as_info_cn1" style="line-height:40px; display:inline-block">
                        @if (!$RealName)
                        <button id="information_bt" type="button" class="as_but inputwd300"> 保存</button> @endif
                    </div>
                </div>
            </div>
            <div id="setting_pwd_box" class="setting_box_div">
                <div class="as_info_xx" style="height:30px"></div>
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">
                        原密码 ：
                        <input id="setting_pwd_box_oldpwd" class="r_inptut inputwd300" type="password" />
                    </div>
                    <div class="setting_pwd_box_row">
                        新密码 ：
                        <input id="setting_pwd_box_newpwd" class="r_inptut inputwd300" type="password" />
                    </div>
                    <div class="setting_pwd_box_row">
                        确认密码：
                        <input id="setting_pwd_box_newpwd2" class="r_inptut inputwd300" type="password" />
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="setting_pwd_box_submit" type="button" class="as_but inputwd300"> 完成</button>
                    </div>
                </div>
            </div>
            <div id="setting_mail_box" class="setting_box_div">
                <div class="as_info_xx" style="height:30px"></div>
                @if (!$Email)
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">
                        邮箱地址 ：
                        <input id="setting_mail_box_mailnumber" class="r_inptut inputwd300" type="text" />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input id="setting_mail_box_code" class="r_inptut inputwd300" type="text" style="width:177px;vertical-align: middle;" />
                        <span class="setting_phone_tip">
                                    <a id="GetEmailCodeBt">获取验证码</a>
                                    <b id="GetEmailTime" style="display: none; "><span class="time_sec" id="emailTiming">60</span>s</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="setting_mail_box_submit" type="button" class="as_but inputwd300">完成</button>
                    </div>
                </div>
                @else
                <div class="bindinfo_box" id="isemail_box">
                    <div>
                        <img src="/static/img/icons_03.png" /> <br />
                        <span style="color:#808080;">阁下已绑定的邮箱</span><br />
                        <span>{{ $Email }}</span>
                    </div>
                    <div id="change_email_bt" style="margin-top:10px;" class="centered  as_but inputwd300">
                        更换绑定的邮箱
                    </div>
                </div>
                <div id="reemail_box" style="display:none;" class="from_Centered">
                    <div class="setting_pwd_box_row">
                        邮箱地址 ：
                        <input id="setting_mail_box_mailnumber" readonly="readonly" value="{{ $Email }}" class="r_inptut inputwd300" type="text"
                        />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input id="re_email_code" class="r_inptut inputwd300" type="text" style="width:177px;vertical-align: middle;" />
                        <span class="setting_phone_tip">
                                <a id="GetUnEmailCodeBt">获取验证码</a>
                                <b id="GetEmailTime" style="display: none; "><span class="time_sec" id="emailTiming">60</span>s</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="re_email" type="button" class="as_but inputwd300">解绑</button>
                    </div>
                </div>
                @endif
            </div>
            <div id="setting_phone_box" class="setting_box_div">
                <div class="as_info_xx" style="height:30px"></div>
                @if (!$Phone)
                <div class="from_Centered">
                    <div class="setting_pwd_box_row">
                        手机号码 ：
                        <input id="setting_phone_box_phonenumber" class="r_inptut inputwd300" type="text" />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input id="setting_phone_box_code" class="r_inptut inputwd300" type="text" style="width:177px;vertical-align: middle;" />
                        <span class="setting_phone_tip">
                                    <a id="GetPhoneCodeBt">获取验证码</a>
                                    <b id="GetPhoneTime" style="display: none; "><span class="time_sec" id="phoneTiming">60</span>s</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="setting_phone_box_submit" type="button" class="as_but inputwd300">完成</button>
                    </div>
                </div>
                @else
                <div class="bindinfo_box" id="ismobile_box">
                    <div>
                        <img src="/static/img/secure_phone.png" /> <br />
                        <span style="color:#808080;">阁下已绑定的手机</span><br />
                        <span>{{ $Phone }}</span>
                    </div>
                    <div id="change_phone_bt" style="margin-top:10px;" class="centered as_but inputwd300">
                        更换绑定的手机
                    </div>
                </div>
                <div id="remobile_box" style="display:none;" class="from_Centered">
                    <div class="setting_pwd_box_row">
                        手机号码：
                        <input id="setting_phone_box_phonenumber" value="{{ $Phone }}" readonly="readonly" class="r_inptut inputwd300" type="text"
                        />
                    </div>
                    <div class="setting_pwd_box_row">
                        验证码：
                        <input id="re_phone_code" class="r_inptut inputwd300" type="text" style="width:177px;vertical-align: middle;" />
                        <span class="setting_phone_tip"><a id="GetUnPhoneCodeBt">获取验证码</a>  <b id="GetPhoneTime" style="display: none; "><span class="time_sec" id="phoneTiming">60</span>s</b>
                        </span>
                    </div>
                    <div class="setting_pwd_box_row">
                        <button id="re_phone" type="button" class="as_but inputwd300">解绑</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>