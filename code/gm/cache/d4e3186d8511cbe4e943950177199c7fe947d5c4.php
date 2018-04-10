<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>取款审核 </div>
            </div>
            <div class="portlet-body">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#portlet_tab1" data-toggle="tab" onclick="addTypeValue(1);chgwstatus(1);">待审核</a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" data-toggle="tab" onclick="addTypeValue(2);chgwstatus(2);">待对账</a>
                            </li>

                        </ul>
                    </div>
                    <div class="portlet-body">
                        <form action="/playerfund/wtdVerifyAjax" id="s_search" class="form-inline" style="text-align:right;">
                            <input type="hidden" id="canEditGroup" value="1" />
                            <input type="hidden" id="w_all" name="w_all" value="">
                            <input type="hidden" id="w_type" name="w_type" value="1">
                            <input type="hidden" id="cs_remark" name="cs_remark" value="1">
                            <input type="hidden" id="fn_remark" name="fn_remark" value="0">
                            <input type="hidden" id="waterchkright" name="waterchkright" value="1">
                            <!--<div class="form-group">
                                <select name="d_type" id="d_type" class="table-group-action-input form-control input-small input-sm"
                                        tabindex="1">
                                        <option value="">所有状态</option>
                                        <option value="1">已分配</option>
                                        <option value="2">未分配</option>
                                </select>
                            </div>-->
                            <div class="form-group">
                                <select name="waterckrs" id="waterckrs" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                    <option value="3">所有流水检查</option>
                                    <option value="2">已通过</option>
                                    <option value="1">未通过</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="table-group-action-input form-control input-inline  input-sm" tabindex="1" id="groupid" name="groupid">
                                    <option value="">所有组别</option>
                                    %GROUPDATA%
                                </select>
                            </div>
                            <div class="form-group">
                                <label>申請时间</label>
                            <input type="text" name="s_StartTime" id="s_StartTime" value="<?php echo e($startTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                                    placeholder="开始时间">
                            </div>
                            <div class="form-group">
                                <label>-</label>
                            <input type="text" name="s_EndTime" id="s_EndTime" value="<?php echo e($endTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                                    placeholder="结束时间">
                            </div>
                            <div class="form-group">
                                <label>取款金额</label>
                                <input type="text" name="s_WStartAmt" id="s_WStartAmt" value="" class="form-control input-inline input-small input-sm">
                            </div>
                            <div class="form-group">
                                <label> - </label>
                                <input type="text" name="s_WEndAmt" id="s_WEndAmt" value="" class="form-control input-inline input-small input-sm">
                            </div>
                            <div class="form-group">
                                <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                    <option value="account">账号</option>
                                    <option value="name">姓名</option>
                                    <option value="agentName">代理</option>
                                    <option value="card">玩家银行卡</option>
                                    <option value="dno">单号</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                                />
                            </div>
                            <div class="form-group">
                                <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit" onclick="chgValue();">
                                    搜索 &nbsp;
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                            <thead>
                                <tr>
                                    <th>单号</th>
                                    <th>账号</th>
                                    <th>玩家组</th>
                                    <th>代理</th>
                                    <th>取款申请</th>
                                    <th>取款手续费</th>
                                    <th>出款确认</th>
                                    <th>上笔存款金额</th>
                                    <th>取款流水限制</th>
                                    <th>申请时间</th>
                                    <th>玩家银行卡</th>
                                    <th>备注</th>

                                    <th>流水检查</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-modal-lg" id="WCheck" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="WCheckVerify" class="close" type="button" onclick="endverifytask();" data-dismiss="modal">×</button>
                            <button id="WCheckNoVerify" class="close" type="button" data-dismiss="modal">×</button>
                            <h3>流水检查</h3>
                            <!-- <div id="limit"></div> -->
                        </div>
                        <div class="modal-body">
                            <div id="waterDetialTable" style="display:none;">
                                <div class="col-md-6" name="check">
                                    <table class="table table-striped table-bordered table-hover table-full-width">
                                        <thead>
                                            <tr>
                                                <th>限制平台</th>
                                                <th>金额</th>
                                                <th>还需流水</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6" name="water">
                                    <table class="table table-striped table-bordered table-hover table-full-width">
                                        <thead>
                                            <tr>
                                                <th>游戏平台</th>
                                                <th>金额</th>
                                                <th>剩余</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover table-full-width" id="wtable">
                                <thead>
                                    <tr>
                                        <th>单号</th>
                                        <th>时间</th>
                                        <th>类型</th>
                                        <th>说明</th>
                                        <th>限制平台</th>
                                        <th>活动</th>
                                        <th>流水要求</th>
                                        <th>未完成流水</th>
                                        <th>流水抵扣明细</th>
                                        <th>账户总余额</th>
                                        <th>是否完成</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" id="submitCheckResult" onclick="submitCheckResult(this);">提交检查结果 </button>
                            <button id="WCheckCancel" class="btn" data-dismiss="modal" onclick="endverifytask();" aria-hidden="true">取消</button>
                            <button id="WCheckNoCancel" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="remarkModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3>取款客服备注</h3>
                        </div>
                        <div class="modal-body">
                            <form id="remark_form" class="form-horizontal" role="form">
                                <input type="hidden" id="cs_remark_dno" />
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">备注
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <div class="input-icon right">
                                                <textarea id="csremark" style="margin: 0px; width: 450px; height: 100px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" save="save">确认</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="fnremarkModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3>财务备注</h3>
                        </div>
                        <div class="modal-body">
                            <form id="fnremark_form" class="form-horizontal" role="form">
                                <input type="hidden" id="fn_remark_dno" />
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">备注
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <div class="input-icon right">
                                                <textarea id="fnremark" style="margin: 0px; width: 450px; height: 100px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" save="save">确认</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
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
                            <input type="hidden" id="isrefuseapproved" value="0">
                            <button class="btn btn-primary red" onclick="refuse(this);">拒绝</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="passModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3>通过出款申请</h3>
                            <div id="passinfo"></div>
                            <div id="alertInfo" style="color: red;"></div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款申请数额</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" readonly id="pamount" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款手续费</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="pfeetype" id="pfeetype" class="form-control" tabindex="1">
                                            <option value="1">取款手续费由玩家承担</option>
                                            <option value="2">取款手续费由公司承担</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款手续费比例</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="pperc" id="pperc" class="form-control" tabindex="1">
                                            <option value="0">无</option>
                                            <option value="0.01">1%</option>
                                            <option value="0.012">1.2%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" readonly id="ppercresult" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="jj" id="jj" class="form-control" tabindex="1">
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" id="jjnum" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款手续费确认</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" readonly id="pwfee" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款金额确认</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" readonly id="pactual" class="form-control" placeholder="">
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
                                        <input type="text" id="pdealremark" class="form-control" placeholder="" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div style="color:red;">建议：可以将玩家银行卡提前录入出款系统，验证出款银行卡是否正确。完全正确后，再点击“通过”。一旦通过，此操作将无法恢复。</div>
                            <button class="btn btn-primary red" onclick="pass(this);">通过</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bankModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal" onclick="cancelWtdBankInfo();">×</button>
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
                                            <option balance="999999" no="6222620340008756532" value="3021">马继华-6222620340008756532 -中国交通银行-余额999999元
                                            </option>
                                            <option balance="999999" no="6231310101006639377" value="3022">于兴慧-6231310101006639377 -其它银行-余额999999元
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
                                        <input type="text" id="bmremark" class="form-control" placeholder="">
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
            <div class="modal fade bs-modal-lg" id="WCheckDetial" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="checkVerify" class="close" type="button" onclick="endverifytask();" data-dismiss="modal">×</button>
                            <button id="noVerify" class="close" type="button" data-dismiss="modal">×</button>
                            <h3>流水检查详情</h3>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-6" name="check">
                                <table class="table table-striped table-bordered table-hover table-full-width">
                                    <thead>
                                        <tr>
                                            <th>限制平台</th>
                                            <th>金额</th>
                                            <th>检查</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" name="water">
                                <table class="table table-striped table-bordered table-hover table-full-width">
                                    <thead>
                                        <tr>
                                            <th>限制平台</th>
                                            <th>金额</th>
                                            <th>检查</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="checkVerifyCancel" class="btn" data-dismiss="modal" onclick="endverifytask();" aria-hidden="true">关闭</button>
                            <button id="noVerifyCancel" class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>