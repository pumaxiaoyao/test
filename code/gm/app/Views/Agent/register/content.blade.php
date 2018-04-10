<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>新增代理
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" id="add_agent_form" role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">用户名
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" name="aname" class="form-control" placeholder="用户名" aria-required="true">
                                    <span class="help-inline">由4-12个字符长的字母或数字组合组成
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">密码
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="password" name="apwd" id="apwd" class="form-control" placeholder="密码">
                                    <span class="help-inline">
                                            密码长度为6-16个字母和数字的组合
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">确认密码
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="password" name="password1" class="form-control" placeholder="确认密码">
                                    <span class="help-inline">
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">真实姓名
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-3">
                                <input type="text" name="realname" value="default" class="form-control" placeholder="真实姓名">
                                <span class="help-inline">
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">上级代理ID
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" name="parentId" class="form-control" placeholder="上级代理ID" aria-required="true">
                                    <span class="help-inline">填写直属代理ID编码，公司直属代理则不填
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="button" onclick="addAgent()" class="btn green">保存</button>
                                <button type="button" class="btn default">取消</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
