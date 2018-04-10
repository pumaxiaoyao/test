<div class="modal fade" id="messageModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 id="myModalLabel">新增消息:
                    <font show=uname></font>
                </h3>
            </div>
            <div class="modal-body">
                <form id="message_form" class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">信息标题：
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" name="PlayerMessageTitle" id="PlayerMessageTitle" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">信息内容：
                                    <span class="required">*</span>
                                </label>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea id="PlayerMessageContent" name="PlayerMessageContent" style="margin: 0px; width: 450px; height: 100px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary green" onclick="sendMessage();">发消息</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>