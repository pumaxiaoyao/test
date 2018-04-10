<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>代理层级设置 </div>
            </div>
            <form action="#" class="form-horizontal">
                <div class="span12">
                    <p>
                        <a class="btn green" href="#editModal" onclick="setadd();" data-toggle="modal">添加</a>
                        <font color=red>代理层级请注意设置抽佣或者抽水，如果没有设置则抽佣=0，抽水=0.</font>
                    </p>
                </div>
            </form>
            <div class="portlet-body">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>代理层级 </div>
                        <ul class="nav nav-tabs">
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                    <thead>
                                        <tr>
                                            <th>序号</th>
                                            <th>代理层级</th>
                                            <th>玩家组</th>
                                            <th>排序</th>
                                            <th>最后修改</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $AGENTLEVEL !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="modaltitle">编辑</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">代理层级</label>

                                    <div class="col-md-8">

                                        <input type="text" id="name" class="form-control" placeholder="">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">默认玩家组</label>

                                    <div class="col-md-8">
                                        <select class="form-control" name="playergroupid" id="playergroupid">
                                            {!! $GROUPDATA !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">备注</label>

                                    <div class="col-md-8">
                                        <input type="text" id="remark" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">排序</label>

                                    <div class="col-md-8">
                                        <input type="text" id="displayorder" class="form-control" placeholder="" onkeyup="clearNoNum(this)">

                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="addagentlevel(this);">保存</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg" id="apportionModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>抽佣结算分摊
                            <span updated=updated></span>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <table class="table table-striped table-bordered table-hover table-full-width">
                                <thead>
                                    <tr>
                                        <th width="20%;">分摊相关项</th>
                                        <th width="20%;">分摊方式</th>
                                        <th width="20%;">比例（%）</th>
                                        <th width="40%;">说明</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="apportionForm">
                                        <tr>
                                            <td>存款优惠承担比例(%)</td>
                                            <td>
                                                <select class="form-control" id="depositChoose">
                                                    <option value="0">不分摊</option>
                                                    <option value="1">固定比例分摊</option>
                                                    <option value="2">同浮动抽佣比例</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="depositratedata" name="depositratedata" size="8" placeholder="">
                                            </td>
                                            <td>代理线下玩家存款时，公司给予的手续费优惠红利，分摊方式选择“不分摊”则代理不承担，建议固定分摊比例100%或同浮动抽佣比例</td>
                                        </tr>
                                        <tr>
                                            <td>返水承担比例(%)</td>
                                            <td>
                                                <select class="form-control" id="rebateChoose">
                                                    <option value="0">不分摊</option>
                                                    <option value="1">固定比例分摊</option>
                                                    <option value="2">同浮动抽佣比例</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="rebateratedata" name="rebateratedata" size="8" placeholder="">
                                            </td>
                                            <td>给予代理线下玩家返水，由代理商承担的比例，分摊方式选择“不分摊”则代理不承担，建议固定分摊比例100%或同浮动抽佣比例</td>
                                        </tr>
                                        <tr>
                                            <td>红利承担比例(%)</td>
                                            <td>
                                                <select class="form-control" id="bonusChoose">
                                                    <option value="0">不分摊</option>
                                                    <option value="1">固定比例分摊</option>
                                                    <option value="2">同浮动抽佣比例</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="bonusratedata" name="bonusratedata" size="8" placeholder="">
                                            </td>
                                            <td>线下玩家获取红利时，代理商承担的比例，分摊方式选择“不分摊”则代理不承担，建议 固定分摊比例100%或同浮动抽佣比例</td>
                                        </tr>
                                        <tr>
                                            <td>线路费比例(%)</td>
                                            <td>
                                                <select class="form-control" id="linefeeChoose">
                                                    <option value="0">不承担</option>
                                                    <option value="1">固定比例</option>
                                                    <option value="2">浮动比例</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="linefeeratedata" name="linefeeratedata" size="8" placeholder="">
                                                <a href="#floatSettingModal" id="linefeeconfig" modalTag="linefee" data-toggle="modal" class="btn btn-xs blue">浮动比例设置</a>
                                            </td>
                                            <td>线路费可以以固定的比例和浮动比例同时存在。线路费的浮动比例是使用结算输赢进行比例计算的单独比例配置</td>
                                        </tr>
                                        <tr>
                                            <td>有效会员</td>
                                            <td>
                                                <input onkeyup="clearNoNum(this)" type="text" id="validBate" size="4" placeholder="">有效会员投注额
                                            </td>
                                            <td>
                                                <input onkeyup="clearNoNum(this)" type="text" id="validMember" size="4" placeholder="">有效会员数
                                            </td>
                                            <td>要求代理线下玩家当月投注额超过“有效会员投注额”的会员数量。</td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="saveApportion(this);">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>

                </div>
            </div>


            <div class="modal fade bs-modal-lg" id="waterPrecModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3>总佣金比例(%)</h3>
                        </div>
                        <div class="modal-body">
                            <button class="btn btn-primary blue" onclick="addprectr();">添加</button> &nbsp;&nbsp;&nbsp;&nbsp;有效会员数，仅是一个预警值。总佣金比例，仅根据总金额大小来判定。
                            <div class="row" style="padding-top:10px;">
                                <table id="t_waterprec" class="table table-striped table-bordered table-hover table-full-width">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>最大值</th>
                                            <th>总佣金比例(%)</th>
                                            <th>有效会员数预警值</th>
                                            <th></th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="saveprectr(this);">保存</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-modal-lg" id="brokerageModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="brokerageModalTitle">设置抽佣/抽水</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <table class="table table-striped table-bordered table-hover table-full-width" id="brokerageModalData">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>游戏平台</th>
                                        <th>抽佣方式</th>
                                        <th>比例（%）<a href="#floatSettingModal" id="commisionconfig" modalTag="commision" data-toggle="modal"
                                                class="btn btn-xs blue">浮动比例设置</a></th>
                                        <th>抽水方式</th>
                                        <th>比例（%）</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="saveBrokerage(this);">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>

                </div>
            </div>
            <div class="modal fade bs-modal-lg" id="floatSettingModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3 id="FloatSettingTitle">
                            </h3>
                        </div>
                        <div class="modal-body">
                            <button class="btn btn-primary blue" onclick="addlevertr();">添加</button>
                            <div class="row" style="padding-top:10px;">
                                <table id="t_waterlever" class="table table-striped table-bordered table-hover table-full-width">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>最大值</th>
                                            <th>比例(%)</th>
                                            <th></th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="savelevertr(this);">保存</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->