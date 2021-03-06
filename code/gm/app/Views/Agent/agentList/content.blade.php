<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>代理列表 </div>
                <div class="actions">
                    <a class="btn green small" href="/agent/register" data-toggle="modal">创建代理</a>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/agent/listAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="status" id="status" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                <option value="0">全部</option>
                                <option value="2">正常</option>
                                <option value="4">拒绝</option>
                                <option value="3">锁定</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                <option value="account">账号</option>
                                <option value="name">姓名</option>
                                <option value="cellPhoneNo">手机号</option>
                                <option value="email">邮箱</option>
                                <option value="roleId">代理代码</option>
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
                            <th>序号</th>
                            <th>代理账号</th>
                            <th>姓名</th>
                            <th>代理层级</th>
                            <th>所属一级代理</th>
                            <th>所属二级代理</th>
                            <th>代理代码</th>
                            <th>注册时间</th>
                            <th>注册IP</th>
                            <th>客服备注</th>
                            <th>状态</th>
                            <th style="width:25%;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Account Modal -->
        <div class="modal fade" id="accountModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="title">停用账户</h3>
                    </div>
                    <div class="modal-body">
                        <p id="info" style="color: #ff0000; ">确定停用账户?</p>
                        <input id="agentId" type="hidden" value="">
                        <input id="status" type="hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="save">确认</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Level Modal -->
        <div class="modal fade" id="levelModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="title">调整层级</h3>
                    </div>
                    <div class="modal-body">
                        <input id="agentId" type="hidden" value="">
                        <table class="table table-striped table-bordered table-hover table-full-width">
                            <thead>
                                <tr>
                                    <th>选择</th>
                                    <th>代理层级</th>
                                    <th>备注</th>
                                    <th>结算分摊</th>
                                    <th>抽佣比例</th>
                                    <th>抽水比例</th>
                                </tr>
                            </thead>
                            <tbody id="groupList">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="save">确认</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="title">编辑</h3>
                    </div>
                    <div class="modal-body">
                        <form id="edit_form" class="form-horizontal" role="form">
                            <input type="hidden" name="aid" id="aid" value="" />
                            <input type="hidden" name="gender" value="0" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">姓名
                                            <span class="required">*</span>
                                        </label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="realname" id="realname" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">邮箱
                                            <span class="required">*</span>
                                        </label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="email" id="email" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">手机号</label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="mobile" id="mobile" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">QQ</label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="qq" id="qq" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_save" class="btn btn-primary green">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="resetPwd" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>修改密码</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">新密码</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="password" id="pwd" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">确认密码</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="password" id="pwdck" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="resetPwd(this);">保存</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="remarkModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>备注:
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