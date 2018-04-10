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
    