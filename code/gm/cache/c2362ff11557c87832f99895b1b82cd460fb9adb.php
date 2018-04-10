<div class="modal fade" id="agentModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3>玩家变更代理:
                    <font show=uname></font>
                </h3>
            </div>
            <div style="color: red; margin-left: 20px;">
                1、注意：玩家变更代理需要谨慎操作，会造成代理输赢日报表的数据差异</br>
                2、切忌：代理月结算数据报表生成期间，不要进行玩家变更代理的更换。 </div>
            <div class="modal-body">
                <form id="agent_form" class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">当前代理：</label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <span class="form-control" id="curAgent"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">
                                    <span class="required">*</span>代理代码：</label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" name="agentCode" id="agentCode" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary red" onclick="saveAgentCode();">保存</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>