<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <input id="dealsrates" type="hidden" value='{"0":"\u65e0","0.01":"1%","0.012":"1.2%","0.015":"1.5%","0.02":"2%","0.0258":"2.58%","0.03":"3%","0.0558":"5.58%"}'
        />
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>存款审核 </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href="/playerfund/dptCorrection" class="btn blue">手工调整余额红利流水</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>存款审核 </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#portlet_tab1" data-toggle="tab">
                                        网银/ATM支付</a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" id='sf' data-toggle="tab">
                                        第三方支付</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <form action="/playerfund/dptVerifyAjax" id="s_search1" class="form-inline" style="text-align:right;">
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
                                    <input type="text" name="s_StartTime" readonly id="s_StartTime" value="{{ $startTime }}" class="form-control input-inline input-small input-sm datepicker"
                                            placeholder="开始时间">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="s_EndTime" readonly id="s_EndTime" value="{{ $endTime }}" class="form-control input-inline input-small input-sm datepicker"
                                            placeholder="结束时间">
                                    </div>
                                    <div class="form-group">
                                        <input name="dno" type="text" placeholder="单号" class="table-group-action-input form-control input-inline input-sm" />
                                    </div>
                                    <div class="form-group">
                                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
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
                                    <div class="form-group">
                                        <button onclick="startrefuseAll(1);" type="button" id="s_submit" class="btn btn-sm red table-group-action-submit">
                                                批量拒绝 </button>
                                    </div>
                                </form>
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data1">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectall1">
                                            </th>
                                            <th>存款时间/单号</th>
                                            <th>账号</th>
                                            <th>姓名</th>
                                            <th>玩家组</th>
                                            <th>代理</th>
                                            <th>支付</th>
                                            <th>申请金额</th>
                                            <th>存入银行</th>
                                            <th>玩家反馈</th>
                                            <th>备注</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="portlet_tab2">
                                <form action="/playerfund/dptVerifyAjax" id="s_search2" class="form-inline" style="text-align:right;">
                                    <input type="hidden" name="payment" value="25" />
                                    <input name="ftime" type="hidden" value="false" class="table-group-action-input form-control input-inline input-sm" />
                                    <div class="form-group">
                                        <input name="dno" type="text" placeholder="单号" class="table-group-action-input form-control input-inline input-sm" />
                                    </div>
                                    <div class="form-group">
                                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                                <option value="1">账号</option>
                                                <option value="2">姓名</option>
                                                <option value="3">代理</option>
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
                                    <div class="form-group">
                                        <button onclick="startrefuseAll(2);" type="button" id="s_submit" class="btn btn-sm red table-group-action-submit">
                                                批量拒绝 </button>
                                    </div>
                                </form>
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data2">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectall2">
                                            </th>
                                            <th>存款时间/单号</th>
                                            <th>账号</th>
                                            <th>姓名</th>
                                            <th>玩家组</th>
                                            <th>支付</th>
                                            <th>申请金额</th>
                                            <th>存入银行</th>
                                            <th>玩家反馈</th>
                                            <th>代理</th>
                                            <th>凭据</th>
                                            <th>操作</th>
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
            <div class="modal fade" id="ModelPlayer" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3 id="myModalLabel">搜索用户</h3>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button class="btn btn-primary green" onclick="selectPlayer();">选择该用户</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="VerifyModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-full">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="btn_cancel" aria-hidden="true"></button>
                            <h4 class="modal-title">存款审核</h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" class="horizontal-form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p>持卡人：
                                                <label id="bowner"></label>&nbsp;附加码：
                                                <label id="acode"></label>&nbsp;对应卡号：
                                                <label id="cardnum"></label>&nbsp;备注：
                                                <label id="deposituser"></label>&nbsp;存款银行：
                                                <label id="userbank"></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label id="limitShow" style="color: #ff0000"></label>
                                            </p>
                                            <div class="radio-list">
                                                <label class="radio-inline" style="color: green">
                                                        <input type="radio" name="checkDpt" value="1" />已查到玩家存款</label>
                                                <label class="radio-inline" style="color: #ff0000">
                                                        <input type="radio" name="checkDpt" value="2" />玩家没有存款</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pass_content" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="form-section">
                                                    <hr> 确认实际存款 </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="form-section">
                                                    <hr> 若该存款享受补助，请设置补助金额 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="control-label">存款申请数额</label>
                                                        <input type="text" readonly id="jl1" class="form-control" value="10000" placeholder="存款申请数额">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">加减</label>
                                                        <select class="form-control" id="jj1">
                                                                <option value="+">+</option>
                                                                <option value="-">-</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">数值</label>
                                                        <input type="text" id="jz1" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">本次存款确认</label>
                                                        <input type="text" id="jv1" readonly value="10000" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">存款优惠比例</label>
                                                        <select class="form-control" id="jb2">
                                                                <option value="0">无</option>
                                                                <option value="0.01">1%</option>
                                                                <option value="0.012">1.2%</option>
                                                                <option value="0.015">1.5%</option>
                                                                <option value="0.02">2%</option>
                                                                <option value="0.0258">2.58%</option>
                                                                <option value="0.03">3%</option>
                                                                <option value="0.0558">5.58%</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">记</label>
                                                        <input type="text" readonly id="jl2" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">加减</label>
                                                        <select class="form-control" id="jj2">
                                                                <option value="+">+</option>
                                                                <option value="-">-</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">数值</label>
                                                        <input type="text" id="jz2" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">存款补助金额</label>
                                                        <input type="text" id="jv2" readonly value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="form-section">
                                                    <hr> 若该存款参与活动，请设置红利金额 </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="form-section">
                                                    <hr> 设置取款流水条件 </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">红利比例(%)</label>
                                                        <input type="text" id="jb3" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">记</label>
                                                        <input type="text" readonly value="0" id="jl3" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">加减</label>
                                                        <select class="form-control" id="jj3">
                                                                <option value="+">+</option>
                                                                <option value="-">-</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">数值</label>
                                                        <input type="text" id="jz3" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">本次红利确认</label>
                                                        <input type="text" id="jv3" readonly value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">取款流水倍数</label>
                                                        <input type="text" id="jb4" value="1" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">记</label>
                                                        <input type="text" readonly value="10000" id="jl4" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">加减</label>
                                                        <select class="form-control" id="jj4">
                                                                <option value="+">+</option>
                                                                <option value="-">-</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">数值</label>
                                                        <input type="text" id="jz4" value="0" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">流水条件确认</label>
                                                        <input type="text" id="jv4" readonly value="10000" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">存款流水限平台</label>
                                                    <select class="form-control" id="dgpid">
                                                            <option value="0">不限平台</option>
                                                            <option value="350808494186211">BB视讯</option>
                                                            <option value="350808494186212">BB彩票</option>
                                                            <option value="350808494186213">BB3D</option>
                                                            <option value="350808494186214">BB机率</option>
                                                            <option value="387122175998732">AG电游</option>
                                                            <option value="387122175998733">AG捕鱼</option>
                                                            <option value="8246252097638400">沙巴体育</option>
                                                            <option value="11964220589608960">MG电游</option>
                                                            <option value="350808494186210">BB体育</option>
                                                            <option value="9283948292830">欧博真人</option>
                                                            <option value="7821359015601">蚂蚁彩票</option>
                                                            <option value="420987656202">newPT电游</option>
                                                            <option value="520723134101">KG</option>
                                                            <option value="550123423101">IM捕鱼</option>
                                                            <option value="550223423201">IM电子</option>
                                                            <option value="773562192801">申博真人</option>
                                                            <option value="773562192802">申博老虎机</option>
                                                            <option value="940256904101">新EBet</option>
                                                            <option value="7589283920390">双赢彩票</option>
                                                            <option value="38712217599873024">AG真人</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">红利流水限平台</label>
                                                    <select class="form-control" id="bgpid">
                                                            <option value="0">不限平台</option>
                                                            <option value="350808494186211">BB视讯</option>
                                                            <option value="350808494186212">BB彩票</option>
                                                            <option value="350808494186213">BB3D</option>
                                                            <option value="350808494186214">BB机率</option>
                                                            <option value="387122175998732">AG电游</option>
                                                            <option value="387122175998733">AG捕鱼</option>
                                                            <option value="8246252097638400">沙巴体育</option>
                                                            <option value="11964220589608960">MG电游</option>
                                                            <option value="350808494186210">BB体育</option>
                                                            <option value="9283948292830">欧博真人</option>
                                                            <option value="7821359015601">蚂蚁彩票</option>
                                                            <option value="420987656202">newPT电游</option>
                                                            <option value="520723134101">KG</option>
                                                            <option value="550123423101">IM捕鱼</option>
                                                            <option value="550223423201">IM电子</option>
                                                            <option value="773562192801">申博真人</option>
                                                            <option value="773562192802">申博老虎机</option>
                                                            <option value="940256904101">新EBet</option>
                                                            <option value="7589283920390">双赢彩票</option>
                                                            <option value="38712217599873024">AG真人</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">关联活动</label>
                                                    <select class="form-control" id="actid">
                                                            <option value="0">无活动</option>
                                                            <option value="378395958440255488">首存即送！专属优惠~</option>
                                                            <option value="374334587268390912">天天签到</option>
                                                            <option value="374340639737143296">加入VIP俱乐部</option>
                                                            <option value="374339313854734336">首存赠送100% 超值豪礼等您拿</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="remark" style="display: none;" class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">备注
                                                        <span class="required">*</span>
                                                    </label>
                                                <input type="text" id="dealremark" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary green" id="btn_pass" style="display: none" onclick="passverify();">
                                    通过存款申请 </button>
                            <button class="btn btn-primary red" id="btn_refuse" style="display: none" onclick="refuseverify();">
                                    拒绝存款申请 </button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                            <!-- <button class="btn" data-dismiss="modal" onclick="endverifytask();" aria-hidden="true">取消</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->