<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>活动审核历史 </div>
            </div>
            <div class="portlet-body">
                <form action="/activity/activityHistoryAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <label>状态：</label>
                        <select name="status" id="status" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                    <option value="0">无</option>
                    <option value="1">通过</option>
                    <option value="2">拒绝</option>
                </select>
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                    <option value="1">账号</option>
                    <option value="2">姓名</option>
                    <option value="3">代理</option>
                    <option value="4">活动名称</option>
                    <option value="5" >活动ID</option>
                </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" value="" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                    搜索 &nbsp; <i class="fa fa-search"></i>
                </button>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>代理</th>
                            <th>申请活动名称</th>
                            <th>申请时间</th>
                            <th>申请状态</th>
                            <th>活动名称</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->