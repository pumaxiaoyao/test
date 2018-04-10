<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>代理审核 </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green" href="/agent/verifyHistory"> 代理审核历史 </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/agent/verifyAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                            <option value="account">账号</option>
                            <option value="name">姓名</option>
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
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>代理编码</th>
                            <th>姓名</th>
                            <th>所属一级代理</th>
                            <th>所属二级代理</th>
                            <th>注册时间</th>
                            <th>注册IP</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Check Modal -->
        <div class="modal fade" id="checkAgentModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">代理审核</h3>
                    </div>
                    <div class="modal-body">
                        <form id="checkAgent" class="form-horizontal" role="form" action="/agent/checkAgent">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">调整层级
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8" id="AgentLayerSelectData">
                                        <select id="AgentLayerData" class="form-control" name="AgentLayerData">
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">备注</label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <textarea id="vremark" style="margin: 0px; width: 450px; height: 100px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input id="type" name="type" type="hidden" value="">
                            <input id="agentId" name="agentId" type="hidden" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="agentPass">通过</button>
                        <button class="btn red" id="agentReject">拒绝</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="remarkModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>代理备注:
                            <font show=uname></font>
                        </h3>
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
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="saveRemark();">保存</button>
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