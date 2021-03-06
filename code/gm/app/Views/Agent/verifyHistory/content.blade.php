<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>代理审核历史 </div>
            </div>
            <div class="portlet-body">
                <form action="/agent/verifyHistoryAjax" id="s_search" class="form-inline" style="text-align:right;">
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
                            <th>代理账号</th>
                            <th>姓名</th>
                            <th>代理层级</th>
                            <th>注册时间</th>
                            <th>注册IP</th>
                            <th>状态</th>
                            <th>备注</th>
                            <!-- <th>操作人</th> -->
                            <th>处理时间</th>
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