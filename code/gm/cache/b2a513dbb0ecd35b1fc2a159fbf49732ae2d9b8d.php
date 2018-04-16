<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>活动资金统计 </div>
                <div class="actions">

                </div>
            </div>
            <div class="portlet-body">
                <form action="/activity/activityFundAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <input name="s_StartTime" id="s_StartTime" type="text" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" placeholder="开始时间"
                            class="table-group-action-input form-control input-inline input-sm" />
                    </div>
                    <div class="form-group">
                        <input name="s_EndTime" id="s_EndTime" type="text" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" placeholder="结束时间"
                            class="table-group-action-input form-control input-inline input-sm" />
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
                            <th>活动名称</th>
                            <th>参与人数</th>
                            <th>参与人次</th>
                            <th>存款总额</th>
                            <th>红利总额</th>
                            <th>活动状态</th>
                            <th>创建时间</th>
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