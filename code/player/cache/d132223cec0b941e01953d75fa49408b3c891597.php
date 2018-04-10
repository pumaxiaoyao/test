<div class="nr_history_right">
    <div class="ck_nr">
        <div class="as_fl20">
            <div class="as_cn">
                <!-- <div class="as_triangle_down" id="setting_wybank_icon">
                        <a id="setting_fastpay_bt" onclick="selBankType(this,'bank')" class="as_info">极速转账</a>
                    </div> -->
                <div class="as_triangle_down " id="setting_fastpay_icon">
                    <a id="setting_thirdpay_bt" onclick="selBankType('#setting_thirdpay_bt','third')" class="as_info">第三方支付</a>
                </div>
                
                <input type="hidden" value="bank" id="paymentType" />
            </div>
        </div>
        <div class="as_fr80">
            <div class="bank_prompt" style="display:none;">
                <div class="step-1">
                    <h3>正在与银行通讯...</h3>
                    <b class="time"></b>
                    <div class="bank_prompt_img"><img src="/static/img/player/bank_prompt.png" /></div>
                    <div class="bank_prompt_div">
                        <span>成功付款后,将会自动到账,并弹出到账提示<br />
                             长时间无反应，请<a onclick="openServiceBox()" class="a">联系客服</a></span>
                    </div>
                </div>
                <div class="step-2" style="display:none;">
                    <div class="logo-th-3"></div>
                    <h3>订单已失效</h3>
                    <p>非常抱歉，由于长时间没有检测到您的存款，<br />订单已经失效，请再次尝试存款</p>
                    <div class="b1">
                        <div onclick="window.location.reload();" class="as_but inputwd140">再存一次</div><a onclick="openServiceBox()" class="a">联系客服</a>
                    </div>
                </div>
                <div class="step-3" style="display:none;">
                    <div class="logo-right-3"></div>
                    <h3>恭喜您，已有一笔存款成功充值！</h3>
                    <ul class="ls">
                        <li>
                            <span class="v amount">0.00</span><span class="k">充值金额</span>
                        </li>
                        <li>
                            <span class="v fee">0.00</span><span class="k">充值优惠</span>
                        </li>
                        <li>
                            <span class="v netamount">0.00</span><span class="k">实际到帐</span>
                        </li>
                    </ul>
                    <div class="b1">
                        <div onclick="window.location.reload()" class="as_but inputwd140">我知道了</div>
                        <a onclick="window.location.reload()" class="btnClose">再存一次</a>
                    </div>
                </div>
            </div>
            <div id="deposit_from" style="display:block; text-align: left;">
                <div class="fastpay_box">
                    <!-- <div class="tk_jr" id="common_deposit">
                            <span class="text">存款金额：</span><span class="input">
                                <input name="ctl01" type="text" id="depositMoney" placeholder="金额" class="r_inptut inputwd300" onKeyUp="amount(this)" onBlur="overFormat(this)" maxlength="8"/>
                            </span>
                        </div> -->
                    <div class="tk_jr" id="third_deposit">
                        <span class="text">存款金额：</span><span class="input">
                                <input name="ctl01" type="text" id="depositMoney" placeholder="金额" class="r_inptut inputwd300" onBlur="overFormat(this)" maxlength="8"/>
                                <!-- <input name="ctl01" type="text" id="depositMoney" placeholder="金额" class="r_inptut inputwd300" onKeyUp="amount(this)" onBlur="overFormat(this)" maxlength="8"/> -->
                            </span>
                    </div>
                    <div class="tk_ts"><span id="depositMoney" class="text">存款每次最低100</span></div>
                    <div class="tk_num" id="setmoneyDiv"></div>
                    <div id="bankSelectRow" class="tk_yh deposit_atmsel_icon">
                        <span class="text">选择银行：</span>

                        <span class="radio">
                                    <label class="on">
                                        <input checked type="radio" name="radiogroup1" value="ICBC" /><b><i class="deposit_atmsel_icon_i ICBC"><img  /></i>工商银行</b></label>
                                    <label>
                                        <input type="radio" name="radiogroup1" value="CCB"><b><i class="deposit_atmsel_icon_i CCB"><img  /></i>建设银行</b></label>
                                    <label>
                                        <input type="radio" name="radiogroup1" value="ABC"><b><i class="deposit_atmsel_icon_i ABC"><img  /></i>农业银行</b></label>
                                    <label>
                                        <input type="radio" name="radiogroup1" value="BOC"><b><i class="deposit_atmsel_icon_i BOC"><img  /></i>中国银行</b></label>
                                    <span class="otherbank">
                                        <label>
                                            <input type="radio" name="radiogroup1" value="POST"><b><i class="deposit_atmsel_icon_i POST"><img  /></i>中国邮政</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="CMBC"><b><i class="deposit_atmsel_icon_i CMBC"><img  /></i>招商银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="PINGAN"><b><i class="deposit_atmsel_icon_i PINGAN"><img  /></i>平安银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="BOCO"><b><i class="deposit_atmsel_icon_i BOCO"><img  /></i>交通银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="CMSB"><b><i class="deposit_atmsel_icon_i CMSB"><img  /></i>民生银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="CEBB"><b><i class="deposit_atmsel_icon_i CEBB"><img  /></i>光大银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="ECITIC"><b><i class="deposit_atmsel_icon_i ECITIC"><img  /></i>中信银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="CIB"><b><i class="deposit_atmsel_icon_i CIB"><img  /></i>兴业银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="GDB"><b><i class="deposit_atmsel_icon_i GDB"><img  /></i>广发银行</b></label>
                                        <label>
                                            <input type="radio" name="radiogroup1" value="HXB"><b><i class="deposit_atmsel_icon_i HXB"><img  /></i>华夏银行</b></label>
                                    </span>
                        <b class="morebank" id="morebank">展开所有银行</b>
                        </span>
                    </div>
                    <div id="ATMBankSelectRow" style="display:none;" class="tk_yh">
                        <!-- <span class="text">选择银行：</span>
                            <span  class="radio">
                                <label class="deposit_atmsel_icon on">
                                    <input checked type="radio" data-url="http://www.icbc.com.cn/" name="radiogroup2" value="ICBC" /><b><i class="deposit_atmsel_icon_i ICBC"><img  /></i>工商银行</b></label>
                                <label class="deposit_atmsel_icon">
                                    <input type="radio" name="radiogroup2" data-url="http://www.ccb.com/" value="CCB" /><b><i class="deposit_atmsel_icon_i CCB"><img  /></i>建设银行</b></label>
                                <label class="deposit_atmsel_icon">
                                    <input type="radio" name="radiogroup2" data-url="http://www.abchina.com/" value="ABC" /><b><i class="deposit_atmsel_icon_i ABC"><img  /></i>农业银行</b></label>
                                <label class="deposit_atmsel_icon">
                                    <input type="radio" name="radiogroup2" data-url="http://www.boc.cn/" value="BOC" /><b><i class="deposit_atmsel_icon_i BOC"><img  /></i>中国银行</b></label>
                                <label class="deposit_atmsel_icon">
                                    <input type="radio" name="radiogroup2" value="OTHER" /><b>其他银行</b></label>
                            </span> -->
                    </div>
                    <div>
                        <button type="button" id="deposit_bt" class="as_but inputwd300">立即存款</button>
                    </div>
                    <div id="thirdinfo"></div>
                </div>
            </div>
            <div id="setting_wybank_box" style="display:none; " class="deposit_bankcard">
                <div class="bank_info">
                    <div class="bank_pic">
                        <h3>订单已经建立, 请尽快完成存款。</h3>
                        <span class="text">请转账至下列账户中:</span>
                        <div class="pic">
                            <div class="pic_bankname">
                                <div id="bankIcon" class="b_icon"></div><i id="atm_bankname"></i></div>
                            <span>* 姓名 :   <i id ="atm_name"></i> <strong id="atm_name_copy">复制</strong></span>
                            <span>* 账号 :   <i id ="atm_cardnumber"></i> <strong id="atm_cardnumber_copy">复制</strong></span>
                            <span>* 金额 :   <i id ="atm_money"></i><strong id="atm_money_copy">复制</strong></span>
                            <span>* 地址 :   <i id ="atm_address"></i><strong id="atm_address_copy">复制</strong></span>
                            <span class="green">* 附言 :   <i id ="atm_comments"></i><strong id="atm_comments_copy">复制</strong></span>
                        </div>
                        <p class="bank_p_text">
                            <strong>重要提示!</strong> * <b>请勿使用支付宝，微信等转账到银行账号</b>
                            <br /> * 转账时<b>请务必填写正确的附言</b>, 存款才能秒到!
                            <br /> * 不知道如何存款? 请查看我们的”<a href="/help/default.aspx?id=1">存款教程</a>”。
                            <br /> * 请及时前往存款，附言有效时间只有20分钟。
                        </p>
                        <button type="button" id="goto_bankweb" class="as_but inputwd300">立即去银行充值</button>
                    </div>
                    <div class="bank_text">
                        <!--  <h3>订单已经建立, 请尽快完成存款。</h3> -->
                        <div class="help-bank">
                            <h4></h4>
                            <p class="text">存款教程</p>
                            <div id="pj-lunbo">
                                <div class="pj-Carousel">
                                    <div class="pj-Carousel-box">
                                        <div class="pj-Carousel-item"><img src="/static/img/player/help_bank01.png" /></div>
                                        <div class="pj-Carousel-item"><img src="/static/img/player/help_bank02.png" />
                                            <br />
                                            <p>注意: 请直接复制收款人信息, 填到对应的表单, 为了保证到账速度, 一定 要选择“加急”哦 </p>
                                        </div>
                                        <div class="pj-Carousel-item"><img src="/static/img/player/help_bank03.png" /><br />
                                            <p>
                                                注意: <br /> ① 一定要填写正确的附言, 存款才能秒到!<br /> ② 该教程页面只是案例展示, 实际附言请以页面显示的为准
                                            </p>
                                        </div>
                                    </div>
                                    <!--状态-->
                                    <div class="pj-Carousel-active"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="setting_bigalipay_box" style="display:none; " class="deposit_bankcard">
                <div class="bank_info">
                    <div class="bank_pic">
                        <h3>订单已经建立, 请尽快扫码支付。</h3>
                        <div class="pic">
                            <div class="b_icon"><img src="/static/img/player/bigalipaycode.jpg" /></div>
                            <span class="blue">充值金额：<b id ="bigalipay_money"></b></span>
                            <span class="blue">　　附言：<b id ="bigalipay_comments"></b></span>
                        </div>
                        <p class="bank_p_text">
                            <strong>重要提示!</strong> * 转账时<b>请务必填写正确的金额跟附言</b>, 存款才能秒到！
                        </p>
                    </div>
                    <div class="bank_text">
                        <div class="help-bank">
                            <img src="/static/img/player/bigalipayhelp.png" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div id="deposit_disabled" style="display: none;" class="deposit_not_available">
                    <img class="deposit_not_available_img" src="/static/img/player/WH_icon_06.png" /><br />
                </div>
                 -->
            <div id="deposit_maintain" style="display: none;" class="deposit_not_available">
                <img class="deposit_not_available_img" src="/static/img/player/WH_icon_06.png" /><br />
            </div>
        </div>
    </div>
</div>
</div>
</div>