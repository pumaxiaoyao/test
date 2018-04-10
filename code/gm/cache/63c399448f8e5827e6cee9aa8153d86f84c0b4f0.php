<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>转账未知处理列表 </div>
            </div>
            <div class="portlet-body">
                <form action="/playerfund/transferListAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                    <input type="text" name="s_StartTime" id="s_StartTime" value="<?php echo e($startTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="开始时间">
                    </div>
                    <div class="form-group">
                    <input type="text" name="s_EndTime" id="s_EndTime" value="<?php echo e($endTime); ?>" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="结束时间">
                    </div>
                    <div class="form-group">
                        <input name="name" id="s_keyword" type="text" value="" placeholder="账号" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                            搜索 &nbsp;
                            <i class="fa fa-search"></i>
                        </button>
                        <button style="display:none;" type="button" onclick="$.blockUI();checkListTransfer();" class="btn btn-sm blue table-group-action-submit">
                            批量处理返回主账户类型的转账未知</i>
                        </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>转账金额</th>
                            <th>转账时间</th>
                            <th>转出账户</th>
                            <th>转入账户</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade bs-modal-lg" id="transferModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>转账未知处理列表</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p>自动执行自助查询，如果自助查询结果未知，可将如下信息复制给奇迹在线客服，进行人工查询</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p style="border:1px dashed;padding-left: 10px;">
                                    运营商：(i12)
                                    <br/> 账号：
                                    <label id="m_name"></label> （id：
                                    <label id="m_uid"></label>）
                                    <br/> 转账时间：
                                    <label id="m_created"></label>
                                    <br/> 转账金额：
                                    <label id="m_amount"></label>
                                    <br/> 转出：
                                    <label id="m_out_name"></label>
                                    <br/> 转出流水号：
                                    <label id="m_out_no"></label>
                                    <br/> 转入：
                                    <label id="m_in_name"></label>
                                    <br/> 转入流水号：
                                    <label id="m_in_no"></label>
                                    <br/>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>自助查询结果:
                                    <label id="query_rs">
                                        <img src="/static/image/select2-spinner.gif">
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>如果自助或者人工查询确认成功，请点击
                                    <a onclick="checkTransfer(this,1)" class="btn btn-xs green">游戏平台转帐成功</a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>如果自助或者人工查询确认失败，请点击
                                    <a onclick="checkTransfer(this,2)" class="btn btn-xs red">游戏平台转帐失败</a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>转出成功、转入失败时，资金将打入到主账户。
                                    <br/> 转出失败时，系统将取消本次未知记录。 </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg" id="transfer2Modal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>转账未知处理列表</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p>由于网络通讯延迟导致的转账失败，无需联系奇迹客服，直接点击下面的按钮，资金进入玩家主账户。</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <a onclick="checkTransfer(this,2)" class="btn default red">资金转入玩家主账户</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>
                                    <br/>游戏平台转主账户，转出成功转入失败，资金将再次转入玩家主账户。
                                    <br/> 游戏平台转游戏平台，转出成功转入失败，资金将退还给玩家主账户。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn2close">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->