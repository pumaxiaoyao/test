<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>取款历史查询 本页总额:
                    <span id="dc"></span> 全部总额:
                    <span id="ac"></span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/playerfund/wtdHistoryAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <label class="label label-warning">审核时间</label>
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
                    <input type="text" name="s_StartTime" id="s_StartTime" value="{{ $startTime }}" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="开始时间">
                    </div>
                    <div class="form-group">
                        <input type="text" name="s_EndTime" id="s_EndTime" value="{{ $endTime }}" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="结束时间">
                    </div>
                    <div class="form-group">
                        <label class="label label-warning">取款金额</label>
                        <input name="s_wtdAmtFr" id="s_wtdAmtFr" type="number" min="0" class="table-group-action-input form-control input-inline input-sm"
                        /> -
                        <input name="s_wtdAmtTo" id="s_wtdAmtTo" type="number" min="0" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <select name="s_dpttype" id="s_dpttype" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                            <option value="15">所有</option>
                            <option value="-1">出款&成功</option>
                            <option value="50">出款</option>
                            <option value="33">成功</option>
                            <option value="22">拒绝</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                            <option value="account">账号</option>
                            <option value="name">姓名</option>
                            <option value="agentName">代理</option>
                            <option value="bankCard">玩家银行卡</option>
                            <option value="dno">单号</option>
                            <option value="staff">操作人</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <select name="s_playercurrency" id="s_playercurrency" class="table-group-action-input form-control input-inline input-sm"
                            tabindex="1">
                            <option value="ALL">Currency - 幣種</option>
                            <option value="CNY">RMB - 人民幣</option>
                            <option value="THB">THB - 泰幣</option>
                            <option value="USD">USD - 美金</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                            搜索 &nbsp;
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：取款额，不包含客服手工添加取款金额。
                        <br> 注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！
                    </p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>单号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>玩家组</th>
                            <th>代理</th>
                            <th>幣種</th>
                            <th>申请金额</th>
                            <th>实际取款</th>
                            <th>申请时间</th>
                            <th>状态</th>
                            <th>出款银行</th>
                            <th>入款银行</th>
                            <th>审核时间</th>
                            <th>出款时间</th>
                            <th>操作人</th>
                            <th>审核备注</th>
                            <th>出款备注</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="bankModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button onclick="cancelWtdBankInfo();" class="close" type="button" data-dismiss="modal">×</button>
                        <h3>银行卡出款</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">取款银行</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" readonly id="outBankInfo" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">出款金额确认</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" readonly id="bmactual" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">选择出款银行</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <input type="hidden" id="aid" value="i12">
                                <div class="form-group">
                                    <select class="form-control" id="bmbcid">
                                        <option balance="90000.0000" no="6222620340008756532" value="3021">马继华-6222620340008756532 -中国交通银行-余额90000.0000元
                                        </option>
                                        <option balance="0.0000" no="6231310101006639377" value="3022">于兴慧-6231310101006639377 -其它银行-余额0.0000元
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">出款手续费确认</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" id="bmwfee" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">备注</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" id="bmremark" class="form-control" placeholder="" value="客服通过">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="submitWtdBankInfo(this);">通过</button>
                        <button onclick="cancelWtdBankInfo();" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="refuseModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>拒绝出款申请</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" id="defaultmsgid" value="1" />
                                <label class="control-label">信息類型：</label>
                                <select class="table-group-action-input form-control input-inline  input-sm" tabindex="1" id="mtypes" name="mtypes">
                                    <option value="1">取款拒绝</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">信息标题：
                                    <span class="required">*</span>
                                </label>
                                <div>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="messagetitle" id="messagetitle" class="form-control" value="取款拒绝">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">信息内容：
                                    <span class="required">*</span>
                                </label>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" id="messagecontent" name="messagecontent" style="height:150px;width:180px">
                                            您于
                                            <span style="color:red;font-size:12px;">{date:Y-m-d H:i:s}</span>申请的取款，其中：取款申请=
                                            <span style="color:red;font-size:12px;">{wamt:2}</span>,已被拒绝。谢谢您的参与，有任何问题请随时与我们联系。 </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">备注:
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="refusedealremark" class="form-control" value="" placeholder="请认真填写拒绝的理由">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="refuse(this);">拒绝</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>