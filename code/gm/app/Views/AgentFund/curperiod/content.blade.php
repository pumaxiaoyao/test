<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>游戏平台佣金 </div>
                <div class="actions" style="text-align:right;">
                    <div style="width:400px;float:right;display:none;" id="proc">
                        <font id="info">数据生成进度</font>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
                                <span class="sr-only">
                                        1% Complete </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/agentfund/curPeriodList" id="s_search" class="form-inline" style="text-align:right;">
                    <a class="btn btn-m green table-group-action-submit" onclick="starttask();">创建上月代理结算单</a>
                    <a class="btn btn-m blue" onclick="DPFstart();" href="#DPFModal" data-toggle="modal">批量审核</a>
                    <a class="btn btn-m red" id="resettle" data-toggle="modal">上月代理月结重算({{ $lastMonth }})</a>
                </form>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectall">
                            </th>
                            <th>结算月</th>
                            <th>一级代理</th>
                            <th>二级代理</th>
                            <th>三级代理</th>
                            <th>代理层级</th>
                            <th>有效会员</th>
                            <th>游戏平台佣金</th>
                            <th>成本分摊</th>
                            <th>累加上月</th>
                            <th>手工调整</th>
                            <th>调整备注</th>
                            <th>本期佣金</th>
                            <th>实际发放</th>
                            <th>结转下月</th>
                            <th>结转备注</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="CbDetailModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>成本分摊</h3>
                    </div>
                    <div class="modal-body" id="detial">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verifyModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="verifyTitle"></h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">请谨慎进行审核操作！</label>
                                <!-- <input type="text" id="verifyremark" class="form-control" placeholder="请认真填写的理由"> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="verify(this);" id="verifyBtn"></button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adjustModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>手工调整</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">手工调整金额（可以为负数）</label>
                                <input type="text" id="adjust" class="form-control" placeholder="">
                                <label class="control-label">调整备注</label>
                                <input type="text" id="adjustRemark" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="saveadjust(this);">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="acturalModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>设置实际发放(最多:
                            <font id="acturalTitle"></font>)</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">金额</label>
                                <input type="text" id="actural" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">备注</label>
                                <input type="text" id="acturalremark" class="form-control" placeholder="请认真填写的理由">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="saveactural(this);">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DetailModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>游戏平台佣金</h3>
                    </div>
                    <div class="modal-body" id="detial">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DPFModal" data-keyboard="false" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <button class="close" type="button" data-dismiss="modal">×</button> -->
                        <h3>批量审核</h3>
                    </div>
                    <div class="modal-body">
                        <div id="dpfproc" class="hide">
                            <font>操作进度（操作进行中，请不要点击任何按钮）</font>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
                                    <span class="sr-only">
                                            1% Complete </span>
                                </div>
                            </div>
                        </div>
                        <div id="dpfinfo" style="font-size:18px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="dpfcs" class="btn blue">全部初审通过</button>
                        <button id="dpffs" class="btn red">全部直接终审通过</button>
                        <button id="dpfclose" class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->