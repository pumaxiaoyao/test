<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家组设置 </div>
            </div>
            <form action="#" class="form-horizontal">
                <div class="span12">
                    <p>
                        <a class="btn green" onclick="setadd();" href="#editModal" data-toggle="modal">添加</a>
                    </p>
                </div>
            </form>
            <div class="portlet-body">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>玩家组 </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#portlet_tab1" data-toggle="tab">
                                    已启用的玩家组</a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" data-toggle="tab">
                                    已禁用的玩家组</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                    <thead>
                                        <tr>
                                            <th>序号</th>
                                            <th>玩家组</th>
                                            <th>备注</th>
                                            <th>默认</th>
                                            <th>启用</th>
                                            <th>排序</th>
                                            <th>最后修改</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="portlet_tab2">
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                    <thead>
                                        <tr>
                                            <th>序号</th>
                                            <th>玩家组</th>
                                            <th>备注</th>
                                            <th>默认</th>
                                            <th>启用</th>
                                            <th>排序</th>
                                            <th>最后修改</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
                        <h3 id="emTitle">新增,编辑</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">玩家组</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">备注</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" id="remark" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">默认</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select class="form-control" id="isdefault">
                                        <option value="0">否</option>
                                        <option value="1">是</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">启用</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select class="form-control" id="status">
                                        <option value="0">禁用</option>
                                        <option value="1">启用</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">排序</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" id="displayorder" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary red" onclick="addplayerlever(this);">通过</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="attrModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div id="attrTable" class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <div class="caption">
                            <h3>
                                <i class="icon-globe"></i>玩家组属性设置
                            </h3>
                        </div>

                    </div>

                    <div class="modal-body">
                        <form action="#" class="form-horizontal">
                            <div class="span12">
                                <p>
                                    <!-- <a class="btn blue" href="/settings/playerLevel">返回玩家组</a> -->
                                    <a class="btn green" onclick="addattr();">添加</a>
                                    <font color=red>玩家组属性必须选择银行卡，否则该组的玩家无法进行存款</font>
                                </p>
                            </div>
                        </form>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption" id="attrTitle">
                                    <i class="fa fa-gift"></i> 玩家组 - <a>爱爱啊阿斯顿</a> </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_groupattribute" maxlayer="0">
                                        <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                            <thead>
                                                <tr>
                                                    <th> </th>
                                                    <th>最大值</th>
                                                    <th>玩家层级</th>
                                                    <th> </th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <div class="form-actions" align="right">
                                            <button type="button" onclick="savePLAttr();" class="btn green">
                                                <i class="icon-ok"></i> 保存 </button>
                                            <button class="btn" type="button" data-dismiss="modal">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cardModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="bankModalTitle">选银行卡</h3>
                    </div>
                    <div class="modal-body">
                        <form>
                            <table id="bankcardList" class="table table-striped table-bordered table-hover table-full-width">
                                <thead>
                                    <tr>
                                        <th>选择</th>
                                        <th>银行名称</th>
                                        <th>开户名</th>
                                        <th>银行账号</th>
                                        <th>开户行</th>
                                        <th>用途</th>
                                        <th>类型</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" onclick="submitBanklist(this);">确认</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg" id="waterModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="waterTitle">返水设置</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <table id="waterTable" class="table table-striped table-bordered table-hover table-full-width">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>游戏平台</th>
                                        <th>返水比例（%）</th>
                                        <th>浮动返水比例（%）</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" onclick="savewaterconfig(this);">确认</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg" id="waterLeverModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3 id="waterlevelTitle">阶梯比例设置</h3>
                    </div>
                    <div class="modal-body">
                        <button class="btn btn-primary blue" onclick="addlevertr();">添加</button>
                        <div class="row" style="padding-top:10px;">
                            <table id="t_waterlever" class="table table-striped table-bordered table-hover table-full-width">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>最大值</th>
                                        <th>返水比例（%）</th>
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