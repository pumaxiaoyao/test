<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>取款流水限制汇总 </div>
            </div>
            <div class="portlet-body">
                <form action="/playerfund/flowLimitAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                    <option value="account">账号</option>
                    <option value="name">姓名</option>
                    <option value="agentName">代理</option>
                </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                搜索 &nbsp; <i class="fa fa-search"></i>
                </button>
                        <button type="button" onclick="startEndAll(66);" class="btn btn-sm red">
                批量重启</i>
                </button>
                        <button type="button" onclick="startEndAll(99);" class="btn btn-sm blue">
                批量完成</i>
                </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectall"></th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>流水限额</th>
                            <th>限额类型</th>
                            <th>限制平台</th>
                            <th>处理时间</th>
                            <th>代理</th>
                            <th>完成状态</th>
                            <th>检查状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="WCheckDetial" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><button class="close" type="button" onclick="endverifytask();" data-dismiss="modal">×</button>
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
                        <button class="btn" data-dismiss="modal" onclick="endverifytask();" aria-hidden="true">关闭</button>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->