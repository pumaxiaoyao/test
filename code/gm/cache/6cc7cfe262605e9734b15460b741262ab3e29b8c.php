<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>存款历史查询 本页总额 :
                    <span id="pdps"></span> 全部总额 :
                    <span id="dps"></span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/playerfund/dptHistoryAjax" id="s_search" class="form-inline" style="text-align:right;">
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
                    <input type="text" name="s_StartTime" id="s_StartTime" value="<?php echo e($startTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="开始时间">
                    </div>
                    <div class="form-group">
                        <input type="text" name="s_EndTime" id="s_EndTime" value="<?php echo e($endTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="结束时间">
                    </div>
                    <div class="form-group">
                        <input type="text" name="dno" id="dno" class="form-control input-inline input-small input-sm datepicker" placeholder="单号">
                    </div>
                    <div class="form-group">
                        <select name="s_dpttype" id="s_dpttype" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                                <option value="6">状态</option>
                                <option value="2">成功</option>
                                <option value="4">失败</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                                <option value="account">账号</option>
                                <option value="name">姓名</option>
                                <option value="agentName">代理</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <select name="s_transtype" id="s_transtype" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                <option value="0">不限存款方式</option>
                                <option value="23">支付宝/微信/ATM</option>
                                <option value="24">网银</option>
                                <option value="25">第三方在线支付</option>
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
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>申请时间/单号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>代理</th>
                            <th>申请金额</th>
                            <th>实际</th>
                            <th>优惠</th>
                            <th>红利</th>
                            <th>取款流水限制</th>
                            <th>交易方式</th>
                            <th>存入银行</th>
                            <th>状态</th>
                            <th>处理时间</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="resetModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="remark_form" class="form-horizontal" role="form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">备注
                                            <span class="required">*</span>
                                        </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <textarea id="remark" style="margin: 0px; width: 450px; height: 100px;"></textarea>
                                        </div>
                                        <input id="dno" type="hidden" value="" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="commitReset();">保存</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
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