<div class="as_fl20_right">
    <div class="as_fl20">
        <div class="as_cn">
            <div class="as_menu_icon  zx_icon " id="setting_tk_icon">
                <a id="setting_tk_bt" onclick="selectAgentSettingBox('tk')" class="as_info as_info_select">提交提款</a>
            </div>
            <div class="as_triangle_down" id="setting_wdHistory_icon">
                <a id="setting_wdHistory_bt" onclick="selectAgentSettingBox('wdHistory')" class="as_info">提款历史</a>
            </div>
        </div>
    </div>
    <div class="as_fr80">
        <div style="padding:0px 10px;">
            <div id="setting_tk_box" class="setting_box_div">
                <div class="tk_nr">
                    <div class="as_bet_zz">
                        <div class="as_bet_zz_title1">
                            <h3>提交提款
                                <b>| 通常您的提款只需3-15分钟即可到账，若超过30分钟仍未到账，请联系在线客服核查。</b>
                            </h3>
                        </div>
                    </div>
                    <div class="tk_box">
                        <div class="tk_jr">
                            <span class="text">提款金额：</span>
                            <span class="input">
                                    <input name="ctl01" id="withdrawalMoney" type="number" onKeyUp="amount(this)" onBlur="overFormat(this)" placeholder="金额"
                                        class="r_inptut inputwd300" />
                                </span>
                        </div>
                        <div class="tk_ts">
                            <span id="withdrawalMoney_tips" class="text">最低提款值金额不能低于100元</span>
                        </div>
                        <div class="tk_yh">
                            <span class="text">选择银行：</span>
                            <span class="radio" id="wd_radios">
                                    <!-- <div class="deposit_atmsel_icon_i">         -->
                                    %ALLCARDSINFO%
                                    <!-- </div> -->
                                </span>
                        </div>
                        <div>
                            <button type="button" id="withdrawal_submit" class="as_but inputwd300">提交提款</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="setting_wdHistory_box" class="setting_box_div">
                <div class="as_bet_zz">
                    <div class="as_bet_zz_title1">
                        <h3>提款历史
                            <b>| 我来证明您的钱已到账。</b>
                        </h3>
                    </div>
                    <div class="as_bet_zz_table">
                        <table id="wdHistoryData">
                            <thead>
                                <tr>
                                    <th>申请时间</th>
                                    <th width="17%">单号</th>
                                    <th width="17%">提款金额</th>
                                    <th>手续费</th>
                                    <th>实际金额</th>
                                    <th width="10%">状态</th>
                                    <th width="10%">备注</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>