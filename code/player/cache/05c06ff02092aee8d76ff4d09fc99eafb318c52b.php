<div class="mod-reg">
    <div class="layout">
        <div class="hd">
            <h3>合营申请表</h3>
            <p>（请详细填写以下表格，带
                <em class="cRed">*</em> 项目为必填项目）</p>
        </div>
        <form id="agentReg" method="post" action="/agents/agentReg">
            <fieldset>
                <legend>账户资料</legend>
                <ul class="mod-forms">
                    <li id="agentBoss">
                        <label>
                            <em class="cRed">*</em> 上级代理</label>
                        <div class="item-ipt">
                            <input type="text" id="bossAname" name="bossAname" value="" maxlength="50" class="txt-ipt" />
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 代理账号</label>
                        <div class="item-ipt">
                            <input type="text" name="aname" maxlength="50" class="txt-ipt" />
                            <!-- input 触发焦点时出现tips -->
                            <p>
                                <span class="tips">请输入4-12个字符, 仅可输入英文字母以及数字的组合</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 密码</label>
                        <div class="item-ipt">
                            <input type="password" id="apwd" name="apwd" maxlength="50" class="txt-ipt" />
                            <p>
                                <span class="tips">密码长度为6-16个字符,以及必须含有字母和数字的组合</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 确认密码</label>
                        <div class="item-ipt">
                            <input type="password" name="password1" maxlength="50" class="txt-ipt" />
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 真实姓名</label>
                        <div class="item-ipt">
                            <input type="text" name="realname" maxlength="50" class="txt-ipt" />
                            <p>
                                <span class="tips">必须与取款银行卡姓名一致</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 邮箱地址</label>
                        <div class="item-ipt">
                            <input type="text" name="email" maxlength="50" class="txt-ipt" />
                            <p>
                                <span class="tips">请务必输入真实有效的邮箱地址，以便我们联系开通合营代理事宜</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 手机号</label>
                        <div class="item-ipt">
                            <input type="text" name="aphone" maxlength="50" class="txt-ipt" />
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em>QQ号</label>
                        <div class="item-ipt">
                            <input type="text" name="qq" maxlength="50" class="txt-ipt" />
                        </div>
                    </li>
                    <li>
                        <label>
                            <em class="cRed">*</em> 验证码</label>
                        <div class="item-ipt">
                            <input type="text" where="pa" name="verifycode" id="captcha_text" maxlength="50" class="txt-ipt" style="width: 100px;" />
                            <img id="captcha" onclick="get_captcha();">
                            <span id="captcha_text-error"></span>
                        </div>
                    </li>
                </ul>
            </fieldset>
            <div class="agreement">
                <input type="checkbox" name="iagree" value="1" checked="checked"> 我已阅读并同意
                <a target="_blank" href="/agent/home/agreement">"合营条款和条件"</a>。
                <br/>
                <input type="checkbox" checked="checked"> 我已年满18周岁
            </div>
            <div class="reg-sub">
            <a id="agent_reg_btn" href="javascript:void (0);" onclick="reg_agent('<?php echo e(isset($agentboss) ? $agentboss : ""); ?>');" class="btn-sub">提交申请</a>
            </div>
        </form>
    </div>
</div>
</div>