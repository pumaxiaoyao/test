<div class="modal fade" id="adjustBonus" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h3 id="myModalLabel">调整红利金额:
                        <font show=uname></font>
                    </h3>
                </div>
                <div class="modal-body">
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="form-section">
                                        调整红利金额 </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">加减</label>
                                        <select class="form-control" id="atype2">
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">数值</label>
                                        <input type="text" id="ja2" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="form-section">
                                        <hr> 调整取款流水条件 </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">取款流水倍数</label>
                                        <input type="text" id="jb2" value="1" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">确认</label>
                                        <input type="text" id="jc2" readonly value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">加减</label>
                                        <select class="form-control" id="jj2">
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">数值</label>
                                        <input type="text" id="jz2" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">确认</label>
                                        <input type="text" readonly id="jv2" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">红利流水限平台</label>
                                        <select class="form-control" id="gpid2">
                                            <option value="0">不限平台</option>
                                            <option value="350808494186211">BB视讯</option>
                                            <option value="350808494186212">BB彩票</option>
                                            <option value="350808494186213">BB3D</option>
                                            <option value="350808494186214">BB机率</option>
                                            <option value="387122175998732">AG电游</option>
                                            <option value="387122175998733">AG捕鱼</option>
                                            <option value="8246252097638400">沙巴体育</option>
                                            <option value="11964220589608960">MG电游</option>
                                            <option value="350808494186210">BB体育</option>
                                            <option value="9283948292830">欧博真人</option>
                                            <option value="7821359015601">蚂蚁彩票</option>
                                            <option value="420987656202">newPT电游</option>
                                            <option value="520723134101">KG</option>
                                            <option value="550123423101">IM捕鱼</option>
                                            <option value="550223423201">IM电子</option>
                                            <option value="773562192801">申博真人</option>
                                            <option value="773562192802">申博老虎机</option>
                                            <option value="940256904101">新EBet</option>
                                            <option value="7589283920390">双赢彩票</option>
                                            <option value="38712217599873024">AG真人</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">该红利参与优惠活动选择</label>
                                        <select class="form-control" id="actid2">
                                            <option value="0">无活动</option>
                                            <option value="374335100697333760">电话回访</option>
                                            <option value="374336017039511552">诚招代理商</option>
                                            <option value="374340225297965056">次次存次次送</option>
                                            <option value="374339692424224768">天天返点无上限 </option>
                                            <option value="378395958440255488">首存即送！专属优惠~</option>
                                            <option value="374338615729610752">百家乐 老K送大奖</option>
                                            <option value="374334587268390912">天天签到</option>
                                            <option value="374340639737143296">加入VIP俱乐部</option>
                                            <option value="374339313854734336">首存赠送100% 超值豪礼等您拿</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">备注</label>
                                        <input type="text" id="remark2" class="form-control" placeholder="请说明调整原因，已经调整的结果">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary green" onclick="SaveConfig(2,this);">确认</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                </div>
            </div>
        </div>
    </div>