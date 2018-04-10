<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家资金调整</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href="#ConfigBl" data-toggle="modal" onclick="selectid(1);" class="btn blue">调整余额</a> &nbsp;
                        <a href="#ConfigRl" data-toggle="modal" onclick="selectid(2);" class="btn red">调整红利金额</a> &nbsp;
                        <a href="#ConfigRlLL" data-toggle="modal" onclick="selectid(3);" class="btn green">批量调整红利</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/playerfund/dptCorrectionAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <input type="hidden" name="ptype" id="ptype" />
                    <div class="form-group">
                        <input name="fs_ptype" checked type="checkbox" value="Deposit">存款
                        <input name="fs_ptype" checked type="checkbox" value="Withdrawal">取款
                        <input name="fs_ptype" checked type="checkbox" value="Adjustment">红利 </div>
                    <div class="form-group">
                        <select name="" id="s_TimeFli" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                                <option value="ClearDate">不筛选</option>
                                <option value="Today">今日</option>
                                <option value="Yesterday">昨日</option>
                                <option value="LastWeek">上周</option>
                                <option value="LastMonth">上月</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="s_StartTime" id="s_StartTime" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="开始时间">
                    </div>
                    <div class="form-group">
                        <input type="text" name="s_EndTime" id="s_EndTime" class="form-control input-inline input-small input-sm datepicker" placeholder="结束时间">
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                                <option value="account">账号</option>
                                <option value="name">姓名</option>
                                <option value="agentName">代理</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                                搜索 &nbsp;
                                <i class="fa fa-search"></i>
                            </button>
                    </div>
                </form>
                <div class="note note-success">
                    <div>
                        <label>本页总额:</label>
                        <label>手工存款:</label>
                        <label class="label label-success" id="pdpt"></label>
                        <label>手工扣款:</label>
                        <label class="label label-success" id="pwtd"></label>
                        <label>手工红利:</label>
                        <label class="label label-success" id="pbonus"></label>
                    </div>
                    <div style="padding-top: 10px;">
                        <label>搜索结果统计:</label>
                        <label>手工存款:</label>
                        <label class="label label-success" id="dpt"></label>
                        <label>手工扣款:</label>
                        <label class="label label-success" id="wtd"></label>
                        <label>手工红利:</label>
                        <label class="label label-success" id="bonus"></label>
                    </div>
                </div>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>玩家组</th>
                            <th>代理</th>
                            <th>金额</th>
                            <th>类型</th>
                            <th>操作</th>
                            <th>备注</th>
                            <th>关联活动</th>
                            <th>处理时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="ModelPlayer" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="myModalLabel">搜索用户</h3>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" onclick="selectPlayer(this);">选择该用户</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ConfigBl" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="myModalLabel">调整余额</h3>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="horizontal-form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a data-toggle="modal" class="btn blue" data-toggle="modal" data-target="#ModelPlayer" href="/player/playerListModel">选择用户</a>
                                        <span id="user1" userid="0"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="form-section">
                                            <hr> 调整账户余额 </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">加减</label>
                                            <select class="form-control" id="atype1">
                                                    <option value="1">+</option>
                                                    <option value="2">-</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">数值</label>
                                            <input type="text" id="ja1" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">银行卡</label>
                                            <select class="form-control" id="cardId">
                                                    <option limit="100000.00" balance="933381.5700" value="3000">
                                                        存款-卡尼奥普-智付3.0-卡尼奥普 - (933,381.57)</option>
                                                    <option limit="100000.00" balance="260644.1300" value="3002">
                                                        存款-LY-依儿-微信支付-lo** - (260,644.13)</option>
                                                    <option limit="100000.00" balance="633698.5300" value="3005">
                                                        存款-QQ微信支付宝扫码-支付宝-888888 - (633,698.53)</option>
                                                    <option limit="100000.00" balance="9506.6100" value="3008">
                                                        存款-用于旧路易会员转移额度至新路易-中国农业银行-000000000 - (9,506.61)</option>
                                                    <option limit="300000.00" balance="348895.9200" value="3009">
                                                        存款-王轶兵-上海浦东发展银行-6217933180010298 - (348,895.92)</option>
                                                    <option limit="300000.00" balance="3762348.5600" value="3010">
                                                        存款-王轶兵-中国招商银行-6214834316226456 - (3,762,348.56)</option>
                                                    <option limit="10000000.00" balance="3737.0000" value="3011">
                                                        存款-i12-速汇宝-6000016833 - (3,737.00)</option>
                                                    <option limit="300000.00" balance="0.0000" value="3012">
                                                        取款-李想-上海浦东发展银行-6217933180066670 - (0.00)</option>
                                                    <option limit="300000.00" balance="0.0000" value="3013">
                                                        取款-徐立洋-中国招商银行-6214833116622971 - (0.00)</option>
                                                    <option limit="300000.00" balance="586241.0000" value="3014">
                                                        存款-张增有-中国建设银行-6236683140002095158 - (586,241.00)</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="float:right;margin-right: 5px;">
                                    <label id="showLimit" style="color: #ff0000;display: none;"></label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="form-section">
                                            <hr> 调整取款流水条件 </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">取款流水倍数</label>
                                            <input type="text" id="jb1" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">确认</label>
                                            <input type="text" id="jc1" readonly value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">加减</label>
                                            <select class="form-control" id="jj1">
                                                    <option value="1">+</option>
                                                    <option value="2">-</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">数值</label>
                                            <input type="text" id="jz1" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">确认</label>
                                            <input type="text" readonly id="jv1" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="form-control" id="gpid1">
                                                <option value="0">不限平台</option>
                                                <option value="IBC">沙巴体育</option>
                                            </select>
                                    </div>
                                    <!--                                <div class="col-md-12">
                                    <select class="form-control" id="actid1">
                                        <option value="0">无活动</option>
                                                                            <option value="374335100697333760">电话回访</option>
                                                                            <option value="374336017039511552">诚招代理商</option>
                                                                            <option value="374340225297965056">次次存次次送</option>
                                                                            <option value="374339692424224768">天天返点无上限 </option>
                                                                            <option value="378395958440255488">首存即送！专属优惠~</option>
                                                                            <option value="374338615729610752">百家乐 老K送大奖</option>
                                                                            <option value="374334587268390912">天天签到</option>
                                                                            <option value="374340639737143296">加入VIP俱乐部</option>
                                                                            <option value="374339313854734336">首存赠送100% 超值豪礼等您拿</option>
                                                                        </select>
                                </div> -->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">备注</label>
                                            <input type="text" id="remark1" class="form-control" placeholder="请说明调整原因，已经调整的结果">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" onclick="SaveConfig(1,this);">确认</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ConfigRlLL" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="myModalLabel">批量调整红利</h3>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="horizontal-form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">请输入用户账号(每行一个账号名,请勿保留空格,若有重复用户将自动去除)</label>
                                            <textarea id="usernames" class="form-control"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="form-section">
                                                    <hr> 调整红利金额 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">加减</label>
                                                    <select class="form-control" id="atype3">
                                                            <option value="1">+</option>
                                                            <option value="2">-</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">数值</label>
                                                    <input type="text" id="ja3" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="form-section">
                                                    <hr> 调整取款流水条件 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">取款流水倍数</label>
                                                    <input type="text" id="jb3" value="1" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">确认</label>
                                                    <input type="text" id="jc3" readonly value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">加减</label>
                                                    <select class="form-control" id="jj3">
                                                            <option value="1">+</option>
                                                            <option value="2">-</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">数值</label>
                                                    <input type="text" id="jz3" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">确认</label>
                                                    <input type="text" readonly id="jv3" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">红利流水限平台</label>
                                                    <select class="form-control" id="gpid3">
                                                            <option value="0">不限平台</option>
                                                            <option value="IBC">沙巴体育</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">该红利参与优惠活动选择</label>
                                                    <select class="form-control" id="actid3">
                                                            <option value="0">无活动</option>
                                                            <option value="374335100697333760">电话回访</option>
                                                            <option value="374336017039511552">诚招代理商</option>
                                                            <option value="374340225297965056">次次存次次送</option>
                                                            <option value="374339692424224768">天天返点无上限 </option>
                                                            <option value="378395958440255488">首存即送！专属优惠~</option>
                                                            <option value="374338615729610752">百家乐 老K送大奖</option>
                                                            <option value="374334587268390912">天天签到</option>
                                                            <option value="374340639737143296">加入VIP俱乐部</option>
                                                            <option value="374339313854734336">首存赠送100% 超值豪礼等您拿</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">备注</label>
                                                    <input type="text" id="remark3" class="form-control" placeholder="请说明调整原因，已经调整的结果">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" onclick="CheckUsername(this);" class="btn green">批量调整红利</a>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="ConfigRl" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" type="button" data-dismiss="modal">×</button>
                                <h3 id="myModalLabel">调整红利金额</h3>
                            </div>
                            <div class="modal-body">
                                <form action="#" class="horizontal-form">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a data-toggle="modal" class="btn blue" data-toggle="modal" data-target="#ModelPlayer" href="/player/playerListModel">选择用户</a>
                                                <span id="user2" userid="0"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="form-section">
                                                    <hr> 调整红利金额 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">加减</label>
                                                    <select class="form-control" id="atype2">
                                                            <option value="1">+</option>
                                                            <option value="2">-</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">数值</label>
                                                    <input type="text" id="ja2" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="form-section">
                                                    <hr> 调整取款流水条件 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">取款流水倍数</label>
                                                    <input type="text" id="jb2" value="1" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">确认</label>
                                                    <input type="text" id="jc2" readonly value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">加减</label>
                                                    <select class="form-control" id="jj2">
                                                            <option value="1">+</option>
                                                            <option value="2">-</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">数值</label>
                                                    <input type="text" id="jz2" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">确认</label>
                                                    <input type="text" readonly id="jv2" value="0" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">红利流水限平台</label>
                                                    <select class="form-control" id="gpid2">
                                                            <option value="0">不限平台</option>
                                                            <option value="8246252097638400">沙巴体育</option>
                                                            
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">该红利参与优惠活动选择</label>
                                                    <select class="form-control" id="actid2">
                                                            <option value="0">无活动</option>
                                                            <option value="374335100697333760">电话回访</option>
                                                            <option value="374336017039511552">诚招代理商</option>
                                                            <option value="374340225297965056">次次存次次送</option>
                                                            <option value="374339692424224768">天天返点无上限 </option>
                                                            <option value="378395958440255488">首存即送！专属优惠~</option>
                                                            <option value="374338615729610752">百家乐 老K送大奖</option>
                                                            <option value="374334587268390912">天天签到</option>
                                                            <option value="374340639737143296">加入VIP俱乐部</option>
                                                            <option value="374339313854734336">首存赠送100% 超值豪礼等您拿</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">备注</label>
                                                    <input type="text" id="remark2" class="form-control" placeholder="请说明调整原因，已经调整的结果">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary green" onclick="SaveConfig(2,this);">确认</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->