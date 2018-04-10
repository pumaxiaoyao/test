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