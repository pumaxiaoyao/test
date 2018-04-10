

<div class="as_fl20_right">
    <div class="as_fl20">
        <div class="as_cn">
            <div class="as_menu_icon  zx_icon " id="setting_memberlist_icon">
                <a id="setting_memberlist_bt" onclick="selectAgentSettingBox('memberlist')" class="as_info as_info_select">下线会员列表</a>
            </div>
            <div class="as_triangle_down" id="setting_history_icon">
                <a id="setting_history_bt" onclick="selectAgentSettingBox('history')" class="as_info">投注历史</a>
            </div>
            <div class="as_triangle_down" id="setting_daily_icon">
                <a id="setting_daily_bt" onclick="selectAgentSettingBox('daily')" class="as_info">每日报表</a>
            </div>
        </div>
    </div>
    <div class="as_fr80">
        <div style="padding:0px 10px;">
            <div id="setting_memberlist_box" class="setting_box_div">
                <div class="as_bet_zz">
                    <div class="as_bet_zz_title">
                        <h3>会员列表
                            <b>| 数据将有一定延迟，仅供参考，精确数据以月结为准。</b>
                        </h3>
                        <span>开始日期
                            <a>
                                <input type="text" class="Wdate" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', maxDate:'#F{$dp.$D(\'enddate\')}'&&'%y-%M-%d'})" id="startdate" style="width:100px" readonly=""
                            name="startdate" value="<?php echo date('Y-m-d', time() - 60 * 60 * 24 * 30); ?>" placeholder="">
                            </a>
                            结束日期
                            <a>
                                <input type="text" class="Wdate" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'#F{$dp.$D(\'startdate\')}', maxDate:'%y-%M-%d'})" id="enddate" style="width:100px" readonly=""
                                    name="enddate" value="<?php echo date('Y-m-d', time()); ?>" placeholder="">
                            </a>
                            <button id="history_Withdrawal" onclick="searchMember()">查询</button>
                            <a>会员总数：</a>
                            <a id="membercount"></a>
                        </span>
                    </div>
                    <div class="as_bet_zz_table">
                        <table id="MemberReportData">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th width="17%">会员账号</th>
                                    <th width="17%">真实姓名</th>
                                    <th>注册日期</th>
                                    <th>存款总额</th>
                                    <th width="10%">提款总额</th>
                                    <th width="10%">投注总额</th>
                                    <th width="10%">公司输赢</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="setting_history_box" class="setting_box_div">
                <div class="as_bet_zz">
                    <div class="as_bet_zz_title">
                        <h3>投注记录
                            <b>| 游戏平台数据有一定延迟，仅供参考。</b>
                        </h3>
                        <span>
                            <a>
                                <input type="text" id="account" name="account" value="" placeholder="账号" style="width:100px">
                            </a>
                            <a>
                                <select id="platform" name="platform" style="width:100px">
                                    <option value="">所有平台</option>
                                    <option value="IBC">体育</option>
                                    <option value="NB">牛博彩票</option>
                                </select>
                            </a>
                            <a>
                                <select id="choose" name="choose" style="width:100px">
                                    <option value="ClearDate">不筛选</option>
                                    <option value="today">今天</option>
                                    <option value="3days">三日内</option>
                                    <option value="week">一周内</option>
                                    <option value="month">一月内</option>
                                </select>
                            </a>
                            开始日期
                            <a>
                                <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', maxDate:'#F{$dp.$D(\'betenddate\')}'&&'%y-%M-%d'})" id="betstartdate" style="width:100px" readonly="" name="betstartdate"
                                    value="<?php echo date('Y-m-d', time() - 60 * 60 * 24 * 30); ?>" placeholder="">
                            </a>
                            结束日期
                            <a>
                                <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'#F{$dp.$D(\'betstartdate\')}', maxDate:'%y-%M-%d'})" id="betenddate" style="width:100px" readonly="" name="betenddate"
                                    value="<?php echo date('Y-m-d', time()); ?>" placeholder="">
                            </a>
                            <button id="history_Withdrawal" onclick="searchHistoryRecord()">查询</button>
                        </span>
                    </div>
                    <div class="as_bet_zz_table">
                        <table id="historyRecordData">
                            <thead>
                                <tr>
                                    <th>玩家账号</th>
                                    <th width="17%">注单号</th>
                                    <th width="17%">下注时间</th>
                                    <th>投注内容</th>
                                    <th>注单状态</th>
                                    <th width="10%">下注金额</th>
                                    <th width="10%">公司输赢</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="setting_daily_box" class="setting_box_div">
                <div class="as_bet_zz_title">
                    <h3>每日报表
                        <b>| 游戏平台数据有一定延迟，仅供参考。</b>
                    </h3>
                    <span>开始日期
                        <a>
                            <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', maxDate:'#F{$dp.$D(\'enddate\')}'&&'%y-%M-%d'})" id="startdate" style="width:100px" readonly="" name="startdate"
                                value="<?php echo date('Y-m-d', time() - 60 * 60 * 24 * 30); ?>" placeholder="">
                        </a>
                        结束日期
                        <a>
                            <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'#F{$dp.$D(\'startdate\')}', maxDate:'%y-%M-%d'})" id="enddate" style="width:100px" readonly="" name="enddate"
                                value="<?php echo date('Y-m-d', time()); ?>" placeholder="">
                        </a>
                        <button id="history_Withdrawal" onclick="searchDailyReport()">查询</button>
                    </span>
                </div>
                <div class="as_bet_zz_table" style="overflow:auto;width:100%">
                    <table id="DailyReportData">
                        <thead>
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
<!-- <script src="/static/js/member/accountSetting.js?201801050959"></script> -->